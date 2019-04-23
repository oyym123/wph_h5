<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Jobs\BidTask;
use App\User;
use Carbon\Carbon;
use EasyWeChat\Core\Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bid extends Common
{
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'period_id',
        'bid_price',
        'pay_amount',
        'pay_type',
        'user_id',
        'status',
        'bid_step',
        'nickname',
        'product_title',
        'end_time',
    ];

    const STATUS_SUCCESS = 1; //成功
    const STATUS_FAIL = 0;    //失败

    const TYPE_OUT = 0; //出局
    const TYPE_LEAD = 1; //领先

    protected $table = 'bid';

    /** 真人竞拍 */
    public function personBid($periodId, $auto = 0, $autoObj = [])
    {
        $redis = app('redis')->connection('first');
        if ($auto == 0) { //表示没有自动竞拍，则记录支出,进行正常收费
            $bid = new Bid();//限制用户不可连续竞拍
            if ($bid->getLastBidInfo($redis, $periodId, 'user_id') == $this->userId) {
                return [
                    'status' => 40,
                ];
            }
        }

        $periods = new Period();
        $period = $periods->getPeriod(['id' => $periodId, 'status' => Period::STATUS_IN_PROGRESS]);
        $products = new Product();
        $product = $products->getCacheProduct($period->product_id);
        $countdown = $redis->ttl('period@countdown' . $period->id);
        $rate = $period->bid_price / $product->sell_price;
        $lastPrice = $this->getLastBidInfo($redis, $period->id, 'bid_price');
        if ($lastPrice) {
            $price = round($lastPrice + $product->bid_step, 2);
        } else {
            //$price = round($product->bid_step, 2);
            $price = round($product->init_price + $product->bid_step, 2);
        }

        DB::table('period')->where(['id' => $periodId])->update([
            'bid_price' => $price,
            'real_person' => Period::REAL_PERSON_YES
        ]);

        $time = date('Y-m-d H:i:s', time());
        $data = [
            'product_id' => $period->product_id,
            'period_id' => $periodId,
            'bid_price' => $price,
            'user_id' => $this->userId,
            'status' => $this->isCanWinBid($period, $rate, $redis),
            'bid_step' => $product->bid_step,
            'pay_amount' => $product->pay_amount, //判断是否是10元专区
            'pay_type' => $this->amount_type ?: Income::TYPE_BID_CURRENCY,
            'nickname' => $this->userIdent->nickname,
            'product_title' => $product->title,
            'created_at' => $time,
            'updated_at' => $time,
            'end_time' => $time,
            'is_real' => User::TYPE_REAL_PERSON
        ];

        if ($auto == 0) { //表示没有自动竞拍，则记录支出,进行正常收费
            //判断消耗的金额类型
            if ($this->userIdent->gift_currency >= $data['pay_amount']) {
                $data['pay_type'] = self::TYPE_GIFT_CURRENCY; //当有赠币时，优先使用
                DB::table('users')->where(['id' => $this->userId])->decrement('gift_currency', $data['pay_amount']);
            } elseif ($this->userIdent->bid_currency >= $data['pay_amount']) {
                DB::table('users')->where(['id' => $this->userId])->decrement('bid_currency', $data['pay_amount']);
            } else {
                return [
                    'status' => 30, //余额不足，需要充值
                    'pay_amount' => $data['pay_amount'] - $this->userIdent->bid_currency
                ];
            }


            $expend = [
                'type' => $data['pay_type'],
                'user_id' => $this->userId,
                'amount' => $data['pay_amount'],
                'pay_amount' => $data['pay_amount'],
                'name' => '竞拍消费',
                'product_id' => $product->id,
                'period_id' => $periodId,
            ];
            (new Expend())->bidPay($expend);
            $remainTimes = 0;
            $totalTimes = 0;
        } else {
            $remainTimes = $autoObj->remain_times;
            $totalTimes = $autoObj->times;
        }

        if ($data['status'] == self::STATUS_FAIL) {
            //重置倒计时
            if ($countdown <= $product->countdown_length) {
                $redis->setex('period@countdown' . $period->id, $product->countdown_length, $data['bid_price']);
            }
            $data['id'] = DB::table('bid')->insertGetId($data);
            $data['user_id'] = $this->userIdent->id;
            $this->setLastPersonId($redis, $data);
            $data['province'] = $this->userIdent->province;
            $data['city'] = $this->userIdent->city;
            $data['remain_times'] = $remainTimes; //自动竞拍剩余次数
            $data['total_times'] = $totalTimes; //自动竞拍总次数
            $this->setThreePersonId($redis, $data);
            //加入竞拍队列，进入数据库Bid表,暂时不启用redis队列
            //dispatch(new BidTask($redis, $data));
            $expend = (new Expend())->periodExpend($period->id, $this->userId);
            $res = [
                'status' => 10, //提交竞拍信息成功
                'used_real_bids' => $expend['bid_currency'],
                'used_gift_bids' => $expend['gift_currency'],
                'used_money' => number_format($expend['bid_currency'], 2),
            ];
            $this->socket($period->id);
            return $res;
        }
    }

    /** 设置最后一个竞拍人的id */
    public function setLastPersonId($redis, $data)
    {
        $redis->hset('bid@lastPersonId', $data['period_id'], json_encode($data));
    }


    /** 修改缓存最后三条记录的竞拍状态 */
    public function updateThreePersonId($redis, $period_id)
    {
        $res = $this->getThreePersonId($redis, $period_id);
        $res[0]['status'] = 1;
        $redis->hset('bid@threePersonId', $period_id, json_encode($res));
    }


    /** 缓存最后三条记录 */
    public function setThreePersonId($redis, $data)
    {
        $res = $this->getThreePersonId($redis, $data['period_id']);
        $result[] = $data;
        $result[] = $res[0];
        $result[] = $res[1];
        $redis->hset('bid@threePersonId', $data['period_id'], json_encode($result));
    }

    /** 获取最后三条记录 */
    public function getThreePersonId($redis, $periodId, $flag = 1)
    {
        if ($flag) {
            $lastPersonIds = json_decode($redis->hget('bid@threePersonId', $periodId), true);
            return $lastPersonIds;
        }
        if ($redis->hexists('bid@threePersonId', $periodId)) {
            $lastPersonIds = json_decode($redis->hget('bid@threePersonId', $periodId), true);
            return $lastPersonIds;
        } else {
            return '';
        }
    }

    /** 获取最后一个竞拍人的id */
    public function getLastBidInfo($redis, $periodId, $type = false)
    {
        $lastPersonIds = json_decode($redis->hget('bid@lastPersonId', $periodId));
        if (!empty($lastPersonIds)) {
            if (!empty($type)) {
                return $lastPersonIds->$type;
            } else {
                return $lastPersonIds;
            }
        } else {
            return 0;
        }
    }

    /** 每3秒检验，是否有中标的用户 */
    public function checkoutBid()
    {
        $redis = app('redis')->connection('first');
        $periods = new Period();
        $products = new Product();
        foreach ($periods->getAll([Period::STATUS_IN_PROGRESS], 1) as $period) {
            $bid = $this->getLastBidInfo($redis, $period->id);
            if ($bid) {
                $product = $products->getCacheProduct($period->product_id);
                //当投标的价格小于售价时 , 则一直都不能竞拍成功
                $lastBid = $this->getLastBidInfo($redis, $period->id);
                /*
                if($product->init_price >0){
                    $tem_rate = ($lastBid->bid_price - $product->init_price) / $product->init_price;
                }else{
                    $tem_rate = $lastBid->bid_price / $product->sell_price;
                }
                */
                //($lastBid->bid_price / $product->sell_price)
                $isSucc = false;
                if ($lastBid->is_real == Period::REAL_PERSON_YES) {
                    $productARR = [328, 330, 331, 334, 337, 340, 343, 344, 345];
                    if (in_array($period->product_id, $productARR)) {
                        $z = $redis->ttl('realSuccess@userId' . $lastBid->user_id);
                        if ($z < 0) {//表示没有拍中过
                            $num = DB::table('bid')->where(['user_id' => $lastBid->user_id])->count();
                            if ($num >= 3) {
                                //$redis->setex('realPersonBidEnd@periodId' . $period->id, 86400 * 10, $period->id);
                                $redis->setex('realPersonBid@periodId' . $period->id, 86400 * 10, $period->id);
                                $redis->setex('realSuccess@userId' . $lastBid->user_id, 86400 * 10, $lastBid->user_id);
                                $isSucc = true;
                            }
                        }
                    }
                }
                if (($lastBid->bid_price / $product->sell_price) > $period->robot_rate) {
                    //if ( (($lastBid->bid_price - $product->init_price) / $product->init_price)> $period->robot_rate) {
                    if ($lastBid->is_real == Period::REAL_PERSON_NO) {//当为机器人时可以停止
                        $redis->setex('realPersonBid@periodId' . $period->id, 86400 * 10, $period->id);
                        $redis->setex('period@robotSuccess' . $period->id, 10000, 'success');
                    } else {
                        if ($isSucc === false) {
                            $redis->del('realPersonBid@periodId' . $period->id);
                            $redis->del('period@robotSuccess' . $period->id);
                        }
                    }
                }

                $y = $redis->ttl('realPersonBidEnd@periodId' . $bid->period_id);
                if ($y > 0) { //当为真人时,竞拍开关,设置10天
                    $redis->setex('realPersonBid@periodId' . $period->id, 86400 * 10, $period->id);
                }

                $flag = ($x = $redis->ttl('realPersonBid@periodId' . $bid->period_id)) > 0 ? 1 : 0;
                if (empty($flag)) {
                    continue; //没有让机器人退出时，就不可结拍
                }
                //当竞拍结束时
                if ($redis->ttl('period@countdown' . $period->id) < 0) {
                    $redis->setex('period@countdown' . $period->id, 10000, 'success');
                    //竞拍成功则立即保存
                    DB::table('bid')->where([
                        'id' => $bid->id
                    ])->update(['status' => self::STATUS_SUCCESS]);
                    //redis缓存也改变
                    $bid->status = self::STATUS_SUCCESS;
                    $this->setLastPersonId($redis, json_decode(json_encode($bid), true));
                    $this->updateThreePersonId($redis, $period->id);
                    //转换状态
                    DB::table('period')->where(['id' => $period->id])->update([
                        'status' => Period::STATUS_OVER,
                        'user_id' => $bid->user_id,
                        'bid_end_time' => date('Y-m-d H:i:s', time()),
                        'bid_id' => $bid->id
                    ]);
                    //新增该产品新的期数
                    if ($product->status == self::STATUS_ENABLE) {
                        $periods->saveData($period->product_id);
                    }

                    //同时清除期数缓存
                    $this->delCache('period@allInProgress' . Period::STATUS_IN_PROGRESS);
                    if ($period->real_person == User::TYPE_REAL_PERSON) { //有真人参与则结算
                        //购物币返还结算
                        Income::settlement($period->id, $bid->user_id);
                    }

                    if ($bid->is_real == User::TYPE_REAL_PERSON) { //只有真人才需要走结算、订单流程
                        //自动拍币返还
                        (new AutoBid())->back($period->id, $bid->user_id);
                        //生成一个订单
                        $order = new Order();
                        $orderInfo = [
                            'sn' => $order->createSn(),
                            'pay_type' => Pay::TYPE_WEI_XIN,
                            'pay_amount' => $bid->bid_price,
                            'product_amount' => $product->sell_price,
                            'product_id' => $product->id,
                            'period_id' => $bid->period_id,
                            'status' => Order::STATUS_WAIT_PAY,
                            'type' => Order::TYPE_BID, //表示竞拍类型订单
                            'buyer_id' => $bid->user_id,
                            'expired_at' => config('bid.order_expired_at'), //过期时间
                        ];

                        $address = UserAddress::defaultAddress($bid->user_id);
                        if ($address) {
                            $orderInfo['address_id'] = $address->id; //收货人地址
                            $orderInfo['str_address'] = str_replace('||', ' ', $address->str_address) . $address->detail_address;
                            $orderInfo['str_username'] = $address->user_name;//收货人姓名
                            $orderInfo['str_phone_number'] = $address->telephone; //手机号
                        }
                        $order = $order->createOrder($orderInfo);
                        //转换状态
                        DB::table('period')->where(['id' => $period->id])->update([
                            'order_id' => $order->id,
                        ]);
                    }
                    //当有用户访问的时候才进行广播
                    $flag = $redis->hget('visit@PeriodRecord', $period->id);
                    //if ($flag >= 1) {
                    $this->socket($period->id);
                    //}
                }
            }
        }
    }

    /** 判断是否可以中标 */
    public function isCanWinBid($period, $rate, $redis)
    {
        //当有真人参与时，机器人则一直跟拍
        if ($period->real_person) {
            return self::STATUS_FAIL;
        } else { //当没有真人参与时，判断是否到达开奖值
            if ($rate >= $period->robot_rate) {
                $redis->setex('period@robotSuccess' . $period->id, 10000, 'success');
                return self::STATUS_SUCCESS;
            }
        }
        return self::STATUS_FAIL;
    }

    /** 机器人竞价 */
    public function robotBid($countdownLength = 10)
    {
        $periods = new Period();
        $products = new Product();
        $redis = app('redis')->connection('first');

        //获取所有正在进行中的期数,循环加入机器人竞拍，每8秒扫描一遍
        foreach ($periods->getAll([Period::STATUS_IN_PROGRESS], $countdownLength) as $period) {
            //当有真人参与，且跟拍到平均价以上时，机器人将不跟拍
            if ($redis->ttl('realPersonBid@periodId' . $period->id) > 1) {
                echo $this->writeLog(['period_id' => $period->id, 'info' => '有真人参与，且跟拍到平均价以上，机器人将不跟拍']);
                continue;
            }
            $countdown = $redis->ttl('period@countdown' . $period->id);
            $flag = $redis->get('period@countdown' . $period->id);
            $success = $redis->get('period@robotSuccess' . $period->id);
            $product = $products->getCacheProduct($period->product_id);

            if ($countdown > $product->countdown_length) {
                echo $this->writeLog(['period_id' => $period->id, 'info' => '竞拍还未开始']);
                continue;
            }

            //当倒计时结束时,机器人将不会竞拍
            if ($success == 'success') {
                echo $this->writeLog(['period_id' => $period->id, 'info' => '竞拍倒计时结束']);
                continue;
            }

//            if ($flag == $period->bid_price + $product->bid_step && $countdownLength == 10) {
//                //减少竞拍次数
//                echo $this->writeLog(['period_id' => $period->id, 'info' => '该时段已经竞拍过一次啦']);
//                continue;
//            }
//            $lastPrice = $redis->get('bid@lastPrice' . $period->id);
//            if ($lastPrice) {
//                $lastBid = 0;
//            } else {
//                $lastBid = $lastPrice + $product->bid_step;
//            }

            $lastPrice = $this->getLastBidInfo($redis, $period->id, 'bid_price');

            // $redis->setex('bid@lastPrice' . $period->id, 10000, $lastBid);

            $robotPeriod = RobotPeriod::getInfo($period->id);
            if ($lastPrice) {
                $price = round($lastPrice + $product->bid_step, 2);
            } else {
                //$price = round($product->bid_step, 2);
                $price = round($product->init_price + $product->bid_step, 2);
            }
            DB::table('period')->where(['id' => $period->id])->update(['bid_price' => $price]);//自增0.1
            $rate = $period->bid_price / $product->sell_price;
            $time = date('Y-m-d H:i:s', time());
            $data = [
                'product_id' => $period->product_id,
                'period_id' => $period->id,
                'bid_price' => $price,
                'user_id' => $robotPeriod->user_id,
                'status' => $this->isCanWinBid($period, $rate, $redis),
                'bid_step' => $product->bid_step,
                'pay_amount' => $product->pay_amount, //判断是否是10元专区
                'pay_type' => self::TYPE_BID_CURRENCY,
                'nickname' => $robotPeriod->nickname,
                'product_title' => $product->title,
                'created_at' => $time,
                'updated_at' => $time,
                'end_time' => $time,
                'is_real' => User::TYPE_ROBOT
            ];

            if ($data['status'] == self::STATUS_SUCCESS) {
                //竞拍成功则立即保存
                $bid = Bid::create($data);
                //转换状态
                DB::table('period')->where(['id' => $period->id])->update([
                    'status' => Period::STATUS_OVER,
                    'user_id' => $robotPeriod->user_id,
                    'bid_end_time' => date('Y-m-d H:i:s', time()),
                    'bid_id' => $bid->id
                ]);
                //新增该产品新的期数
                if ($product->status == self::STATUS_ENABLE) {
                    $periods->saveData($period->product_id);
                }
                //同时清除期数缓存
                $this->delCache('period@allInProgress' . Period::STATUS_IN_PROGRESS);
                //redis缓存也改变
                $data['id'] = $bid->id;
                $data['user_id'] = $robotPeriod->user_id;
                $this->setLastPersonId($redis, $data);
                $data['province'] = $robotPeriod->province;
                $data['city'] = $robotPeriod->city;
                $this->setThreePersonId($redis, $data);
            } else {

                $redis->setex('period@countdown' . $period->id, $product->countdown_length, $data['bid_price']);
                $data['id'] = DB::table('bid')->insertGetId($data);
                $data['user_id'] = $robotPeriod->user_id;
                $this->setLastPersonId($redis, $data);
                $data['province'] = $robotPeriod->province;
                $data['city'] = $robotPeriod->city;
                $this->setThreePersonId($redis, $data);

                //加入竞拍队列，3秒之后进入数据库Bid表
                //dispatch(new BidTask($data));
            }

            //当有用户访问的时候才进行广播
            $flag = $redis->hget('visit@PeriodRecord', $period->id);
            //if ($flag >= 1) {
            $this->socket($period->id);
            //}
        }
    }

    /** 获取竞拍记录 */
    public function bidRecord($periodId)
    {
        $data = [];
        if ($this->limit == 3) {
            $redis = app('redis')->connection('first');
            $model = $this->getThreePersonId($redis, $periodId, 0);
            if (!empty($model)) {
                foreach ($model as $key => $bid) {
                    if ($bid['bid_price']) {
                        $data[] = [
                            'period_id' => $bid['period_id'],
                            'bid_price' => number_format($bid['bid_price'], 2),
                            'num' => 0,
                            'bid_time' => $bid['end_time'],
                            'nickname' => $bid['nickname'],
                            'avatar' => '',
                            'status' => $bid['status'],
                            'area' => $bid['province'] . $bid['city'],
                            'countdown' => ($x = $redis->ttl('period@countdown' . $bid['period_id'])) > 0 ? $x : 0,
                            'bid_type' => $key == 0 ? self::TYPE_LEAD : self::TYPE_OUT, //0 =出局 1=领先
                            'user_id' => $bid['user_id'],
                            'remain_times' => isset($bid['remain_times']) ? $bid['remain_times'] : 0, //自动竞拍剩余次数
                            'total_times' => isset($bid['total_times']) ? $bid['total_times'] : 0,   //自动竞拍总次数
                        ];
                    }
                }
            } else {
                $bids = Bid::has('user')->where(['period_id' => $periodId])->limit($this->limit)->orderBy('bid_price', 'desc')->get();
                foreach ($bids as $key => $bid) {
                    $user = $bid->user;
                    $data[] = [
                        'period_id' => $bid->period_id,
                        'bid_price' => number_format($bid->bid_price, 2),
                        'num' => 0,
                        'bid_time' => $bid->end_time,
                        'nickname' => $bid->nickname,
                        'avatar' => '',
                        'status' => $bid->status,
                        'area' => $user->province . $user->city,
                        'countdown' => ($x = $redis->ttl('period@countdown' . $bid->period_id)) > 0 ? $x : 0,
                        'bid_type' => $key == 0 ? self::TYPE_LEAD : self::TYPE_OUT, //0 =出局 1=领先
                        'user_id' => $bid['user_id'],
                        'remain_times' => 0, //自动竞拍剩余次数
                        'total_times' => 0,   //自动竞拍总次数
                    ];
                }
            }
        } else {
            $bids = Bid::has('user')->where(['period_id' => $periodId])->limit($this->limit)->orderBy('bid_price', 'desc')->get();
            foreach ($bids as $key => $bid) {
                $user = $bid->user;
                $data[] = [
                    'bid_price' => $bid->bid_price,
                    'bid_time' => $bid->end_time,
                    'nickname' => $bid->nickname,
                    'avatar' => '',
                    'status' => '',
                    'countdown' => '',
                    'area' => $user->province . $user->city,
                    'bid_type' => $key == 0 ? self::TYPE_LEAD : self::TYPE_OUT, //0 =出局 1=领先
                    'user_id' => $bid['user_id'],
                    'remain_times' => 0,  //自动竞拍剩余次数
                    'total_times' => 0,   //自动竞拍总次数
                ];
            }
        }
        return $data;
    }

    /** 竞拍最新的状态 */
    public function newestBid($periodIds)
    {
        //redis搜索
        $redis = app('redis')->connection('first');
        $res = [];
        foreach (explode(',', $periodIds) as $id) {
            if ($bid = $this->getLastBidInfo($redis, $id)) {
                $res[] = [
                    'a' => $bid->period_id,
                    'b' => $bid->pay_amount,
                    'c' => number_format($bid->bid_price, 2),
                    'd' => $bid->nickname,
                    'e' => $bid->pay_type,
                    'f' => $bid->status,
                    'g' => $bid->end_time,
                    'h' => ($x = $redis->ttl('period@countdown' . $bid->period_id)) > 0 ? $x : 0,
                    'i' => 0,
                ];
            } else {
                $res[] = [
                    'a' => $id,
                    'b' => 0,
                    'c' => '0.00',
                    'd' => '当前价',
                    'e' => 0,
                    'f' => 0,
                    'g' => 0,
                    'h' => ($x = $redis->ttl('period@countdown' . $id)) > 0 ? $x : 0,
                    'i' => 0,
                ];
            }
        }
        return $res;
        //mysql数据库搜索
        /*        $model = DB::table('bid')
                    ->select(DB::raw('max(bid_price) as bid_price,period_id'))
                    ->whereIn('period_id', $ids)
                    ->groupBy(['period_id'])
                    ->orderBy('bid_price', 'desc')
                    ->get();
                foreach ($model as $item) {
                    $bid = DB::table('bid')
                        ->select('status', 'period_id', 'nickname', 'bid_price', 'status', 'pay_type', 'end_time', 'pay_amount')
                        ->where([
                            'bid_price' => $item->bid_price,
                            'period_id' => $item->period_id
                        ])->first();
                    $res[] = [
                        'a' => $bid->period_id,
                        'b' => $bid->pay_amount,
                        'c' => $bid->bid_price,
                        'd' => $bid->nickname,
                        'e' => $bid->pay_type,
                        'f' => $bid->status,
                        'g' => $bid->end_time
                    ];
                }*/
    }

    /** 获取用户表信息 */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function period()
    {
        return $this->belongsTo('App\Models\Period');
    }

    public function clearVisit()
    {
        $redis = app('redis')->connection('first');
        $periods = new Period();
        foreach ($periods->getAll([Period::STATUS_IN_PROGRESS], 1) as $period) {
            $redis->hset('visit@PeriodRecord', $period->id, 0);
        }
    }

    public function socket($periodId)
    {
        $bid = new Bid();
        $bid->limit = 3;
        $msg_content = $bid->bidRecord($periodId);
        $response['type'] = 'bid';
        $response['period_id'] = $periodId;
        $response['content'] = $msg_content;
        //携带key 防止websocket被攻击 key=cf3216cd-8e05-3a3d-a2ef-1eae97b17e86
        $res = base64_encode('cf3216cd-8e05-3a3d-a2ef-1eae97b17e86' . json_encode($response));
        if (PHP_OS == 'WINNT') { //本地测试使用
            exec("node G:node/client.js $res");
        } else {
            exec("/usr/sbin/node /usr/local/node/client.js $res");
        }
    }

    /** 清除数据，防止数据过大影响查询 */
    public function delBid()
    {
        //确保有110条数据能被保留下来
        $res = DB::table('bid')->where(['status' => Bid::STATUS_ENABLE])->where('bid_price', '>', 11)->get();
        foreach ($res as $item) {
            $num = ($item->bid_price - 11) * 10;
            $bidIds = DB::table('bid')->select('id')->where(['period_id' => $item->period_id])->limit($num)->orderBy('bid_price', 'asc')->get()->toArray();
            if ($bidIds) {
                DB::table('bid')->whereIn('id', array_column($bidIds, 'id'))->delete();
            }
        }
    }
}

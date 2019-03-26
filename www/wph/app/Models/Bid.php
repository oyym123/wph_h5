<?php

namespace App\Models;

use App\Jobs\BidTask;
use App\User;
use Carbon\Carbon;
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
        'user_id',
        'status',
        'bid_step',
        'nickname',
        'product_title',
        'end_time',
    ];

    const STATUS_SUCCESS = 1; //成功
    const STATUS_FAIL = 0;    //失败

    protected $table = 'bid';

    /** 保存竞拍数据 */
    public function saveData($request)
    {
        DB::table('period')->where(['id' => $request->period_id])->increment('bid_price', 0.1);//自增0.1
        DB::table('period')->where(['id' => $request->period_id])->update(['real_person' => Period::REAL_PERSON_YES]);//有真人参与
        $time = date('Y-m-d H:i:s', time());
        $data = [
            'product_id' => $request->product_id,
            'period_id' => $request->period_id,
            'bid_price' => $request->bid_price,
            'user_id' => $this->userId,
            'status' => $this->isCanWinBid(),
            'bid_step' => 1,
            'nickname' => $this->userIdent->nickname,
            'product_title' => $request->product_title,
            'created_at' => $time,
            'updated_at' => $time,
            'end_time' => $time
        ];
        //加入竞拍队列，3秒之后进入数据库Bid表
        $model = (new BidTask($data))->delay(Carbon::now()->addSeconds(3));
        dispatch($model);
    }

    /** 判断是否可以中标 */
    public function isCanWinBid($period, $rate, $redis)
    {
        //当有真人参与时，机器人则一直跟拍
        if ($period->real_person) {
            if ($rate >= 1) { //到达平均售价时，机器人将不再参与竞拍,设置一个一年时间的key,当机器人参与的时候，判断是不是存在这个
                $this->putCache('realPersonBid@periodId' . $period->id, $period->id, 60 * 24 * 365);
                //当竞拍结束时
                if ($redis->ttl('period@countdown' . $period->id) < 0) {
                    $redis->hdel('period@countdown' . $period->id);
                    return self::STATUS_SUCCESS;
                }
            }
            return self::STATUS_FAIL;
        } else { //当没有真人参与时，判断是否到达开奖值
            if ($rate >= $period->robot_rate) {
                $redis->hdel('period@countdown' . $period->id);
                return self::STATUS_SUCCESS;
            }
        }
        return self::STATUS_FAIL;
    }

    /** 机器人竞价 */
    public function robotBid()
    {
        $periods = new Period();
        $products = new Product();
        $redis = app('redis')->connection('first');
        foreach ($periods->getAll() as $period) {
            //当有真人参与，且跟拍到平均价以上时，机器人将不跟拍
            if ($this->hasCache('realPersonBid@periodId' . $period->id)) {
                echo $this->writeLog(['有真人参与，且跟拍到平均价以上，机器人将不跟拍']);
                continue;
            }

            $countdown = $redis->ttl('period@countdown' . $period->id);

            if ($countdown < 2) {
                //重置倒计时
                $redis->setex('period@countdown' . $period->id, 10, 1);
            }

//            //当倒计时结束时,机器人将不会竞拍
//            if ($countdown < 0) {
//                echo $this->writeLog(['period_id' => $period->id, 'info' => '竞拍倒计时结束，或者没有倒计时']);
//                continue;
//            }

            $product = $products->getCacheProduct($period->product_id);
            $robotPeriod = RobotPeriod::getInfo($period->id);
            DB::table('period')->where(['id' => $period->id])->increment('bid_price', 0.1);//自增0.1
            $rate = $period->bid_price / $product->sell_price;

            $time = date('Y-m-d H:i:s', time());
            $data = [
                'product_id' => $period->product_id,
                'period_id' => $period->id,
                'bid_price' => $period->bid_price + $product->bid_step,
                'user_id' => $robotPeriod->user_id,
                'status' => $this->isCanWinBid($period, $rate, $redis),
                'bid_step' => 1,
                'nickname' => $robotPeriod->nickname,
                'product_title' => $product->title,
                'created_at' => $time,
                'updated_at' => $time,
                'end_time' => $time
            ];

            if ($data['status'] == self::STATUS_SUCCESS) {
                //竞拍成功则立即保存
                Bid::create($data);
                //转换状态
                DB::table('period')->where(['id' => $period->id])->update(['status' => Period::STATUS_OVER]);
                //新增该产品新的期数
                $periods->saveData($period->product_id);
                //同时清除期数缓存
                $this->delCache('period@allInProgress' . Period::STATUS_IN_PROGRESS);
            } else {
                //重置倒计时
                $redis->setex('period@countdown' . $period->id, 10, 1);
                //加入竞拍队列，3秒之后进入数据库Bid表
                $model = (new BidTask($data));
                dispatch($model);
            }
        }
    }
}

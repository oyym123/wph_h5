<?php

namespace App\Models;

use DeepCopy\f001\B;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Period extends Common
{
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'bid_price',
        'code',
        'status',
        'auctioneer_id',
        'robot_rate',
        'person_rate',
        'countdown_length'
    ];

    protected $table = 'period';

    const STATUS_NOT_START = 10;
    const STATUS_IN_PROGRESS = 20;
    const STATUS_OVER = 30;

    const REAL_PERSON_YES = 1;
    const REAL_PERSON_NO = 0;

    public static function getStatus($key = 999)
    {
        $data = [
            self::STATUS_NOT_START => '未开始',
            self::STATUS_IN_PROGRESS => '正在进行',
            self::STATUS_OVER => '已结束',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 获取成交数据 */
    public function dealEnd($where = [], $type = 0)
    {
        $data = [];
        if ($type == 1) {//表示微拍头条的数据
            $where = ['product.is_home_recommend' => Product::RECOMMEND_YES];
            $periods1 = DB::table('period')
                ->select(['*', 'period.id'])
                ->join('product', 'product.id', '=', 'period.product_id')
                ->where([
                        'period.deleted_at' => null,
                        'period.status' => self::STATUS_IN_PROGRESS
                    ] + $where)->offset($this->offset)->limit(1)->inRandomOrder()->get()->toArray();

            $periods2 = DB::table('period')
                ->select(['*', 'period.id'])
                ->join('product', 'product.id', '=', 'period.product_id')
                ->where([
                        'period.deleted_at' => null,
                        'period.status' => self::STATUS_OVER
                    ] + $where)->offset($this->offset)->limit(2)->inRandomOrder()->get()->toArray();
            $periods = array_merge(array_map('get_object_vars', $periods2), array_map('get_object_vars', $periods1));
            foreach ($periods as $period) {
                $product = Product::find($period['product_id']);
                $user = User::find($period['user_id']);
                $savePrice = ($x = round(((1 - ($period['bid_price'] / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                $data[] = [
                    'id' => $period['id'],
                    'period_code' => $period['code'],
                    'bid_price' => $period['bid_price'],
                    'nickname' => $user ? self::changeStr($user->name, 7, '...') : '佚名',
                    'avatar' => $user ? env('QINIU_URL_IMAGES') . $user->avatar : '',
                    'title' => $product->title,
                    'short_title' => $product->title,
                    'bid_step' => $product->bid_step,
                    'save_price' => $savePrice,
                    'end_time' => $period['bid_end_time'],
                    'img_cover' => env('QINIU_URL_IMAGES') . $product->img_cover,
                    'product_id' => $product->id,
                    'sell_price' => $product->sell_price,
                    'product_type' => $product->type,
                ];
            }
        } else {
            $periods = Period::has('product')->where($where + ['status' => self::STATUS_OVER])
                ->offset($this->offset)->limit($this->limit)->orderBy('updated_at', 'desc')->get();

            foreach ($periods as $period) {
                $product = $period->product;
                $savePrice = ($x = round(((1 - ($period->bid_price / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                $data[] = [
                    'id' => $period->id,
                    'period_code' => $period->code,
                    'bid_price' => $period->bid_price,
                    'nickname' => $period->user ? self::changeStr($period->user->nickname, 7, '...')  : '',
                    'avatar' => $period->user ? $period->user->getAvatar() : '',
                    'title' => $product->title,
                    'short_title' => $product->title,
                    'bid_step' => $product->bid_step,
                    'save_price' => $savePrice,
                    'end_time' => $period->bid_end_time,
                    'img_cover' => env('QINIU_URL_IMAGES') . $product->img_cover,
                    'product_id' => $product->id,
                    'sell_price' => $product->sell_price,
                    'product_type' => $product->type,
                ];
            }
        }


        return $data;
    }

    /** 获取下一期的period_id */
    public function nextPeriod($productId)
    {
        $period = Period::where([
            'product_id' => $productId,
            'status' => self::STATUS_IN_PROGRESS
        ])->select(['id'])->orderBy('created_at', 'desc')->first();
        if ($period) {
            return $period->id;
        } else {
            self::showMsg('该产品暂时没有竞拍活动!', 4);
        }
    }

    /** 获取产品列表 */
    public function getProductList($type = 1, $data = [])
    {
        if ($type == 4) {
            $cacheKey = 'period@getProductList' . $type . 'type=' . $this->request->type . 'offset=' . $this->offset;
        } else {
            $cacheKey = 'period@getProductList' . $type . 'offset=' . $this->offset;
        }

        if ($this->hasCache($cacheKey)) {
            return $this->getCache($cacheKey);
        }
        $where = [
            'deleted_at' => null,
            'status' => self::STATUS_IN_PROGRESS
        ];
        $whereIn = $ids = [];
        if ($type == 2) {   //我在拍
            $expend = DB::table('expend')
                ->select('period_id')
                ->where(['user_id' => $this->userId])
                ->groupBy('period_id')
                ->get()->toArray();
            $field = 'id';
            $ids = array_column($expend, 'period_id');
            if (empty($expend)) {
                self::showMsg('没有我在拍数据', self::CODE_NO_DATA);
            }
        } elseif ($type == 3) { //我收藏
            $collectIds = DB::table('collection')->select('product_id')->where([
                'user_id' => $this->userId,
                'status' => Collection::STATUS_COLLECTION_YES
            ])->get()->toArray();

            $field = 'product_id';
            $ids = array_column($collectIds, 'product_id');

            if (empty($collectIds)) {
                self::showMsg('没有数据', self::CODE_NO_DATA);
            }
        } elseif ($type == 5) { //拍卖师分类
            $where = $where + [
                    'auctioneer_id' => $data['auctioneer_id'],
                ];
        }

        if (in_array($type, [4, 6, 7])) { //需要关联产品表
            $where = [];
            if ($type == 4) {//产品类型分类
                if (!empty($this->request->type)) {
                    $where = ['product.type' => $this->request->type];
                }
            } elseif ($type == 6) { //热门拍卖
                $where = ['product.is_popular' => Product::POPULAR_YES];
            } elseif ($type == 7) { //热门推荐
                $where = ['product.is_recommend' => Product::RECOMMEND_YES];
            }

            $periods = DB::table('period')
                ->select(['*', 'period.id'])
                ->join('product', 'product.id', '=', 'period.product_id')
                ->where([
                        'period.deleted_at' => null,
                        'period.status' => self::STATUS_IN_PROGRESS
                    ] + $where)->offset($this->offset)->limit($this->limit)->orderBy('sort', 'desc')->get();

        } else {
            if ($ids) {
                $whereIn = function ($query) use ($field, $ids) {
                    $query->whereIn($field, $ids);
                };
            }
            $periods = DB::table('period')->where($where)->where($whereIn)->offset($this->offset)->limit($this->limit)->orderBy('id', 'desc')->get();
        }
        $res = [];
        $collection = new Collection();
        $redis = app('redis')->connection('first');
        $bid = new Bid();

        foreach ($periods as $period) {
            $product = Product::find($period->product_id);
            if ($product) {
                $res[] = [
                    'id' => $period->id,
                    'product_id' => $product->id,
                    'period_code' => $period->code,
                    'bid_price' => $period->bid_price,
                    'title' => self::changeStr($product->title, 29, '...'),
                    'status' => 0, //正在进行中
                    'img_cover' => self::getImg($product->img_cover),
                    'sell_price' => number_format($bid->getLastBidInfo($redis, $period->id, 'bid_price'), 2),
                    'bid_step' => $product->pay_amount,
                    'is_favorite' => $collection->isCollect($this->userId, $product->id),
                ];
            }
        }
        if (empty($res) && $this->offset == 0) {
            self::showMsg('没有数据', 2);
        }
        return $this->putCache($cacheKey, $res, 0.1);
    }

    /** 获取产品详情 */
    public function getProductDetail($id, $flag = 0)
    {
        $cacheKey = 'period@getProductDetails' . $id;
        if ($this->hasCache($cacheKey)) {
            return $this->getCache($cacheKey);
        }
        $period = $this->getPeriod(['id' => $id]);
        $product = $period->product;
        $auctioneer = $period->Auctioneer;
        $collection = new Collection();

        $userCount = DB::table('bid')->select('user_id')->where(['period_id' => $period->id])->groupBy(['user_id'])->get();
        $this->limit = 6;
        //h5新增
        $proxy = [
            'remain_times' => 0,
            'total_times' => 0,
            'percent' => 0,
        ];
        if ($this->userId > 0) {
            $proxy = AutoBid::isAutoBid($this->userId, $period->id);
        }

        $redis = app('redis')->connection('first');
        if ($flag) {
            $num = $redis->hget('visit@PeriodRecord', $period->id);
            //设置访问记录
            $redis->hset('visit@PeriodRecord', $period->id, $num + 1);
        }

        $expend = (new Expend())->periodExpend($period->id, $this->userId);
        $bid =new Bid();
        $bid->limit =3;
        $data = [
            'detail' => [
                'id' => $period->id,
                'period_status' => $period->status == self::STATUS_IN_PROGRESS ? 0 : 1,
                'product_id' => $period->product_id,
                'period_code' => $period->code,
                'title' => $product->title,
                'product_type' => $product->type,
                'img_cover' => $product->getImgCover(),
                'imgs' => array_merge(self::getImgs($product->imgs), [$product->getImgCover()]),
                'desc_imgs' => self::getImgs($product->desc_imgs),
                'sell_price' => $product->sell_price,
                'bid_step' => $product->pay_amount,
                'price_add_length' => $product->price_add_length,
                'init_price' => $product->init_price,
                'countdown' => $product->countdown_length,
                'countdown_length' => ($x = $redis->ttl('period@countdown' . $period->id)) > 0 ? $x : 0,
                'is_gift_bids_enable' => 1,
                'collection_users_count' => $product->collection_count,
                'bid_users_count' => count($userCount),
                'bid_count' => ($period->bid_price * 10) / $product->pay_amount,
                'buy_by_diff' => $product->buy_by_diff,
                'settlement_bid_id' => $period->bid_id,
                'auctioneer_id' => $period->auctioneer_id,
                'is_favorite' => $collection->isCollect($this->userId, $product->id),
                'product_status' => $product->status,
                'return_proportion' => config('bid.return_proportion') * 100,
                'tags_img' => self::getImg('weipaihangbanner.png'),
                'auction_avatar' => Auctioneer::AUCTION_AVATAR,
                'auction_id' => Auctioneer::AUCTION_ID,
                'auction_name' => Auctioneer::AUCTION_NAME,
                'auctioneer_avatar' => self::getImg($auctioneer->image),
                'auctioneer_tags' => $auctioneer->tags,
                'auctioneer_license' => $auctioneer->number,
                'auctioneer_name' => $auctioneer->name,
            ],
            'guide' => [
                [
                    'id' => 1,
                    'title' => '竞拍指南',
                    'img' => self::getImg('weipaizhinan2.png'),
                    'function' => 'html',
                    'params' => [
                        'key' => 'url',
                        'type' => 'String',
                        'value' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/newbie-guide',
                    ],
                ],
            ],
            'expended' => [
                'used_real_bids' => $expend['bid_currency'],
                'used_gift_bids' => $expend['gift_currency'],
                'used_money' => number_format($expend['bid_currency'], 2),
                'is_buy_differential_able' => $product->buy_by_diff,
                'buy_differential_money' => '0.00',
                'order_sn' => '',
                'order_type' => '',
                'need_to_bided_pay' => 0,
                'need_to_bided_pay_price' => '0.00',
                'return_shop_bids' => 0,
                'pay_status' => 0,
                'pay_time' => 0,
            ],
            'past_deal' => array_chunk($this->dealEnd(['product_id' => $product->id]), 6),
            'proxy' => $proxy,
            'price' =>
                array(
                    'd' => 0,
                    'c' => $period->bid_price,
                    'h' => '',
                    'g' => '',
                    'b' => '',
                    'e' => '',
                    'f' => '',
                    'a' => '',
                ),
            'bid_records' => $bid->bidRecord($period->id),
        ];
        return $this->putCache($cacheKey, $data, 0.025);
    }

//    /** 是否有真人参与 */
//    public function isRealPerson($bidPrice)
//    {
//        $period = DB::table('period')->where([
//            'id' => $bidPrice,
//            'real_person' => self::REAL_PERSON_YES
//        ])->first();
//        return $this->getCache('period@isRealPerson' . $bidPrice, $period, 1);
//    }

    /** 获取所有期数，默认进行中 */
    public function getAll($status = [self::STATUS_IN_PROGRESS], $flag = 10)
    {
        $countdownLength = '';
        if ($flag == 10) {
            $countdownLength = [10];
        } elseif ($flag == 5) {
            $countdownLength = [5];
        } elseif ($flag == 1) {
            $countdownLength = [5, 10];
        }
        $cacheKey = 'period@allInProgress' . json_encode($status) . json_encode($countdownLength);
        if ($this->hasCache($cacheKey)) {
            return $this->getCache($cacheKey);
        } else {
            $periods = DB::table('period')->where([
                'deleted_at' => null,
            ])->whereIn('countdown_length', $countdownLength)->whereIn('status', $status)->get();
            return $this->putCache($cacheKey, $periods, 0.1);
        }
    }

    /**
     * 根据产品保存期数
     */
    public function saveData($productId)
    {
        $res = DB::table('period')->where([
            'product_id' => $productId,
            'status' => self::STATUS_IN_PROGRESS
        ])->first();
        if (!$res) { //确保数据库中没有一个产品同时进行竞拍
            $dayStart = date('Y-m-d', time()) . ' 00:00:00';
            $dayEnd = date('Y-m-d', time()) . ' 23:59:59';

            $check = DB::table('period')
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('product_id', '=', $productId)
                ->orderBy('created_at', 'desc')
                ->first();

            $period = $check ? intval(substr($check->code, -4)) : 0;
            $code = date('Ymd', time()) . str_pad($period + 1, 4, '0', STR_PAD_LEFT);
            $temproduct = Product::find($productId);
            $robot_rate = round($temproduct->init_price / $temproduct->sell_price, 2);
            $data = [
                'product_id' => $productId,
                'bid_price' => $temproduct->init_price,
                'countdown_length' => $temproduct->countdown_length,
                'auctioneer_id' => Auctioneer::randAuctioneer(),
                'status' => self::STATUS_IN_PROGRESS,
                'robot_rate' => config('bid.robot_rate') + $robot_rate,//
                'person_rate' => mt_rand(100, 150) / 100,
                'code' => $code,
            ];
            $result = self::create($data);
            //防止产生重复的数据
            $res = DB::table('period')->select(['id'])->where(['created_at' => $result->created_at])->get()->toArray();
            $ids = array_column($res, 'id');
            if (count($ids) == 2) {
                self::find($ids[0])->forceDelete();
                $id = $ids[1];
            } else {
                $id = $result->id;
            }
            $redis = app('redis')->connection('first');
            //设置倒计时初始时间和初始价格
            $redis->setex('period@countdown' . $id, config('bid.init_countdown'), 1);
            RobotPeriod::batchSave($id, $productId);
        }
    }

    /** 历史成交走势图 */
    public function historyTrend($productId)
    {
        $periods = Period::where([
            'product_id' => $productId,
            'status' => self::STATUS_OVER
        ])->offset($this->offset)->limit($this->limit)->orderBy('created_at', 'desc')->get();
        $list = $bidPrices = $data = [];
        $products = new Product();
        $product = $products->getCacheProduct($productId);
        foreach ($periods as $period) {
            $bidPrices[] = $period->bid_price;
        }
        $averagePrice = round(array_sum($bidPrices) / count($bidPrices), 2);
        foreach ($periods as $period) {

            $list[] = [
                'code' => $period->code,
                'price' => $period->bid_price,
            ];
            if ($period->bid_price - $averagePrice > 0) {
                $flag = 1;
            } else {
                $flag = 0;
            }
            $data[] = [
                'end_time' => $period->bid_end_time,
                'bid_price' => $period->bid_price,
                'flag' => $flag,
                'diff_price' => number_format(abs($period->bid_price - $averagePrice), 2),
                'nickname' => $period->user ? $period->user->nickname : '',
            ];
        }
        $res = [
            'img' => self::getImg($product->img_cover),
            'title' => $product->title,
            'present_price' => $data[0]['bid_price'],
            'max_price' => max($bidPrices),
            'min_price' => min($bidPrices),
            'average_price' => $averagePrice,
            'detail' => $data,
            'list' => $list
        ];
        return $res;
    }

    /** 获取产品表信息 */
    public function Product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    /** 获取用户表信息 */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /** 获取拍卖师表信息 */
    public function Auctioneer()
    {
        return $this->hasOne('App\Models\Auctioneer', 'id', 'auctioneer_id');
    }


    /** 获取拍卖师表信息 */
    public function Order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }


//    public function bid()
//    {
//        return $this->hasMany('App\Models\Bid', 'period_id', 'id');
//    }

    public function getPeriod($where = [])
    {
        if ($model = Period::where($where)->first()) {
            return $model;
        }
        list($info, $status) = $this->returnRes('', self::CODE_NO_DATA);
       self::showMsg($info, $status);

    }
}

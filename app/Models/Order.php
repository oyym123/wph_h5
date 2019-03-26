<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Common
{
    use SoftDeletes;
    protected $table = 'order';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'sn',
        'pay_type',
        'pay_amount',
        'period_id',
        'product_id',
        'product_amount',
        'discount_amount', //折扣后的价格
        'status',
        'buyer_id',
        'evaluation_status', //评价状态
        'address_id', //收货人地址
        'shipping_number', //快运单号
        'shipping_company', //快递公司拼音
        'seller_shipped_at', //卖家发货时间
        'str_address', //收货地址
        'str_username', //收货人姓名
        'str_phone_number', //手机号
        'expired_at', //过期时间
        'type', //类型
        'ip', //ip
        'created_at',
        'updated_at',
        'signed_at', //签收时间
        'recharge_card_id', //充值卡id
        'gift_amount', //赠送的金额
    ];

    const TYPE_BID = 1;                 //竞拍类型
    const TYPE_BUY_BY_DIFF = 2;         //差价购买
    const TYPE_SHOP = 3;                //购物币全款购买
    const TYPE_AUTO_BID = 4;            //自动竞拍支付
    const TYPE_RECHARGE = 5;            //充值

    const STATUS_WAIT_PAY = 10;         // 待付款
    const STATUS_PAYED = 15;            // 已付款
    const STATUS_WAIT_SHIP = 20;        // 待发货
    const STATUS_SHIPPED = 25;          // 已发货
    const STATUS_CONFIRM_RECEIVING = 50;// 买家已签收

    const STATUS_COMPLETE = 100;        // 已完成

    const STATUS_EVALUATION_YES = 1;    //已评价
    const STATUS_EVALUATION_NO = 0;     //未评价


    /** 获取类型 */
    public static function getType($key = 999)
    {
        $data = [
            self::TYPE_BID => '竞拍类型',
            self::TYPE_BUY_BY_DIFF => '差价购买',
            self::TYPE_SHOP => '购物币购买',
            //   self::TYPE_AUTO_BID => '自动竞拍支付订单',
            self::TYPE_RECHARGE => '充值',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    public static function getStatus($key = 999)
    {
        $data = [
            self::STATUS_WAIT_PAY => '待付款',
            self::STATUS_PAYED => '已付款',
            self::STATUS_WAIT_SHIP => '待发货',
            self::STATUS_SHIPPED => '已发货',
            self::STATUS_CONFIRM_RECEIVING => '待晒单',
            self::STATUS_COMPLETE => '已完成',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 创建订单 */
    public function createOrder($data)
    {
        return self::create($data);
    }

    /** 物流信息 */
    public function transportDetail($sn, $userId)
    {
        $order = Order::where([
            'sn' => $sn,
            'buyer_id' => $userId,
        ])->whereIn('status', [self::STATUS_SHIPPED, self::STATUS_CONFIRM_RECEIVING, self::STATUS_COMPLETE])->first();
        if (!$order) {
            self::showMsg('没有该订单!', self::CODE_ERROR);
        }
        $product = $order->product;
        $address = $order->userAddress;
        $data = [
            'status' => $order->status,
            'begin_at' => $order->created_at,
            'amount' => $order->pay_amount,
            'audit_at' => self::changeTime($order->created_at, rand(10, 600)),
            'prepare' => self::changeTime($order->created_at, rand(100, 3600)),
            'sn' => $order->sn,
            'delivery_at' => $order->seller_shipped_at,
            'delivery_company' => $order->shipping_company,
            'delivery_number' => $order->shipping_number,
            //'delivery_detail' => Shipping::shippingLogs($order->shipping_company, $order->shipping_number),
            'signed_at' => $order->signed_at,
            'product_info' => [
                'img_cover' => $product->getImgCover(),
                'sell_price' => $product->sell_price,
                'nickname' => User::find($order->buyer_id)->nickname,
                'save_price' => ($x = round(((1 - ($order->pay_amount / $product->sell_price)) * 100), 1)) > 0 ? $x : '0.0'
            ],
            'address_info' => [
                'username' => $address->user_name,
                'telephone' => $address->telephone,
                'address' => str_replace('||', ' ', $address->str_address) . $address->detail_address
            ]
        ];
        return $data;
    }

    /** 确认收货 */
    public function confirmReceipt($sn, $userId)
    {
        $order = $this->getOrder([
            'sn' => $sn,
            'buyer_id' => $userId,
            'status' => self::STATUS_SHIPPED
        ]);
        return Order::where(['id' => $order->id])->update([
            'status' => self::STATUS_CONFIRM_RECEIVING,
            'signed_at' => date('Y-m-d H:i:s', time())
        ]);
    }

    /** 创建订单号 */
    public function createSn()
    {
        $rand = mt_rand(1111, 9999);
        list($milli, $sec) = explode(" ", microtime());
        $milliSecond = str_pad(round($milli * 1000000), 6, '0', STR_PAD_RIGHT);
        $sn = date('YmdHis', time()) . $milliSecond . $rand;
        if (!Order::where(['sn' => $sn])->first()) { //当数据库中不存在该订单号时返回
            return $sn;
        } else { //当数据库中存在这个订单号，则再调用一次，一般不可能存在
            list($milli, $sec) = explode(" ", microtime());
            $milliSecond = str_pad(round($milli * 1000000), 6, '0', STR_PAD_RIGHT);
            $sn = date('YmdHis', time()) . $milliSecond . $rand;
            return $sn;
        }
    }

    public static function counts($today = 0)
    {
        if ($today) {
            return DB::table('order')
                ->whereBetween('created_at', [date('Y-m-d', time()), date('Y-m-d', time()) . ' 23:59:59'])
                ->count();
        } else {
            return DB::table('order')
                ->count();
        }
    }

    /** 取消订单 */
    public function cancel($sn)
    {
        $model = $this->getOrder([
            'sn' => $sn,
            'buyer_id' => $this->userId,
            'status' => Order::STATUS_WAIT_PAY
        ]);
        // $model->withTrashed()->restore();
        return $model->delete();
    }

    /** 获取订单详情 */
    public function getOrder($where = [])
    {
        if ($model = self::where($where)->first()) {
            return $model;
        }
        self::showMsg('订单不存在!', self::CODE_NO_DATA);
    }


    /** 获取购物可以币抵消的价格 */
    public function getDiscountAmount($productId, $userId)
    {
        return Vouchers::getAmount($productId, $userId);
    }

    /** 获取最终支付价格 */
    public function getPayAmount($data)
    {
        //购物币全价购买时,并且使用购物币,且该产品允许购物币全款购买
        if ($data['type'] == Order::TYPE_SHOP && $data['used_shopping'] == 1 && $data['is_shop'] == 1) {
            $discountAmount = $data['shopping_currency'];
        } elseif ($data['type'] == Order::TYPE_BUY_BY_DIFF && $data['used_shopping'] == 1) { //差价购买时,并且使用购物币
            $amount = $this->getDiscountAmount($data['product_id'], $data['user_id']);
            if (($data['shopping_currency'] - $amount) < 0) {
                $discountAmount = $data['shopping_currency'];
            } else {  //竞拍成功购买时,不允许折扣
                $discountAmount = $amount;
            }
        } else {
            $discountAmount = 0;
        }

        $price = $data['amount'] - $discountAmount; //最终价格
        if ($price < 0) {
            $payAmount = 0;
            $discountAmount = $data['amount'];
        } else {
            $payAmount = $price;
        }
        return [$payAmount, $discountAmount]; //返回支付价格 和 折扣价格
    }

    /** 获取拍期数表信息 */
    public function Period()
    {
        return $this->hasOne('App\Models\Period', 'id', 'period_id');
    }

    /** 获取收货人表信息 */
    public function UserAddress()
    {
        return $this->hasOne('App\Models\UserAddress', 'id', 'address_id');
    }

    /** 获取拍产品表信息 */
    public function Product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    /** 获取用户表信息 */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'buyer_id');
    }
}

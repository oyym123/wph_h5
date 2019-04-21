<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/10
 * Time: 15:43
 */

namespace App\H5\Controllers;


use App\H5\components\WebController;
use App\Models\NewPay;
use App\Models\Order;
use App\Models\Pay;
use App\Models\Period;
use App\Models\Product;
use App\Models\RechargeCard;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PayController extends WebController
{
    /**
     * @SWG\Get(path="/api/pay/recharge-center",
     *   tags={"支付"},
     *   summary="充值中心",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function rechargeCenter()
    {
        return view('h5.pay.recharge-center', (new RechargeCard())->lists());
    }


    /**
     * @SWG\Get(path="/api/pay/confirm",
     *   tags={"支付"},
     *   summary="确认订单",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="product_id", in="formData", default="14", description="产品id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="period_id", in="formData", default="396", description="期数id【有的话就传，没有不传】",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="formData", default="2342352133", description="订单号【有的话就传，没有不传】",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
    [data] => Array
    (
    [address_info] => Array 【地址信息,没有数据address_info为空】
    (
    [address_id] => 23
    [username] => 王小明
    [telephone] => 18779284935
    [address] => 吉林省 通化市 东昌区西路103号
    )
    [pay_amount] => 29 【实际支付价格】
    [discount_amount] => 1.00 【折扣价格】
    [sell_price] => 30.00   【市场价】
    [product_id] => 14  【产品id】
    [period_id] => 397  【期数id】
    [sn] =>  2342352133 【订单号】
    [img_cover] => http://pccz39pca.bkt.clouddn.com/images/1496208238144.png
    )
     *     "
     *   )
     * )
     */
    public function confirm()
    {
        $this->auth();
        $request = $this->request;
        $orderObj = new Order();
        $product = (new Product())->getCacheProduct($request->product_id);
        $address = UserAddress::defaultAddress($this->userId);
        $addressInfo = [];
        if ($address) {
            $addressInfo = [
                'address_id' => $address->id,
                'username' => $address->user_name,
                'telephone' => $address->telephone,
                'address' => str_replace('||', ' ', $address->str_address) . $address->detail_address
            ];
        }

        $payAmount = $product->sell_price;
        $isShop = $periodId = 0;

        //预先当成全购物币购买处理
        $type = Order::TYPE_SHOP;

        if ($request->period_id) { //当有期数id,表示参与过竞拍
            $period = (new Period())->getPeriod([
                'id' => $request->period_id,
                'product_id' => $product->id,
                'status' => Period::STATUS_OVER
            ]);
            if ($period) {
                $periodId = $period->id;
                if ($period->user_id == $this->userId) {
                    $type = Order::TYPE_BID;
                    $payAmount = $period->bid_price;
                } else {
                    $type = Order::TYPE_BUY_BY_DIFF;
                }
            }
        } else {
            $type = Order::TYPE_SHOP;
            if ($product->is_shop) {
                $isShop = $product->is_shop;
            }
        }

        $data = [
            'amount' => $payAmount,
            'product_id' => $product->id,
            'shopping_currency' => $this->userIdent->shopping_currency,
            'user_id' => $this->userId,
            'type' => $type, //购买类型
            'used_shopping' => 1,  //默认使用购物币
            'is_shop' => $isShop
        ];
        list($amount, $discountAmount) = $orderObj->getPayAmount($data);

        if ($request->sn) {
            $order = Order::where([
                'sn' => $request->sn,
                'buyer_id' => $this->userId,
            ])->first();
            if ($order) {
                $periodId = $order->period_id;
                $amount = $order->pay_amount;
                $discountAmount = $order->discount_amount;
            }
        }

        $res = [
            'address_info' => $addressInfo,
            'sell_price' => $product->sell_price,//市场价
            'discount_amount' => round($discountAmount, 2),//使用的购物币
            'pay_amount' => round($amount, 2), //实际支付价格
            'product_id' => $product->id, //产品id
            'period_id' => $periodId,
            'sn' => $request->sn,
            'img_cover' => $product->getImgCover(),
            'order_type' => $type
        ];

        return view('h5.pay.confirm', $res);
    }

    /**
     * @SWG\Get(path="/api/pay/recharge",
     *   tags={"支付"},
     *   summary="充值",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="id", in="formData", default="1", description="充值卡id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *              [state] => 1
     *              [timeStamp] => 1534418590
     *              [nonceStr] => kREaNmSVurnZgUiegWmYkpkSfftTvvyK
     *              [signType] => MD5
     *              [package] => prepay_id=wx16192310839885759ce8cb760225893217
     *              [paySign] => CFA72D66F71040AC73FF22FC7FDD1F95
     *              [out_trade_no] => 201808161923103569554853
     *     "
     *   )
     * )
     */
    public function recharge()
    {
        $this->auth();
        $request = $this->request;
        $rechargeCard = new RechargeCard();
        $recharge = $rechargeCard->getRechargeCard(['id' => $request->id]);
        $order = new Order();
        $orderInfo = [
            'sn' => $order->createSn(),
            'pay_type' => Pay::TYPE_WEI_XIN,
            'pay_amount' => number_format($recharge->amount),
            'status' => Order::STATUS_WAIT_PAY,
            'type' => Order::TYPE_RECHARGE,
            'buyer_id' => $this->userId,
            'ip' => $request->getClientIp(),
            'gift_amount' => $recharge->gift_amount,
            'recharge_card_id' => $recharge->id,
        ];
        $res = [];
       // print_r($orderInfo);exit;
        DB::beginTransaction();
        try {
            $order = $order->createOrder($orderInfo);
            $pay = new NewPay();
            $data = [
                'details' => '充值',
                'open_id' => $this->userIdent->open_id,
                'sn' => $order->sn,
                'order_id' => $order->id,
                'amount' => $order->pay_amount,
                'user_id' => $order->buyer_id
            ];
            $res = $pay->WxPay($data);
            echo $res;//跳转微信H5支付
//            if ($res['state'] == 0) {
//                throw new \Exception($res['result_msg']);
//            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            self::showMsg($e->getMessage(), 4); // 等待处理
        }
      //  self::showMsg($res);
    }

    /**
     * @SWG\Get(path="/api/pay/pay",
     *   tags={"支付"},
     *   summary="立即购买",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="product_id", in="formData", default="2", description="产品id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="period_id", in="formData", default="396", description="期数id",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="formData", default="2", description="订单号",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="used_shopping", in="formData", default="1", description="是否使用购物币【1=使用,0=不使用】", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="message", in="formData", default="2", description="留言", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *              [state] => 1
     *              [timeStamp] => 1534418590
     *              [nonceStr] => kREaNmSVurnZgUiegWmYkpkSfftTvvyK
     *              [signType] => MD5
     *              [package] => prepay_id=wx16192310839885759ce8cb760225893217
     *              [paySign] => CFA72D66F71040AC73FF22FC7FDD1F95
     *              [out_trade_no] => 201808161923103569554853
     *     "
     *   )
     * )
     */
    public function pay()
    {
        $this->auth();
        $request = $this->request;
        //生成一个订单
        $orderObj = new Order();
        $product = (new Product())->getCacheProduct($request->product_id);
        $address = UserAddress::defaultAddress($this->userId);
        if (!$address) {
            self::showMsg('请选择一个默认的收货地址！', 4);
        }
        $res = [];
        $payAmount = $product->sell_price;
        $isShop = $periodId = 0;

        //预先当成全购物币购买处理
        $type = Order::TYPE_SHOP;

        if ($request->period_id) { //当有期数id,表示参与过竞拍
            $period = (new Period())->getPeriod([
                'id' => $request->period_id,
                'product_id' => $product->id,
                'status' => Period::STATUS_OVER
            ]);
            if ($period) {
                $periodId = $period->id;
                if ($period->user_id == $this->userId) {
                    $type = Order::TYPE_BID;
                    $payAmount = $period->bid_price;
                } else {
                    $type = Order::TYPE_BUY_BY_DIFF;
                }
            }
        } else {
            $type = Order::TYPE_SHOP;
            if ($product->is_shop) {
                $isShop = $product->is_shop;
            }
        }

        $status = Order::STATUS_WAIT_PAY;
        $order = null;
        if ($request->sn) {
            $order = Order::where([
                'sn' => $request->sn,
                'buyer_id' => $this->userId,
            ])->first();
            $type = $order->type;
            $periodId = $order->period_id;
        }

        $data = [
            'amount' => $payAmount,
            'product_id' => $product->id,
            'shopping_currency' => $this->userIdent->shopping_currency,
            'user_id' => $this->userId,
            'type' => $type, //购买类型
            'used_shopping' => $request->used_shopping,  //是否使用购物币
            'is_shop' => $isShop
        ];
        list($amount, $discountAmount) = $orderObj->getPayAmount($data);
        $flag = 0;
        DB::beginTransaction();
        try {
            if ($amount == 0) {
                $status = Order::STATUS_WAIT_SHIP;//待发货
            } else {
                if ($type == Order::TYPE_SHOP) {
                    //    $flag = 2;
                }
            }
            $orderInfo = [
                'pay_type' => Pay::TYPE_WEI_XIN,
                'pay_amount' => $amount,
                'product_amount' => $product->sell_price,
                'product_id' => $product->id,
                'period_id' => $periodId,
                'discount_amount' => $discountAmount,
                'status' => $status,
                'type' => $type,
                'buyer_id' => $this->userId,
                'address_id' => $address->id, //收货人地址
                'str_address' => str_replace('||', ' ', $address->str_address) . $address->detail_address,
                'str_username' => $address->user_name, //收货人姓名
                'ip' => $request->getClientIp(),
                'str_phone_number' => $address->telephone, //手机号
                'expired_at' => config('bid.order_expired_at'), //过期时间
            ];

            if ($order && $order->status == Order::STATUS_WAIT_PAY) {
                if (Order::where(['id' => $order->id])->update($orderInfo)) {
                    $order = Order::find($order->id);
                } else {
                    throw new \Exception('更新订单失败！');
                }
            } else {
                $orderInfo['sn'] = $orderObj->createSn();
                $order = $orderObj->createOrder($orderInfo);
            }

            if ($order->pay_amount == 0) {
                //表示使用了购物币打折,需要从用户账户中扣除
                DB::table('users')->where([
                    'id' => $order->buyer_id
                ])->decrement('shopping_currency', $order->discount_amount);
                if ($type == Order::TYPE_BUY_BY_DIFF) {
                    DB::table('vouchers')->where([
                        'product_id' => $data['product_id'],
                        'user_id' => $data['user_id']
                    ])->decrement('amount', $order->discount_amount);
                }
                $flag = 1;
            } else {
                $pay = new NewPay();
                $data = [
                    'details' => mb_substr($product->title, 0, 80),
                    'order_id' => $order->id,
                    'open_id' => $this->userIdent->open_id,
                    'sn' => $order->sn,
                    'amount' => $order->pay_amount,
                    'user_id' => $order->buyer_id
                ];
                $res = $pay->WxPay($data);
                echo $res;//跳转微信H5支付
//                if ($res['state'] == 0) {
//                    throw new \Exception($res['result_msg']);
//                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            self::showMsg($e->getMessage(), 4); // 等待处理
        }

        if ($flag === 1) { //表示购物币购买
            self::showMsg('您已支付成功!', 4);
        } elseif ($flag === 2) {
            self::showMsg('抱歉,您的购物币不足!', 4);
        } else {
            self::showMsg($res);
        }
    }
}

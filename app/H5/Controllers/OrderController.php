<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/5
 * Time: 19:11
 */

namespace App\H5\Controllers;


use App\Api\components\WebController;
use App\Models\Common;
use App\Models\Order;
use App\Models\Pay;
use App\Models\Period;
use App\Models\Product;
use App\Models\UserAddress;
use App\Models\Vouchers;
use Illuminate\Support\Facades\DB;

class OrderController extends WebController
{
    /**
     * @SWG\Get(path="/api/order/my-auction",
     *   tags={"我的竞拍"},
     *   summary="我的竞拍",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="type", in="query", default="0", description="（100= 全部 , 0 = 我在拍 , 1= 我拍中 , 2 = 差价购 , 3= 待付款 , 4 = 待签收 , 5 = 待晒单）" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *              period_id => 期数id
     *              product_id => 产品id
     *              period_code => 期数代码
     *              title => 标题
     *              img_cover => 封面url地址
     *              bid_step => 竞拍步骤
     *              product_type => 产品类型
     *              is_purchase_enable => 是否可加价
     *              sell_price => 售价
     *              num => 出价次数
     *              pay_real_price => 真正成交价格
     *              end_time => 结束时间
     *              is_long_history => 是否很长时间
     *              sn => 订单号
     *              bid_type => 竞拍类型 （1 = 正常竞拍 , 2 = 差价购买）
     *              order_type=> 订单类型 （ 1 = 竞拍类型 , 2 = 差价购买 ,3 = 购物币购买）
     *              order_status => 订单类型 （ 10 = 未支付 , 15 = 已付款 ,20 = 待发货 , 25 = 已发货 , 50 = 买家已签收 , 100 = 已完成）
     *              result_status => 结果类型 （100= 全部 , 0 = 我在拍 , 1= 我拍中 , 2 = 差价购 , 3= 待付款 ,6=待发货 4 = 待签收 , 5 = 待晒单）
     *              pay_status => 支付状态 （10=>未支付 , 20=已支付）
     *              pay_time => 支付时间
     *              pay_price => 支付价格
     *              pay_shop_bids => 支付商铺竞价
     *              order_time => 订单时间
     *              check_status => 检查状态
     *              return_voucher_bids => 返还的购物币
     *              nickname => 昵称
     *              show_confirm_trans => 是否展示确认收货按钮
     *     "
     *   )
     * )
     */
    public function MyAuction()
    {
        $this->auth();
        $request = $this->request;
        $user = $this->userIdent;
        $res = [];
        $data = array(
            'period_id' => 0,
            'product_id' => 13,
            'period_code' => '',
            'title' => '',
            'img_cover' => '',
            'bid_step' => 1,
            'product_type' => 0,
            'is_purchase_enable' => 1,
            'sell_price' => '8787.00',
            'num' => 0,
            'pay_real_price' => '862.00',
            'end_time' => '',
            'label' => '',
            'is_long_history' => 0,
            'sn' => '',
            'bid_type' => 0,
            'order_status' => 0,
            'order_type' => 1,
            'result_status' => 99,
            'pay_status' => Pay::STATUS_UNPAID,
            'pay_time' => '',
            'save_price' => 0,
            'pay_price' => 0,
            'pay_shop_bids' => 0,
            'order_time' => '',
            'check_status' => 0,
            'return_voucher_bids' => 0,
            'nickname' => $user->nickname,
            'show_confirm_trans' => 0,
        );

        if ($request->type == 100) {
            $types = [0, 1, 2, 3, 4, 5];
        } else {
            $types = [$request->type];
        }
        $result = [];
        foreach ($types as $key => $type) {
            switch ($type) {
                case 0: //我在拍
                    //  $bids = Period::find(39)->bid()->where(['id' => 755])->first();
                    $expend = DB::table('expend')
                        ->select('period_id')
                        ->where(['user_id' => $this->userId])
                        ->groupBy('period_id')
                        ->get()->toArray();
                    $periodIds = array_column($expend, 'period_id');

                    $periods = Period::whereIn('id', $periodIds)->where([
                        'status' => Period::STATUS_IN_PROGRESS
                    ])->offset($this->offset)->limit($this->limit)->get();

                    foreach ($periods as $period) {
                        $product = $period->product;
                        $num = DB::table('bid')
                            ->where([
                                'period_id' => $period,
                                'user_id' => $this->userId
                            ])->count('id');
                        $data['period_id'] = $period->id;
                        $data['product_id'] = $period->product_id;
                        $data['period_code'] = $period->code;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $period->bid_step;
                        $data['sell_price'] = $product->sell_price;
                        $data['pay_price'] = $period->bid_price;
                        $data['nickname'] = '...';
                        $data['result_status'] = 0;
                        $data['num'] = $num; //出价次数
                        $res[] = $data;
                    }
                    break;
                case 1: //我拍中
                    if ($request->type !== 100) {
                        $status = [Order::STATUS_COMPLETE, Order::STATUS_WAIT_PAY];
                    } else {
                        $status = [Order::STATUS_COMPLETE];
                    }
                    $orders = Order::has('product')
                        ->where([
                            'buyer_id' => $this->userId,
                            //'type' => Order::TYPE_BID,
                        ])->whereIn('status', $status)->offset($this->offset)->limit($this->limit)->get();
                    foreach ($orders as $order) {
                        $product = $order->product;
                        if ($order->period_id == 0) {
                            $periodId = 0;
                            $periodCode = '';
                            $bidStep = '';
                            $savePrice = ($x = round(((1 - ($order->pay_amount / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        } else {
                            $period = $order->period;
                            $periodId = $period->id;
                            $periodCode = $period->code;
                            $bidStep = $period->bid_step;
                            $savePrice = ($x = round(((1 - ($order->pay_amount / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        }

                        $data['period_id'] = $periodId;
                        $data['product_id'] = $order->product_id;
                        $data['period_code'] = $periodCode;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $bidStep;
                        $data['save_price'] = $savePrice;
                        $data['order_type'] = $order->type;
                        $data['sell_price'] = $product->sell_price;
                        $data['pay_price'] = $order->pay_amount;
                        $data['result_status'] = 1;
                        $data['nickname'] = $user->nickname;
                        $data['label'] = Order::getStatus($order->status); //出价次数
                        $data['sn'] = $order->sn;
                        $data['order_time'] = $order->created_at;
                        $data['order_status'] = $order->status;
                        $res[] = $data;
                    }
                    break;
                case 2: //差价购
                    $expend = DB::table('expend')
                        ->select('period_id')
                        ->where(['user_id' => $this->userId])
                        ->groupBy('period_id')
                        ->get()->toArray();
                    $periodIds = array_column($expend, 'period_id');
                    $order = DB::table('order')
                        ->select('period_id')
                        ->where([
                            'buyer_id' => $this->userId,
                        ])->where('status', '<>', Order::STATUS_WAIT_PAY)->get()->toArray();
                    $periodIds = array_diff($periodIds, array_column($order, 'period_id'));
                    $periods = Period::whereIn('id', $periodIds)->where([
                        'status' => Period::STATUS_OVER
                    ])->where('user_id', '<>', $this->userId)->offset($this->offset)->limit($this->limit)->get();
                    foreach ($periods as $period) {
                        $product = $period->product;
                        $payAmount = DB::table('bid')
                            ->where([
                                'period_id' => $period->id,
                                'user_id' => $this->userId,
                                'pay_type' => Common::TYPE_BID_CURRENCY
                            ])->sum('pay_amount');
                        $data['period_id'] = $period->id;
                        $data['product_id'] = $period->product_id;
                        $data['period_code'] = $period->code;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $period->bid_step;
                        $data['sell_price'] = $product->sell_price;
                        $data['nickname'] = ($x = $period->user) ? $x->nickname : '';
                        $data['pay_price'] = $period->bid_price;
                        $data['result_status'] = 2;
                        $data['return_voucher_bids'] = $payAmount * config('bid.return_proportion');
                        $res[] = $data;
                    }
                    break;
                case 3: //待付款
                    $orders = Order::has('product')
                        ->where([
                            'buyer_id' => $this->userId,
                            'status' => Order::STATUS_WAIT_PAY
                        ])->offset($this->offset)->limit($this->limit)->get();
                    foreach ($orders as $order) {
                        $product = $order->product;
                        if ($order->period_id == 0) {
                            $periodId = 0;
                            $periodCode = '';
                            $bidStep = '';
                        } else {
                            $period = $order->period;
                            $periodId = $period->id;
                            $periodCode = $period->code;
                            $bidStep = $period->bid_step;
                        }

                        $data['period_id'] = $periodId;
                        $data['product_id'] = $order->product_id;
                        $data['period_code'] = $periodCode;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $bidStep;
                        $data['bid_type'] = $order->type;
                        $data['sell_price'] = $product->sell_price;
                        $data['pay_price'] = $order->pay_amount;
                        $data['result_status'] = 3;
                        $data['order_type'] = $order->type;
                        $data['nickname'] = $user->nickname;
                        $data['label'] = Order::getStatus($order->status);
                        $data['sn'] = $order->sn;
                        $data['order_time'] = $order->created_at;
                        $data['order_status'] = $order->status;
                        $res[] = $data;
                    }
                    break;
                case 6: //待发货
                    $orders = Order::has('product')
                        ->where([
                            'buyer_id' => $this->userId,
                            'status' => Order::STATUS_WAIT_SHIP
                        ])
                        ->offset($this->offset)->limit($this->limit)->get();
                    foreach ($orders as $order) {
                        $product = $order->product;
                        if ($order->period_id == 0) {
                            $periodId = 0;
                            $periodCode = '';
                            $bidStep = '';
                        } else {
                            $period = $order->period;
                            $periodId = $period->id;
                            $periodCode = $period->code;
                            $bidStep = $period->bid_step;
                        }

                        $data['period_id'] = $periodId;
                        $data['product_id'] = $order->product_id;
                        $data['period_code'] = $periodCode;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $bidStep;
                        $data['bid_type'] = $order->type;
                        $data['sell_price'] = $product->sell_price;
                        $data['pay_price'] = $order->pay_amount;
                        $data['result_status'] = 6;
                        $data['order_type'] = $order->type;
                        $data['nickname'] = $user->nickname;
                        $data['label'] = Order::getStatus($order->status);
                        $data['sn'] = $order->sn;
                        $data['order_time'] = $order->created_at;
                        $data['order_status'] = $order->status;
                        $res[] = $data;
                    }
                    break;
                case 4: //待签收
                    $orders = Order::has('product')
                        ->where([
                            'buyer_id' => $this->userId,
                            'status' => Order::STATUS_SHIPPED
                        ])
                        ->offset($this->offset)->limit($this->limit)->get();
                    foreach ($orders as $order) {
                        $product = $order->product;
                        if ($order->period_id == 0) {
                            $periodId = 0;
                            $periodCode = '';
                            $bidStep = '';
                            $savePrice = ($x = round(((1 - ($order->pay_amount / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        } else {
                            $period = $order->period;
                            $periodId = $period->id;
                            $periodCode = $period->code;
                            $bidStep = $period->bid_step;
                            $savePrice = ($x = round(((1 - ($period->bid_price / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        }
                        $data['period_id'] = $periodId;
                        $data['product_id'] = $order->product_id;
                        $data['period_code'] = $periodCode;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $bidStep;
                        $data['sell_price'] = $product->sell_price;
                        $data['save_price'] = $savePrice;
                        $data['pay_price'] = $order->pay_amount;
                        $data['order_type'] = $order->type;
                        $data['result_status'] = 4;
                        $data['nickname'] = $user->nickname;
                        $data['label'] = Order::getStatus($order->status);
                        $data['sn'] = $order->sn;
                        $data['order_time'] = $order->created_at;
                        $data['order_status'] = $order->status;
                        $res[] = $data;
                    }
                    break;
                case 5: //待晒单
                    $orders = Order::has('product')
                        ->where([
                            'buyer_id' => $this->userId,
                            'status' => Order::STATUS_CONFIRM_RECEIVING
                        ])
                        ->offset($this->offset)->limit($this->limit)->get();

                    foreach ($orders as $order) {
                        $product = $order->product;
                        if ($order->period_id == 0) {
                            $periodId = 0;
                            $periodCode = '';
                            $bidStep = '';
                            $savePrice = ($x = round(((1 - ($order->pay_amount / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        } else {
                            $period = $order->period;
                            $periodId = $period->id;
                            $periodCode = $period->code;
                            $bidStep = $period->bid_step;
                            $savePrice = ($x = round(((1 - ($period->bid_price / $product->sell_price)) * 100), 1)) > 0 ? $x : 0.0;
                        }

                        $data['period_id'] = $periodId;
                        $data['product_id'] = $order->product_id;
                        $data['period_code'] = $periodCode;
                        $data['title'] = $product->title;
                        $data['img_cover'] = $product->getImgCover();
                        $data['bid_step'] = $bidStep;
                        $data['order_type'] = $order->type;
                        $data['sell_price'] = $product->sell_price;
                        $data['save_price'] = $savePrice;
                        $data['pay_price'] = $order->pay_amount;
                        $data['result_status'] = 5;
                        $data['label'] = Order::getStatus($order->status);
                        $data['sn'] = $order->sn;
                        $data['order_time'] = $order->created_at;
                        $data['order_status'] = $order->status;
                        $res[] = $data;
                    }
                    break;
            }
            $result = $result + $res;
        }
        if (empty($result) && $this->offset == 0) {
            self::showMsg('没有数据', 2);
        }
        self::showMsg($result);
    }


    /**
     * @SWG\Get(path="/api/order/cancel-order",
     *   tags={"我的竞拍"},
     *   summary="取消订单",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="query", default="201807312348483696031716", description="订单号", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function cancelOrder()
    {
        $this->auth();
        $order = new Order();
        $order->userId = $this->userId;
        if ($order->cancel($this->request->sn) == 1) {
            self::showMsg('取消订单成功！', 0);
        } else {
            self::showMsg('取消订单失败！', 4);
        }
    }


    /**
     * @SWG\Get(path="/api/order/confirm-receipt",
     *   tags={"我的竞拍"},
     *   summary="确认收货",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="query", default="201807312348483696031716", description="订单号", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function confirmReceipt()
    {
        $this->auth();
        $order = new Order();
        $res = $order->confirmReceipt($this->request->sn, $this->userId);
        if ($res) {
            self::showMsg(['status' => 0, 'info' => '确认收货成功！']);
        } else {
            self::showMsg(['status' => -1, 'info' => '确认收货失败！']);
        }
    }

    /**
     * @SWG\Get(path="/api/order/transport-detail",
     *   tags={"我的竞拍"},
     *   summary="物流详情",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="query", default="201807312348483696031716", description="订单号", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                      [sn] => 201807312348483696031716
     *                      [status] => 50 (订单状态)
     *                      [begin_at] => 2018-07-31 23:48:48 (开始时间)
     *                      [amount] => 0.60  (成交价)
     *                      [audit_at] => 2018-07-31 23:48:48 （审核时间）
     *                      [prepare] => 2018-07-31 23:48:48   （准备时间）
     *                      [delivery_at] => 2018-08-05 20:10:54 （发货时间）
     *                      [delivery_company] => 京东快递         （快递公司）
     *                      [delivery_number] => 3370492175597    （快运单号号）
     *                      [delivery_detail] => Array  [这个字段暂时不用]
     *                          (
     *                              [6] => Array
     *                              (
     *                                  [title] => 由【福建福安公司】 发往 【福建福州转运中心】
     *                                  [date_time] => 2018-08-04 16:04:47
     *                              )
     *
     *                              [7] => Array
     *                              (
     *                                  [title] => 【福建福安公司】-已进行装袋扫描
     *                                  [date_time] => 2018-08-04 16:00:22
     *                              )
     *
     *                              [8] => Array
     *                              (
     *                                  [title] => 由【福建福安公司】 发往 【福建福州转运中心】
     *                                  [date_time] => 2018-08-04 16:00:22
     *                              )
     *
     *                              [9] => Array
     *                              (
     *                                  [title] => 【福建福安公司】 的收件员 陈秀丽已收件
     *                                  [date_time] => 2018-08-04 14:33:32
     *                              )
     *                      [signed_at] => 2018-07-31 23:48:48 (签收时间)
     *                      [product_info] => Array
     *                          (
     *                              [img_cover] => http://od83l5fvw.bkt.clouddn.com/images/1505283933090.png
     *                              [sell_price] => 0.60
     *                              [nickname] => 小米
     *                              [save_price] => 89 【节约比例】
     *                          )
     *
     *                      [address_info] => Array
     *                          (
     *                              [username] => 王小明12  （用户名）
     *                              [telephone] => 18779284935   （手机号）
     *                              [address] => 吉林省 通化市 东昌区西路103号  （地址）
     *                          )
     *
     *     "
     *   )
     * )
     */
    public function transportDetail()
    {
        $this->auth();
        self::showMsg((new order())->transportDetail($this->request->sn, $this->userId));
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/16
 * Time: 20:58
 */

namespace App\H5\Controllers;


use App\Api\components\WebController;
use App\Helpers\Helper;
use App\Models\Income;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Pay;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxNotifyController extends Controller
{
    public $enableCsrfValidation = false;

    //微信支付回调验证
    public function notify(Request $request)
    {
        //$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $xml = file_get_contents('php://input');
        //$xml = $request->post();
        //$xml = $xml[1];
        // 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
//        $path = PHP_OS == 'WINNT' ? 'G:/logs/wph.log' : '/www/logs/wph.log';
//        Helper::writeLog($xml, $path);

        //将服务器返回的XML数据转化为数组
        $data = Helper::xmlToArray($xml);
        // 保存微信服务器返回的签名sign
        $data_sign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);

        $sign = (new Pay())->sign($data);
        // 判断签名是否正确  判断支付状态
        if (($sign === $data_sign) && ($data['return_code'] == 'SUCCESS') && ($data['result_code'] == 'SUCCESS')) {
            $result = $data;
            //获取服务器返回的数据
            $order_sn = $data['out_trade_no'];            //订单单号
            $openid = $data['openid'];                    //付款人openID
            $total_fee = $data['total_fee'];            //付款金额
            $transaction_id = $data['transaction_id'];    //微信支付流水号
            //支付成功
            $order = DB::table('order')->where(['sn' => $data['out_trade_no']])->first();
            if ($order->type == Order::TYPE_RECHARGE) {  //当状态为充值时
                $incomes = Income::where(['order_id' => $order->id])->first();
                if ($incomes) {
                    exit('已经充值过了!');
                }
                $amount = $order->pay_amount;
                $giftAmount = $order->gift_amount;

                $income = [
                    'type' => Income::TYPE_BID_CURRENCY,
                    'user_id' => $order->buyer_id,
                    'amount' => $amount,
                    'name' => '充值拍币',
                    'order_id' => $order->id
                ];
                if (!Income::create($income)) {
                    throw new \Exception('充值失败');
                }

                //分成
                (new Invite())->shareMoney($order->buyer_id, $order->pay_amount, $order->id);
                //拍币充值成功
                DB::table('users')->where(['id' => $order->buyer_id])->increment('bid_currency', $amount);
                //送的赠币
                DB::table('users')->where(['id' => $order->buyer_id])->increment('gift_currency', $giftAmount);
                //标记已付款
                DB::table('order')->where(['id' => $order->id])->update(['status' => Order::STATUS_PAYED]);
            } else {
                if ($order->type == Order::TYPE_BUY_BY_DIFF && ($order->discount_amount > 0)) { //差价购买
                    DB::table('vouchers')->where([
                        'product_id' => $order->product_id,
                        'user_id' => $order->buyer_id
                    ])->decrement('amount', $order->discount_amount);
                }

                if ($order->discount_amount > 0) { //表示使用了购物币打折,需要从用户账户中扣除
                    DB::table('users')->where([
                        'id' => $order->buyer_id
                    ])->decrement('shopping_currency', $order->discount_amount);
                }
                //标记待发货
                DB::table('order')->where(['id' => $order->id])->update(['status' => Order::STATUS_WAIT_SHIP]);
            }

            $pay = [
                'out_trade_no' => $data['transaction_id'], //返回流水号
                'weixin_pay_xml' => $xml, //支付参数
                'status' => Pay::STATUS_ALREADY_PAY, //状态
                'out_trade_status' => Pay::getStatus(Pay::STATUS_ALREADY_PAY), //支付状态中文显示
            ];

            DB::table('pay')->where(['order_id' => $order->id])->update($pay);
        } else {
            $result = false;
        }
        // 返回状态给微信服务器
        if ($result) {
            $str = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        } else {
            $str = '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        }
        echo $str;
        // return $result;
    }
}
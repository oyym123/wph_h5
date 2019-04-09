<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 10:51
 */

namespace App\H5\Controllers;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class NewPayController
{


    public function index()
    {
        $order = [
            'out_trade_no' => time(),
            'total_fee' => '1', // **单位：分**
            'body' => 'test body - 测试',
            'openid' => 'onkVf1FjWS5SBIixxxxxxx',
        ];

        $pay = Pay::wechat($this->config)->mp($order);

        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }

    public function weixinPay()
    {
//        echo '<pre>';
//        print_r(config('pay.wechat'));exit;
        $order = [
            'out_trade_no' => time(),
            'body' => 'subject-测试',
            'total_fee' => '1',
            //'openid' => 'odJ8f5U3_HfROOLOEPM7ZPmQRnA8',
        ];
        $result = Pay::wechat(config('pay.wechat'))->wap($order);
        return $result;
    }

    public function aliPay()
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ];
        return Pay::alipay()->wap($order);
    }
}
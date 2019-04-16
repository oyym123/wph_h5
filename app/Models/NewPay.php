<?php


namespace App\Models;

use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class NewPay
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
    }

    public function notify()
    {
        $pay = Pay::wechat(config('pay.wechat'));

        try {
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }

    //微信H5支付
    public function WxPay($data)
    {
        $order = [
            'out_trade_no' => $data['sn'],
            'body' => $data['details'],
            'total_fee' => $data['amount'],
        ];
        $result = Pay::wechat(config('pay.wechat'))->wap($order);
        return $result;
    }

    //支付宝支付
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
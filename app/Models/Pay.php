<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pay extends Common
{
    use SoftDeletes;

    protected $table = 'pay';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'pay_amount',
        'pay_type',
        'status',
        'out_trade_no', //返回的流水号
        'out_trade_status', //支付状态中文显示
        'log',
        'order_id',
        'sn',
        'paid_at', //支付时间
    ];

    const TYPE_WEI_XIN = 1;
    const STATUS_UNPAID = 10;//未支付
    const STATUS_ALREADY_PAY = 20;//已支付

    /** 获取支付状态 */
    public static function getStatus($key = 999)
    {
        $data = [
            self::STATUS_UNPAID => '未支付',
            self::STATUS_ALREADY_PAY => '已支付',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    public function WxPay($res)
    {
        $appid = config('bid.wx_app_id');//appid
        $body = $res['details'];// '金邦汇商城';//'【自己填写】'
        $mch_id = config('bid.wx_mch_id');//'你的商户号【自己填写】'
        $nonce_str = $this->nonce_str();//随机字符串
        $notify_url = $_SERVER["HTTP_HOST"] . '/api/wx-notify/notify';//回调的url【自己填写】';
        //$total_fee = 1;//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
        $total_fee = $res['amount'] * 100;//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
        $openid = $res['open_id'];//'用户的openid【自己填写】';
        $out_trade_no = $res['sn'];//商户订单号
        $spbill_create_ip = '116.62.212.29';//'服务器的ip【自己填写】';
        $trade_type = 'JSAPI';//交易类型 默认
        //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
        $post['appid'] = $appid;
        $post['body'] = $body;

        $post['mch_id'] = $mch_id;

        $post['nonce_str'] = $nonce_str;//随机字符串

        $post['notify_url'] = $notify_url;

        $post['openid'] = $openid;

        $post['out_trade_no'] = $out_trade_no;

        $post['spbill_create_ip'] = $spbill_create_ip;//终端的ip

        $post['total_fee'] = $total_fee;//总金额 最低为一块钱 必须是整数

        $post['trade_type'] = $trade_type;
        $sign = $this->sign($post);//签名
        $post_xml = '<xml>
           <appid>' . $appid . '</appid>
           <body>' . $body . '</body>
           <mch_id>' . $mch_id . '</mch_id>
           <nonce_str>' . $nonce_str . '</nonce_str>
           <notify_url>' . $notify_url . '</notify_url>
           <openid>' . $openid . '</openid>
           <out_trade_no>' . $out_trade_no . '</out_trade_no>
           <spbill_create_ip>' . $spbill_create_ip . '</spbill_create_ip>
           <total_fee>' . $total_fee . '</total_fee>
           <trade_type>' . $trade_type . '</trade_type>
           <sign>' . $sign . '</sign>
        </xml> ';
        //统一接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = Helper::post2($url, $post_xml);
        $array = Helper::xmlToArray($xml);//全要大写
        if ($array['return_code'] == 'SUCCESS' && $array['result_code'] == 'SUCCESS') {
            $time = time();
            $tmp = [];//临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id=' . $array['prepay_id'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";

            $data['state'] = 1;
            $data['timeStamp'] = "$time";//时间戳
            $data['nonceStr'] = $nonce_str;//随机字符串
            $data['signType'] = 'MD5';//签名算法，暂支持 MD5
            $data['package'] = 'prepay_id=' . $array['prepay_id'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->sign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;
            $pay = [
                'pay_amount' => $res['amount'],
                'pay_type' => self::TYPE_WEI_XIN,
                'status' => self::STATUS_UNPAID,
                'out_trade_status' => self::getStatus(self::STATUS_UNPAID), //支付状态中文显示
                'order_id' => $res['order_id'],
                'sn' => $out_trade_no,
                'paid_at' => date('Y-m-d H:i:s', time()), //支付时间
            ];
            $this->saveData($pay);
        } else {
            $data['state'] = 0;
            $data['text'] = "错误";
            $data['return_code'] = $array['return_code'];
            $data['result_msg'] = $array['return_msg'];
        }
        return $data;
    }

    public function saveData($data)
    {
        return Pay::create($data);
    }

    //随机32位字符串
    private function nonce_str()
    {
        $result = '';
        $str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
        for ($i = 0; $i < 32; $i++) {
            $result .= $str[rand(0, 48)];
        }
        return $result;
    }

    //签名 $data要先排好顺序
    public function sign($data)
    {
        ksort($data);
        $stringA = '';
        foreach ($data as $key => $value) {
            if (!$value) continue;
            if ($stringA) $stringA .= '&' . $key . "=" . $value;
            else $stringA = $key . "=" . $value;
        }
        $wx_key = '3173259eA0d5E5d12e3a9b2c90N0Qdb0';//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        $stringSignTemp = $stringA . '&key=' . $wx_key;//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        return strtoupper(md5($stringSignTemp));
    }
}

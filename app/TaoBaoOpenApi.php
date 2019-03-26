<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;


require_once(__DIR__ . "/sdk/taobao/TopSdk.php");

class TaoBaoOpenApi extends Model
{
    public function getKey()
    {
        date_default_timezone_set('Asia/Shanghai');

        $c = new \TopClient;
        $c->appkey = config('aliyun.app_key');
        $c->secretKey = config('aliyun.secret_key');
        return $c;
    }

    /** 阿里大于短信 */
    public function userRegister()
    {
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
//        $req->setExtend($this->params['extend']); //透传信息，可以是用户ID，或不填
        $req->setSmsType("normal");
        $req->setSmsFreeSignName(config('aliyun.sign_name')); //短信签名
        //$req->setSmsParam(json_encode(['code' => '123', 'product' => '1232']));//code=验证码
        $req->setSmsParam(json_encode(['code' => $this->params['code']]));//code=验证码
        $req->setRecNum($this->params['phone_number']);
        $req->setSmsTemplateCode(config('aliyun.template_code')); //短信模板ID
        $resp = $this->getKey()->execute($req);
        return json_encode($resp);
    }
}


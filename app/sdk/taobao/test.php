<?php
include "TopSdk.php";
date_default_timezone_set('Asia/Shanghai');

$c = new TopClient;
$c->appkey = '23311401';
$c->secretKey = '7446accb9b04ee1c3ccbeafdd56cb3f1';
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123");
$req->setSmsType("normal");
$req->setSmsFreeSignName("登录验证");
$req->setSmsParam("验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！");
$req->setRecNum("18606615070");
$req->setSmsTemplateCode("SMS_5018036");
$resp = $c->execute($req);
?>


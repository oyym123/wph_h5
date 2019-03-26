<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2017/11/30
 * Time: 15:59
 */

namespace App\Api\Controllers;

use App\Api\components\WebController;
use EasyWeChat\Support\Log;
use EasyWeChat\Foundation\Application;

class WechatController extends WebController
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function server()
    {
        Log::info('request arrived.');

        $wechat = app('wechat');

        $wechat->server->setMessageHandler(function ($message) {
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');
        return $wechat->server->serve();//这一句是对微信进行了验证
    }

    public function demo(Application $wechat)
    {
        // $wechat 则为容器中 EasyWeChat\Foundation\Application 的实例
    }
}

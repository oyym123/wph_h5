<?php
/**
 * Created by PhpStorm.
 * User: lixinxin
 * Date: 2017/12/03
 * Time: 12:03
 */

namespace App\Api\Controllers;

use App\Api\components\WebController;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;
use Illuminate\Http\Request;

class WeixinOauthCallbackController extends WebController
{
//    function index()
//    {
//
//        try {
//            // file_put_contents('/tmp/test.log', var_export($_REQUEST, 1) . PHP_EOL, FILE_APPEND);
//            // 获取 OAuth 授权结果用户信息
//            $user = self::weixin()->oauth->user();
//            $wechatUser = $user->toArray();
//            session([
//                'wechat_user' => $wechatUser,
////                'bind_mobile' => empty($userInfo->bind_mobile) ? '' : $userInfo->bind_mobile,
////                'user_id' => empty($userInfo->user_id) ? 0 : $userInfo->user_id,
//            ]);
//            session()->save();
//            file_put_contents('/tmp/test.log', var_export($user->toArray(), 1) . PHP_EOL, FILE_APPEND);
//            return Redirect::to($_GET['redirect']);
//        } catch (Exception $e) {
//            echo $e->getMessage();
//        }
//    }
}
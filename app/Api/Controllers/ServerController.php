<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2017/11/30
 * Time: 12:03
 */

namespace App\Api\Controllers;

use App\Api\components\WebController;
use App\UserInfo;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Message\News;

class ServerController extends WebController
{

    function __construct()
    {
        $this->weixin = self::weixin();
    }

    function index()
    {
        // 测试
        file_put_contents('/tmp/test.log', var_export($_POST, 1), FILE_APPEND);
        file_put_contents('/tmp/test.log', var_export($_GET, 1), FILE_APPEND);
        file_put_contents('/tmp/test.log', PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL, FILE_APPEND);
        $this->weixin->server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    if ($message->Event == 'subscribe') {
                        return $this->_subscribe($message);
                    } elseif ($message->Event == 'unsubscribe') {
                        return $this->_unsubscribe($message);
                    } elseif ($message->Event == 'CLICK') {
                        return $this->_click($message);
                    }
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        $response = $this->weixin->server->serve();
        // 将响应输出
        return $response;
    }

    private function _subscribe($message)
    {

        //下面是你点击关注时，进行的操作
//        $userInfo['unionid'] = $message->ToUserName;
        $userInfo['openid'] = $message->FromUserName;
        file_put_contents('/tmp/test.log', var_export($message, 1), FILE_APPEND);
        $user = $this->weixin->user->get($userInfo['openid']);
        $userInfo['subscribed_at'] = $user['subscribe_time'];
        $userInfo['unsubscribed_at'] = 0; // 如果之前取消关注,再次关注则去掉取消关注这个值
        $userInfo['nickname'] = $user['nickname'];
        $userInfo['user_photo'] = $user['headimgurl'];
        $userInfo['sex'] = $user['sex'];
        $userInfo['updated_at'] = time();
        $userInfo['address_str'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['country'];

        try {
            $userInfoItem = DB::table('user_info')->where('openid', $userInfo['openid'])->first();

            DB::beginTransaction(); //开启事务
            if ($userInfoItem) {
                // 更新
                $result = DB::table('user_info')
                    ->where('id', $userInfoItem->id)
                    ->update($userInfo);
                if (!$result) {
                    throw new Exception('更新用户出错');
                }
            } else {
                // 新增
                $id = DB::table('users')->insertGetId([
                    'email' => time() . mt_rand(1000000, 9999999) . '@e.com',
                    'name' => md5($userInfo['openid']),
                    'avatar' => 'users/default.png',
                    'password' => md5($userInfo['openid'] . mt_rand(100000, 999999)),
                    'remember_token' => time(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                if (!$id) {
                    throw new Exception('保存用户出错');
                }
                $userInfoId = DB::table('user_info')->insertGetId([
                        'user_id' => $id,
                        'updated_at' => time(),
                        'created_at' => time(),
                    ] + $userInfo);
                if (!$userInfoId) {
                    throw new Exception('保存用户信息出错');
                }
                $userInfoItem = DB::table('user_info')->where('id', $userInfoId)->first();
            }

            if ($userInfoItem) {
                (new UserInfo())->inviteBind($userInfoItem, $message);
            }

            DB::commit();

            // return "您好！欢迎关注微拍行!";
        } catch (Exception $e) {
            DB::rollback();

            return '您的信息由于某种原因没有保存，请重新关注';
        }

        $this->weixin->server->setMessageHandler(function () {
            $news1 = new News([
                'title' => '德才师父视频',
                'description' => "欣赏德才师父四十二手眼玫瑰掌内功精彩视频请点此注册。(如已注册，则直接进入视频中心)",
                'url' => config('app.url') . 'api/article',
                'image' => 'https://mmbiz.qpic.cn/mmbiz_png/16rcM8fWf9bL4rozl7Ix2gsS45HGqewwibwKStKzicUIlPtTKX1zOggJ32tXialgRbogsIFfOHw94SJQMtQAmicehQ/640?wx_fmt=png&wxfrom=5&wx_lazy=1',
            ]);
            return [$news1];
        });
        return $this->weixin->server->serve()->send();
    }

    private function _unsubscribe($message)
    {
        DB::table('user_info')
            ->where('openid', $message->FromUserName)
            ->update([
                'unsubscribed_at' => time()
            ]);
    }


    function test()
    {

        // 测试积分
        DB::beginTransaction(); //开启事务
        try {
            $userInfoItem = DB::table('user_info')->where('user_id', 7)->first();

            (new UserInfo())->bindMobileAndAwardInviter($userInfoItem);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        DB::commit();
        exit;

    }
}
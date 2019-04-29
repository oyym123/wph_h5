<?php


namespace App\Models;


class Weibo
{
    public $wbA;
    public $wbC;

    public function __construct($access_token = '')
    {
        include_once(__DIR__ . '/SaeTOAuthV2.php');
        //认证
        $this->wbA = new SaeTOAuthV2(config('weibo.wb_akey'), config('weibo.wb_skey'));

    }

    /** 第一步登入地址 */
    public function getUrl()
    {
        $code_url = $this->wbA->getAuthorizeURL('https://' . $_SERVER['HTTP_HOST'] . '/h5/user/wb-login', 'code', NULL, 'mobile');
        return $code_url;
    }

    /** 第二步获取AccessToken以及uid */
    public function getAccessToken($code)
    {
        $keys = [
            'code' => $code,
            'redirect_uri' => 'https://' . $_SERVER['HTTP_HOST'] . '/h5/user/wb-login'
        ];

        /** @var
         * $res
         * {
         * "access_token": "ACCESS_TOKEN",
         * "expires_in": 1234,
         * "remind_in":"798114",
         * "uid":"12341234"
         * }
         */
        $res = $this->wbA->getAccessToken('code', $keys);
        //第三步
        $this->wbC = new SaeTClientV2(config('weibo.wb_akey'), config('weibo.wb_skey'), $res['access_token']);
        //获取用户信息
        $userInfo = $this->wbC->show_user_by_id($res['uid']);
        return $userInfo;
    }
}
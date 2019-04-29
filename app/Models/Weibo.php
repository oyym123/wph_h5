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
        $userInfo = $this->wbC->show_user_by_id($res['uid']);
        return $userInfo + ['uid' => $res['uid']];

        /**
         * {
         * "id": 1404376560,
         * "screen_name": "zaku",
         * "name": "zaku",
         * "province": "11",
         * "city": "5",
         * "location": "北京 朝阳区",
         * "description": "人生五十年，乃如梦如幻；有生斯有死，壮士复何憾。",
         * "url": "http://blog.sina.com.cn/zaku",
         * "profile_image_url": "http://tp1.sinaimg.cn/1404376560/50/0/1",
         * "domain": "zaku",
         * "gender": "m",
         * "followers_count": 1204,
         * "friends_count": 447,
         * "statuses_count": 2908,
         * "favourites_count": 0,
         * "created_at": "Fri Aug 28 00:00:00 +0800 2009",
         * "following": false,
         * "allow_all_act_msg": false,
         * "geo_enabled": true,
         * "verified": false,
         * "status": {
         * "created_at": "Tue May 24 18:04:53 +0800 2011",
         * "id": 11142488790,
         * "text": "我的相机到了。",
         * "source": "<a href="http://weibo.com" rel="nofollow">新浪微博</a>",
         * "favorited": false,
         * "truncated": false,
         * "in_reply_to_status_id": "",
         * "in_reply_to_user_id": "",
         * "in_reply_to_screen_name": "",
         * "geo": null,
         * "mid": "5610221544300749636",
         * "annotations": [],
         * "reposts_count": 5,
         * "comments_count": 8
         * },
         * "allow_all_comment": true,
         * "avatar_large": "http://tp1.sinaimg.cn/1404376560/180/0/1",
         * "verified_reason": "",
         * "follow_me": false,
         * "online_status": 0,
         * "bi_followers_count": 215
         * }
         */
    }

}
<?php


namespace App\Models;


class Weibo
{
    public function getUrl()
    {
        include_once(__DIR__ . '/SaeTOAuthV2.php');
        $o = new SaeTOAuthV2(config('weibo.wb_akey'), config('weibo.wb_skey'));
        $code_url = $o->getAuthorizeURL($_SERVER['HTTP_HOST'] . '/h5/wei-bo/call-back');
        return $code_url;
    }
}
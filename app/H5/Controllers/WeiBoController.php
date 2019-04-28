<?php


namespace App\H5\Controllers;


use App\H5\components\WebController;
use App\Helpers\Helper;

class WeiBoController extends WebController
{
    /** 获取回调数据 */
    public function callBack()
    {
        $path = self::isWindows() ? 'G:/logs/wph.log' : '/www/logs/wph.log';
        Helper::writeLog($this->request->post(), $path);
    }
}
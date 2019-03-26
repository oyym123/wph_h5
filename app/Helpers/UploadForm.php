<?php

namespace App\Helpers;

// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm
{
    /** 获取七牛图片存储地址 */
    public static function uploadImgToQiniu($filePath, $bkt, $key)
    {
        require_once '../vendor/qiniu/php-sdk/autoload.php';

        //初始化Auth状态
        $auth = new Auth(env('QINIU_ACCESS_KEY'), env('QINIU_SECRET_KEY'));

        // 生成上传 Token
        $token = $auth->uploadToken($bkt);

        // 上传到七牛后保存的文件名
//        $key = 'my-php-logo.png';

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        return $uploadMgr->putFile($token, $key, $filePath);
        /*
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

        echo "\n====> putFile result: \n";
        if ($err !== null) {
            var_dump(($err));
        } else {
            var_dump(($ret));
        }
        */
    }
}


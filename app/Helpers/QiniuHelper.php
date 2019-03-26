<?php

namespace App\Helpers;

use Qiniu\Auth;
use Qiniu\Processing\PersistentFop;
use Qiniu\Storage\BucketManager;

// 引入鉴权类

class QiniuHelper
{
    public static function auth2()
    {
        require_once '../sdk/qiniu/php-sdk/autoload.php';

        $auth = new Auth(Yii::$app->params['qiniu_access_key'], Yii::$app->params['qiniu_secret_key']);
        $bkt = Yii::$app->params['qiniu_bucket_videos'];
        $upToken = $auth->uploadToken($bkt);
        return $upToken;
    }

    /** 传图 */
    public static function fetchImg($url)
    {
        require_once __DIR__ . '/../sdk/qiniu/php-sdk/autoload.php';
        //初始化Auth状态
        $auth = new Auth(config('qiniu.access_key'), config('qiniu.secret_key'));
        $bucketMgr = new BucketManager($auth);
        $items = $bucketMgr->fetch($url, config('qiniu.bucket_images'));
        return $items;
    }

    /** 获取七牛图片存储地址 */
    public static function downloadImageUrl($url, $key)
    {
        if (self::isPublic($url)) {
            return $url . $key;
        }
        require_once __DIR__ . '/../sdk/qiniu/php-sdk/autoload.php';

        //初始化Auth状态
        $auth = new Auth(config('qiniu.access_key'), config('qiniu.secret_key'));

        //baseUrl构造成私有空间的域名/key的形式
        return $auth->privateDownloadUrl($url . $key) . '&imageMogr2/strip';
    }

    /** 获取七牛视频存储地址 */
    public static function downloadVideoUrl($url, $key)
    {
        if (self::isPublic($url)) {
            return $url . $key;
        }
        require_once __DIR__ . '/../sdk/qiniu/php-sdk/autoload.php';

        //初始化Auth状态
        $auth = new Auth(config('qiniu.access_key'), config('qiniu.secret_key'));

        //baseUrl构造成私有空间的域名/key的形式
        return $auth->privateDownloadUrl($url . $key);
    }

    /** 判断是否是公有桶 */
    public static function isPublic($url)
    {
        switch ($url) {
            case config('qiniu.qiniu_url_images'):
                return true;
                break;
            case config('qiniu.qiniu_url_videos'):
                return true;
                break;
            case config('qiniu.qiniu_url_images_private'):
                return false;
                break;
            case config('qiniu.qiniu_url_videos_private'):
                return false;
                break;
        }
    }

    /**
     * (七牛云图片鉴黄)
     * 小于300万次请求时，识别100张图片 = 0.23(元)
     * Time: 2017/9/11
     * Author: OYYM
     */
    public static function imageIdentify($butcket, $key)
    {
        $url = $butcket . $key . '?qpulp';
        $res = json_decode(Helper::get($url, []));
        if (isset($res->code) && $res->code == 0) {
            return $res->result->review; //结果为true和false;
        }
        return true; //表示需要审核
    }

    /**
     * 七牛云短视频鉴黄（图谱科技提供）
     * 60 张截图 = 0.06(元)
     * Time: 2017/9/11
     * Author: OYYM
     */
    public static function videoIdentify($butcket, $key)
    {
        $url = $butcket . $key . '?tupu-video/nrop/s/4';//代表每4秒截一张（注意2,3秒截一张不支持）
        $res = json_decode(Helper::get($url, []));
        if (isset($res->code) && $res->code == 0) {
            return $res->review; //结果为true和false;
        }
        return true; //表示需要审核
    }

    /**视频操作 */
    public function pfop($url)
    {
        require_once '../../vendor/qiniu/php-sdk/autoload.php';
        $auth = new Auth(Yii::$app->params['qiniu_access_key'], Yii::$app->params['qiniu_secret_key']);
        $bkt = Yii::$app->request->get('bkt') ?: Yii::$app->params['qiniu_bucket_videos'];

        //要转码的文件所在的空间和文件名
        $bucket = Yii::$app->params['qiniu_bucket_videos'];
        $key = $url;

        //转码时使用的队列名称
        $pipeline = 'video_mp4';
        $pfop = new PersistentFop($auth, $bucket, $pipeline);

        //要进行转码的转码操作
        $fops = "avthumb/mp4/s/640x360/vb/1.25m";
        list($id, $err) = $pfop->execute($key, $fops);
        //查询转码的进度和状态
        list($ret, $err) = $pfop->status($id);
        if ($err != null) {
            return $url;
        } else {
            return $ret['items'][0]['key'];
        }
    }

    /**视频截图操作*/
    public static function screenShot($url, $second)
    {
        $link = self::downloadVideoUrl(config('qiniu.url_videos'), $url . '?vframe/jpg/offset/' . $second . '&imageView2/2/h/200');
        return $link;
        // echo '<img src='.$link.'>';
    }

    /** 获取视频元信息(视频时长) */
    public static function videoTime($url)
    {
        $link = self::downloadVideoUrl(Yii::$app->params['qiniu_url_videos'], $url . '?avinfo');
        $jsonStr2 = Helper::Post($link, 1);
        $arr = json_decode($jsonStr2, true);
        $time = ArrayHelper::getValue($arr, "streams.0.duration");
        return $time;
    }

    public function deleteFile($url)
    {
        require_once '../../vendor/qiniu/php-sdk/autoload.php';
        $auth = new Auth(Yii::$app->params['qiniu_access_key'], Yii::$app->params['qiniu_secret_key']);
        $bkt = Yii::$app->request->get('bkt') ?: Yii::$app->params['qiniu_bucket_videos'];
        $bucketMgr = new BucketManager($auth);
        $key = $url;
        $err = $bucketMgr->delete($bkt, $key);
        if ($err !== null) {
            return $err;
        } else {
            return 1;
        }
    }

    /**视频操作 */
    public static function videoPfop($url)
    {
        require_once '../../vendor/qiniu/php-sdk/autoload.php';
        $auth = new Auth(Yii::$app->params['qiniu_access_key'], Yii::$app->params['qiniu_secret_key']);
        $bkt = Yii::$app->request->get('bkt') ?: Yii::$app->params['qiniu_bucket_videos'];

        //要转码的文件所在的空间和文件名
        $bucket = Yii::$app->params['qiniu_bucket_videos'];
        $key = $url;

        //转码时使用的队列名称
        $pipeline = 'uu_oo';
        $pfop = new PersistentFop($auth, $bucket, $pipeline);

        //要进行转码的转码操作
        $fops = "avthumb/mp4/s/640x360/vb/1.25m";
        list($id, $err) = $pfop->execute($key, $fops);
        //查询转码的进度和状态
        list($ret, $err) = $pfop->status($id);

        if ($err != null) {
            return $url;
        } else {
            if ($ret['items'][0]['returnOld'] != 1) {
                return null;
            }
            return $ret['items'][0]['key'];
        }
    }

    /** 上传base64编码的图片 */
    public static function requestByCurl($remote_server, $post_string)
    {
        require_once '../../vendor/qiniu/php-sdk/autoload.php';
        $auth = new Auth(Yii::$app->params['qiniu_access_key'], Yii::$app->params['qiniu_secret_key']);
        $bucket = Yii::$app->request->get('$bucket') ?: Yii::$app->params['qiniu_bucket_images'];
        $upToken = $auth->uploadToken($bucket, null, 3600);//获取上传所需的token

        $headers = array();
        $headers[] = 'Content-Type:image/png';
        $headers[] = 'Authorization:UpToken ' . $upToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }


}
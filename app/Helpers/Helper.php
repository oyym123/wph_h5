<?php
namespace App\Helpers;

class Helper
{
    public static function post($url, $post_data)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据

        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);

        curl_close($ch);
        //打印获得的数据

        return $output;
    }

    /**
     * Name: post2
     * Desc: https请求post
     * User: ouyangyumin <ouyangyumin@zgzzzs.com>
     * Date: 2017-00-00
     * @param $url
     * @param $post_data
     * @return mixed
     */
    public static function post2($url, $post_data, $header = [])
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据

        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //关闭https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($ch);

        curl_close($ch);
        //打印获得的数据

        return $output;
    }

    /** 模拟带header头的get请求 */
    public static function get($url, $header = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        // $headerArr[] = 'Authorization:Bearer YWMtcGqkAmwpEeewefG';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //关闭https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($ch);

        curl_close($ch);
        //打印获得的数据

        return $output;
    }


    public static function request($URL, $type, $params = [], $headers)
    {
        $ch = curl_init($URL);
        $timeout = 5;
        if ($headers != "") {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        switch ($type) {
            case "GET" :
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            case "PUT" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            case "PATCH":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $file_contents = curl_exec($ch);//获得返回值
        curl_close($ch);
        return $file_contents;
    }

    /**
     * Name: get
     * Desc: https请求post
     * User: ouyangyumin <ouyangyumin@zgzzzs.com>
     * Date: 2017-00-00
     * @param $url
     * @return mixed
     */
    public static function curl_request($url, $header, $post = '', $cookie = '', $returnCookie = 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if ($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set-Cookie:([^;]*);/", $header, $matches);
            $info['cookie'] = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        } else {
            return $data;
        }
    }


    /**
     * 发送短信验证码
     * Desc:
     * User: lixinxin <lixinxinlgm@163.com>
     * Date: 2016-03-07
     *
     * $params = [
     *  'mobile' => '手机号'
     *  'code' => '验证码'
     *  'product' => app名字
     *  'type' => "登录验证"
     *  'template' => '阿里大鱼的模板'
     * ]
     *
     */
    public static function sendSms($params)
    {
        $url = 'https://' . $_SERVER["HTTP_HOST"] . '/sdk/taobao/api.php';

        $params['time'] = time();
        ksort($params);
        $params['sign'] = md5(implode(',', $params) . Yii::$app->params['alidayu.secretKey']);

        return self::post($url, $params);

        /*
//        echo Yii::$app->basePath . "/../sdk/taobao/TopSdk.php";exit;
        include "/Users/L/51zs/frontend/sdk/taobao/TopSdk.php";
//        include Yii::$app->basePath . "/../sdk/taobao/top/TopClient.php";

//        echo Yii::$app->basePath . "/../sdk/taobao/top/TopClient.php";exit;
        date_default_timezone_set('Asia/Shanghai');

        $c = new TopClient;
        $c->appkey = Yii::$app->params['alidayu.appkey'];
        $c->secretKey = Yii::$app->params['alidayu.secretKey'];
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("1");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($params['type']);
        $req->setSmsParam(json_encode(['code' => $params['code'], 'product' => $params['product']])); // '{"code":"","product":" 51招生 "}'
        $req->setRecNum("18606615070");
        $req->setSmsTemplateCode($params['template']);
        $resp = $c->execute($req);

        return json_decode($resp);
        */
    }


    /** 切割字符串 */
    public static function mbStrSplit($string, $len = 1)
    {
        $start = 0;
        $strlen = mb_strlen($string);
        $array = [];
        while ($strlen) {
            $array[] = mb_substr($string, $start, $len, "utf8");
            $string = mb_substr($string, $len, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }
        return $array;
    }

    /** 判断是否是手机 */
    public static function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /** 截取名字替换星号 */
    public static function formatStr($str)
    {
        $str = self::mbStrSplit(trim($str), 1);
        $strS = array_shift($str);
        $strP = array_pop($str);
        $strLen = count($str);
        $strLenS = str_repeat('*', $strLen);
        return $strS . $strLenS . $strP;
    }

    /** 写入测试数据 */
    public static function writeLog($data, $path)
    {
        file_put_contents($path, date('Y-m-d H:i:s') . "\n" . var_export($data, 1) . "\n", FILE_APPEND);
    }

    //将XML转为array
    public static function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    public static function errors()
    {
        return [
            '0' => '请求数据正常',
            '-1' => '数据错误',
            '-10' => '取消订单失败',
            '-100' => '需要登录',
            '-200' => '敏感词信息错误',
        ];
    }

    /** 隐藏手机号中间的4位 */
    public static function formatMobile($mobile)
    {
        if ($mobile) {
            return substr_replace($mobile, '****', 3, 4);
        }
    }

    /** 取header头信息 */
    public static function headerInfo($url, $key)
    {
        if ($url) {
            $header = get_headers($url, true);
            return ArrayHelper::getValue($header, $key, '');
        }
    }

    /** 数组转化为对象 */
    public static function arrayToObject($array)
    {
        if (gettype($array) != 'array') return;
        $arr = json_encode($array);
        $obj = json_decode($arr);
        return $obj;
    }

    /** 时分形式转为秒 */
    public static function HourToSecond($hour)
    {
        $h = (int)(substr($hour, 0, 2));
        $m = (int)(substr($hour, 3, 2));
        $s = (int)(substr($hour, 6, 2));

        if (strlen($hour) == 8 && $m >= 0 && $m <= 69 && $s >= 0 && $s <= 60) {
            $seconds = $h * 3600 + $m * 60 + $s;
            return $seconds;
        } else {
            return false;
        }
    }

    /** 个性化时间 */
    public static function tranTime($time)
    {
        $rtime = date("m-d H:i", $time);
        $htime = date("H:i", $time);
        $longTime = date("m-d", $time);
        $time = time() - $time;

        if ($time < 60) {
            $str = '刚刚';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . '分钟前';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . '小时前 ';
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d == 1)
                $str = '昨天';
            else
                $str = '前天';
        } else {
            $str = $longTime;
        }
        return $str;
    }

    public static function getIP()
    {
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        /*
        处理多层代理的情况
        或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        */
        if (false !== strpos($ip, ','))
            $ip = reset(explode(',', $ip));
        return $ip;
    }

//
//    /** 获取ip */
//    public static function getIP()
//    {
//        if (getenv('HTTP_CLIENT_IP')) {
//            $ip = getenv('HTTP_CLIENT_IP');
//        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
//            $ip = getenv('HTTP_X_FORWARDED_FOR');
//        } elseif (getenv('HTTP_X_FORWARDED')) {
//            $ip = getenv('HTTP_X_FORWARDED');
//        } elseif (getenv('HTTP_FORWARDED_FOR')) {
//            $ip = getenv('HTTP_FORWARDED_FOR');
//        } elseif (getenv('HTTP_FORWARDED')) {
//            $ip = getenv('HTTP_FORWARDED');
//        } else {
//            $ip = $_SERVER['REMOTE_ADDR'];
//        }
//        return $ip;
//    }


    /** 客户端路由 */
    public static function clientUrl($params, $prefix = 'gaozhao://o.c?')
    {
        foreach ($params as $key => $val) {
            $prefix .= "$key=$val&";
        }
        return trim($prefix, '&');
    }


    /** 敏感词检测 */
    public static function wordScreen($contents)
    {
        $badword = require(Yii::getAlias('@common') . '/MysqlFile/badword.php');
        foreach ($badword as $value) {
            if (stristr($contents, $value)) {
                return false;
            }
        }
        return $contents;
    }

    /** 通过IP获取归属地，调用阿里的免费接口 */
    public static function ipToAddress($ip)
    {
        $ip = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip);
        $data = json_decode($ip, true);
        if ($data['code'] == 0) {
            return $data['data'];
        } else {
            return [
                'country' => '中国',
                'country_id' => 'CN',
                'area' => '',
                'area_id' => '',
                'region' => '',
                'region_id' => '',
                'city' => '',
                'city_id' => '',
                'county' => '',
                'county_id' => '',
                'isp' => '',
                'isp_id' => '',
                'ip' => $ip
            ];
        }

        //传入的ip为39.108.97.89，获取的值
//        ['code' => 0,
//            'data' => [
//                'country' => '中国',
//                'country_id' => 'CN',
//                'area' => '华东',
//                'area_id' => '300000',
//                'region' => '浙江省',
//                'region_id' => '330000',
//                'city' => '杭州市',
//                'city_id' => '330100',
//                'county' => '',
//                'county_id' => '-1',
//                'isp' => '阿里巴巴',
//                'isp_id' => '100098',
//                'ip' => '39.108.97.89']
//        ];
    }

    /** 存储信息到redis中 */
    public static function setRedisInfo($params, $key)
    {
        Yii::$app->redis->del($key);
        $result = 1;
        foreach ($params as $k => $v) {
            if (Yii::$app->redis->hset($key, $k, $v) != 1) {
                $result = 0;
            }
        }

        if (Yii::$app->redis->hset($key, 'fdzx_params', serialize($params)) != 1) {
            $result = 0;
        }
        return $result; //值为1表示成功，0 表示失败
    }

    /** 获取redis中的信息 */
    public static function getRedisInfo($key)
    {
        $data = [];
        foreach (unserialize(Yii::$app->redis->hget($key, 'fdzx_params')) as $k => $v) {
            $data[$k] = $v;
        }
        return $data;
    }

    /** 设置提示消息 */
    public static function setHint($status, $contents)
    {
        Yii::$app->session->setFlash($status, $contents);
        echo '<script type="text/javascript">
                    window.history.back(-1);
                  </script>';
        exit;
    }

    /**
     * 创建分享深度链接
     * Linkme
     */
    public static function createShare($params)
    {
        $str = '';
        foreach ($params as $key => $param) {
            $str .= $key . '=' . $param . '&';
        }
        $str = rtrim($str, "&");
        return Yii::$app->request->hostInfo . '/site/share?' . $str;
    }

    public static function toUnicode($string)
    {
        $str = mb_convert_encoding($string, 'UCS-2', 'UTF-8');
        $arrstr = str_split($str, 2);
        $unistr = '';
        foreach ($arrstr as $n) {
            $dec = hexdec(bin2hex($n));
            $unistr .= '&#' . $dec . ';';
        }
        return $unistr;
    }


    /** png转jpg */
    public static function png2jpg($srcPathName, $delOri = true)
    {
        $srcFile = $srcPathName;
        $srcFileExt = strtolower(trim(substr(strrchr($srcFile, '.'), 1)));
        if ($srcFileExt == 'png') {
            $dstFile = str_replace('.png', '.jpg', $srcPathName);
            $photoSize = GetImageSize($srcFile);
            $pw = $photoSize[0];
            $ph = $photoSize[1];
            $dstImage = ImageCreateTrueColor($pw, $ph);
            imagecolorallocate($dstImage, 255, 255, 255);
            //读取图片
            $srcImage = ImageCreateFromPNG($srcFile);
            //合拼图片
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $pw, $ph, $pw, $ph);
            imagejpeg($dstImage, $dstFile, 90);
            if ($delOri) {
                unlink($srcFile);
            }
            imagedestroy($srcImage);
        }
    }


    /**
     * 获取随机字符串
     * @param int $randLength 长度
     * @param int $addtime 是否加入当前时间戳
     * @param int $includenumber 是否包含数字
     * @return string
     */
    function get_rand_str($randLength = 6, $addtime = 1, $includenumber = 0)
    {
        if ($includenumber) {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQEST123456789';
        } else {
            $chars = 'abcdefghijklmnopqrstuvwxyz';
        }
        $len = strlen($chars);
        $randStr = '';
        for ($i = 0; $i < $randLength; $i++) {
            $randStr .= $chars[rand(0, $len - 1)];
        }
        $tokenvalue = $randStr;
        if ($addtime) {
            $tokenvalue = $randStr . time();
        }
        return $tokenvalue;
    }
}

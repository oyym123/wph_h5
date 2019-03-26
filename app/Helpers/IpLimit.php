<?php
/**
 * Created by PhpStorm.
 * User: Oyym
 * Date: 2017/9/13
 * Time: 15:42
 */
namespace App\Helpers;

use Illuminate\Http\Request;

class IpLimit
{
    public static $allow_ip = [
        "127.0.0.1",
        "27.189.*.*", //天洋城四代12栋 ip网段
        "115.33.*.*",//包子所在 ip网段
        "27.189.228.*"
    ];

    private static function makePregIP($str)
    {
        if (strstr($str, "-")) {

            $aIP = explode(".", $str);
            $preg_limit = '';
            $preg = '';

            foreach ($aIP as $k => $v) {
                if (!strstr($v, "-")) {
                    $preg_limit .= self::makePregIP($v);
                    $preg_limit .= ".";
                } else {
                    $aipNum = explode("-", $v);
                    for ($i = $aipNum[0]; $i <= $aipNum[1]; $i++) {
                        $preg .= $preg ? "|" . $i : "[" . $i;
                    }
                    $preg_limit .= strrpos($preg_limit, ".", 1) == (strlen($preg_limit) - 1) ? $preg . "]" : "." . $preg . "]";
                }
            }
        } else {
            $preg_limit = $str;
        }

        return $preg_limit;
    }

    private static function getAllBlockIP()
    {
        if (self::$allow_ip) {
            $i = 1;
            foreach (self::$allow_ip as $k => $v) {
                $ipaddres = self::makePregIP($v);

                $ip = str_ireplace(".", "\.", $ipaddres);
                $ip = str_replace("*", "[0-9]{1,3}", $ip);
                $ipaddres = "/" . $ip . "/";
                $ip_list[] = $ipaddres;
                $i++;
            }
        }
        return $ip_list;
    }

    public static function checkIP(Request $request)
    {
        $iptable = self::getAllBlockIP();
        $IsJoined = false;
        //取得用户ip
        $Ip = Request::getClientIp();
        $Ip = trim($Ip);
        //在白名单中返回真
        if ($iptable) {
            foreach ($iptable as $value) {
                if (preg_match("{$value}", $Ip)) {
                    $IsJoined = true;
                    break;
                }
            }
        }
        //不在白名单中禁止访问
        if (!$IsJoined) {
            // echo "IP Error";
            return false;
        }
        return true;
    }
}

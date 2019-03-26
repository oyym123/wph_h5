<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/21
 * Time: 23:06
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Common extends Model
{
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    //   protected $dateFormat = 'U';

    public $offset = 0; // 分页
    public $limit = 20; // 分页
    public $userEntity = null; // 用户实体
    public $psize = 20;
    public $params = [];

    const STATUS_DISABLE = 0;   // 无效
    const STATUS_ENABLE = 1;    // 有效

    const STATUS_NEED_REVIEW = 1; //需要审核
    const STATUS_NOT_NEED_REVIEW = 0; //不需要审核

    const CODE_NORMAL = 0; //数据正常
    const CODE_NEED_LOGIN = 1; //需要登入
    const CODE_NO_DATA = 2; //没有数据
    const CODE_FREEZE_ACCOUNT = 3; //账号冻结
    const CODE_ERROR = 4; //数据错误

    const TYPE_GIFT_CURRENCY = 1;       //赠币
    const TYPE_BID_CURRENCY = 2;        //拍币
    const TYPE_SHOPPING_CURRENCY = 3;   //购物币
    const TYPE_INVITE_CURRENCY = 4;     //推广币

    public function getCurrencyStr($key = 999)
    {
        $data = [
            self::TYPE_GIFT_CURRENCY => '赠币',
            self::TYPE_BID_CURRENCY => '拍币',
            self::TYPE_SHOPPING_CURRENCY => '购物币',
            self::TYPE_INVITE_CURRENCY => '元',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 获取返回状态提示 */
    public function codeStr($key = 999)
    {
        $data = [
            self::CODE_NORMAL => '数据正常',
            self::CODE_NEED_LOGIN => '需要登入才能获取',
            self::CODE_NO_DATA => '该数据不存在',
            self::CODE_FREEZE_ACCOUNT => '该账号已被冻结',
            self::CODE_ERROR => '数据错误',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 获取七牛云图片 */
    public static function getImg($img)
    {
        return env('QINIU_URL_IMAGES') . $img;
    }

    /** 获取七牛云多张图片 */
    public static function getImgs($imgs)
    {
        $data = [];
        if (is_array($imgs)) {
            $image = $imgs;
        } else {
            $image = json_decode($imgs);
        }
        foreach ($image as $img) {
            $data[] = env('QINIU_URL_IMAGES') . $img;
        }
        return $data;
    }

    /** 返回数据 */
    public function returnRes($data, $status = self::CODE_NORMAL)
    {
        if ($status == self::CODE_NORMAL) {
            return [$data, $status];
        } else {
            return [$this->codeStr($status), $status];
        }
    }

    /** 获取数据*/
    public function getCache($key)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
    }

    /** 缓存数据，默认1分钟 */
    public function putCache($key, $value, $time = 1)
    {
        Cache::put($key, $value, $time);
        return $value;
    }

    public function hasCache($key)
    {
        if (Cache::has($key)) {
            return true;
        } else {
            return false;
        }
    }

    /** 清除缓存 */
    public function delCache($key)
    {
        if (Cache::has($key)) {
            return Cache::forget($key);
        }
    }

    public static function commonStatus($key = 999)
    {
        $data = [
            self::STATUS_DISABLE => '无效',
            self::STATUS_ENABLE => '有效',
        ];
        return $key != 999 ? $data[$key] : $data;
    }


    /**
     * 解析并送出JSON
     * 200101
     * @param  array $res 资源数组，如果是一个字符串则当成错误信息输出
     * @param  int $state 状态值，默认为0
     * @param  int $msg 是否直接输出,1为返回值
     * @return array
     **/
    public static function showMsg($res, $code = 0, $msg = '成功')
    {
        //header("Content-type: application/json; charset=utf-8");

        if (empty($res)) {
            if ($res == []) {
                $res = [];
            } else {
                $res = '';
            }
        }
        // 构造数据
        $item = array('code' => $code, 'message' => $msg, 'data' => null);

        if (is_array($res) && !empty($res)) {
            $item['data'] = self::int2String($res); // 强制转换为string类型下放
        } elseif (is_string($res)) {
            $item['message'] = $res;
        }

        // 是否需要送出get
        if (isset($_GET['isget']) && $_GET['isget'] == 1) {
            $item['pars'] = !empty($_GET) ? $_GET : null;
        }

        //   if ((isset($_GET['debug']) && $_GET['debug'] == '1') || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
        if ((isset($_GET['debug']) && $_GET['debug'] == '1') || (PHP_OS == 'WINNT')) {
            echo "<pre>";
            print_r($_REQUEST);
            print_r($item);
            //编码
            echo json_encode($item);
        } else {
            //编码
            $item = json_encode($item);
            // 送出信息
            echo "{$item}";
        }
        exit;
    }

    public static function int2String($arr)
    {
        foreach ($arr as $k => $v) {
            if (is_int($v)) {
                $arr[$k] = (string)$v;
            } else if (is_array($v)) { //若为数组，则再转义.
                $arr[$k] = self::int2String($v);
            }
        }
        return $arr;
    }

    public static function getStates($on = '有效', $off = '无效')
    {
        return [
            'on' => ['value' => self::STATUS_ENABLE, 'text' => $on, 'color' => 'success'],
            'off' => ['value' => self::STATUS_DISABLE, 'text' => $off, 'color' => 'danger'],
        ];
    }


    public static function isReview()
    {
        return [
            self::STATUS_NEED_REVIEW => '需要审核',
            self::STATUS_NOT_NEED_REVIEW => '不需要审核',
        ];
    }

    /** 获取id和名称 */
    public static function getNameId($model, $key = 'id', $value = 'name')
    {
        $data = [];
        foreach ($model as $item) {
            $data[$item->$key] = $item->$value;
        }
        return $data;
    }

    /** 改变时间 */
    public static function changeTime($time, $seconds, $flag = 1)
    {

        if ($flag = 1) {
            $res = date('Y-m-d H:i:s', (strtotime($time) + $seconds));
        } else {
            $res = date('Y-m-d H:i:s', (strtotime($time) - $seconds));
        }
        return $res;
    }

    /** 转换日期格式 */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toDateTimeString();
    }

    public function createdAt($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->created_at);
    }

    public function updatedAt($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->updated_at);
    }

    public function settlementDate($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->settlement_date);
    }

    /** 时间转换字符串 */
    public function date2String($date, $format = 'Y-m-d')
    {
        return date($format, $date);
    }

    /** 时间转换数值 */
    public function date2Int($attribute, $param)
    {
        !empty($this->$attribute) && $this->$attribute = strtotime($this->$attribute);
    }

    /** 写入日志的格式 */
    public function writeLog($data)
    {
        return date('Y-m-d H:i:s') . "\n" . var_export($data, 1) . "\n";
    }

    public static function p($data)
    {
        echo '<pre>';
        print_r($data);
        exit;
    }
}
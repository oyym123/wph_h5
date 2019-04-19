<?php

namespace App\H5\components;

use App\Helpers\Helper;
use App\Models\Common;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public $enableCsrfValidation = false;
    public $offset = 0;
    public $limit = 20;
    public $pages = 0;
    //  public $userId = 6776;
    public $userId = 0;
    public $userIdent = 0;
    public $request;
    public $token;
    public $weixin;

    public function __construct(Request $request)
    {
        ob_start();
        $request && $this->request = $request;
        $request->pages && $this->pages = $request->pages;
        $request->limit && $this->limit = $request->limit;
        $this->offset = $this->pages * $this->limit;
        if ($this->limit > 100) {
            $this->limit = 100;
        }
//        $cook = $request->cookie();   //获取cookie
//        if (isset($cook['user_info']) && !empty($cook['user_info'])) {
        // $request->psize && $this->psize = $request->psize;
        if ($request->session()->has('user_info')) { //获取用户信息
            $user = json_decode(session('user_info'));
            // print_r($user);exit;
            //$user = json_decode($cook['user_info']);
            $this->userId = $user->id;
            $this->userIdent = User::find($this->userId);
            //判断账号是否可用
            if ($this->userIdent->status == User::STATUS_DISABLE) {
                list($info, $status) = (new Common())->returnRes('', Common::CODE_FREEZE_ACCOUNT);
                self::showMsg($info, $status);
            }
        }
//
//        $allowIp = ['218.17.209.172', '127.0.0.1'];
//        if (in_array(Helper::getIP(), $allowIp)) {
//            $path = self::isWindows() ? 'G:/logs/wph.log' : '/www/logs/wph.log';
//            if (!empty($_POST)) {
//                Helper::writeLog($_POST, $path);
//            }
//            if (!empty($_GET)) {
//                Helper::writeLog($_GET, $path);
//            }
//        }
    }


    /** 取缓存数据 */
    public static function getCache()
    {
        Redis::select(1);
        if (!empty($_SERVER['REQUEST_URI'])) {
            $val = Redis::hget('cache', md5($_SERVER['REQUEST_URI']));
            if ($val) {
                echo $val;
                exit;
            }
        }
    }

    /** 设置缓存数据 */
    public static function setCache($key, $val)
    {

        Redis::select(1);
        Redis::hset('cache', $key, $val);
    }

    /** 删除缓存数据 */
    public static function delCache($key)
    {
        Redis::select(1);
        Redis::hdel('cache', $key);
    }

    /** 判断操作系统是不是windows，方便测试和开发 */
    public static function isWindows()
    {
        if (PHP_OS == 'WINNT') {
            return true;
        };
    }

    public function needLogin()
    {
//        header("location:" . '/h5/user/login-view');
        echo "<script>window.location.href='/h5/user/login-view';</script> ";
        exit;
    }

    /** 身份验证 */
    public function auth()
    {
        if (empty($this->userId)) {
            self::needLogin();
        }
    }

    /**
     * 解析并送出JSON
     * 200101
     * @param array $res 资源数组，如果是一个字符串则当成错误信息输出
     * @param int $state 状态值，默认为0
     * @param int $msg 是否直接输出,1为返回值
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

        //   if ((isset($_GET['debug']) && $_GET['debug'] == '1') || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {
        // if ((isset($_GET['debug']) && $_GET['debug'] == '1') || self::isWindows()) {
        if ((isset($_GET['debug']) && $_GET['debug'] == '1')) {
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

    /** 根据user-agent取手机类型 */
    public static function getAppTypeByUa()
    {
        $tmp = 0;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            $tmp = 1;
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            $tmp = 2;
        }
        return $tmp;
    }

    /** 缓存用户提交的数据（优化） */
    public function postSessionCache(Request $request, $name, $params)
    {
        //所有提交数据存在“用户ip+名称”字段里
        session([$request->getClientIp() . $name => $params]);
    }

    /** 获取图片 */
    public function getImage($img)
    {
        return config('qiniu.domain') . $img;
    }

    public function getCurrentAction()
    {
        $action = Route::current()->getActionName();

        list($class, $method) = explode('@', $action);
        return ['controller' => $class, 'method' => $method];
    }

    /** 获取方法名称 */
    public function getMName()
    {
        return $this->getCurrentAction()['method'];
    }

}



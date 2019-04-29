<?php

namespace App;

use App\Helpers\Helper;
use App\Helpers\QiniuHelper;
use App\Models\City;
use App\Models\Common;
use App\UserInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Qiniu\Storage\BucketManager;

class User extends Authenticatable
{
    protected $table = 'users';
    use Notifiable;

    /** 转换日期格式 */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toDateTimeString();
    }
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    // protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'session_key', 'open_id', 'token', 'nickname', 'avatar', 'is_real', 'status',
        'province', 'city', 'invite_code', 'be_invited_code','spid','gift_currency','mobile','wb_uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const STATUS_DISABLE = 0;   // 无效
    const STATUS_ENABLE = 1;    // 有效

    const TYPE_ROBOT = 0; //机器人
    const TYPE_REAL_PERSON = 1; //真人

    const REGISTER_TYPE_WEI_XIN = 1;

    public function getAvatar()
    {
        return env('QINIU_URL_IMAGES') . $this->avatar;
    }

    /** 获取身份 */
    public static function getIsReal($key = 999)
    {
        $data = [
            self::TYPE_ROBOT => '电脑人',
            self::TYPE_REAL_PERSON => '真人',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    public static function counts($today = 0)
    {
        if ($today) {
            return DB::table('users')->where(['is_real' => self::TYPE_REAL_PERSON])
                ->whereBetween('created_at', [date('Y-m-d', time()), date('Y-m-d', time()) . ' 23:59:59'])
                ->count();
        } else {
            return DB::table('users')->where(['is_real' => self::TYPE_REAL_PERSON])->count();
        }

    }

    public function setToken($openId, $sessionKey)
    {
        $this->token = md5($openId . $sessionKey);
    }

    public function getToken()
    {
        return $this->token;
    }

    public function saveData($data)
    {
        $model = self::create($data);
        return $model;
    }

    /** 用户信息修改 */
    public function userUpdate($params, $userId)
    {
        DB::beginTransaction();
        try {
            DB::table('user_info')->where('user_id', $userId)->first();
            DB::table('users')->where('id', $userId)->update([
                    'email' => $params['email'] ?: $params['bind_mobile'] . '163.com',
                ]
            );

            $info['real_name'] = $params['name'];
            $info['sex'] = $params['sex'];
            $info['id_card'] = $params['id_card'];
            $info['detail_address'] = $params['detail_address'];

            DB::table('user_info')->where('user_id', $userId)->update($info);
            session(['user_id' => $userId]);
            session()->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage(); // 等待处理
            return true;
        }
    }

    /**
     * 机器用户注册
     */
    public function rebotRegister()
    {
        set_time_limit(0);
        $randQQ = rand(1000000, 999999999);
        //获取QQ信息api接口
        $api = "http://users.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=" . (string)($randQQ);
        $res = Helper::get($api);
        $res = mb_convert_encoding($res, "UTF-8", "GBK");
        $str = substr($res, strpos($res, '(') + 1);
        $qqInfo = json_decode(substr($str, 0, -1), true)[$randQQ];

        $sessionKey = \Faker\Provider\Uuid::uuid();
        $openId = \Faker\Provider\Uuid::uuid();
        $token = md5(md5($openId . $sessionKey));
        $user = DB::table('users')->where(['email' => $randQQ . '@qq.com', 'is_real' => User::TYPE_ROBOT])->first();

        if (PHP_OS == 'WINNT') {
            $img = file_get_contents('C:\xampp\htdocs\100.png'); //测试图片
            $img2 = file_get_contents('C:\xampp\htdocs\100.jpg'); //测试图片
            $img3 = file_get_contents('C:\xampp\htdocs\100girl.jpg'); //测试图片
        } else {
            $img = file_get_contents('/www/img/100.png'); //测试图片
            $img2 = file_get_contents('/www/img/100.jpg'); //测试图片
            $img3 = file_get_contents('/www/img/100girl.jpg'); //测试图片
        }
        $imgQQ = Helper::get($qqInfo[0]);
        $flag = 0;
        if ($imgQQ != $img && $imgQQ != $img2 && $imgQQ != $img3) {
            $flag = 1;
        }

        $nickname = $str = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $qqInfo[6]); //去除空格
        if (empty($user) && !empty($nickname) && $flag) {  //判断是否真实存在或者重复
            list($province, $city) = City::randCity();
            $avatar = QiniuHelper::fetchImg($qqInfo[0])[0]['key'];

            if (!empty($avatar)) {
                $data = [
                    'session_key' => $sessionKey,
                    'email' => $randQQ . '@qq.com',
                    'open_id' => $openId,
                    'nickname' => $nickname,
                    'name' => $nickname,
                    'avatar' => $avatar,
                    'is_real' => USER::TYPE_ROBOT,
                    'token' => $token,
                    'province' => $province,
                    'city' => $city
                ];
                $model = User::create($data);
                if ($model->save()) {
                    Redis::hset('token', $token, $model->id);
                    echo $randQQ . '成功保存<br>';
                }
            }
        } else {
            echo $randQQ . '失败!<br/>';
        }
    }

    /**
     * 获取随机用户
     */
    public static function randUser($limit = 100)
    {
        $model = DB::table('users')
            ->where([
                'is_real' => self::TYPE_ROBOT,
                'status' => self::STATUS_ENABLE
            ])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
        return $model;
    }


    /** 绑定手机 */
    public function bindMobile($params, $userId)
    {
        DB::beginTransaction();
        try {
            $userInfo = DB::table('user_info')->where('user_id', $userId)->first();
            list($msg, $status) = Sms::check([
                'user_id' => $userInfo->user_id,
                'type' => 1,
                'mobile' => $params['bind_mobile'],
                'sms_code' => $params['code']
            ]);

            if ($status < 0) {
                throw new \Exception("$msg");
            }

            $result = DB::table('user_info')->where('user_id', $userId)->update(['bind_mobile' => $params['bind_mobile']]);

            if (!$result) {
                throw new \Exception("更新用户信息数据出错");
            }

            DB::commit();
            return ['绑定成功', 1];
        } catch (\Exception $e) {
            DB::rollback();
            return [$e->getMessage(), -1];
        }
    }

    /** 所有拍币统计 */
    public function bidCurrencyCount()
    {
        User::where()->sum('bid_currency');

    }


    /** 获取用户信息表 */
    public function UserInfo()
    {
        return $this->hasOne('App\userInfo', 'user_id', 'id')->withDefault([
            'name' => '游客',
        ]);
    }
}

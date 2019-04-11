<?php

namespace App\Models;

use App\Helpers\Helper;
use App\UserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    use Notifiable;

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
        'province', 'city', 'invite_code'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


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

    /** 注册用户 */
    public function userRegister($params, $userId)
    {
        DB::beginTransaction();
        try {
            $userInfo = DB::table('user')->where('user', $userId)->first();
            $info = [];
            $result = DB::table('user_info')->where('user_id', $userId)->update($info);

            if (!$result) {
                throw new \Exception("更新用户信息数据出错");
            }

            list($res, $code) = Invite::inviteCreate($params['invite_mobile'], $userId);

            if (!$code) {
                throw new \Exception("$res");
            }

            // 统计推荐关系送积分, 之前已经暗绑定,因为用户提交了资料,所以可以明绑定了
            $userInfoModel = new UserInfo();
            // $userInfoModel->bindMobileAndAwardInviter($userInfo);

            session(['user_id' => $userId]);
            session()->save();
            DB::commit();
            return ['注册成功', 1];
        } catch (\Exception $e) {
            DB::rollback();
            return [$e->getMessage(), -1];
        }
    }

    /**
     * 检验验证码是否可用
     * user_id
     * type
     * sms_code
     * mobile
     */
    public static function smsCheck($params)
    {
        $where = [];
        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $where['user_id'] = $params['user_id'];
        }

        $sms = DB::table('sms')
            ->where($where)
            ->where('type', $params['type'])
            ->where('mobile', $params['mobile'])
            ->where('status', 1)
            ->orderBy('id', 'desc')->first(); // 获取最新的验证码信息

        if (!$sms) {
            return ['请先获取短信验证码', -1];
        }

        if ($sms->key != $params['sms_code']) {
            return ['验证码错误', -1];
        }

        if ((time() - $sms->created_at) > 900) { //短信验证码有效期15分钟
            return ['验证码已失效', -1];
        }

        DB::table('sms')->where('id', $sms->id)->update(['status' => 2]);
        return ['验证成功!', 1];
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


    /** 获取用户信息表 */
    public function UserInfo()
    {
        return $this->hasOne('App\userInfo', 'user_id', 'id')->withDefault([
            'name' => '游客',
        ]);
    }
}
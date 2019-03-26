<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Sms extends Base
{
    protected $table = 'sms';

    const TYPE_USER_REG = 1; // 用户注册

    const STATUS_1 = 1; // 未使用
    const STATUS_2 = 2; // 已使用

    /**
     * 检验是否能进行登入
     * user_id
     * type
     * sms_code
     * mobile
     */
    public static function check($params)
    {
        $sms = DB::table('sms')->where('user_id', $params['user_id'])
            ->where('type', $params['type'])
            ->where('mobile', $params['mobile'])
            ->where('status', self::STATUS_ENABLE)
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

        DB::table('sms')->where('id', $sms->id)->update(['status' => 2, 'user_id' => $params['user_id']]);
    }

    public function create($data)
    {
        return DB::table('sms')->insertGetId($data);
    }
}


<?php

namespace App;

use App\Api\components\WebController;
use App\Base;
use Illuminate\Support\Facades\DB;

class UserInfo extends Base
{
    protected $table = 'user_info';

    /** 产品数据更新 */
    public static function updateInfo($params)
    {
        $model = UserInfo::find($params['id']);
        foreach ($params as $key => $val) {
            $model->$key = $val;
        }
        if (!$model->save()) {
            throw new \Exception('更新失败!');
        }
    }

    /** 获取用户表 */
    public function belongsToUser()
    {
        return $this->hasOne('App\user', 'user_id', 'id');
    }

    /** 创建用户 */
    public function createWeixinUser($data)
    {
        $userInfo = DB::table('user_info')->where('openid', $data['id'])->first();

    }

    /** 绑定二维码推荐关系 */
    function inviteBind($userInfo, $message)
    {
        if (!empty($message->Event) && !empty($userInfo)) {
            $invite = DB::table('invite')->where('user_id', $userInfo->user_id)->first();

            if (empty($invite)) {

                // 查一级推荐人
                $level_1 = str_replace('qrscene_', '', $message->EventKey);
                $level1UserInfo = DB::table('user_info')->where('user_id', $level_1)->first();
                if (empty($level1UserInfo)) {
                    return; // 用户不存在
                }
                // 根据一级推荐查二级推荐人
                $level_2 = 0;
                $level1Query = DB::table('invite')->where('user_id', $level_1)->first();
                if ($level1Query) {
                    $level_2 = $level1Query->level_1;
                }
                $id = DB::table('invite')->insertGetId([
                    'user_id' => $userInfo->user_id,
                    'level_1' => $level_1,
                    'level_2' => $level_2,
                    'created_at' => time(),
                    'updated_at' => time(),
                ]);
                if (!$id) {
                    throw new \Exception('保存推荐关系失败');
                }
                /*
                                // 保存一级推荐人积分
                                $result = DB::table('user_info')->where('id', $level_1)->update([
                                    'point_total' => $level1UserInfo->point_total + config('setting.invite1_get_point'),
                                    'invite_level1_count' => $level1UserInfo->invite_level1_count + 1, // 统计邀请人数
                                    'invite_level1_point' => $level1UserInfo->invite_level1_point + config('setting.invite1_get_point'), // 统计邀请获得积分
                                ]);
                                if (!$result) {
                                    throw new Exception('更新一级推荐用户出错');
                                }

                                // 保存积分记录
                                $id = DB::table('user_point_card')->insertGetId([
                                    'user_id' => $level1UserInfo->user_id,
                                    'point' => config('setting.invite1_get_point'), // 增加推荐积分
                                    'intro' => '一推荐获得积分', // 增加推荐积分
                                    'created_at' => time(),
                                    'updated_at' => time(),
                                ]);
                                if (!$id) {
                                    throw new Exception('保存一级推荐积分出错');
                                }*/
                /*
                                // 保存二级推荐人积分
                                if ($level_2 && ($level2UserInfo = DB::table('user_info')->where('id', $level_2)->first())) {
                                    $result = DB::table('user_info')->where('id', $level_2)->update([
                                        'point_total' => $level2UserInfo->point_total + config('setting.invite2_get_point'),
                                        'invite_level2_count' => $level2UserInfo->invite_level2_count + 1, // 统计邀请人数
                                        'invite_level2_point' => $level2UserInfo->invite_level2_point + config('setting.invite2_get_point'), // 统计邀请获得积分
                                    ]);
                                    if (!$result) {
                                        throw new Exception('更新一级推荐用户出错');
                                    }

                                    // 保存积分记录 二级推荐人没有积分
                                    $id = DB::table('user_point_card')->insertGetId([
                                        'user_id' => $level2UserInfo->user_id,
                                        'point' => config('setting.invite2_get_point'), // 增加推荐积分
                                        'intro' => '二推荐获得积分', // 增加推荐积分
                                        'invite_level' => 2, // 增加推荐积分
                                        'invite_user' => $userInfo->user_id, // 增加推荐积分
                                        'invite_mobile' => '', // 增加推荐积分
                                        'created_at' => time(),
                                        'updated_at' => time(),
                                    ]);
                                    if (!$id) {
                                        throw new Exception('保存二级推荐积分出错');
                                    }
                                }*/
            }
        }
    }

    /** 当被邀请人绑定手机号码后, 奖励邀请人积分 */
    function bindMobileAndAwardInviter($userInfo)
    {
        $invite = DB::table('invite')->where('user_id', $userInfo->user_id)->first();
        if (empty($invite)) {
            return;
        }

        $level1UserInfo = DB::table('user_info')->where('id', $invite->level_1)->first();
        if (empty($level1UserInfo)) {
            return;
        }

        // 保存一级推荐人积分
        $result = DB::table('user_info')->where('id', $invite->level_1)->update([
            'point_total' => $level1UserInfo->point_total + config('setting.invite1_get_point'),
            'invite_level1_count' => $level1UserInfo->invite_level1_count + 1, // 统计邀请人数
            'invite_level1_point' => $level1UserInfo->invite_level1_point + config('setting.invite1_get_point'), // 统计邀请获得积分
        ]);
        if (!$result) {
            throw new Exception('更新一级推荐用户出错');
        }

        // 保存积分记录
        $id = DB::table('user_point_card')->insertGetId([
            'user_id' => $level1UserInfo->user_id,
            'point' => config('setting.invite1_get_point'), // 增加推荐积分
            'intro' => '一推荐获得积分', // 增加推荐积分
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        if (!$id) {
            throw new Exception('保存一级推荐积分出错');
        }

        $level2UserInfo = DB::table('user_info')->where('id', $invite->level_2)->first();
        if (empty($level2UserInfo)) {
            return;
        }
        // 保存二级推荐人积分
        $result = DB::table('user_info')->where('id', $invite->level_2)->update([
            'point_total' => $level2UserInfo->point_total + config('setting.invite2_get_point'),
            'invite_level2_count' => $level2UserInfo->invite_level2_count + 1, // 统计邀请人数
            'invite_level2_point' => $level2UserInfo->invite_level2_point + config('setting.invite2_get_point'), // 统计邀请获得积分
        ]);
        if (!$result) {
            throw new Exception('更新一级推荐用户出错');
        }

        // 保存积分记录 二级推荐人没有积分
        $id = DB::table('user_point_card')->insertGetId([
            'user_id' => $level2UserInfo->user_id,
            'point' => config('setting.invite2_get_point'), // 增加推荐积分
            'intro' => '二推荐获得积分', // 增加推荐积分
            'invite_level' => 2, // 增加推荐积分
            'invite_user' => $userInfo->user_id, // 增加推荐积分
            'invite_mobile' => '', // 增加推荐积分
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        if (!$id) {
            throw new Exception('保存二级推荐积分出错');
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/25
 * Time: 0:35
 */

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;

class RobotPeriod extends Common
{
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'period_id',
        'user_id',
        'status',
        'avatar',
        'nickname',
        'province',
        'city',
    ];

    protected $table = 'robot_period';

    /** 异步执行 */
    public function asyncInsert()
    {
        $periods = DB::table('period')->where([
            'deleted_at' => null,
            'status' => Period::STATUS_IN_PROGRESS
        ])->get()->toArray();
        $ids = [];

        if ($periods) {
            $ids = array_column($periods, 'id');
        }
        
        $periodIds = DB::table('robot_period')->select('period_id')->whereIn('period_id', $ids)->get()->toArray();
        $noIds = array_diff($ids, array_column($periodIds, 'period_id'));
        foreach ($noIds as $id) {
            $this->batchSave($id, Period::find($id)->product_id);
        }
    }

    /** 批量分配 */
    public static function batchSave($periodId, $productId)
    {
        foreach (User::randUser(mt_rand(50, 100)) as $user) {
            $data = [
                'product_id' => $productId,
                'period_id' => $periodId,
                'user_id' => $user->id,
                'avatar' => $user->avatar,
                'nickname' => $user->nickname,
                'province' => $user->province,
                'city' => $user->city,
            ];
            self::create($data);
        }
    }

    /** 删除期数结束时的机器人，提升数据库查询效率 */
    public function delRobot()
    {
        $periodIds = DB::table('period')->select('id')->where(['status' => Period::STATUS_OVER])->get()->toArray();
        if ($periodIds) {
            DB::table('robot_period')->whereIn('period_id', array_column($periodIds, 'id'))->delete();
        }
    }

    /** 获取关联的期数 */
    public static function getInfo($periodId)
    {
        $model = DB::table('robot_period')->where([
            'period_id' => $periodId,
            'status' => self::STATUS_ENABLE
        ])->inRandomOrder()->first();
        return $model;
    }
}
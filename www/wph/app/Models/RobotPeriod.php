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
    ];

    protected $table = 'robot_period';

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
            ];
            self::create($data);
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
<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserAddress extends Common
{
    protected $table = 'user_address';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'is_default',
        'status',
        'user_name',
        'telephone',
        'postal',
        'detail_address',
        'str_address',
    ];

    const STATUS_IS_DEFAULT = 1; //默认地址
    const STATUS_NOT_DEFAULT = 0; //不是默认地址

    public function saveData($data)
    {
        $model = self::create($data);
        if ($model) {
            if ($model->is_default == self::STATUS_IS_DEFAULT) {
                DB::table('user_address')->where(['user_id' => $model->user_id])
                    ->where('id', '<>', $model->id)
                    ->update(['is_default' => self::STATUS_NOT_DEFAULT]);
            }
            return $model;
        }
    }

    public function updateData($data)
    {
        $model = self::where([
            'id' => $data['id'],
            'user_id' => $data['user_id']
        ])->first();
        if (empty($model)) {
            return 0;
        }
        if ($data['is_default'] == self::STATUS_IS_DEFAULT) {
            DB::table('user_address')->where(['user_id' => $model->user_id])
                ->update(['is_default' => self::STATUS_NOT_DEFAULT]);
        }
        return self::where(['id' => $model->id])->update($data);
    }

    /** 获取默认地址 */
    public static function defaultAddress($userId)
    {
        $model = self::where([
            'is_default' => self::STATUS_IS_DEFAULT,
            'user_id' => $userId
        ])->first();
//        if (empty($model)) {
//            return self::where([
//                'user_id' => $userId
//            ])->first();
//        }
        return $model;
    }
}

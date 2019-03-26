<?php

namespace App\Models;


class Withdraw extends Common
{
    protected $table = 'withdraw';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'withdraw_at', //处理的时间
        'account', //账号状态
    ];
    const STATUS_PROCESSING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_FAILURE = 2;

    public static function getStatus($key = 999)
    {
        $data = [
            self::STATUS_PROCESSING => '正在处理',
            self::STATUS_COMPLETED => '已完成',
            self::STATUS_FAILURE => '提现失败',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    public function saveData($data)
    {
        return self::create($data);
    }

    /** 详情 */
    public function detail($userId)
    {
        $models = self::where([
            'user_id' => $userId
        ])->offset($this->offset)->limit($this->limit)->get();
        $data = [];
        foreach ($models as $model) {
            $data[] = [
                'amount' => $model->amount,
                'created_at' => $model->created_at,
                'status' => $this->getStatus($model->status),
            ];
        }
        if (empty($data) && $this->offset == 0) {
            self::showMsg('没有数据', 2);
        }
        return $data;
    }

    /** 判断是否有正在申请的提现 */
    public function isProcessing($userId)
    {
        return self::where([
            'status' => self::STATUS_PROCESSING,
            'user_id' => $userId
        ])->first();
    }
}

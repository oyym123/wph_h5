<?php

namespace App;

use Illuminate\Support\Facades\DB;

class UserPointCard extends Base
{
    protected $table = 'user_point_card';

    const TYPE_1 = 1; // 一推荐获得积分
    const TYPE_2 = 2; // 二推荐获得积分
    const TYPE_3 = 3; // 注册获得积分

    const STATUS_1 = 1; // 未使用
    const STATUS_2 = 2; // 已使用

    static function type() {
        return [
            self::TYPE_1 => '一级推荐获得积分',
            self::TYPE_2 => '二级推荐获得积分',
            self::TYPE_3 => '注册获得积分',
        ];
    }
}


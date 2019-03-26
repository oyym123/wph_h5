<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Common
{
    protected $table = 'article';
    const TYPE_COMMON_QUESTION = 1; //常见问题
    const TYPE_MAKE_MONEY = 2; //如何赚钱


    public static function getStatus($key = 999)
    {
        $data = [
            self::TYPE_COMMON_QUESTION => '常见问题',
            self::TYPE_MAKE_MONEY => '如何赚钱',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

}

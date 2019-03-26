<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidType extends Common
{
    use SoftDeletes;

    protected $table = 'bid_type';

    public static function getList($flag = null)
    {
        $data = [];
        $model = self::where(['status' => self::STATUS_ENABLE])->get();
        foreach ($model as $item) {
            if ($flag) {
                $data[$item->id] = $item->name;
            } else {
                $data[0] = ['id' => 0, 'title' => '全部'];
                $data[] = [
                    'id' => $item->id,
                    'title' => $item->name
                ];
            }
        }
        return $data;
    }
}

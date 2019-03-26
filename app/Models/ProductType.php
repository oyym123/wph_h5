<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProductType extends Common
{
    use SoftDeletes;
    protected $table = 'product_type';

    public static function getOne($id, $field = [])
    {
        $res = DB::table('product_type')->select($field)->where('id', $id)->whereNull('deleted_at')->first();
        if (empty($res)) {
            return '';
        } else {
            return $res;
        }
    }

    public static function getList($flag = null)
    {
        $data = [];
        $model = ProductType::where(['status' => self::STATUS_ENABLE])->get();
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

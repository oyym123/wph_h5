<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    protected $table = 'city';
    
    /** 简化城市名称 */
    public static function simplifyCity($province = '北京', $city)
    {
        $pName = str_replace(['省', '市'], "", $province);
        $cName = str_replace(['市', '县', '区'], "", $city);
        if (strpos($province, '市') !== false || mb_strlen($cName) > 2 || mb_strlen($pName) > 2) {
            $cName = '';
        }
        return [$pName, $cName];
    }

    /**
     * 获取随机城市
     */
    public static function randCity()
    {
        $province = DB::table('city')->select('id', 'name')->where('level', 1)->inRandomOrder()->first();
        $city = DB::table('city')->select('id', 'name')->where('upid', $province->id)->inRandomOrder()->first();
        return self::simplifyCity($province->name, $city->name);
    }
}

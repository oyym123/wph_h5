<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Collection extends Common
{
    protected $table = 'collection';
    const STATUS_COLLECTION_YES = 1;
    const STATUS_COLLECTION_NO = 0;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
    ];

    /** 判断是否收藏 */
    public function isCollect($userId, $productId)
    {
        $res = DB::table('collection')->where([
            'status' => self::STATUS_COLLECTION_YES,
            'user_id' => $userId,
            'product_id' => $productId
        ])->first();
        return !empty($res) ? self::STATUS_COLLECTION_YES : self::STATUS_COLLECTION_NO;
    }

    /** 收藏人数统计 */
    public function userCount($productId)
    {
        DB::table('collection')->where([
            'status' => self::STATUS_COLLECTION_YES,
            'product_id' => $productId
        ])->count();
    }

    public function saveData($data)
    {
        $model = Collection::where($data)->first();
        if ($model) {
            if ($model->status == self::STATUS_COLLECTION_NO) {
                Collection::where($data)->update(['status' => self::STATUS_COLLECTION_YES]);
                DB::table('product')->where(['id' => $data['product_id']])->increment('collection_count', 1);
                return ['info' => '收藏成功', 'status' => self::STATUS_COLLECTION_YES];
            } else {
                Collection::where($data)->update(['status' => self::STATUS_COLLECTION_NO]);
                DB::table('product')->where(['id' => $data['product_id']])->decrement('collection_count', 1);
                return ['info' => '取消收藏成功', 'status' => self::STATUS_COLLECTION_NO];
            }
        } else {
            $data['status'] = self::STATUS_COLLECTION_YES;
            self::create($data);
            DB::table('product')->where(['id' => $data['product_id']])->increment('collection_count', 1);
            return ['info' => '收藏成功', 'status' => self::STATUS_COLLECTION_YES];
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Auctioneer extends Common
{
    protected $table = 'auctioneer';

    const AUCTION_ID = 1;
    const AUCTION_NAME = '诺诺拍卖行';
    const AUCTION_AVATAR = '';

    /** 获取拍卖师id和名称 */
    public static function getName()
    {
        $model = DB::table('auctioneer')->select('id', 'name')
            ->where(['status' => self::STATUS_ENABLE])
            ->get();
        return self::getNameId($model);
    }

    /**
     * 获取随机拍卖师
     */
    public static function randAuctioneer()
    {
        $model = DB::table('auctioneer')->select('id')
            ->where('status', self::STATUS_ENABLE)
            ->inRandomOrder()
            ->first();
        return $model->id;
    }

    /** 拍卖师主页 */
    public function home($id)
    {
        $model = Auctioneer::getAuctioneer(['id' => $id]);
        $data = [
            'id' => $model->id,
            'img' => self::getImg($model->image),
            'tags' => $model->tags,
            'name' => $model->name,
            'number' => $model->number,
            'unit' => $model->unit,
            'year' => $model->years,
            'certificate' => $model->certificate,
            'list' => (new Period())->getProductList(5, ['auctioneer_id' => $id])
        ];
        return $data;
    }

    public function getAuctioneer($where = [])
    {
        if ($model = Auctioneer::where($where)->first()) {
            return $model;
        }
        self::showMsg('没有该拍卖师!', self::CODE_NO_DATA);
    }
}

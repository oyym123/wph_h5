<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/2
 * Time: 23:03
 */

namespace App\Api\Controllers;


use App\Api\components\WebController;
use App\Models\Period;

class LatestDealController extends WebController
{
    /**
     * /**
     * @SWG\Get(path="/api/latest-deal",
     *   tags={"最新成交"},
     *   summary="最新成交列表",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *           [id] => 期数id
     *           [period_code] => 期数代码
     *           [bid_price] => 竞拍价格
     *           [user_id] => 用户id
     *           [nickname] => 用户昵称
     *           [avatar] => 用户头像
     *           [title] => 标题
     *           [bid_step] => 竞拍单价
     *           [end_time] => 成交时间
     *           [img_cover] => 产品封面
     *           [product_id] => 产品id
     *           [sell_price] => 产品售价
     *           [product_type] => 产品类型，当product_type=1时，表示为10元专区的产品，加上10元专区的logo "
     *   )
     * )
     */
    public function index()
    {
        $model = new Period();
        $model->limit = $this->limit;
        $model->offset = $this->offset;
        self::showMsg($model->dealEnd());
    }
}
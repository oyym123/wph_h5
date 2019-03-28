<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/24
 * Time: 17:44
 */

namespace App\H5\Controllers;


use App\Api\components\WebController;
use App\Models\Period;

class PeriodController extends WebController
{
    /**
     * @SWG\Get(path="/api/period/next-period",
     *   tags={"前往下一期"},
     *   summary="商品详情->前往下一期 & 最新成交->参与竞拍 获取period_id",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="product_id", in="query", default="2", description="产品id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *           [data] => Array
     *               (
     *              [period_id] => 391
     *              )
     *     "
     *   )
     * )
     */
    public function nextPeriod()
    {
        $res = (new Period())->nextPeriod($this->request->product_id);
        self::showMsg(['period_id' => $res]);
    }
}
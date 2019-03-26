<?php

namespace App\Api\Controllers;

use App\Api\components\WebController;
use App\Models\Auctioneer;
use Encore\Admin\Controllers\ModelForm;

class AuctioneerController extends WebController
{
    use ModelForm;

    /**
     * /**
     * @SWG\Get(path="/api/auctioneer",
     *   tags={"拍卖师"},
     *   summary="",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="auctioneer_id", in="query", default="1", description="拍卖师id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                      [id] => 1
     *                      [img] => http://od83l5fvw.bkt.clouddn.com/images/7890.jpg
     *                      [tags] => 中国执业拍卖师  （标签）
     *                      [name] => 陈英          （名字）
     *                      [number] =>  2300410   （拍卖师编号）
     *                      [year] => 5             （年限）
     *                      [certificate] => 中国拍卖执业资格证书   (证书)
     *                      [list] => Array
     *                          (
     *                            [0] => Array   （跟主页数据一样）
     *                               (
     *                                  [id] => 47
     *                                  [product_id] => 2
     *                                  [period_code] => 201808040007
     *                                  [title] => Apple iPhone 8 256G 颜色随机
     *                                  [img_cover] => http://od83l5fvw.bkt.clouddn.com/images/1505283933090.png
     *                                  [sell_price] => 0.60
     *                                  [bid_step] => 0.10
     *                                  [is_favorite] => 0
     *                               )
     *                          )
     *     "
     *   )
     * )
     */
    public function index()
    {
        self::showMsg((new Auctioneer())->home($this->request->auctioneer_id));
    }
}

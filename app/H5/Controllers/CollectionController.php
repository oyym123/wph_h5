<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/3
 * Time: 0:11
 */

namespace App\H5\Controllers;


use App\H5\components\WebController;
use App\Models\Collection;

class CollectionController extends WebController
{
    /**
     * @SWG\Get(path="/api/collection/collect",
     *   tags={"收藏"},
     *   summary="收藏或者取消收藏",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="product_id", in="query", default="", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function collect()
    {
        $this->auth();
        $data = [
            'user_id' => $this->userId,
            'product_id' => $this->request->product_id
        ];
        (new Collection())->saveData($data);
      //  self::showMsg();
    }
}
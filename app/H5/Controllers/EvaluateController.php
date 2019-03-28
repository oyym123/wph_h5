<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/4
 * Time: 21:54
 */

namespace App\H5\Controllers;


use App\Api\components\WebController;
use App\Models\Evaluate;
use App\Models\Order;
use App\Models\Upload;
use zgldh\QiniuStorage\QiniuStorage;

class EvaluateController extends WebController
{
    /**
     * @SWG\Post(path="/api/evaluate/submit",
     *   tags={"晒单"},
     *   summary="提交晒单",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="sn", in="formData", default="1", description="订单号", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="contents", in="formData", default="很好的产品", description="内容", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="imgs", in="formData", default="1.png", description="图片1", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function submit()
    {
        $this->auth();
        $request = $this->request;
        $order = (new Order())->getOrder([
            'status' => Order::STATUS_CONFIRM_RECEIVING,
            'buyer_id' => $this->userId,
            'sn' => $request->sn
        ]);
        //$imgs = Upload::manyImg($request->file('imgs'));
        $imgs = $request->imgs;
        if (is_array($imgs)) {
            $imgs = json_encode($imgs);
        }

        if (count(json_decode($imgs, true)) < 2) {
            self::showMsg('至少传' . 2 . '张图片!', 4);
        }

        if (count(json_decode($imgs, true)) > 9) {
            self::showMsg('最多传' . 9 . '张图片!', 4);
        }

        $data = [
            'imgs' => $imgs,
            'order_id' => $order->id,
            'product_id' => $order->product_id,
            'period_id' => $order->period_id,
            'content' => $request->contents,
            'user_id' => $this->userId,
        ];
        $evaluate = new Evaluate();
        if ($evaluate->saveData($data)) {
            self::showMsg('感谢您的晒单！', 0);
        }
    }

    /**
     * @SWG\Post(path="/api/evaluate/upload-img",
     *   tags={"晒单"},
     *   summary="上传单张图片",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="img", in="formData", default="", description="图片", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *              [data] => Array
     *              (
     *                  url => cbfee5b55c1b0ef98c0b0fc564f8310e.png
     *              )
     *
     *     "
     *   )
     * )
     */
    public function uploadImg()
    {
        $this->auth();
        $img = Upload::oneImg($this->request->img);
        self::showMsg([
            'url' => $img,
            'full_url' => env('QINIU_URL_IMAGES') . $img
        ]);
    }

    /**
     * @SWG\Get(path="/api/evaluate",
     *   tags={"晒单"},
     *   summary="晒单列表",
     *   description="Author: OYYM",
     *    @SWG\Parameter(name="product_id", in="query", default="7", description="产品id",required = true,
     *     type="string",
     *   ),
     *    @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function index()
    {
        $model = new Evaluate();
        $model->offset = $this->offset;
        $model->limit = $this->limit;
        self::showMsg($model->getList(['product_id' => $this->request->product_id]));
    }

    /**
     * @SWG\Get(path="/api/evaluate/lists",
     *   tags={"晒单"},
     *   summary="首页晒单接口",
     *   description="Author: OYYM",
     *    @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function lists()
    {
        $model = new Evaluate();
        $model->offset = $this->offset;
        $model->limit = $this->limit;
        self::showMsg($model->getList());
    }

    /**
     * @SWG\Get(path="/api/evaluate/detail",
     *   tags={"晒单"},
     *   summary="晒单详情页",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="id", in="query", default="1", description="评论id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function detail()
    {
        $model = new Evaluate();
        self::showMsg($model->detail($this->request->id));
    }

    /**
     * @SWG\Get(path="/api/evaluate/rule",
     *   tags={"晒单"},
     *   summary="晒单规则",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function rule()
    {
        $data = [
            'example' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/evaluate-rule',
            'first' => '(1) 虚拟商品：上传竞拍成功页面截图或对应账户收货信息截图，留言超过8个字，即可获得1个赠币奖励！',
            'second' => '(2) 实物商品：上传至少3张商品照片，并留言超过8个字，即可获得1个赠币；真人露脸出镜额外奖励2个赠币。'
        ];
        self::showMsg($data);
    }

    /**
     * @SWG\Get(path="/api/evaluate/add-evaluate",
     *   tags={"晒单"},
     *   summary="添加评价",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="product_id", in="query", default="", description="产品id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="url", in="query", default="", description="京东网址", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function addEvaluate()
    {
        $model = new Evaluate();
        self::showMsg($model->createEvaluate($this->request->product_id, $this->request->url));
    }
}
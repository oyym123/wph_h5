<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/2
 * Time: 23:19
 */

namespace App\H5\Controllers;


use App\H5\components\WebController;
use App\Models\Bid;
use App\Models\Period;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RobotPeriod;
use Composer\DependencyResolver\Request;
use Illuminate\Support\Facades\Input;


class ProductController extends WebController
{

    /**
     * @SWG\Get(path="/api/product",
     *   tags={"产品"},
     *   summary="产品列表",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="type", in="query", default="", description="类型,0=全部",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="token", in="header", default="", description="用户token" ,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     *
     */
    public function index()
    {
        $period = new Period();
        $period->request = $this->request;
        $period->userId = $this->userId;
        $period->limit = $this->limit;
        $period->offset = $this->offset;
        self::showMsg($period->getProductList(4));
    }


    /**
     * @SWG\Get(path="/api/product/detail",
     *   tags={"产品"},
     *   summary="商品详情",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="period_id", in="query", default="49", description="期数id",required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *             [expended] => Array 用户消耗的
     *                       (
     *                          [used_real_bids] => 0
     *                          [used_voucher_bids] => 0
     *                          [used_money] => 0.00
     *                          [is_buy_differential_able] => 0
     *                          [buy_differential_money] => 0.00
     *                          [order_id] =>
     *                          [order_type] =>
     *                          [need_to_bided_pay] => 0
     *                          [need_to_bided_pay_price] => 0.00
     *                          [return_bids] => 0
     *                          [return_shop_bids] => 0
     *                          [pay_status] => 0
     *                          [pay_time] => 0
     *                      )
     *              [detail] => Array
     *                      (
     *                          [id] => 期数id
     *                          [period_status] => 2
     *                          [product_id] => 1042
     *                          [period_code] => 期数代码
     *                          [title] => 预售 三星 Galaxy A9 Star 4GB+64GB 颜色随机
     *                          [product_type] => 0
     *                          [img_cover] => 1529055804660
     *                          [imgs] => 1529055809318,1529055809433,1529055809639,1529055809710,1529055809774
     *                          [sell_price] =>3299.00
     *                          [bid_step] => 1
     *                          [price_add_length] => 0.1
     *                          [init_price] => 0.00
     *                          [countdown_length] => 10 (竞拍倒计时)
     *                          [is_voucher_bids_enable] => 1
     *                          [buy_by_diff] => 1  （是否可以差价购买 1=可以差价购，0=不可以）
     *                          [settlement_bid_id] => 256 (中奖者投标id)
     *                          [auctioneer_id] => 5 （拍卖师id）
     *                          [is_favorite] => 0
     *                          [product_status] => 3
     *                          [default_offer] => 5
     *                          [offer_ladder] => 10,20,50,66
     *                          [have_show] => 0
     *                          [auction_avatar] => 1517297843391
     *                          [auction_id] => 1
     *                          [auction_name] => 诺诺拍卖行
     *                          [auctioneer_avatar] => 1520580890766
     *                          [auctioneer_license] => 2300410
     *                          [auctioneer_name] => 陈英嫦
     *                      )
     *              [proxy] => Array
     *                      (
     *                      )
     *
     *              [price] => Array
     *                      (
     *                          [c] => 0
     *                          [d] => 377.50
     *                          [h] =>
     *                          [g] =>
     *                          [b] =>
     *                          [e] =>
     *                          [f] =>
     *                          [a] =>
     *                      )
     *              [bid_records] => Array
     *                      (
     *                      [0] => Array
     *                      (
     *                          [area] => 江西南昌
     *                          [bid_nickname] => 不可忽视的激情
     *                          [bid_no] => 3775
     *                          [bid_price] => 377.50
     *                      )
     *              )
     *     "
     *   )
     * )
     */
    public function detail()
    {
        $period = new  Period();
        $period->userId = $this->userId;
        $period->userEntity = $this->userIdent;
        $flag = $this->request->flag ?: 0;
        self::showMsg($period->getProductDetail($this->request->period_id, $flag));
    }

    /**
     * @SWG\Get(path="/api/product/cancel-visit",
     *   tags={"产品"},
     *   summary="取消访问",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="period_id", in="query", default="", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function cancelVisit()
    {
        $redis = app('redis')->connection('first');
        if ($this->request->period_id) {
            $num = $redis->hget('visit@PeriodRecord', $this->request->period_id);
            $redis->hset('visit@PeriodRecord', $this->request->period_id, $num - 1);
        }
    }

    /**
     * @SWG\Get(path="/api/product/past-deals",
     *   tags={"产品"},
     *   summary="往期成交",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="product_id", in="query", default="2", description="产品id",required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
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
    public function pastDeals()
    {
        $model = new Period();
        $model->limit = $this->limit;
        $model->offset = $this->offset;
        self::showMsg($model->dealEnd(['product_id' => $this->request->product_id]));
    }

    /**
     * @SWG\Get(path="/api/product/bid-rules",
     *   tags={"产品"},
     *   summary="竞价规则",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function bidRules()
    {
        $data = array(
            'value' => '<p><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(89, 89, 89);"></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(1) 所有商品竞拍初始价均为0元起，每出一次出价会消耗一定数量的拍币，同时商品价格以0.1元递增。</span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="color: rgb(89, 89, 89); font-family: 微软雅黑; font-size: 14px;">(2) 在初始倒计时内即可出价，初始倒计时后进入竞拍倒计时，当您出价后，该件商品的计时器将被自动重置，以便其他用户进行出价竞争。如果没有其他用户对该件商品出价，计时器归零时，您便成功拍得了该商品。</span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(3) 若拍卖成功，请在30天内以成交价购买竞拍商品，超过30天未下单，视为放弃，不返拍币。</span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(4) <span style="font-size:14px;font-family:&#39;微软雅黑&#39;,sans-serif">若拍卖失败，将返还所消耗拍币的100%作为购物币，可用于差价购买当期商品，赠币除外。</span></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span></p><p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(5) 平台严禁违规操作，最终解释权归微拍行所有。</span></p><p><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(89, 89, 89);"><br/></span></p>',
        );
        self::showMsg($data);
    }

    /**
     *
     * @SWG\Get(path="/api/product/type",
     *   tags={"产品"},
     *   summary="产品分类",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function type()
    {
        self::showMsg(ProductType::getList());
    }

    /**
     * @SWG\Get(path="/api/product/history-trend",
     *   tags={"产品"},
     *   summary="历史成交走势",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="product_id", in="query", default="2", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  [img] => 产品图片地址
     *                  [title] => 标题
     *                  [present_price] => 当前成交价
     *                  [max_price] => 最大价格
     *                  [min_price] => 最低价格
     *                  [average_price] => 平均价格
     *                  [detail] => Array
     *                      (
     *                          [0] => Array
     *                               (
     *                                  [flag] => 0 (0=下降，1=上升)
     *                                  [diff_price] => 0.2 (对比平均差价值)
     *                                  [end_time] => 拍中时间
     *                                  [bid_price] => 成交价
     *                                  [nickname] => 昵称
     *                               )
     *                      )
     *                  [list] =>  Array
     *                      (
     *                          [0] => Array
     *                              (
     *                                  [code] => 201808040007 成交期数代码
     *                                  [price] => 成交价格
     *                               )
     *                      )
     *     "
     *   )
     * )
     */
    public function historyTrend()
    {
        $period = new Period();
        $period->limit = $this->limit;
        $period->offset = $this->offset;
        self::showMsg($period->historyTrend($this->request->product_id));
    }

    /**
     * @SWG\Get(path="/api/product/shop-list",
     *   tags={"产品"},
     *   summary="购物币专区",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
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
    public function shopList()
    {
        $product = new Product();
        $product->limit = $this->limit;
        $product->offset = $this->offset;
        self::showMsg($product->shopList());
    }

    /**
     * @SWG\Get(path="/api/product/shop-detail",
     *   tags={"产品"},
     *   summary="购物币专区产品详情",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="product_id", in="query", default="7", description="产品详情", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function shopDetail()
    {
        $this->auth();
        $product = new Product();
        $product->userId = $this->userId;
        self::showMsg($product->shopDetail($this->request->product_id));
    }

    /**
     * @SWG\Get(path="/api/product/jd-product",
     *   tags={"产品"},
     *   summary="获取京东信息",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function jdProduct()
    {
        $product = new Product();
        $res = $product->getJd(7);
    }
}
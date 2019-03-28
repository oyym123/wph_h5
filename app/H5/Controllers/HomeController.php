<?php

namespace App\H5\Controllers;

use App\Api\components\WebController;
use App\Models\Income;
use App\Models\Period;


class HomeController extends WebController
{
    public function successView()
    {
        return view('api.home.success');
    }

    /**
     *
     * @SWG\Get(path="/api/home",
     *   tags={"首页"},
     *   summary="主页数据",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="
     *           [banner] => Array
     *                    (
     *                        [0] => Array
     *                           (
     *                             [id] => 5
     *                             [title] => 标题
     *                             [img] => 图片地址
     *                             [function] => html = url跳转类型
     *                             [params] => Array
     *                              (
     *                                  [key] => url表示地址
     *                                  [type] => String(类型)
     *                                  [value] => 跳转的地址（根据这个跳转）
     *                               )
     *                           )
     *                      )
     *           [display_module] => Array
     *                     (
     *                          [0] => Array
     *                             (
     *                              [id] => 1
     *                              [title] => 标题
     *                              [img] => 图片地址
     *                              [url] => 跳转的地址
     *                              )
     *                      )
     *     "
     *   )
     * )
     *
     */
    public function index()
    {
        $data = [
            'banner' => [
                [
                    'id' => 1,
                    'title' => '新手指南',
                    'img' => env('QINIU_URL_IMAGES') . 'banner-zhinan.jpg',
                    'function' => 'html',
                    'params' => [
                        'key' => 'url',
                        'type' => 'String',
                        'value' => '/pages/zhiNan/zhiNan?url=https://' . $_SERVER["HTTP_HOST"] . '/api/newbie-guide',
                    ],
                ],
                [
                    'id' => 3,
                    'title' => '拍品',
                    'img' => env('QINIU_URL_IMAGES') . 'banner-iphone.jpg',
                    'function' => 'html',
                    'params' => [
                        'key' => 'url',
                        'type' => 'String',
                        'value' => '/pages/detail_page/detail_page?period_id=47119',
                    ],
                ]
            ],
            'display_module' => [
                [
                    'id' => 0,
                    'title' => '手机专区',
                    'img' => env('QINIU_URL_IMAGES') . 'tuiguang2.png',
                    'url' => 'invite.html',
                ],
                [
                    'id' => 1,
                    'title' => '充值',
                    'img' => env('QINIU_URL_IMAGES') . 'chongzhi2018.png',
                    'url' => 'recharge.html',
                ],
                [

                    'id' => 2,
                    'title' => '限时秒杀',
                    'img' => env('QINIU_URL_IMAGES') . 'shiyuanzuanqv2018.png',
                    'url' => 'goods_list.html',
                ], [

                    'id' => 3,
                    'title' => '晒单',
                    'img' => env('QINIU_URL_IMAGES') . 'shaidan2018.png',
                    'url' => 'share.html',

                ],
                [
                    'id' => 4,
                    'title' => '常见问题',
                    'img' => env('QINIU_URL_IMAGES') . 'changjianwenti2018.png',
                    'url' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/common-problems',
                ]
            ],
            'last_deal' => (new  Period())->dealEnd([], 1)
        ];

        return view('h5.home.index', $data);
        // self::showMsg($data);
    }

    /**
     * @SWG\Get(path="/api/home/deal-end",
     *   tags={"首页"},
     *   summary="微拍头条&已完成商品的接口数据",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="
     *           [id] => 期数id
     *           [period_code] => 期数代码
     *           [bid_price] => 竞拍价格
     *           [save_price] => 节省的价格
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
    public function dealEnd()
    {
        $model = new Period();
        $model->limit = 6;
        $type = $this->request->type;
        $data = $model->dealEnd([], $type);
        shuffle($data);
        self::showMsg($data);
    }

    /**
     * /**
     * @SWG\Get(path="/api/home/get-period",
     *   tags={"首页"},
     *   summary="正在热拍|我在拍|我收藏",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="type", in="query", default="1", description="1 = 正在热拍(默认) | 2 = 我在拍 | 3 = 我收藏 | 6 = 热门拍卖 | 7= 热门推荐",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  [id] => period_id（期数id）
     *                  [product_id] => 产品id
     *                  [period_code] => 期数代码
     *                  [title] => 标题
     *                  [img_cover] => 产品封面
     *                  [sell_price] => 市场价
     *                  [bid_step] => 竞价
     *                  [pay_amount] => 每次竞拍应该支付的价格
     *                  [is_favorite] => 是否收藏 1 = 已收藏 | 0 = 未收藏
     *     "
     *   )
     * )
     */
    public function getPeriod()
    {
        $type = $this->request->type;

        if (in_array($type, [2, 3])) {
            $this->auth();
        } elseif (!in_array($type, [1, 2, 3])) {
            //  $type = 1;
        }

        $period = new Period();
        $period->userId = $this->userId;
        $period->limit = $this->limit;
        $period->offset = $this->offset;
        self::showMsg($period->getProductList($type));
    }
}

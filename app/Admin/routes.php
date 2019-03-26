<?php

use Illuminate\Routing\Router;


Admin::registerAuthRoutes();
//Route::pattern('id', '[0-9]+');

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->group([], function ($router) {
        /* @var \Illuminate\Routing\Router $router */
        $router->resource('users', 'UserController');
        //优惠券
        $router->resource('coupon', 'couponController');
        //拍卖师
        $router->resource('auctioneer', 'AuctioneerController');
        //产品分类
        $router->resource('product-type', 'ProductTypeController');
        //产品
        $router->resource('product', 'ProductController');
        //产品期数
        $router->resource('period', 'PeriodController');
        //投标记录
        $router->resource('bid', 'BidController');
        //充值卡
        $router->resource('recharge-card', 'RechargeCardController');
        //提现申请
        $router->resource('withdraw', 'WithdrawController');
        //推广代理
        $router->resource('invite', 'InviteController');
        //订单管理
        $router->resource('order', 'OrderController');
        //出价分类
        $router->resource('bid-type', 'BidTypeController');
        //上传产品
        $router->resource('upload-product', 'UploadProductController');
        //文章内容
        $router->resource('article', 'ArticleController');
    });

    $router->get('/', 'HomeController@index');

    //用户中心
    $router->any('users', 'UserController@index');
    $router->get('users/{id}/edit', 'UserController@edit');
    $router->get('users/create', 'UserController@create');

    //图片管理
    $router->get('image', 'ImageController@index');
    $router->get('image/{id}/edit', 'ImageController@edit');
    $router->get('image/create', 'ImageController@create');


});

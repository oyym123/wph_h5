<?php
/**
 * H5数据接口路由
 */

use App\Models\Auctioneer;
use Illuminate\Support\Facades\Route;

Route::any('server', 'ServerController@index'); // 这个要放到中间件的外面

Route::get('/auctioneer', function () {
    return new \App\Http\Resources\AuctioneerCollection(Auctioneer::paginate());
});

Route::group(['middleware' => 'h5'], function () {
    //新手指引banner链接
    Route::get('/newbie-guide', function () {
        return view('api.home.newbie_guide');
    });
    Route::any('wx-notify/notify', 'WxNotifyController@notify'); // 微信回调

    Route::get('auctioneer', 'AuctioneerController@index');

    // 测试
    Route::get('server/test', 'ServerController@test');
    Route::get('user/index2', 'UserController@index');

    Route::any('user/get-invite-qr-code', 'UserController@getInviteQrCode');
    Route::get('home/success', 'HomeController@success');
    Route::get('home/success-view', 'HomeController@successView');

    //首页
    Route::get('home', 'HomeController@index');
    Route::get('home/get-period', 'HomeController@getPeriod');
    Route::get('home/deal-end', 'HomeController@dealEnd');

    //最新成交
    Route::get('latest-deal', 'LatestDealController@index');

    //产品
    Route::get('product', 'ProductController@index');
    Route::get('product/cancel-visit', 'ProductController@cancelVisit');
    Route::get('product/jd-product', 'ProductController@jdProduct');
    Route::get('product/type', 'ProductController@type');
    Route::get('product/detail', 'ProductController@detail');
    Route::get('bid/latest-deal', 'BidController@latestDeal');

    Route::get('product/bid-rules', 'ProductController@bidRules');
    Route::get('product/past-deals', 'ProductController@pastDeals');
    Route::get('product/period', 'ProductController@period');
    Route::get('product/history-trend', 'ProductController@historyTrend');
    Route::get('product/shop-list', 'ProductController@shopList');
    Route::get('product/shop-detail', 'ProductController@shopDetail');
    Route::get('product/history-trend', 'ProductController@historyTrend');
    Route::get('product/past-deal', 'ProductController@pastDeal');
    //前往下一期
    Route::get('period/next-period', 'PeriodController@nextPeriod');

    /** 竞拍 */
    Route::post('bid/bidding', 'BidController@bidding');
    Route::get('bid/record', 'BidController@record');
    Route::post('bid/auto', 'BidController@auto');
    Route::post('bid/newest-bid', 'BidController@newestBid');
    Route::get('bid/auto-info', 'BidController@autoInfo');
    Route::get('bid/bid-socket', 'BidController@bidSocket');

    /** 支付 */
    Route::post('pay/confirm', 'PayController@confirm'); //确认订单
    Route::get('pay/recharge-center', 'PayController@rechargeCenter'); //充值中心
    Route::post('pay/recharge', 'PayController@recharge'); //充值
    Route::post('pay/pay', 'PayController@pay'); //立即购买
    Route::get('new-pay/weixin-pay', 'NewPayController@weixinPay'); //立即购买


    /** 用户中心 */
    Route::get('user/batch-register', 'UserController@batchRegister');
    Route::get('user/user-agreement', 'UserController@userAgreement'); //用户收货地址
    Route::get('user/default-address', 'UserController@defaultAddress'); //用户收货地址
    Route::post('user/address', 'UserController@address'); //用户收货地址
    Route::post('user/withdraw', 'UserController@withdraw'); //提现
    Route::post('user/set-withdraw-account', 'UserController@setWithdrawAccount'); //我的绩效
    Route::get('user/performance', 'UserController@performance'); //我的绩效
    Route::get('user/performance-income', 'UserController@performanceIncome'); //我的绩效-收益加载更多
    Route::get('user/performance-withdraw', 'UserController@performanceWithDraw'); //我的绩效-提现信息加载更多
    Route::get('user/property-income', 'UserController@propertyIncome'); //收益明细
    Route::get('user/property-expend', 'UserController@propertyExpend'); //支出明细
    Route::get('user/property', 'UserController@property'); //我的竞拍
    Route::get('user/batch-register', 'UserController@batchRegister');//批量用户注册
    Route::get('user/shopping-currency', 'UserController@shoppingCurrency');//批量用户注册
    Route::get('user/evaluate', 'UserController@evaluate');//批量用户注册
    Route::get('/balance-desc', function () {  //收益详情
        return view('api.user.balance-desc');
    });

    Route::get('/shopping-rule', function () { //购物币规则
        return view('api.user.shopping-rule');
    });

    Route::get('/common-problems', function () { //常见问题
        $res = \App\Models\Article::where([
            'status' => 1,
            'type' => \App\Models\Article::TYPE_COMMON_QUESTION
        ])->first();
        if ($res) {
            echo $res->contents;
        } else {
            return view('api.user.common-problems');
        }
    });

    Route::get('/make-money', function () { //常见问题
        $res = \App\Models\Article::where([
            'status' => 1,
            'type' => \App\Models\Article::TYPE_MAKE_MONEY
        ])->first();
        if ($res) {
            echo $res->contents;
        }
    });

    Route::get('/user-agreement', function () { //常见问题
        return view('api.user.user-agreement');
    });

    Route::get('/evaluate-rule', function () { //晒单示例
        return view('api.user.evaluate-rule');
    });
    /**  我的推广  */
    Route::get('invite/index', 'InviteController@Index'); //我的推广主页
    Route::get('invite/invite-list', 'InviteController@inviteList'); //我的推广主页
    Route::get('invite/detail', 'InviteController@detail'); //我的推广主页

    /** 订单中心 */
    Route::get('order/cancel-order', 'OrderController@cancelOrder'); //我的竞拍
    Route::get('order/my-auction', 'OrderController@MyAuction'); //我的竞拍
    Route::get('order/confirm-order', 'OrderController@confirmOrder'); //确认订单
    Route::get('order/confirm-receipt', 'OrderController@confirmReceipt'); //确认收货
    Route::get('order/transport-detail', 'OrderController@transportDetail'); //运输详情


    /** 晒单 */
    Route::get('evaluate/rule', 'EvaluateController@rule'); //晒单规则
    Route::post('evaluate/upload-img', 'EvaluateController@uploadImg'); //提交晒单
    Route::post('evaluate/submit', 'EvaluateController@submit'); //提交晒单
    Route::get('evaluate/lists', 'EvaluateController@lists'); //首页晒单列表
    Route::get('evaluate/detail', 'EvaluateController@detail'); //晒单详情
    Route::get('evaluate', 'EvaluateController@index'); //晒单列表
    Route::get('evaluate/add-evaluate', 'EvaluateController@addEvaluate'); //晒单列表

    //收藏
    Route::get('collection/collect', 'CollectionController@collect');

    Route::get('user/register-view', 'UserController@registerView');//用户注册视图
    Route::get('user/info', 'UserController@info');//用户注册提交表单
    Route::post('user/update-post', 'UserController@updatePost');//用户注册提交表单
    //Route::get('user/register-success', 'UserController@registerSuccess');//视图

    Route::any('user/update', 'UserController@update'); //用户修改（个人中心）
    Route::any('user/binding-mobile', 'UserController@binddingMobile'); //绑定手机号（个人中心）
    Route::post('user/binding-mobile-post', 'UserController@binddingMobilePost'); //绑定手机号（个人中心）
    Route::any('wechat', 'WechatController@server');
    Route::any('test', 'UserController@test');
    Route::any('user/center', 'UserController@center');


    /** 会员卡与积分 */
    Route::any('user-point-card', 'UserPointCardController@index');
    Route::any('user/member-card', 'UserController@memberCard');

    Route::any('weixin-oauth-callback', 'WeixinOauthCallbackController@index');
    Route::any('weixin-oauth-callback/test', 'WeixinOauthCallbackController@test');

    /** 积分兑换 */
    Route::any('point/exchange', 'PointController@exchange');
    /** 发送短信验证码 */
    Route::any('sms/send', 'SmsController@send');
    /** 文章 会员视频 */
    Route::any('article', 'ArticleController@index');

    /** 获取阿拉丁分享链接 */
    Route::get('getshareurl', 'ShareUrlController@index');
});


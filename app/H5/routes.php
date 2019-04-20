<?php
/**
 * H5数据接口路由
 */
use Illuminate\Routing\Router;
use App\Models\Auctioneer;

Route::any('server', 'ServerController@index'); // 这个要放到中间件的外面

Route::get('/auctioneer1', function () {
    print_r(session()->all());
    exit;
    return new \App\Http\Resources\AuctioneerCollection(Auctioneer::paginate());
});

Route::group([

], function (Router $router) {

    //新手指引banner链接
    $router->get('/newbie-guide', function () {
        return view('api.home.newbie_guide');
    });

    $router->any('wx-notify/notify', 'WxNotifyController@notify'); // 微信回调
    $router->get('auctioneer', 'AuctioneerController@index');

    // 测试
    $router->get('server/test', 'ServerController@test');
    $router->get('user/index2', 'UserController@index');

    $router->any('user/get-invite-qr-code', 'UserController@getInviteQrCode');
    $router->get('home/success', 'HomeController@success');
    $router->get('home/success-view', 'HomeController@successView');

    //首页
    $router->get('home', 'HomeController@index');
    $router->get('home/get-period', 'HomeController@getPeriod');
    $router->get('home/deal-end', 'HomeController@dealEnd');

    //最新成交
    $router->get('latest-deal', 'LatestDealController@index');

    //产品
    $router->get('product/phone-zone-view', 'ProductController@phoneZoneView');//10元专区视图
    $router->get('product/ten-zone-view', 'ProductController@tenZoneView');//10元专区视图
    $router->get('product', 'ProductController@index');
    $router->get('product/cancel-visit', 'ProductController@cancelVisit');
    $router->get('product/jd-product', 'ProductController@jdProduct');
    $router->get('product/type', 'ProductController@type');
    $router->get('product/detail', 'ProductController@detail');
    $router->get('bid/latest-deal', 'BidController@latestDeal');

    $router->get('product/bid-rules', 'ProductController@bidRules');
    $router->get('product/past-deals', 'ProductController@pastDeals');
    $router->get('product/period', 'ProductController@period');
    $router->get('product/history-trend', 'ProductController@historyTrend');
    $router->get('product/shop-list-view', 'ProductController@shopListView');//购物币专区视图
    $router->get('product/shop-list', 'ProductController@shopList');
    $router->get('product/shop-detail-view', 'ProductController@shopDetailView');//购物币详情视图
    $router->get('product/shop-detail', 'ProductController@shopDetail');
    $router->get('product/history-trend', 'ProductController@historyTrend');
    $router->get('product/past-deal', 'ProductController@pastDeal');
    //前往下一期
    $router->get('period/next-period', 'PeriodController@nextPeriod');

    /** 竞拍 */
    $router->get('bid/scheduled-tasks', 'BidController@scheduledTasks'); //本地测试计划任务
    $router->post('bid/crontab-start', 'BidController@crontabStart'); //本地测试计划任务
    $router->post('bid/bidding', 'BidController@bidding');
    $router->get('bid/record', 'BidController@record');
    $router->post('bid/auto', 'BidController@auto');
    $router->post('bid/newest-bid', 'BidController@newestBid');
    $router->get('bid/auto-info', 'BidController@autoInfo');
    $router->get('bid/bid-socket', 'BidController@bidSocket');

    /** 支付 */
    $router->get('pay/confirm', 'PayController@confirm'); //确认订单
    $router->get('pay/recharge-center', 'PayController@rechargeCenter'); //充值中心
    $router->get('pay/recharge', 'PayController@recharge'); //充值
    $router->get('pay/pay', 'PayController@pay'); //立即购买
    $router->get('new-pay/weixin-pay', 'NewPayController@weixinPay'); //立即购买


    /** 用户中心 */
    $router->get('user/update-view', 'UserController@updateView');//修改信息视图
    $router->post('user/update', 'UserController@update');//修改信息
    $router->get('user/my-info', 'UserController@myInfo');//基本信息
    $router->post('user/login-out', 'UserController@loginOut');//退出登入
    $router->get('user/setup-list', 'UserController@setupList');//设置
    $router->get('user/login-view', 'UserController@loginView');//用户登入视图
    $router->post('user/login', 'UserController@login');//用户登入提交
    $router->get('user/register-view', 'UserController@registerView');//用户登入视图
    $router->post('user/register', 'UserController@register');//用户登入提交
    $router->post('user/check_sms', 'UserController@checkSms');//短信验证
    $router->get('user/batch-register', 'UserController@batchRegister');
    $router->get('user/user-agreement', 'UserController@userAgreement'); //用户收货地址
    $router->get('user/default-address', 'UserController@defaultAddress'); //用户收货地址
    $router->get('user/address-view', 'UserController@addressView'); //用户收货地址视图
    $router->post('user/address', 'UserController@address'); //用户收货地址

    $router->post('user/withdraw', 'UserController@withdraw'); //提现
    $router->post('user/set-withdraw-account', 'UserController@setWithdrawAccount'); //我的绩效
    $router->get('user/performance', 'UserController@performance'); //我的绩效
    $router->get('user/performance-income', 'UserController@performanceIncome'); //我的绩效-收益加载更多
    $router->get('user/performance-withdraw', 'UserController@performanceWithDraw'); //我的绩效-提现信息加载更多
    $router->get('user/property-income', 'UserController@propertyIncome'); //收益明细
    $router->get('user/property-expend', 'UserController@propertyExpend'); //支出明细
    $router->get('user/property', 'UserController@property'); //我的竞拍
    $router->get('user/batch-register', 'UserController@batchRegister');//批量用户注册
    $router->get('user/shopping-currency', 'UserController@shoppingCurrency');//批量用户注册
    $router->get('user/evaluate', 'UserController@evaluate');//批量用户注册
    $router->get('user/collection-view', 'UserController@collectionView');//收藏视图
    $router->get('user/collection', 'UserController@collection');//收藏数据
    $router->get('/balance-desc', function () {  //收益详情
        return view('api.user.balance-desc');
    });

    $router->get('/shopping-rule', function () { //购物币规则
        return view('api.user.shopping-rule');
    });

    $router->get('/common-problems', function () { //常见问题
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

    $router->get('/make-money', function () { //常见问题
        $res = \App\Models\Article::where([
            'status' => 1,
            'type' => \App\Models\Article::TYPE_MAKE_MONEY
        ])->first();
        if ($res) {
            echo $res->contents;
        }
    });

    $router->get('/user-agreement', function () { //常见问题
        return view('api.user.user-agreement');
    });

    $router->get('/evaluate-rule', function () { //晒单示例
        return view('api.user.evaluate-rule');
    });
    /**  我的推广  */
    $router->get('invite/index', 'InviteController@Index'); //我的推广主页
    $router->get('invite/invite-list', 'InviteController@inviteList'); //我的推广主页
    $router->get('invite/detail', 'InviteController@detail'); //我的推广主页

    /** 订单中心 */
    $router->get('order/cancel-order', 'OrderController@cancelOrder'); //我的竞拍
    $router->get('order/my-auction', 'OrderController@MyAuction'); //我的竞拍
    $router->get('order/confirm-order', 'OrderController@confirmOrder'); //确认订单
    $router->get('order/confirm-receipt', 'OrderController@confirmReceipt'); //确认收货
    $router->get('order/transport-detail', 'OrderController@transportDetail'); //运输详情


    /** 晒单 */
    $router->get('evaluate/rule', 'EvaluateController@rule'); //晒单规则
    $router->post('evaluate/upload-img', 'EvaluateController@uploadImg'); //提交晒单
    $router->post('evaluate/submit', 'EvaluateController@submit'); //提交晒单
    $router->get('evaluate/lists', 'EvaluateController@lists'); //首页晒单列表
    $router->get('evaluate/detail', 'EvaluateController@detail'); //晒单详情
    $router->get('evaluate', 'EvaluateController@index'); //晒单列表
    $router->get('evaluate/add-evaluate', 'EvaluateController@addEvaluate'); //晒单列表

    //收藏
    $router->get('collection/collect', 'CollectionController@collect');

    $router->get('user/register-view', 'UserController@registerView');//用户注册视图
    $router->get('user/info', 'UserController@info');//用户注册提交表单
    $router->post('user/update-post', 'UserController@updatePost');//用户注册提交表单
    //$router->get('user/register-success', 'UserController@registerSuccess');//视图

    //$router->any('user/update', 'UserController@update'); //用户修改（个人中心）
    $router->any('user/binding-mobile', 'UserController@binddingMobile'); //绑定手机号（个人中心）
    $router->post('user/binding-mobile-post', 'UserController@binddingMobilePost'); //绑定手机号（个人中心）
    $router->any('wechat', 'WechatController@server');
    $router->any('test', 'UserController@test');
    $router->any('user/center', 'UserController@center');


    /** 会员卡与积分 */
    $router->any('user-point-card', 'UserPointCardController@index');
    $router->any('user/member-card', 'UserController@memberCard');

    $router->any('weixin-oauth-callback', 'WeixinOauthCallbackController@index');
    $router->any('weixin-oauth-callback/test', 'WeixinOauthCallbackController@test');

    /** 积分兑换 */
    $router->any('point/exchange', 'PointController@exchange');
    /** 发送短信验证码 */
    $router->post('sms/send', 'SmsController@send');
    /** 文章 会员视频 */
    $router->any('article', 'ArticleController@index');

    /** 获取阿拉丁分享链接 */
    $router->get('getshareurl', 'ShareUrlController@index');

});


<html class="pixel-ratio-3 retina android android-5 android-5-0">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/weui.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/jiazai.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/h5/light7.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/h5/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('css/h5/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/h5/swiper.min.css')}}">
    <script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
    <script type="text/javascript">

        // jssdk config 对象
        jssdkconfig = null || {};

        // 是否启用调试
        jssdkconfig.debug = false;

        jssdkconfig.jsApiList = [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard',
            'openAddress'
        ];

        wx.config(jssdkconfig);

    </script>

    <script src="{{ asset('js/zepto.min.js') }}"></script>
    <script src="{{ asset('js/h5/jquery.min.js') }}"></script>
    <script src="{{ asset('js/h5/global.js') }}"></script>
    <script src="{{ asset('js/h5/light7.min.js') }}"></script>
    <script src="{{ asset('js/h5/swiper.min.js') }}"></script>
    <script src="{{ asset('js/h5/laytpl.js') }}"></script>
    <script src="{{ asset('js/h5/common.js') }}"></script>
    <script src="{{ asset('js/h5/weixinJs.js') }}"></script>

    {{--<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>--}}
</head>

<body style="background-color: #f8f8f8;font-size: smaller">
<div class="page-group">
    <div class="page page-current page-inited" id="page-index" >
        <nav class="bar bar-tab bar-footer" style="z-index: 99;">
            @if(isset($display_module))
            <a class="tab-item external active" href="/h5/home">
                @else
                    <a class="tab-item external " href="/h5/home">
                @endif
                <span class="icon iconfont icon-home_light"></span>
                <span class="tab-label">首页</span>
            </a>
                    @if(isset($latest_active))
            <a class="tab-item external active" href="/h5/latest-deal" >
                @else
                    <a class="tab-item external " href="/h5/latest-deal" >
                        @endif
                <span class="icon iconfont icon-hot"></span>
                <span class="tab-label">最新成交</span>
            </a>
                    @if(isset($product_type_active))
            <a class="tab-item external active" href="/h5/product/type">
                @else
                    <a class="tab-item external " href="/h5/product/type">
                @endif
                <span class="icon iconfont icon-similar"></span>
                <span class="tab-label">分类</span>
            </a>
                @if(isset($user_center_active))
                        <a class="tab-item external active" href="/h5/user/center">
                    @else<a class="tab-item external " href="/h5/user/center">@endif
                <span class="icon iconfont icon-my_light"></span>
                <span class="tab-label">我的</span>
            </a>
        </nav>
        <header class="bar bar-nav" style="position: fixed;">
            <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;"
               href="javascript:history.go(-1);">
                <span style="color: #999999;" class="icon icon-left"></span>
            </a>
            <h1 class="title">@yield('title_head')</h1>
        </header>
        @section('content')
    </div>
</div>
@show
<div id="popout">@yield('popout')</div>
<div id="mask">@yield('mask')</div>
<div id="navigation">@yield('navigation')</div>

</body>
@yield('myjs')
</html>
{{--<script>--}}
{{--// 首先禁止body--}}
{{--document.body.ontouchmove = function (e) {--}}
{{--e.preventDefault();--}}
{{--};--}}

{{--// 然后取得触摸点的坐标--}}
{{--var startX = 0, startY = 0;--}}
{{--//touchstart事件--}}
{{--function touchSatrtFunc(evt) {--}}
{{--try {--}}
{{--//evt.preventDefault(); //阻止触摸时浏览器的缩放、滚动条滚动等--}}
{{--var touch = evt.touches[0]; //获取第一个触点--}}
{{--var x = Number(touch.pageX); //页面触点X坐标--}}
{{--var y = Number(touch.pageY); //页面触点Y坐标--}}
{{--//记录触点初始位置--}}
{{--startX = x;--}}
{{--startY = y;--}}

{{--} catch (e) {--}}
{{--alert('touchSatrtFunc：' + e.message);--}}
{{--}--}}
{{--}--}}
{{--document.addEventListener('touchstart', touchSatrtFunc, false);--}}

{{--// 然后对允许滚动的条件进行判断，这里讲滚动的元素指向body--}}
{{--var _ss = document.body;--}}
{{--_ss.ontouchmove = function (ev) {--}}
{{--var _point = ev.touches[0],--}}
{{--_top = _ss.scrollTop;--}}
{{--// 什么时候到底部--}}
{{--var _bottomFaVal = _ss.scrollHeight - _ss.offsetHeight;--}}
{{--// 到达顶端--}}
{{--if (_top === 0) {--}}
{{--// 阻止向下滑动--}}
{{--if (_point.clientY > startY) {--}}
{{--ev.preventDefault();--}}
{{--} else {--}}
{{--// 阻止冒泡--}}
{{--// 正常执行--}}
{{--ev.stopPropagation();--}}
{{--}--}}
{{--} else if (_top === _bottomFaVal) {--}}
{{--// 到达底部 如果想禁止页面滚动和上拉加载，讲这段注释放开，也就是在滚动到页面底部的制售阻止默认事件--}}
{{--// 阻止向上滑动--}}
{{--// if (_point.clientY < startY) {--}}
{{--//     ev.preventDefault();--}}
{{--// } else {--}}
{{--//     // 阻止冒泡--}}
{{--//     // 正常执行--}}
{{--//     ev.stopPropagation();--}}
{{--// }--}}
{{--} else if (_top > 0 && _top < _bottomFaVal) {--}}
{{--ev.stopPropagation();--}}
{{--} else {--}}
{{--ev.preventDefault();--}}
{{--}--}}
{{--};--}}
{{--</script>--}}

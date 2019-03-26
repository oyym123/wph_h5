<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/weui.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/jiazai.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <script src="{{ asset('js/zepto.min.js') }}"></script>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
</head>

<body style="background-color: #f8f8f8;font-size: smaller ">

@section('content')

@show
<div id="popout">@yield('popout')</div>
<div id="mask">@yield('mask')</div>
<div id="navigation">@yield('navigation')</div>

</body>
@yield('myjs')
</html>
<script>
    // 首先禁止body
    document.body.ontouchmove = function (e) {
        e.preventDefault();
    };

    // 然后取得触摸点的坐标
    var startX = 0, startY = 0;
    //touchstart事件
    function touchSatrtFunc(evt) {
        try {
            //evt.preventDefault(); //阻止触摸时浏览器的缩放、滚动条滚动等
            var touch = evt.touches[0]; //获取第一个触点
            var x = Number(touch.pageX); //页面触点X坐标
            var y = Number(touch.pageY); //页面触点Y坐标
            //记录触点初始位置
            startX = x;
            startY = y;

        } catch (e) {
            alert('touchSatrtFunc：' + e.message);
        }
    }
    document.addEventListener('touchstart', touchSatrtFunc, false);

    // 然后对允许滚动的条件进行判断，这里讲滚动的元素指向body
    var _ss = document.body;
    _ss.ontouchmove = function (ev) {
        var _point = ev.touches[0],
            _top = _ss.scrollTop;
        // 什么时候到底部
        var _bottomFaVal = _ss.scrollHeight - _ss.offsetHeight;
        // 到达顶端
        if (_top === 0) {
            // 阻止向下滑动
            if (_point.clientY > startY) {
                ev.preventDefault();
            } else {
                // 阻止冒泡
                // 正常执行
                ev.stopPropagation();
            }
        } else if (_top === _bottomFaVal) {
            // 到达底部 如果想禁止页面滚动和上拉加载，讲这段注释放开，也就是在滚动到页面底部的制售阻止默认事件
            // 阻止向上滑动
            // if (_point.clientY < startY) {
            //     ev.preventDefault();
            // } else {
            //     // 阻止冒泡
            //     // 正常执行
            //     ev.stopPropagation();
            // }
        } else if (_top > 0 && _top < _bottomFaVal) {
            ev.stopPropagation();
        } else {
            ev.preventDefault();
        }
    };
</script>

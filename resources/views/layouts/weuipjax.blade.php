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

    <!-- JavaScripts建议将这些js下载到本地 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
    <script>
        $(document).pjax('a', '#pjax-container');
        $(document).on('pjax:send', function () { //pjax链接点击后显示加载动画；
            $(".spinner").css("display", "block");
        });
        $(document).on('pjax:complete', function () { //pjax链接加载完成后隐藏加载动画；
            $(".spinner").css("display", "none");
        });

        $(document).on("pjax:timeout", function (event) {
            // 阻止超时导致链接跳转事件发生
            event.preventDefault()
        });
    </script>
</head>

<body style="background-color: #f8f8f8;font-size: smaller ">



@section('content')

@show

<div id="popout">@yield('popout')</div>
<div id="mask">@yield('mask')</div>
<div id="navigation">@yield('navigation')</div>
<!-- 添加 Pjax 设置：(必须有一个空元素放加载的内容) -->
<div class="main-content" id="pjax-container">
    @section('content-pjax')
    @show
</div>
</body>
@yield('myjs')
</html>

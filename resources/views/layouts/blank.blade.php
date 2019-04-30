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
</head>

<body style="background-color: #f8f8f8;font-size: smaller">
<div class="page-group">
    <div class="page page-current page-inited" id="page-index" >
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

</body>
@yield('myjs')
</html>

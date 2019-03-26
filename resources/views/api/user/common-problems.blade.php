<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>客服中心</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta https-equiv="Cache-Control" content="no-cache">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta name="W_design" content="750">
    <link rel="stylesheet" href="https://static.gogobids.com/css/public.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_5vqt1dxhvuoc4n29.css">
    <script src="https://static.gogobids.com/js/common/autoRootSize_web.min.js"></script>
    <style>.mui-content {
            background: #fff !important;
            overflow-y: auto
        }

        .intro {
            padding: .4rem .25rem
        }

        .intro_tit {
            position: relative;
            font-size: .28rem;
            margin-bottom: .3rem;
            padding-left: .2rem;
            font-weight: 700
        }

        .intro_tit i {
            background: #f01e28;
            position: absolute;
            top: .05rem;
            left: 0;
            width: .06rem;
            height: .3rem
        }

        .ui-navigation + .mui-content {
            bottom: 1rem
        }

        .service_kefu {
            display: inline-block;
            padding: .05rem;
            color: #36c;
            text-decoration: underline
        }

        .copyright {
            text-align: center;
            color: #ccc;
            padding: .4rem 0 0;
            display: none
        }

        .service_ol {
            display: block;
            position: fixed;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 90;
            font-size: .3rem
        }

        .questions_list li {
            position: relative;
            padding: .2rem .3rem;
            border-bottom: 1px solid #ddd;
            overflow: hidden;
            transition: all .5s linear;
            -webkit-transition: all .5s linear
        }

        .questions_list .tit {
            display: block;
            background-size: 12px auto;
            line-height: .6rem;
            min-height: .6rem;
            padding-right: .4rem;
            font-weight: 700;
            font-size: .26rem;
            position: relative
        }

        .questions_list li .tit:before {
            position: absolute;
            right: 0;
            top: 0;
            font-size: .28rem;
            content: '\e617';
            color: #ccc
        }

        .questions_list .focus .tit:before {
            content: '\e600'
        }

        .questions_list .con {
            position: relative;
            border-top: 1px solid #ddd;
            margin-top: .2rem;
            padding-top: .2rem;
            color: #999;
            width: 100%
        }

        .qqGroup_wrap {
            position: relative
        }

        .ui-btn-submit-s {
            padding: 0 .25rem;
            position: absolute;
            right: 0;
            top: 0
        }</style>
</head>
<body>
<div class="wrap">
    <header class="ui-navigation"><a class="icon-back mui-action-back"></a>客服中心</header>
    <div class="mui-content mui-scroll-wrapper">
        <div class="mui-scroll">
            <div class="intro">
                <div class="top"><h3 class="intro_tit"><i></i><b>如以下常见问题未能帮助到您，请通过以下方式联系我们。</b></h3>
                    <p id="qqGroup_wrap" class="qqGroup_wrap">QQ交流群：<span class="isShowQqBtn_no">3010371519</span></p>
                    <p>客服热线：<a id="J-callservice" data-num="4009912121" class="service_kefu">19941297930</a></p>
                    <p>服务时间：周一至周五 9:30-21:00，周六日：9:30-18:30</p></div>
                <div id="question"></div>
                <p class="copyright">所有解释权由51微拍所有</p></div>
        </div>
    </div>
</body>
<script src="/js/server/service.js"></script>
</html>
@extends('layouts.h5')
@section('title')
    首页
@stop
@section('content')
    <header class="bar bar-nav">
        <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;"
           href="javascript:history.go(-1);">
            <span style="color: #999999;" class="icon icon-left"></span>
        </a>
        <h1 class="title">登录</h1>
        <a href="register-view" style="color: #EF1544;" class="button button-link button-nav pull-right create-actions">注册</a>
    </header>
    <div class="content native-scroll">
        <div class="weui-cells__title">请输入登录信息</div>
        <div class="list-block">
            <ul>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">手机号：</div>
                            <div class="item-input">
                                <input type="tel" id="mobile" value="" placeholder="请输入手机号码" pattern="[0-9]*">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">密码：</div>
                            <div class="item-input">
                                <input type="password" id="contacts" value="" placeholder="请输入密码">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <label for="weuiAgree" class="weui-agree" onclick="changecolor()">
                <input id="weuiAgree" type="checkbox" checked="checked" class="weui-agree__checkbox">
                <span class="weui-agree__text">
	                                阅读并同意<a href="javascript:;" class="external open-popup" data-popup=".popup-about">《用户协议》</a>
	            </span>
            </label>
            <div class="weui-btn-area" style="margin-top: .6rem;">
                <a class="weui-btn weui-btn_primary external" style="background-color: #EF1544;"
                   href="javascript:validate()" id="showTooltips">登录</a>
            </div>
            <div style="height: 40px;">
	            <span class="weui-agree" style="float: right;">
	        		<a href="register-view" class="external">忘记密码？</a>
	            </span>
            </div>
            <div class="thirdparty">
                {{--<span class="weui-agree" style="text-align: center;color:#AAAAAA;">--}}
                {{--<span class="external">第三方快速登录</span>--}}
                {{--<p onclick="wechatsign()" style="margin-top: 5px;margin-bottom: 5px;"><img src="https://demo..cn/addons/_fastauction/app/resource/images/weixin.png" style="width: 50px;"></p>--}}
                {{--<p>微信</p>--}}
                {{--</span>--}}

                <span class="weui-agree" style="text-align: center;color:#AAAAAA;">
                	        		<span class="external">第三方快速登录</span>
                	        		<p  style="margin-top: 5px;margin-bottom: 5px;">
                                        <a href="{{ $weibo_url }}"><img src="/images/h5/weibo.png" style="width: 50px;"></a>
                	        		<p>微博</p>
                	            </span>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="popup popup-about">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-right close-popup">
                关闭
            </a>
            <h1 class="title">用户协议</h1>
        </header>
        <div class="content">
            <div class="content-inner">
                <div class="content-block">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/h5/jquery.cookie.js') }}"></script>
    <script>
        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
            $('.thirdparty').show();
        });

        function changecolor() {
            if (!$('#weuiAgree').is(":checked")) {
                $('#showTooltips').css('background-color', '#aaa')
            } else {
                $('#showTooltips').css('background-color', '#EF1544')
            }
        }

        function wechatsign() {
            location.href = "/?i=37&c=entry&m=_fastauction&p=member&ac=user&do=wechatsign";
        }

        function validate() {
            if ($('#weuiAgree').is(":checked")) {
                var mobile = $("#mobile").val();
                var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
                if (!reg.test(mobile)) {
                    $.toast('请填写正确的手机号');
                    return false;
                }
                var contacts = $("#contacts").val();
                if (contacts == '') {
                    $.toast('请填写登录密码');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "login",
                    data: {pwd: contacts, mobile: mobile},
                    dataType: 'json',
                    beforeSend: function (XMLHttpRequest) {
                    },
                    success: function (data) {
                        if (data.code >= 0) {
                            //    $.cookie('laravel_session', data.session_info, { expires: 7, path: '/' });
                            $.toast('登录成功');
                            location.href = "/h5/user/center";
                        } else {
                            $.toast(data.message);
                        }
                    },
                    error: function () {
                        $.toast('通信错误，请重试');
                    }
                });
            }
        }
    </script>
    @parent
@stop

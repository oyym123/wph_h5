@extends('layouts.h5')
@section('title')
    首页
@stop

@section('content')
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;" href="javascript:history.go(-1);">
                    <span style="color: #999999;" class="icon icon-left"></span>
                </a>
                <h1 class="title">注册</h1>
                <a href="login-view" style="color: #EF1544;" class="button button-link button-nav pull-right create-actions">登录</a>
            </header>
            <div class="content native-scroll" id="con1">
                <div class="weui-cells__title">请输入注册信息</div>
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
                                    <div class="item-title label">验证码：</div>
                                    <div class="item-input">
                                        <input type="text" id="contacts" value="" placeholder="请输入验证码">
                                        <span style="color: #EF1544;position: absolute;top: .6rem;right: .6rem;font-size: 13px;" id="getVerifyCode">获取验证码</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">邀请码：</div>
                                    <div class="item-input">
                                        <input type="tel" id="inviteid" name="new_inviteid" value="" placeholder="选填" pattern="[0-9]*">
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
                        <a class="weui-btn weui-btn_primary external" style="background-color: #EF1544;" href="javascript:validate()" id="showTooltips">下一步</a>
                    </div>
                </div>
            </div>
            <div class="content native-scroll" id="con2" style="display: none;">
                <div class="list-block">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">设置密码：</div>
                                    <div class="item-input">
                                        <input type="password" id="pwd1" placeholder="请输入密码">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">确认密码：</div>
                                    <div class="item-input">
                                        <input type="password" id="pwd2" placeholder="请确认密码">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="weui-btn-area" style="margin-top: .6rem;">
                        <a class="weui-btn weui-btn_primary external" style="background-color: #EF1544;" href="javascript:register()">注册</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup popup-about">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left close-popup" style="padding-top: .5rem;">
                    <span style="color: #999999;" class="icon icon-left"></span>
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
        <script>
            function changecolor(){
                if(!$('#weuiAgree').is(":checked")){
                    $('#showTooltips').css('background-color','#aaa')
                }else{
                    $('#showTooltips').css('background-color','#EF1544')
                }
            }

            function register(){
                var pwd1 = $("#pwd1").val();
                if(pwd1 == ''){
                    $.toast('请输入密码');
                    return false;
                }
                var pwd2 = $("#pwd2").val();
                if(pwd2 == ''){
                    $.toast('请再次输入密码');
                    return false;
                }
                if(pwd1 != pwd2){
                    $.toast('两次输入的密码不一致，请重试');
                    return false;
                }
                var mobile = $("#mobile").val();
                var new_inviteid = $("#inviteid").val();
                var contacts = $("#contacts").val();
                $.post("register",{mobile:mobile,pwd:pwd1,code:contacts,invite_code:new_inviteid},function(d){
                    if(d.code >= 0){
                        $.toast(d.message);
                        location.href = "/h5/user/center";
                    }else if(d.code < 0){
                        $.toast(d.message);
                    }else{
                        $.toast("未知错误");
                    }
                },"json");
            }

            function validate(){
                if($('#weuiAgree').is(":checked")){
                    var mobile = $("#mobile").val();
                    var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
                    if (!reg.test(mobile)) {
                        $.toast('请填写正确的手机号');
                        return false;
                    }
                    var contacts = $("#contacts").val();
                    if(contacts == ''){
                        $.toast('请输入验证码');
                        return false;
                    }
                    var new_inviteid = $("#inviteid").val();
                    $.post("check_sms",{mobile:mobile,code:contacts,new_inviteid:new_inviteid},function(d){
                        console.log(d);
                        if(d.code >= 0){
                            $('#con1').hide();
                            $('#con2').show();
                        }else if(d.code < 0){
                            $.toast(d.msg);
                        }else{
                            $.toast("未知错误");
                        }
                    },"json");
                }
            }

            $(document).on('click','#getVerifyCode',function () {
                var mobile = $('#mobile').val();
                var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
                if(!reg.test(mobile)){
                    $.toast("请输入正确的手机号");
                    return false;
                }
                $.post("/h5/sms/send",{mobile:mobile,scenes:1},function(d){
                    if(d.code >= 0){
                        $.toast("验证码发送成功");
                        $('#getVerifyCode').removeClass('verifycode');
                        settime();
                    }else if(d.code< 2){
                        $.toast(d.msg);
                    }else{
                        $.toast("未知错误");
                    }
                },"json");
            });

            var countdown=60;
            function settime() {
                if (countdown == 0) {
                    $('#getVerifyCode').html('重新发送');
                    $('#getVerifyCode').addClass('verifycode');
                    countdown = 60;
                    return;
                } else {
                    $('#getVerifyCode').html("" + countdown + "秒");
                    countdown--;
                }
                setTimeout(function() {
                    settime()
                },1000)
            }

        </script>


    @parent
@stop

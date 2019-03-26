@extends('layouts.weui')
@section('title')
    个人中心
@stop
<div class="weui-mask" id="mask" style="display: none;"></div>
@section('popout')
    <div class="page">
        <div id="dialogs">
            <!--BEGIN dialog2-->
            <div class="js_dialog" id="iosDialog2" style="display: none;">
                <div class="weui-dialog">
                    <div class="weui-dialog__bd">功能正在开发中</div>
                    <div class="weui-dialog__ft">
                        <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                    </div>
                </div>
            </div>
            <!--END dialog2-->
            <!--BEGIN dialog2-->
            <div class="js_dialog" id="iosDialog1" style="display: none;">
                <div class="weui-dialog">
                    <div class="weui-dialog__bd">功能正在开发中</div>
                    <div class="weui-dialog__ft">
                        <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                    </div>
                </div>
            </div>
            <!--END dialog2-->
        </div>
    </div>
@stop
@section('content')
    <style>
        .weui-grid__label {
            color: #5d5d5d
        }
    </style>
    <div class="page">
        <div style="position: relative">
            <div>
                <img style="max-width:100%" src="/images/user-center/center.jpg">
            </div>
            <div style="position: absolute;top: 30%;left: 42%">
                <img style="width: 64px;height:64px;position: absolute; border-radius:50%;"
                     src="{{$data['user_photo'] or ''}}">
            </div>
            <div id="nick" style="position: absolute;top: 75%;left: 42%">
                <div id="nick-name">{{$data['nick_name'] or ''}} @if($data['sex'] == 1)
                        <img src="/images/user-center/sexboy.png">
                    @else
                        <img src="/images/user-center/girlsex.png">
                    @endif
                </div>

            </div>
        </div>
        <script>
            // alert($("#nick-name").text().length);
            l = 62;
            h = $("#nick-name").text().length;
            if (h >= l && h <= l + 5) {
                $("#nick").css({"left": "43%"});
            } else if (h > l + 5 && h <= l + 10) {//表示大于五个字符的时候
                $("#nick").css({"left": "38%"});
            } else if (h > l + 10) {
                $("#nick").css({"left": "33%"});
            }
        </script>
        <div class="weui-grids">
            <a href="update" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/gerenxinxi.png" alt="">
                </div>
                <p class="weui-grid__label">个人信息</p>
            </a>
            <a href="binding-mobile" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/bandingshouji.png" alt="">
                </div>
                <p class="weui-grid__label" id="showIOSDialog8">绑定手机</p>
            </a>
            <a href="member-card" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/huiyuanka.png" alt="">
                </div>
                <p class="weui-grid__label">我的会员卡</p>
            </a>
            <a href="../user-point-card/" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/jifen.png" alt="">
                </div>
                <p class="weui-grid__label">积分记录</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog1">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/expensecalendar.png" alt="">
                </div>
                <p class="weui-grid__label">消费记录</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog2">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/stored-value.png" alt="">
                </div>
                <p class="weui-grid__label">储值记录</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog3">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/exchange.png" alt="">
                </div>
                <p class="weui-grid__label">兑换记录</p>
            </a>

            <a href="javascript:;" class="weui-grid" id="showIOSDialog4">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/wodequan.png" alt="">
                </div>
                <p class="weui-grid__label">我的券</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog5">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/youhuiquan.png" alt="">
                </div>
                <p class="weui-grid__label">优惠券</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog6">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/onlinestore.png" alt="">
                </div>
                <p class="weui-grid__label">在线商城</p>
            </a>
            <a href="javascript:;" class="weui-grid" id="showIOSDialog7">
                <div class="weui-grid__icon">
                    <img src="/images/user-center/destoon_finance_charge.png" alt="">
                </div>
                <p class="weui-grid__label">在线充值</p>
            </a>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            var $iosDialog1 = $('#iosDialog1');

            var $mask = $('#mask');

            $('#dialogs').on('click', '.weui-dialog__btn', function () {
                $(this).parents('.js_dialog').fadeOut(200);
                $mask.fadeOut(200);
            });

            $('#showIOSDialog1').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog2').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog3').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog4').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog5').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog6').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog7').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
            $('#showIOSDialog8').on('click', function () {
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            });
        });
    </script>
@stop
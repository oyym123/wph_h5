@extends('layouts.weui')
@section('title')
    绑定/修改手机号码
@stop


<div class="weui-mask" id="mask" style="display: none;"></div>
<div class="page">
    <div id="dialogs">
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog2" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd">{{$errors->first()}}</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog1" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd"> {{$codeError or ''}}</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
    </div>
</div>
@section('content')

    @if (isset($codeError))
        <a href="javascript:;" class="weui-btn weui-btn_default" id="showToast1"></a>
    @endif

    <script>
        $(function () {
            var $toast = $('#toast');
            if ($("#showToast1").length > 0) {

                var $iosDialog1 = $('#iosDialog1');

                var $mask = $('#mask');

                $('#dialogs').on('click', '.weui-dialog__btn', function () {
                    $(this).parents('.js_dialog').fadeOut(200);
                    $mask.fadeOut(200);
                });
                $mask.fadeIn(200);
                $iosDialog1.fadeIn(200);
            }
        });
    </script>
    <div class="page">
        <form action="binding-mobile-post" method="post">
            {{ csrf_field() }}
            <div class="page__bd">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已绑定 {{$data['bind_mobile']}}，如需修改请重新绑定
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__hd">
                        <label class="weui-label"><span style="color:red">*</span> 手机号 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input code" name="bind_mobile" id="mobile" type="number"
                               placeholder="请输入手机号"
                               value="{{$oldPut['bind_mobile']}}"/>
                    </div>
                    <div class="weui-cell__ft">
                        <button class="weui-vcode-btn obtain generate_code" type="button" value=" 获取验证码"></button>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 验证码 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" name="code" value="{{$oldPut['code']}}"
                               placeholder="请输入短信验证码"/>
                    </div>
                </div>
                <div class="weui-btn-area">
                    <input class="weui-btn weui-btn_primary" type="submit" value="确定">
                </div>
            </div>

        </form>
    </div>

    <script type="text/javascript">
        $(function () {
            $(".generate_code").click(function () {

                var disabled = $(".generate_code").attr("disabled");
                if (disabled) {
                    return false;
                }
                if ($("#mobile").val() == "" || isNaN($("#mobile").val()) || $("#mobile").val().length != 11) {
                    alert("请填写正确的手机号！");
                    return false;
                }
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                });
                $.post({
                    type: "post",
                    url: "../sms/send",
                    data: {mobile: $("#mobile").val()},
                    dataType: "text",
                    async: false,
                    success: function (data) {
                        settime();
                        //console.log(data);
                    },
                    error: function (err) {

                        //console.log(err);
                    }
                });
            });
            var countdown = 60;
            var _generate_code = $(".generate_code");
            _generate_code.text('获取验证码');

            function settime() {
                if (countdown == 0) {
                    _generate_code.attr("disabled", false);
                    _generate_code.text("获取验证码");

                    countdown = 60;
                    return false;
                } else {
                    $(".generate_code").attr("disabled", true);
                    _generate_code.text("重新发送(" + countdown + ")");
                    countdown--;
                }
                setTimeout(function () {
                    settime();
                }, 1000);
            }
        })

    </script>

    <script type="text/javascript">

        $(function () {
            var $iosDialog2 = $('#iosDialog2');
            var $mask = $('#mask');

            if ($(".alert-danger").length && $(".alert-danger").length > 0) {
                $mask.fadeIn(200);
                $iosDialog2.fadeIn(200);

                $('#dialogs').on('click', '.weui-dialog__btn', function () {
                    $mask.fadeOut(200);
                    $iosDialog2.fadeOut(200);
                });
            }
        });
    </script>
    <script type="text/javascript">

    </script>


@stop
@if ($errors->any())
    <div class="alert alert-danger">
        <ul></ul>
        {{--        <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>--}}
    </div>
@endif
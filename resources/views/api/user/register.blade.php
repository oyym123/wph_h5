@extends('layouts.weui')
@section('title')
    资料填写
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
    <a href="javascript:;" id="showIOSDialog2"></a>
    <div class="page">
        <div class="page__bd">
            <form action="register" method="post">
                {{ csrf_field() }}
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 姓名 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="name" type="text" placeholder="请输入您的姓名"
                               value="{{$data['name'] or ''}}"/>
                    </div>
                </div>
                <div class="weui-cell weui-cell_select weui-cell_select-after">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label"> <span style="color:red">*</span> 性别</label>
                    </div>
                    <div class="weui-cell__bd">
                        <select class="weui-select" name="sex_select">
                            @if (isset($data['sex_select'])&& $data['sex_select']==1)
                                <option value="1" selected>男</option>
                                <option value="2">女</option>
                            @elseif (isset($data['sex_select']) && $data['sex_select']==2)
                                <option value="1">男</option>
                                <option value="2" selected>女</option>
                            @else
                                <option selected="selected">请选择</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__hd">
                        <label class="weui-label"><span style="color:red">*</span> 手机号 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input code" name="bind_mobile" id="mobile" type="number"
                               placeholder="请输入手机号"
                               value="{{$data['bind_mobile'] or ''}}"/>
                    </div>
                    <div class="weui-cell__ft">
                        <button class="weui-vcode-btn obtain generate_code" type="button" value=" 获取验证码"></button>
                    </div>
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
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 验证码 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="code" value="{{$data['code'] or ''}}" type="number"
                               placeholder="请输入短信验证码"/>
                    </div>
                </div>
                {{--                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label for="" class="weui-label"> <span
                                                    style="color:red">*</span> 生日</label>
                                    </div>
                                    <div class="weui-cell__bd">
                                        <input class="weui-input" type="date" value="{{$data['birthday'] or ''}}" name="birthday"/>
                                    </div>
                                </div>--}}
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 身份证</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" name="id_card" value="{{$data['id_card'] or ''}}"
                               pattern="[0-9]*" placeholder="请输入身份证号"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"> &nbsp;&nbsp;&nbsp;邮箱</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="email" value="{{$data['email'] or ''}}" type="text"
                               placeholder="请输入邮箱"/>
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">&nbsp;&nbsp;&nbsp;推荐人</label>
                    </div>
                    <div class="weui-cell__bd">
                        @if($invite_user_mobile)
                            <input name="invite_mobile" disabled="true" class="weui-input" type="number"
                                   pattern="[0-9]*"
                                   value="{{$invite_user_mobile or ''}}"
                                   placeholder="请输入推荐人手机号"/>
                            <input name="invite_mobile" value="{{$invite_user_mobile or ''}}" type="hidden">
                        @else
                            <input name="invite_mobile" class="weui-input" type="number" pattern="[0-9]*"
                                   value="{{$data['invite_mobile'] or ''}}"
                                   placeholder="请输入推荐人手机号"/>
                        @endif
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd" style="font-size: smaller;color: red;letter-spacing:2px;">&nbsp;&nbsp;&nbsp;带*号的为必填项</div>
                </div>
                <div class="weui-cells__title">&nbsp;&nbsp;&nbsp;详细地址</div>
                <div class="weui-cells weui-cells_form" style="margin-left: 2.5%;width: 95%;">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <textarea name="detail_address" class="weui-textarea" placeholder="请输入地址"
                                      rows="3">{{$data['detail_address'] or ''}}</textarea>
                            <div class="weui-textarea-counter"><span>0</span>/200</div>
                        </div>
                    </div>
                </div>
                {{--             <label for="weuiAgree" class="weui-agree">
                                 <input id="weuiAgree" type="checkbox"
                                        @if(isset($data['agree']) && $data['agree']==1) checked="checked" @endif name="agree"
                                        value="1"
                                        class="weui-agree__checkbox"/>
                                 <span class="weui-agree__text">
                                     阅读并同意<a href="javascript:void(0);">《相关条款》</a>
                         </span>
                             </label>--}}
                <div class="weui-btn-area">
                    <input class="weui-btn weui-btn_primary" type="submit" value="确定">
                </div>
            </form>
        </div>

    </div>

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
    @parent @stop

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

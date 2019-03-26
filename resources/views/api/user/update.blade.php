@extends('layouts.weuipjax')
@section('title')
    修改/查看个人信息
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
                <div class="weui-dialog__bd">功能正在开发中</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
    </div>
</div>
@section('content')
    <a href="javascript:;" id="showIOSDialog2"></a>
    @if (isset($status)&& $status==1)
        <a href="javascript:;" class="weui-btn weui-btn_default" id="showToast"></a>
    @endif
    <script>  $(function () {
            var $toast = $('#toast');
            if ($("#showToast").length > 0) {
                if ($toast.css('display') != 'none') return;
                $toast.fadeIn(100);
                setTimeout(function () {
                    $toast.fadeOut(100);
                    window.location = "center";
                }, 2000);
            }
        });
    </script>
    <!--BEGIN toast-->
    <div id="toast" style="display: none;">
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">保存成功</p>
        </div>
    </div>
    <!--end toast-->

    <div class="page">
        <div class="page__bd">
            <form action="update-post" method="post">
                {{ csrf_field() }}

                <div class="weui-cell weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label"> &nbsp;&nbsp;&nbsp;手机号 </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" disabled="true" value="{{$data['bind_mobile'] or ''}}"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 姓名
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="name" type="text" placeholder="请输入您的姓名"
                               value="{{$data['real_name'] or ''}}"/>
                    </div>
                </div>
                <div class="weui-cell weui-cell_select weui-cell_select-after">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label"> <span style="color:red">*</span> 性别</label>
                    </div>
                    <div class="weui-cell__bd">
                        <select class="weui-select" name="sex">
                            @if (isset($data['sex'])&& $data['sex']==1)
                                <option value="1" selected>男</option>
                                <option value="2">女</option>
                            @elseif (isset($data['sex']) && $data['sex']==2)
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
           {{--     <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label"> <span
                                    style="color:red">*</span>
                            生日</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" disabled="true" name="birthday"
                               value="{{$data['birthday'] or ''}}"/>
                    </div>
                </div>--}}
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"> <span style="color:red">*</span> 身份证</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" disabled="true" type="number" name="id_card"
                               value="{{$data['id_card'] or ''}}"
                               pattern="[0-9]*" placeholder="请输入身份证号"/>
                        <input type="hidden" name="id_card"
                               value="{{$data['id_card'] or ''}}"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"> &nbsp;&nbsp;&nbsp;邮箱</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="email" value="{{$data['email'] or ''}}" type="text"
                               placeholder="请输入邮箱"/>
                    </div>
                </div>

                <div class="weui-cells__title">详细地址</div>
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

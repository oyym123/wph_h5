@extends('layouts.weui')
@section('title')
    绑定成功成功
@stop
<div class="weui-msg">
    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">手机绑定成功</h2>
        <p class="weui-msg__desc">您已成功绑定新的手机号码！</p>
    </div>
    <div class="weui-msg__opr-area">
        <p class="weui-btn-area">
            <a href="center" class="weui-btn weui-btn_primary">返回首页</a>
        </p>
    </div>
    <div class="weui-msg__extra-area">
        <div class="weui-footer">
            <p class="weui-footer__links">
                <a href="javascript:void(0);" class="weui-footer__link">微拍行</a>
            </p>
            <p class="weui-footer__text">Copyright &copy; 2008-2017 </p>
        </div>
    </div>
</div>
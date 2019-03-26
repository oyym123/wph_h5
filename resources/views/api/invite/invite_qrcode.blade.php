@extends('layouts.weui')
@section('content')

    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg"
                   style="background-color: #f8f8f8">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb"
                             src="{{$data['user_photo'] or ''}}"
                             alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">我是 {{$data['nick_name'] or ''}}</h4>
                        <h4 class="weui-media-box__title"></h4>
                        <p class="weui-media-box__desc">当前已推荐<span style="color: orangered">0</span>人，获得<span style="color: orangered">0.0</span>积分</p-->
                    </div>
                </a>
            </div>
            <div align="center" style="background-color: #f8f8f8">
                <div style="font-size:1px;">&nbsp;</div>
                <div style="color: #696969;background-color: #f8f8f8">
                    <b> &nbsp;推荐他人注册还可终身享受消费提成奖励！<br>微拍行，期待您的加入！</b></div>
            </div>
            </div>
        </div>

        <div style="color: #696969;background-color: #f8f8f8">
            <div style="font-size:1px;">&nbsp;</div>
            <div align="center">
                <img style="max-width:92%" src="{{$image_link or ''}}">
            </div>
            <div style="text-align: center;color:#696969;"> 长按此图识别图中二维码</div>
        </div>
    </div>

@stop
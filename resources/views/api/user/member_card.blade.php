@extends('layouts.weui')
@section('title')
    我的会员卡
@stop
<style>
    .test {
        border-right: 1px solid #eaeaea;
        height: 80%;
        margin-top: 2.5%;
    }
</style>
<div style="text-align: center;margin-top: 10%;position: relative;">
    <img style="max-width:80%;" src="/images/user-center/vipphoto.jpg">
    <div style="position: absolute;bottom: 1%;left:52%">NO.{{$data['mobile'] or ''}}</div>
</div>
<div style="color: #f09431;text-align: center;">
    <p style="font-size: xx-small">&nbsp;</p>
    <img src="/images/user-center/huangguan.png"> 会员等级:微拍行注册会员
</div>
<p style="font-size: xx-small">&nbsp;</p>
<div style="background-color: white">
    <div class="weui-flex" style="height:13%;text-align: center;">
        <div class="weui-flex__item">
            <div class="placeholder" style="font-size: smaller;margin-top: 5%;">储值（元）</div>
            <div class="placeholder" style="font-size: x-large;margin-top: 1%;">0</div>
        </div>
        <div class="test"></div>
        <div class="weui-flex__item">
            <div class="placeholder" style="font-size: smaller;margin-top: 5%;">积分（分）</div>
            <div class="placeholder" style="font-size: x-large;margin-top: 1%;">0</div>
        </div>
    </div>
</div>

<div class="weui-panel">
    <div class="weui-panel__bd">
        <div class="weui-media-box weui-media-box_small-appmsg">
            <div class="weui-cells">
                <span class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__hd"><img
                                src="/images/user-center/qiandao.png"
                                alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p>签到（签到送<span style="color: #F09431">1</span>积分）(功能开发中)</p>
                    </div>
                     <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary"> <span
                         >签到</span></a>
                </span>
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__hd"><img
                                src="/images/user-center/chongzhi.png"
                                alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p>在线充值 (功能开发中)</p>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
            </div>
        </div>
    </div>
</div>

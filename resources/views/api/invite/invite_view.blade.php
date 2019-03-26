@extends('layouts.weui')
@section('title')
    我的推荐奖励
@stop

<p style="font-size: xx-small">&nbsp;</p>
<div style="background-color: white;margin-left: 2.5%;width: 95%;">
    <div class="weui-flex" style="height:13%;text-align: center;">
        <div class="weui-flex__item">
            <div class="placeholder" style="font-size: smaller;margin-top: 8%;color: #aeb2bb">推荐人</div>
            <div class="placeholder" style="font-size: x-large;margin-top: 1%;">0</div>
        </div>
        <div class="weui-flex__item">
            <div class="placeholder" style="font-size: smaller;margin-top: 8%;color: #aeb2bb">奖励积分</div>
            <div class="placeholder" style="font-size: x-large;margin-top: 1%;color: orangered">0</div>
        </div>
    </div>
</div>

<div class="weui-panel">
    <div class="weui-flex" style="height: 6%;margin-top: 3%">
        <div class="weui-flex__item" style="margin-left: 2.5%">
            <div class="placeholder">被推荐人卡号</div>
        </div>
        <div class="weui-flex__item" style="margin-right: -55.5%; ">
            <div class="placeholder">奖励积分</div>

        </div>
    </div>

    <!--a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"></div>

        <div class="weui-cell__bd weui-cell_primary">
            <p>000</p>
        </div>
        <span style="color:orangered">0</span>
    </a-->

</div>
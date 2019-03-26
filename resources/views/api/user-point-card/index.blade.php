@extends('layouts.weui')
@section('title')
    积分记录
@stop
<style>
    .weui-flex {
        color: white;
    }

    .test {
        border-right: 1px solid #aeb2bb;
        height: 80%;
        margin-top: 2.5%;
    }
</style>

<div class="weui-flex" style="height:13%;text-align: center;background-color: #6a6e77">
    <div class="weui-flex__item">
        <div class="placeholder" style="font-size: smaller;margin-top: 5%;">累计获得积分</div>
        <div class="placeholder" style="font-size: x-large;margin-top: 1%;color: #aeb2bb">+0</div>
    </div>
    <div class="test"></div>
    <div class="weui-flex__item">
        <div class="placeholder" style="font-size: smaller;margin-top: 5%;">累计扣除积分</div>
        <div class="placeholder" style="font-size: x-large;margin-top: 1%;color: #aeb2bb">-0</div>
    </div>
</div>
<!--div class="weui-cell">
    <div class="weui-cell__bd">
        <p>赠送积分</p>
        <p style="font-size: 13px;color: #888888;">2017-12-01 18:53</p>
    </div>
    <div class="weui-cell__ft">+500</div>
</div-->

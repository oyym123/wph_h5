@extends('layouts.h5')
@section('title')
    出价记录
@stop
@section('title_head')
    出价记录
@stop
@section('content')
<style>
    .buysuccess{margin-top: .5rem;background-color: white;padding-left: .5rem;padding-right: .5rem;padding-top: 4px;padding-bottom: 0px;font-size: 16px;}
    .infoname{display: inline-block;width: 30%;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;}
    .infostatus{display: inline-block;width: 15%;}
    .infoaddress{display: inline-block;width: 35%;}
    .infoprice{display: inline-block;float: right;}
    .infolist{font-size: 13px;padding-top: .3rem;padding-bottom: .3rem;}
    .infolist>div{display: flex;align-items: center;justify-content: space-between;padding:.25rem 0 .25rem .2rem}
    .infolist .icon{position: relative;}
</style>
        <div class="content native-scroll">
            <div class="buysuccess">
                <div class="infolist" id="infolist">
                    @foreach($data as $v )
                        @if($v['bid_type'] ==1)
                            <div style="color : #EF1544;">
                                <i class="icon iconfont icon-mobile" ></i>
                                <span class="infoname">{{ $v['nickname'] }}</span>
                                <span class="infostatus">{{ $v['bid_type'] ? '领先' : '出局' }}</span>
                                <span class="infoaddress">{{ $v['area'] }}</span>
                                <span class="infoprice">￥{{ $v['bid_price'] }}</span>
                            </div>
                        @else
                            <div><i class="icon iconfont icon-mobile"></i>
                                <span class="infoname">{{ $v['nickname'] }}</span>
                                <span class="infostatus">{{ $v['bid_type'] ? '领先' : '出局' }}</span>
                                <span class="infoaddress">{{ $v['area'] }}</span>
                                <span class="infoprice">￥{{ $v['bid_price'] }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>


@parent
@stop

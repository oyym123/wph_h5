
@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    往前成交
@stop
@section('content')
<div id="wrapper">
    <div class="scroller">
        <div class="" id="latelist" style="background-color: #EFEFF4;">
            <!-- 最近成交列表加载 -->
            @foreach ($data as $k => $v)
                <div class="ui-block deal_list"
                     onclick="location.href='/h5/product/detail?period_id={{$v['id']}}'">
                    <span class="time_line">{{ $v['end_time'] }}</span> <span class="cover ui-mark-1 ui-traded">
                                <img src="{{ $v['avatar'] }}">
                            </span>
                    <span class="info_text">
                                <span class="deal_user hidelong">成交人：{{  $v['nickname'] }}</span>
                                <span class="market_price">市场价：￥{{ $v['sell_price'] }}</span>
                                <span class="deal_price">成交价：<em>￥{{  $v['bid_price'] }}</em>
                                </span>
                            </span>
                    <span class="save_price" style="top: 0.5rem;">
                                 <em>{{ $v['save_price'] }}%</em>
                                 节省
                             </span>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <div class="more"><i class="pull_icon"></i><span></span></div>
    </div>
</div>
<script type="text/html" id="lateauc">
    @verbatim
    {{# for(var i = 0, len = d.length; i< len; i++){ }}
    <div class="ui-block deal_list" onclick="location.href='/h5/product/detail?period_id={{d[i].id}}'">
        <span class="time_line">{{d[i].end_time}}</span>
        <span class="cover ui-mark-1 ui-traded">
        <img src="{{d[i].avatar}}">
        </span>
        <span class="info_text">
        <span class="deal_user hidelong">成交人：{{d[i].nickname}}</span>
        <span class="market_price">市场价：￥{{d[i].sell_price}}</span>
        <span class="deal_price">成交价：<em>￥{{d[i].bid_price}}</em></span>
        </span>
        <span class="save_price" style="top: 0.5rem;">
            <em>{{d[i].save_price}}%</em>节省
        </span>
    </div>
    {{# } }}
    @endverbatim
</script>
<script src="{{ asset('js/h5/iscroll.js') }}"></script>
<link rel="stylesheet" href="{{asset('css/h5/scroller.css')}}">
<script>
    pages = 0;
    $(function () {
        var myscroll = new iScroll("wrapper", {
            onScrollMove: function () {
                if (this.y < (this.maxScrollY)) {
                    $('.pull_icon').addClass('flip');

                } else {
                    $('.pull_icon').removeClass('flip loading');
                }
            },
            onScrollEnd: function () {
                if ($('.pull_icon').hasClass('flip')) {
                    pages++;
                    pullUpAction(pages);
                }
            },
            onRefresh: function () {
                $('.more').removeClass('flip');
            }
        });

        function pullUpAction(pagenum) {
            setTimeout(function () {
                $.get("/api/product/past-deals", {pages: pagenum,product_id:
                    @if(empty($data))  0 @else {{ $data[0]['product_id'] }} @endif  }, function (d) {
                    d = d.data;
                    if (d.length != '') {
                        var gettpl = document.getElementById('lateauc').innerHTML;
                        laytpl(gettpl).render(d, function (html) {
                            $("#latelist").append(html);
                        });
                    } else {
                        $("#latelist").append("<p style='text-align: center;margin-top: 5px;'>无更多记录</p>");
                    }
                }, "json");
                myscroll.refresh();
            }, 100)
        }

        if ($('.scroller').height() < $('#wrapper').height()) {
            $('.more').hide();
            myscroll.destroy();
        }
        //$('#J-deallistWrapper').vTicker();
        $.init();
    });
</script>
@parent
@stop

@extends('layouts.h5')
@section('title')
    最新成交
@stop
@section('title_head')
    最新成交
@stop
@section('content')
    <div id="wrapper" >
        <div class="scroller" >
            <!-- 头条 -->
            <div class="deallist_roll" id="J-deallistWrap" >
                <div id="J-deallistWrapper" class="" style="overflow: hidden; position: relative; height: 120px;">
                    <ul id="J-deallistRoll"
                        style="transform: translate3d(0px, 0px, 0px); position: absolute; margin: 0px; padding: 0px;">
                        @foreach ($last_deal as $k => $v)
                            <li style="margin: 0px; padding: 0px; height: 40px;"
                            ><a class="hidelong" href="/h5/product/detail?period_id={{$v['id']}}'">
                                    恭喜<b>{{ $v['nickname'] }}</b>以<em>￥{{ $v['bid_price'] }}</em>
                                    拍到{{ $v['title'] }}
                                    <img src="{{ $v['img_cover'] }}"></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="emptyblank"></div>

            <script src="{{ asset('js/h5/jquery.vticker.min.js') }}"></script>
            <script src="{{ asset('js/h5/iscroll.js') }}"></script>
            <!-- 信息 -->
            <div id="latelist">
                <!-- 最近成交列表加载 -->
                @foreach ($list as $k => $v)
                    <div class="ui-block deal_list"
                         onclick="location.href='/h5/product/detail?period_id={{$v['id']}}'">
                        <span class="time_line">{{ $v['end_time'] }}</span> <span class="cover ui-mark-1 ui-traded">
                                <img src="{{ $v['img_cover'] }}">
                            </span>
                        <span class="info_text">
                                <span class="deal_user hidelong">成交人：{{  $v['nickname'] }}</span>
                                <span class="market_price">市场价：￥{{ $v['sell_price'] }}</span>
                                <span class="deal_price">成交价：<em>￥{{  $v['bid_price'] }}</em>
                                </span>
                            </span>
                        <span class="save_price">
                                 <em>{{ $v['save_price'] }}%</em>
                                 节省
                                 <a onclick="nextPeriod({{$v['product_id']}})"  class="bid_btn"></a>
                             </span>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <div class="more"><i class="pull_icon"></i><span></span></div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/h5/scroller.css')}}">

    <script type="text/html" id="lateauc">
        @verbatim
        {{# for(var i = 0, len = d.length; i< len; i++){ }}
        <div class="ui-block deal_list" onclick="location.href='/h5/product/detail?period_id={{d[i].id}}'">
            <span class="time_line">{{d[i].end_time}}</span>
            <span class="cover ui-mark-1 ui-traded">
        <img src="{{d[i].img_cover}}">
        </span>
            <span class="info_text">
        <span class="deal_user hidelong">成交人：{{d[i].nickname}}</span>
        <span class="market_price">市场价：￥{{d[i].sell_price}}</span>
        <span class="deal_price">成交价：<em>￥{{d[i].bid_price}}</em></span>
        </span>
            <span class="save_price"><em>{{d[i].save_price}}%</em>节省
                <a href="javascript:;" onclick="nextPeriod({{d[i].product_id}})"  class="bid_btn"></a></span>
        </div>
        {{# } }}
        @endverbatim
    </script>
    <script>
        pages = 0;
        $(function () {
            var myscroll = new iScroll("wrapper",{
                onScrollMove:function(){
                    if (this.y<(this.maxScrollY)) {
                        $('.pull_icon').addClass('flip');

                    }else{
                        $('.pull_icon').removeClass('flip loading');
                    }
                },
                onScrollEnd:function(){
                    if ($('.pull_icon').hasClass('flip')) {
                        pages ++ ;
                        pullUpAction(pages);
                    }
                },
                onRefresh:function(){
                    $('.more').removeClass('flip');
                }
            });

            function pullUpAction(pagenum){
                setTimeout(function(){
                        $.get("/api/latest-deal", {pages: pagenum}, function (d) {
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
            if ($('.scroller').height()<$('#wrapper').height()) {
                $('.more').hide();
                myscroll.destroy();
            }
            $('#J-deallistWrapper').vTicker();
            $.init();
        });
        //前往最新的一期
        function nextPeriod(product_id){
            $.get("/h5/period/next-period", {product_id: product_id}, function (d) {
                if(d.code == 0){
                    d = d.data;
                    location.href='/h5/product/detail?period_id='+d.period_id
                }
            }, "json");
        }
    </script>
    @parent
@stop

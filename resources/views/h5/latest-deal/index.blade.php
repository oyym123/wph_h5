@extends('layouts.h5')
@section('title')
    最新成交
@stop
@section('title_head')
    最新成交
@stop
@section('content')
            <div class="content infinite-scroll">
                <!-- 头条 -->
                <div class="deallist_roll" id="J-deallistWrap">
                    <div id="J-deallistWrapper" class="" style="overflow: hidden; position: relative; height: 120px;">
                        <ul id="J-deallistRoll"
                            style="transform: translate3d(0px, 0px, 0px); position: absolute; margin: 0px; padding: 0px;">
                            @foreach ($last_deal as $k => $v)
                                <li style="margin: 0px; padding: 0px; height: 40px;"
                                ><a class="hidelong" href="">
                                        恭喜<b>{{ $v['nickname'] }}</b>以<em>￥{{ $v['bid_price'] }}</em>
                                        拍到{{ $v['title'] }}
                                        <img src="{{ $v['img_cover'] }}"></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="emptyblank"></div>
                <script type="text/javascript"
                        src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/js/jquery.vticker.min.js"
                        charset="utf-8"></script>
                <!-- 信息 -->
                <div id="latelist">
                    <!-- 最近成交列表加载 -->
                    @foreach ($list as $k => $v)
                        <div class="ui-block deal_list"
                             onclick="location.href=''">
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
                                 <a href="javascript:;" class="bid_btn"></a>
                             </span>
                        </div>
                    @endforeach
                </div>
            </div>
    <script type="text/html" id="lateauc">
        {{--{{# for(var i = 0, len = d.length; i< len; i++){ }}--}}
        {{--<div class="ui-block deal_list" onclick="location.href='{{d[i].a}}'">--}}
        {{--<span class="time_line">{{d[i].endtime}}</span>--}}
        {{--<span class="cover ui-mark-1 ui-traded">--}}
        {{--<img src="{{d[i].logo}}">--}}
        {{--</span>--}}
        {{--<span class="info_text">--}}
        {{--<span class="deal_user hidelong">成交人：{{d[i].nickname}}</span>--}}
        {{--<span class="market_price">市场价：￥{{d[i].oldprice}}</span>--}}
        {{--<span class="deal_price">成交价：<em>￥{{d[i].finalmoney}}</em></span>--}}
        {{--</span>--}}
        {{--<span class="save_price"><em>{{d[i].rate}}</em>节省<a href="javascript:;" class="bid_btn"></a></span>--}}
        {{--</div>--}}
        {{--{{# } }}--}}
    </script>

    <script>
        $(function () {
            $(document).on("pageInit", "#page-index", function (e, id, page) {
                var pagenum = 1;
                loading = false;
                function get_late(page) {
                    $.post("latest-deal", {page: page}, function (d) {
                        if (d.length != '') {
                            var gettpl = document.getElementById('lateauc').innerHTML;
                            laytpl(gettpl).render(d, function (html) {
                                $("#latelist").append(html);
                                loading = false;
                            });
                        } else {
                            $("#latelist").append("<p style='text-align: center;margin-top: 5px;'>无更多记录</p>");
                        }
                    }, "json");
                }

                get_late(pagenum);
                $(page).on('infinite', function () {
                    if (loading) {
                        return false;
                    }
                    loading = true;
                    pagenum++;
                    get_late(pagenum);
                });
            });
            $('#J-deallistWrapper').vTicker();
            $.init();
        });
    </script>

    @parent
@stop

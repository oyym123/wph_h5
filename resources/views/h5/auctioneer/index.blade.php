@extends('layouts.h5')
@section('title')
    拍卖师主页
@stop
@section('title_head')
    拍卖师主页
@stop
@section('content')
    <div class="content native-scroll">
        <!--拍卖师详情-->
        <div class="list-block usercenter" style="margin:0;">
            <ul>
                <li>
                    <a href="javascript:;" class="item-content">
                        <div class="item-media"><img style="height:2.3rem;width: 2.1rem;"
                                                     src="{{$img}}">
                        </div>
                        <div class="item-inner" style="margin-left: .3rem;">
                            <div class="item-title">
                                <span class="aucname">{{ $name }}</span>
                                <span class="aucdetail">{{ $tags }}</span><br>
                                <span class="auccode">拍卖师编号:{{ $number }}</span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!--拍卖师标签-->
        <div style="padding: .75rem;">
            <div>
                <i class="icon iconfont icon-roundcheck"></i>
                <span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">持有{{ $certificate }}</span>
            </div>
            <div>
                <i class="icon iconfont icon-roundcheck"></i>
                <span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">担任{{ $year }}年以上拍卖师</span>
            </div>
            <div>
                <i class="icon iconfont icon-roundcheck"></i>
                <span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">现属机构：{{ $unit }}</span>
            </div>
        </div>
        <!--拍卖师商品-->
        <div class="aucgoodsdiv">
            <div class="goodshead">
                正在拍卖
            </div>
            <div>
                <div id="goodslist" class="tab active">
                    <div class="" id="listgoods" style="padding-left: 0;padding-right: 0;position: relative;">
                        <div class="gooddiv">
                        <div style="clear: both;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        .aucgoodsdiv {
            background-color: white;
        }

        .goodshead {
            font-size: 16px;
            padding-top: .2rem;
            padding-bottom: .2rem;
            padding-left: .75rem;
        }
    </style>


    <script type="text/html" id="goodslists">
        @verbatim
        {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
        <div class="gooddiv">
            <div class="collection">
                <input type="hidden" name="cl" class="cl" value=""/>

            </div>
            <div onclick="togoods({{d.data[i].id}})">
    <span class="goodimg" id="logo{{d.data[i].img_cover}}">
    <img class="goodlogo" src="{{ d.data[i].img_cover}}"/>
    </span>
                <p id="sy{{d.data[i].id}}" sytime='{{d.data[i].countdown}}' perid="{{d.data[i].id}}"
                   class="downtime"></p>
                <input type="hidden" value="0" id="end{{d.data[i].id}}"/>
                <input type="hidden" value="{{d.data[i].bid_price}}" id="mid{{d.data[i].id}}"/>
                <input type="hidden" id="period_ids" value="{{d.data[i].id}}"/>
                <p class="goodmoney tipout" id="bg{{d.data[i].id}}">￥<span
                            id="money{{d.data[i].id}}">{{d.data[i].bid_price}}</span></p>
                <p id="name{{d.data[i].id}}" class="goodmember">{{d.data[i].title}}</p>
                <span class="toauc" id="perbutton{{d.data[i].id}}">{{# if(d.data[i].businessflag == 0){ }}
                    歇业中{{# }else{ }}参与竞拍{{# } }}</span>
            </div>
        </div>
        {{# } }}
        @endverbatim
        <div style="clear: both;"></div>
    </script>
    <script src="{{ asset('js/h5/jquery.vticker.min.js') }}"></script>

    <link rel="stylesheet" href="{{asset('css/h5/scroller.css')}}">
    <script src="{{ asset('js/h5/iscroll.js') }}"></script>
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
            <span class="save_price"><em>{{d[i].save_price}}</em>节省
                <a href="/h5/period/next-period?product_id={{d[i].product_id}}" class="bid_btn"></a></span>
        </div>
        {{# } }}
        @endverbatim
    </script>
    <script>
        $('#J-close').click(function () {
            $('.mod_guide').hide();

        })
        pages = 0;
        $(function () {
            var myscroll = new iScroll("wrapper", {
                onScrollMove: function () {
                    alert(pages);
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
                    $.get("/api/latest-deal", {pages: pagenum}, function (d) {
                        console.log(d.data);
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
            $('#J-deallistWrapper').vTicker();
            $.init();
        });
    </script>

    <script type="text/javascript">
        connect();
        // 连接服务端
        function connect() {
            // 创建websocket
            @if(PHP_OS == 'WINNT') //本地测试专用
            ws = new WebSocket("ws://127.0.0.1:8081");
            @else //线上环境
            ws = new WebSocket("wss://api.95wx.cn/wss");
            @endif

            // 当有消息时根据消息类型显示不同信息
            ws.onmessage = function (event) {
                //  console.log(event.data);
            };

            ws.onclose = function () {
                console.log("连接关闭，定时重连");
                //  connect();
            };
            ws.onerror = function () {
                console.log("出现错误");
            };
        }
        ws.onmessage = function (event) {
            var data = JSON.parse(event.data);
            //   console.log(data);return false;
            if (data.length !== 0) {

                data = data['content'][0];
                console.log(data);
                if (data.status == 0) {
                    $('#sy' + data.period_id).attr('sytime', data.countdown);
                    // $('#name' + data.period_id).text(data.nickname);
                    $('#bg' + data.period_id).attr('class', 'goodmoney tipin');
                    var t = setTimeout(function () {
                        $('#bg' + data.period_id).attr('class', 'goodmoney tipout');
                    }, 20);
                    $('#money' + data.period_id).text(data.bid_price);
                } else {
                    $('#perbutton' + data.period_id).text('本期结束');
                    $('#perbutton' + data.period_id).css('background-color', '#999999');
                    $('#sy' + data.period_id).attr('sytime', 0);
                    $('#sy' + data.period_id).css('color', 'black');
                    $('#bg' + data.period_id).css('color', 'black');
                    $('#logo' + data.period_id).addClass('endimg');
                }
            }
        }
        function togoods(id) {
            location.href = "/h5/product/detail?period_id=" + id;
        }

        $.get("/h5/home/get-period", {
            type: 5
        }, function (d) {
            if (d.data.length != '') {

                var gettpl = document.getElementById('goodslists').innerHTML;
                laytpl(gettpl).render(d, function (html) {
                    $("#listgoods").empty();
                    $("#listgoods").append(html);
                });
            }
        }, "json");

    </script>
    @parent
@stop

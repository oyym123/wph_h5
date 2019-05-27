@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    微拍行
@stop
@section('content')
    <div id="wrapper">
        <div class="scroller">
            <div class="page-group">

                <div class="content native-scroll infinite-scroll-bottom infinite-scroll">
                    <!-- 幻灯片  -->
                    <div class="swiper-container swiper-container-horizontal" id="indexadv">
                        <div class="swiper-wrapper"
                             style="width: 720px; transform: translate3d(-360px, 0px, 0px); transition-duration: 0ms;">
                            @foreach ($banner as $k => $v)
                                <div onclick="location.href=''" class="swiper-slide swiper-slide-active"
                                     style="min-height: 100px; font-size: 0px; width: 360px;">
                                    <img src="{{ $v['img'] }}?imageView2/1/w/900/h/350">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span
                                    class="swiper-pagination-bullet"></span><span
                                    class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
                    </div>
                    <script>
                        var swiper = new Swiper('#indexadv', {
                            speed: 500,
                            autoplay: 3000,
                            autoplayDisableOnInteraction: false,
                            setWrapperSize: true,
                            pagination: '.swiper-pagination',
                            paginationClickable: true
                        });

                    </script>
                    <!-- 导航栏 -->
                    <div id="indexnav">
                        <div class="swiper-container swiper-container-horizontal" id="indexnavswiper">
                            <div class="swiper-wrapper" style="width: 360px;">
                                <div class="swiper-slide swiper-slide-active" style="width: 360px;">
                                    <div class="j-rmd-types rmd-types">
                                        @foreach ($display_module as $k => $v)
                                            <a href="{{ $v['url'] }}" class="external" style="width:20%;">
                                                <img src="{{ $v['img'] }}" alt="">
                                                <span>{{ $v['title'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        var swiper = new Swiper('#indexnavswiper', {
                            autoplay: 0,
                            autoplayDisableOnInteraction: false,
                            setWrapperSize: true,
                        });
                    </script>

                    <!-- 头条 -->
                    <div class="deallist_roll" id="J-deallistWrap">
                        <div id="J-deallistWrapper" class=""
                             style="overflow: hidden; position: relative; height: 153px;">
                            <ul id="J-deallistRoll"
                                style="transform: translate3d(0px, 0px, 0px); position: absolute; margin: 0px; padding: 0px; top: 0px;">
                                @foreach ($last_deal as $k => $v)
                                    <li style="margin: 0px; padding: 0px; height: 51px;">
                                        <a class="hidelong" href="/h5/product/detail?period_id={{$v['id']}}">
                                            恭喜<b>{{ $v['nickname'] }}</b>
                                            以<em>￥{{ $v['bid_price'] }}</em>
                                            拍到{{ $v['title'] }}
                                            <img src="{{ $v['img_cover'] }}"></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- 最近成交 -->
                    <div class="list-block">
                        <div class="row no-gutter">
                            @foreach ($last_deal as $k => $v)
                                <div class="col-33" onclick="location.href='/h5/product/detail?period_id={{$v['id']}}'">
                                    <div class="lately">
                                        @if(!empty($v['end_time']))
                                            <span class="endimg">
									<img class="endlogo" src="{{ $v['img_cover'] }}">
								</span>
                                        @else
                                            <span style="position:relative;display: inline-block;width: 4rem;height: 4rem;margin: 0 auto;">
									<img class="endlogo" src="{{ $v['img_cover'] }}">
								</span>
                                        @endif
                                        <p class="endmoney">{{ $v['bid_price'] }}</p>
                                        <p class="endmember"
                                           style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                                            {{ $v['nickname'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mod_guide" @if(!empty(session('user_info'))) style="display: none;" @endif >
                        <div class="r_red">
                            <a class="icon-close-x" id="J-close"></a>
                            <div class="ct_wrap">
                                <div class="bag_seal">
                                </div>
                                <div class="txt" style="margin-top: 67%;">
                                    新人福利<br>
                                    <em>5</em>元
                                </div>
                            </div>
                            <a class="sub_btn"
                               href="/h5/user/login-view">立即领取</a>
                        </div>
                    </div>

                    <!-- 商品 -->
                    <div class="list-block goods-list">

                        <div class="buttons-tab">
                            <a href="#goodslist" class="tab-link button active" onclick="get_goods(6)">正在热拍</a>
                            <a href="#selfing" class="tab-link button" onclick="get_goods(7)">拍品推荐</a>
                            <a href="#collection" class="tab-link button " onclick="get_goods(2)">我在拍</a>
                        </div>

                        <div class="tabs">

                            <div id="goodslist" class="tab active">
                                <div class="" id="listgoods"
                                     style="padding-left: 0;padding-right: 0;position: relative;">

                                    <div>
                                        <div class="more"><i class="pull_icon"></i><span></span></div>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                            <div id="selfing" class="tab">
                                <div class="" id="listing">
                                    <div class="nodata-default">
                                        <a href="/h5/product/type">去逛逛</a>
                                    </div>
                                </div>
                            </div>
                            <div id="collection" class="tab">
                                <div class="" id="listcol">
                                    <div class="nodata-default">
                                        <a href="/h5/product/type">去逛逛</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    </div>


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

        window.onscroll = function () {
            // console.log("1:" + $(document).scrollTop());
            console.log(window.innerHeight);//在谷歌浏览器中请使用 innerHeight以替换clientHeight
            console.log($(document).scrollTop());
            console.log(document.body.scrollHeight);//以上三个属性打印出来之后当滚动条滚到底部 1 + 2 = 3。
            if(window.innerHeight + $(document).scrollTop() == document.body.scrollHeight){
                addChildTimer = setInterval(addItems, 500);//滚动完之后的下拉加载，此处只是做了一个简单的实现添加了十个元素。
            }
        };

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
            ws.onmessage =  function(event) {
                //  console.log(event.data);
            };

            ws.onclose = function() {
                console.log("连接关闭，定时重连");
                //  connect();
            };
            ws.onerror = function() {
                console.log("出现错误");
            };
        }
        ws.onmessage =  function(event) {
            var  data = JSON.parse(event.data);
            //   console.log(data);return false;
            if(data.length !==0){
                data = data['content'][0];
                console.log(data);
                if(data.status == 0){
                    $('#sy' + data.period_id).attr('sytime', data.countdown);
                    // $('#name' + data.period_id).text(data.nickname);
                    $('#bg' + data.period_id).attr('class', 'goodmoney tipin');
                    var t = setTimeout(function () {
                        $('#bg' + data.period_id).attr('class', 'goodmoney tipout');
                    }, 20);
                    $('#money' + data.period_id).text(data.bid_price);
                }else{
                    $('#perbutton' + data.period_id).text('本期结束');
                    $('#perbutton' + data.period_id).css('background-color', '#999999');
                    $('#sy' + data.period_id).attr('sytime', 0);
                    $('#sy' + data.period_id).css('color', 'black');
                    $('#bg' + data.period_id).css('color', 'black');
                    $('#logo' + data.period_id).addClass('endimg');
                }
            }
        }
    </script>
    <script type="text/javascript">
        $(function () {
            get_goods(6);
            $('#J-deallistWrapper').vTicker();
            var tt = setInterval("begin()", 9000);
            if ($(window).height() > 700) {
                $('.txt').css('margin-top', '67%');
            }
        });
        function togoods(id) {
            location.href = "/h5/product/detail?period_id=" + id;
        }
        function get_goods(type) {
            $.get("/h5/home/get-period", {
                type: type,
                pages: 0,
                limit:6,
            }, function (d) {
                if (d.data.length != '') {
                    console.log(d);
                    var gettpl = document.getElementById('goodslists').innerHTML;
                    laytpl(gettpl).render(d, function (html) {

                        $("#listgoods").empty();
                        if (type == 2) {
                            $("#collection").empty()
                            $("#collection").append(html);
                            $(".cl").val(1);
                            if (d.length > 0) {
                                $("#listcol").hide();
                            }
                        } else if (type == 7) {
                            $("#selfing").empty();
                            $("#selfing").append(html);
                            $(".cl").val('');
                            if (d.length > 0) {
                                $("#listing").hide();
                            }
                        } else {
                            $(".cl").val('');
                            $("#listgoods").append(html);
                        }
                    });
                }
            }, "json");
        }
    </script>
    @parent
@stop

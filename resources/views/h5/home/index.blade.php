@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    微排行
@stop
@section('content')
<div class="page-group">
    <div class="content native-scroll infinite-scroll-bottom infinite-scroll">
        <!-- 幻灯片  -->
        <div class="swiper-container swiper-container-horizontal" id="indexadv">
            <div class="swiper-wrapper"
                 style="width: 720px; transform: translate3d(-360px, 0px, 0px); transition-duration: 0ms;">
                @foreach ($banner as $k => $v)
                    <div onclick="location.href=''" class="swiper-slide swiper-slide-active" style="min-height: 100px; font-size: 0px; width: 360px;">
                        <img src="{{ $v['img'] }}?imageView2/1/w/900/h/500">
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
            <div id="J-deallistWrapper" class="" style="overflow: hidden; position: relative; height: 153px;">
                <ul id="J-deallistRoll" style="transform: translate3d(0px, 0px, 0px); position: absolute; margin: 0px; padding: 0px; top: 0px;">
                    @foreach ($last_deal as $k => $v)
                        <li style="margin: 0px; padding: 0px; height: 51px;">
                            <a class="hidelong" href="">
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
                    <div class="col-33" onclick="location.href=''">
                        <div class="lately">
                            @if(!empty($v['end_time']))
								<span class="endimg" >
									<img class="endlogo"  src="{{ $v['img_cover'] }}">
								</span>
                                @else
                                <span style="position:relative;display: inline-block;width: 4rem;height: 4rem;margin: 0 auto;">
									<img class="endlogo" src="{{ $v['img_cover'] }}">
								</span>
                            @endif
                            <p class="endmoney">{{ $v['bid_price'] }}</p>
                            <p class="endmember" style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                                {{ $v['nickname'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="mod_guide" style="display: none;">
            <div class="r_red">
                <a class="icon-close-x" id="J-close"></a>
                <div class="ct_wrap">
                    <div class="bag_seal">
                    </div>
                    <div class="txt" style="margin-top: 67%;">
                        新人福利<br>
                        <em>200</em>元
                    </div>
                </div>
                <a class="sub_btn"
                   href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=signin">立即领取</a>
            </div>
        </div>

        <!-- 商品 -->
        <div class="list-block goods-list">
            <div class="buttons-tab">
                <a href="#goodslist" class="tab-link button active" onclick="get_goods(1)">热拍商品</a>
                <a href="#selfing" class="tab-link button" onclick="get_goods(2)">我正在拍</a>
                <a href="#collection" class="tab-link button " onclick="get_goods(3)">我的收藏</a>
            </div>
            <div class="tabs">
                <div id="goodslist" class="tab active">
                    <div class="" id="listgoods" style="padding-left: 0;padding-right: 0;position: relative;">


                        <div style="clear: both;"></div>
                    </div>
                </div>
                <div id="selfing" class="tab">
                    <div class="" id="listing">
                        <div class="nodata-default">
                            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=category">去逛逛</a>
                        </div>
                    </div>
                </div>
                <div id="collection" class="tab">
                    <div class="" id="listcol">
                        <div class="nodata-default">
                            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=category">去逛逛</a>
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
    <input type="hidden" name="cl" class="cl" value="" />
    <span id="{{d.data[i].product_id}}" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" {{# if(d.data[i].is_favorite == 0){ }} style="display: none;" {{# } }}>
    已收藏
    </span>
    <span id="{{d.data[i].product_id}}" class="scbutton addcollection" onclick="addcollection(this)"  {{# if(d.data[i].is_favorite == 1){ }} style="display: none;" {{# } }}>
    <i class="icon iconfont icon-add"></i>
    收藏
    </span>
    </div>
    <div onclick="togoods({{d.data[i].id}})">
    <span class="goodimg" id="logo{{d.data[i].img_cover}}">
    <img class="goodlogo" src="{{ d.data[i].img_cover}}"/>
    </span>
    <p id="sy{{d.data[i].id}}" sytime='{{d.data[i].countdown}}' perid="{{d.data[i].id}}" class="downtime"></p>
    <input type="hidden" value="0" id="end{{d.data[i].id}}"  />
    <input type="hidden" value="{{d.data[i].bid_price}}" id="mid{{d.data[i].id}}"  />
    <input type="hidden" id="period_ids" value="{{d.data[i].id}}" />
    <p class="goodmoney tipout"id="bg{{d.data[i].id}}" >￥<span id="money{{d.data[i].id}}">{{d.data[i].bid_price}}</span></p>
    <p id="name{{d.data[i].id}}" class="goodmember">{{d.data[i].title}}</p>
    <span class="toauc" id="perbutton{{d.data[i].id}}">{{# if(d.data[i].businessflag == 0){ }}歇业中{{# }else{ }}参与竞拍{{# } }}</span>
    </div>
    </div>
    {{# } }}
    @endverbatim
    <div style="clear: both;"></div>
</script>
<script type="text/javascript"
        src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/js/jquery.vticker.min.js"
        charset="utf-8"></script>

<script type="text/javascript">

    // 服务端发来消息时
    function onmessage(e) {
//      console.log(e.data);
        var data = JSON.parse(e.data);
        switch (data['type']) {
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong"}');
                break;
            // 服务端ping客户端
            case 'init':
                onopens(data['client_id']);
                break;
            // 出价信息
            case 'offer':
                $('#sy' + data.perid).attr('sytime', data.countdown);
                $('#name' + data.perid).text(data.finalname);
                $('#bg' + data.perid).attr('class', 'goodmoney tipin');
                var t = setTimeout(function () {
                    $('#bg' + data.perid).attr('class', 'goodmoney tipout');
                }, 20);
                $('#money' + data.perid).text(data.prtxt);
                break;
            case 'end':
                $('#end' + data.perid).val(1);
                break;
        }
    }
</script>


<script type="text/javascript">

    $('#J-close').click(function () {
        $('.mod_guide').hide();
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=dashboard&ac=home&do=setclose", {}, function (d) {
        }, "json");
    })
    $(function () {
        get_goods(1);
        $('#J-deallistWrapper').vTicker();
        var tt = setInterval("begin()", 9000);
        if ($(window).height() > 700) {
            $('.txt').css('margin-top', '67%');
        }
    });
    function togoods(id) {
        location.href = "product/detail?period_id=" + id;
    }
    function get_goods(type) {
        $.get("home/get-period", {
            id: 0,
            type: type
        }, function (d) {
            if (d.data.length != '') {
                console.log(d);
                var gettpl = document.getElementById('goodslists').innerHTML;
                laytpl(gettpl).render(d, function (html) {
                    $("#listgoods").empty();
                    if (type == 3) {
                        $("#collection").empty()
                        $("#collection").append(html);
                        $(".cl").val(1);
                    } else if (type == 2) {
                        $("#selfing").append(html);
                        $(".cl").val('');
                    } else {
                        $(".cl").val('');

                        $("#listgoods").append(html);
                    }
                });
            }
        }, "json");
    }
    function addcollection(obj) {
        var id = $(obj).attr('id');
        location.href = "/h5/collection/collect?product_id="+id
    }
    function cancelcollection(obj) {
        var id = $(obj).attr('id');
        $.get(
            "/h5/collection/collect",
            {product_id: id},
            function (d) {
                var a = $(".cl").val();
                console.log(a);
                if (a == 1) {
                    if (d['data'] != null) {
                        var gettpl = document.getElementById('goodslists').innerHTML;
                        laytpl(gettpl).render(d, function (html) {
                            $("#collection").empty();
                            $("#collection").append(html);
                            $(".cl").val(1);
                        });
                    } else {
                        $("#collection").empty();
                        var html = ''
                        html += '<div class="nodata-default">' +
                            '<a href="https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=category">' + '去逛逛' + '</a>' +
                            '</div>';
                        $("#collection").append(html);
                    }
                } else {
                    $(obj).hide();
                    $(obj).parent('div').find('span.addcollection').show();
                }
            }, "json");
    }
    var businessflag = "1";
    function begin() {
        getinfo();
        $('.downtime').each(function () {
            var begintime = $(this).attr('sytime');
            var txt = '';
            if (begintime > 0) {
                h = Math.floor(begintime / 3600);
                m = Math.floor((begintime % 3600) / 60);
                s = Math.floor((begintime % 3600) % 60);
                if (h < 10) {
                    h = '0' + h;
                }
                if (m < 10) {
                    m = '0' + m;
                }
                if (s < 10) {
                    s = '0' + s;
                }
                txt = h + ":" + m + ":" + s;
              //  $(this).text(txt);
                begintime = begintime - 1;
                $(this).attr('sytime', begintime);
            } else {
                var perid = $(this).attr('perid');
                var endflag = $('#end' + perid).val();
                if (endflag > 0) {
                    if (businessflag == 0) {
                        $('#perbutton' + perid).text('歇业中');
                    } else {
                        $('#perbutton' + perid).text('本期结束');
                    }
                    $('#perbutton' + perid).css('background-color', '#999999');
                    $('#sy' + perid).attr('sytime', 0);
                   // $('#sy' + perid).text('00:00:00');
                    $('#sy' + perid).css('color', 'black');
                    $('#bg' + perid).css('color', 'black');
                    $('#logo' + perid).addClass('endimg');
                }
            }
        });
    }

    function getinfo() {
        var arrs = new Array();
        $("input[id^='period_ids']").each(function(i){
            arrs.push($(this).val());
        });

        $.post("bid/newest-bid", {
            periods : arrs.join(",")
        }, function (data) {
            data = data.data;
          //  console.log(data);
            $.each(data, function (key, val) {
                if (val.f == '1') { //表示竞拍成功
                    $('#end' + val.a).val(1);
                } else {
                    var nowmid = $('#mid' + val.a).val();
                    if (val.c !== nowmid) {
                        $('#mid' + val.a).val(val.a);
                        $('#sy' + val.a).attr('sytime', val.h)
                        //$('#name' + val.a).text(val.d);
                        $('#bg' + val.a).attr('class', 'goodmoney tipin');
                        var t = setTimeout(function () {
                            $('#bg' + val.a).attr('class', 'goodmoney tipout');
                        }, 50);
                        //console.log(val.a);
                        $('#money' + val.a).text(val.c);
                    }
                }
            });
        }, "json");
    }


</script>


@parent
@stop

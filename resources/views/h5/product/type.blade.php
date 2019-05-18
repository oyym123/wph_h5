@extends('layouts.h5')
@section('title')
    分类
@stop
@section('title_head')
    产品分类
@stop
@section('content')
    <div class="content native-scroll">
        <div class="mui-scroll-wrapper mui-content" id="mainContainer" style="z-index: 1; background-color: white;">
            <div class="mui-scroll" style="transform: translate3d(0px, 0px, 0px) translateZ(0px);">
                <ul class="ui-tags-ct container" id="J-mainCt" style="padding-bottom: 2rem;">
                </ul>
                <div class="mui-pull-bottom-pocket mui-block">
                    <div class="mui-pull">
                        <div class="mui-pull-loading mui-icon mui-spinner mui-hidden"></div>
                        <div class="mui-pull-caption mui-pull-caption-down"></div>
                    </div>
                </div>
            </div>
            <div class="mui-scrollbar mui-scrollbar-vertical">
                <div class="mui-scrollbar-indicator"
                     style="transition-duration: 0ms; display: block; height: 277px; transform: translate3d(0px, 0px, 0px) translateZ(0px);"></div>
            </div>
        </div>

        <div class="ui-tags-tit" id="J-mainTags">
            <input type="hidden" name="cateid" id="cateid" value="0">
            @foreach($data as $key=>$v)
                <div class="item-content" onclick="showclass(this)" data-id="{{$v['id']}}"
                     @if($key==0)id="defut" @endif >
                    <div class="item-inner">
                        <a data-href="list27">{{$v['title']}}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script type="text/html" id="classlist">
        @verbatim
        {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
        <li class="" style="display:block" onclick="togoods({{d.data[i].id}})">
            <div class="goods ui-mark-1">
                <a class="cover" id="logo{{d.data[i].id}}">
                    <img src="{{ d.data[i].img_cover }}">
                </a>
                <div class="titles" style="height: 2.2rem;font-size: medium">{{ d.data[i].title }}</div>
                <div class="price_wraps" id="end{{d.data[i].id}}">
                    <div class="price_cur tipout" id="money{{d.data[i].id}}">￥{{d.data[i].bid_price}}</div>
                    <a class="bid_btn" style="margin-left: 2rem;"></a>
                </div>
            </div>
        </li>
        {{# } }}
        @endverbatim
    </script>
    <script>
        var cateid = $('#cateid').val();
        console.log(cateid);
        if (cateid != '') {
            get_class(cateid);
            $('#' + cateid).addClass('active');
            $('#defut').removeClass('active');
        } else {
            get_class(0);
        }
        function showclass(obj) {
            var dataid = $(obj).attr('data-id');
            $('.item-content').each(function () {
                $(this).removeClass('active');
            });
            $(obj).addClass('active');
            get_class(dataid);
        }
        function get_class(id) {
            $(".container").empty();
            $.get(
                "/h5/product", {
                    type: id
                },
                function (d) {

                    if (d.data) {
                        $('#mainContainer').css('background-color', 'white');
                        var gettpl = document.getElementById('classlist').innerHTML;
                        laytpl(gettpl).render(d, function (html) {
                            $(".container").append(html);
                        });
                    } else {
                        $(".container").append('<div class="nodata-default"></div>');
                        $('#mainContainer').css('background-color', '#efeff4');
                    }
                }, "json");
        }
        function togoods(id) {
            location.href = "/h5/product/detail?period_id=" + id;
        }
    </script>


    <script type="text/javascript">
        connect();
        // 连接服务端
        function connect() {
            // 创建websocket
            @if(PHP_OS == 'WINNT') //本地测试专用
        //    ws = new WebSocket("ws://127.0.0.1:8081");
            ws = new WebSocket("wss://api.95wx.cn/wss");
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
//                console.log(data);
                if (data.status == 0) {
                    $('#money' + data.period_id).attr('class', 'price_cur tipin');
                    var t = setTimeout(function () {
                        $('#money' + data.period_id).attr('class', 'price_cur tipout');
                    }, 20);
                    $('#money' + data.period_id).text('￥' + data.bid_price);
                }else{
                    $('#end' + data.period_id).addClass('traded');
                    $('#logo' + data.period_id).addClass('endimg');
                }
            }
        }
    </script>
    @parent
@stop

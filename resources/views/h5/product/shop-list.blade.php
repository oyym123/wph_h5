@extends('layouts.h5')
@section('title')
    购物币专区
@stop
@section('title_head')
    购物币专区
@stop
@section('content')
    <style>
        .gooddiv1 {
            width: 49.2%;
            text-align: center;
            display: inline-block;
            padding-top: 2rem;
            padding-bottom: .7rem;
            border: 1px solid rgba(208, 208, 208, 0.3);
            border-left: 0;
            border-top: 0;
            overflow: hidden;
            position: relative;
            background-color: #FFFFFF;
        }

        .gooddiv1 .goodimg {
            width: 5rem;
            height: 5rem;
            position: relative;
            display: inline-block;
        }

        .gooddiv1 .goodlogo {
            width: 100%;
            height: 100%;
        }

        .gooddiv1 .scbutton i {
            position: relative;
            top: -1px;
            left: 1px;
            padding: 0;
            font-size: 15px;
        }

        .gooddiv1 .goodmoney {
            font-size: 0.9rem;
            font-weight: bold;
            width: 70%;
            margin: 0 auto;
        }

        .gooddiv1 .goodmember {
            font-size: 0.6rem;
        }
    </style>
    <div id="wrapper">
        <div class="scroller">
            <div id="latelist">
                @foreach($list as $v)
                    <div class="gooddiv1">
                        <div onclick="togoods({{ $v['product_id'] }})">
                        <span class="goodimg">
                        <img class="goodlogo" src="{{ $v['img_cover'] }}"/>
                        </span>
                            <p class="goodmoney tipout">
                                ￥<span>{{ $v['sell_price'] }}</span>
                            </p>
                            <p class="goodmember">{{ $v['title'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                <div class="more"><i class="pull_icon"></i><span></span></div>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/h5/iscroll.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/h5/scroller.css')}}">
    <script type="text/html" id="goodslists">
        @verbatim
        {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
        <div class="gooddiv1">
            <div onclick="togoods({{d.data[i].product_id}})">
            <span class="goodimg">
            <img class="goodlogo" src="{{ d.data[i].img_cover}}"/>
            </span>
                <p class="goodmoney tipout">
                    ￥<span>{{d.data[i].sell_price}}</span>
                </p>
                <p class="goodmember">{{d.data[i].title}}</p>
            </div>
        </div>
        {{# } }}
        @endverbatim
    </script>
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
                    $.get("/h5/product/shop-list", {pages: pagenum}, function (d) {
                        if (d.data.length != '') {
                            var gettpl = document.getElementById('goodslists').innerHTML;
                            laytpl(gettpl).render(d, function (html) {
                                $("#listgoods").empty();
                                $(".cl").val('');
                                $("#latelist").append(html);
                            });
                        }
                    }, "json");
                    myscroll.refresh();
                }, 100)
            }

            if ($('.scroller').height() < $('#wrapper').height()) {
                $('.more').hide();
                myscroll.destroy();
            }
        });

        function togoods(id) {
            location.href = "/h5/product/shop-detail?product_id=" + id;
        }
    </script>
    @parent
@stop

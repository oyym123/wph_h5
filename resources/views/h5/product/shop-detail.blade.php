@extends('layouts.h5')
@section('title')
    商品详情
@stop
@section('title_head')
    商品详情
@stop
@section('content')
    <div class="dt_detail" style="background-color: white;padding-bottom: 10px;">
        <!--商品幻灯片-->
        <div class="banner swiper-container-horizontal swiper-container-android" id="ban_adv">
            <div class="swiper-wrapper"
                 style="transform: translate3d(-1800px, 0px, 0px); transition-duration: 0ms;">
                @foreach ($detail['imgs'] as $k => $v)
                    <div class="swiper-slide" data-swiper-slide-index="{{ $k }}"
                         style="width: 360px;height:45%">
                        <img src="{{ $v }}">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span
                        class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
        </div>
        <style>
            .tool_tips em {
                color: #EF1544
            }

            .tool_tips .quick_num {
                height: .5rem;
                line-height: .5rem;
                display: -webkit-box;
                display: -webkit-flex;
                display: flex;
                padding: 0 .1rem .2rem
            }

            .tool_tips .quick_num a {
                -webkit-box-flex: 1;
                -webkit-flex: 1;
                flex: 1;
                height: 1rem;
                margin: .3rem;
                border: solid 1px #999;
                color: #333;
                font-size: 14px;
                line-height: 1rem;
                border-radius: .3rem
            }

            .tool_tips .quick_num a.focus {
                color: #EF1544;
                border-color: #EF1544
            }


            .botcelly p {
                height: 25px;
                line-height: 25px;
            }

            .numbersel input {
                background: none;
                outline: none;
                border: 0px;
                width: 20px;
                padding-left: 5px;
                border-radius: 0;
                height: 35px;
            }

            .numbersel span {
                display: inline-block;
                height: 35px;
                width: 35px;
                border: 1px solid #dfdfdf;
                line-height: 35px;
                text-align: center;
            }

            .botcell {
                height: 50px;
                line-height: 50px;
                width: 100%;
                position: fixed;
                left: 0;
                bottom: 0;
                z-index: 101;
                background: #fff;
            }

            .botcellz {
                display: inline-block;
                height: 50px;
                width: 15%;
                float: left;
                padding: 2% 0;
                text-align: center;
                border-top: 1px solid #dfdfdf;
            }

            .botcellz i {
                display: block;
                height: 22px;
                width: 22px;
                font-size: 25px;
                color: #999999;
                background-size: cover;
                margin: 0 auto;
                position: relative;
                top: -13px;
            }

            .botcellz p {
                color: #888;
                font-size: 12px;
                height: 20px;
                line-height: 20px;
            }


            .auced {
                width: calc(85%);
                background: #ed414a;
                text-align: center;
                color: #fff;
                float: right;
            }

            .banner {
                visibility: visible;
                width: 100%;
                position: relative;
                overflow: hidden;
            }

            .banner img {
                width: 100%;
            }

            .goodsname {
                padding-left: 10px;
                font-size: 17px;
                text-align: left;
                line-height: 1.2rem;
                width: 100%;
                display: inline-block;
            }

            .aucinfo {
                padding-left: 10px;
                padding-right: 10px;
                font-size: 13px;
                text-align: center;
                margin-top: 1px;
            }

            /*中间的过度的横线*/
            .link-top {
                width: 100%;
                height:1px;
                color: rgb(245, 245, 245);
                border-top: solid #ACC0D8 1px;
            }
        </style>
        <script>
            $(function () {
                var mySwiper = new Swiper('#ban_adv', {
                    autoplay: 3000,
                    speed: 500,
                    loop: true,
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    autoplayDisableOnInteraction: false
                });
            });
        </script>
        <div class="link-top"></div>
        <div class="goodsname" style="font-size: smaller;position:relative;top:.1rem">{{ $detail['title'] }}</div>
        <div class="aucinfo">
            <div class="" style="font-size: larger;color: rgb(162, 162, 162)">
                <span style="position:relative;right: 3.5rem">购物币　
                    <span style="color:red;font-size: xx-large; ">￥{{ $detail['sell_price'] }}</span>
                </span>
            </div>
        </div>

        <!--晒单等-->
        <div class="list-block" style="margin-top: .7rem;background-color: #FFFFFF;">
            <div class="buttons-tab">
                <a href="#goodslist" class="tab-link button active">拍品展示</a>
                <a href="#selfing" class="tab-link button">宝贝评价</a>
            </div>
            <div class="tabs">
                <div id="goodslist" class="tab active">
                    @foreach($detail['desc_imgs'] as $v)
                        <img style="width: 100%" src="{{ $v }}">
                    @endforeach
                </div>
                <div id="selfing" class="tab">

                </div>
            </div>
        </div>
    </div>

    <!--底部-->
    <div class="botcell">
        <a class="botcellz collent" onclick="addcollection()" style="border-right:1px solid #dfdfdf;">
            <i class="icon iconfont icon-like"></i>
            <p id="sctxt">收藏</p>
        </a>

        <a class="botcellz canclcollent" onclick="cancelcollection()"
           style="border-right:1px solid #dfdfdf;  display: none; ">
            <i class="icon iconfont icon-likefill" style="color: #EF1544;"></i>
            <p>已收藏</p>
        </a>

        <div class="auced" onclick="payorder({{ $detail['product_id'] }})">
            <div>立即购买</div>
        </div>
    </div>

    <script>
        function payorder(pid, period_id = 0, sn = 0) {
            location.href = "/h5/pay/confirm?product_id=" + pid + "&period_id=" + period_id + "&sn=" + sn;
        }

        @if($detail['is_favorite'] == 1)
        $('.collent').hide();
        $('.canclcollent').show();

        @endif
        function addcollection(e) {
            var id = "{{ $detail['product_id'] }}";
            $.ajax({
                cache: true,
                type: "GET",
                url: "/h5/collection/collect",
                data: {
                    'product_id': id,
                },
                success: function (data) {
                    $('.collent').hide();
                    $('.canclcollent').show();
                    $('#collect_num').text(($('#collect_num').text()) * 1 + 1)
                }
            });
        }

        function cancelcollection() {
            var id = "{{ $detail['product_id'] }}";
            $.ajax({
                cache: true,
                type: "GET",
                url: "/h5/collection/collect",
                data: {
                    'product_id': id,
                },
                success: function (data) {
                    $('.collent').show();
                    $('.canclcollent').hide();
                    $('#collect_num').text(($('#collect_num').text()) * 1 - 1)
                }
            });
        }

    </script>

    @parent
@stop

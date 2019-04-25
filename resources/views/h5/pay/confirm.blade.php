@extends('layouts.h5')
@section('title')
    确认订单
@stop
@section('title_head')
    确认订单
@stop
@section('content')
    <body>
    <style>
        nav {
            display: none;
        }

        .address {
            overflow: hidden;
            background: url("/images/h5/paybgimg.png") no-repeat 0 100% #fff;
            background-size: 18.75rem 0.3rem;
            padding-bottom: 0.3rem
        }

        .address .add_address {
            margin: 1.25rem auto;
            display: block;
            width: 6.75rem;
            height: 2rem;
            line-height: 2rem;
            color: #333;
            border: solid 1px #333;
            text-align: center
        }

        .address .alipay_info {
            padding: 0.625rem;
            line-height: 2;
        }

        .address .alipay_info span {
            color: #666;
        }

        .address .address_info {
            padding: 0.625rem 1.75rem 0.625rem 2.7500000000000004rem;
            line-height: 1.2;
            color: #666;
            position: relative
        }

        .address .address_info:before, .address .address_info:after {
            position: absolute;
            top: 0;
            left: 0.75rem;
            font-family: "iconfont" !important;
            -webkit-font-smoothing: antialiased;
            display: box;
            display: -webkit-box;
            box-align: center;
            -webkit-box-align: center;
            -webkit-box-pack: center;
            box-pack: center;
            height: 100%;
            width: 1.5rem;
            content: "\e608";
            font-size: 1.5rem;
            color: #999;
        }

        .address .address_info:after {
            content: "\e70a";
            left: auto;
            right: 0;
            font-size: 0.9rem;
            color: #333;
        }

        .address .address_info .name {
            float: left
        }

        .address .address_info .mobile {
            float: right
        }

        .address .address_info .info {
            clear: both;
            padding-top: 0.375rem
        }

        .address .address_info.lh2 {
            line-height: 2;
        }

        .goods_list .title {
            padding-left: 0.625rem
        }

        .goods_list .cover {
            width: 4.35rem;
            height: 4.35rem;
            float: left;
            position: relative;
            overflow: hidden;
            padding: 0.2rem;
        }

        .goods_list .cover img {
            width: 100%;
            height: 100%;
        }

        .goods_list .goods_info {
            float: left;
            width: 11.2rem;
            padding: 0.75rem 0.25rem 0;
            line-height: 1.25rem;
            font-size: 0.6rem
        }

        .goods_list .goods_info em {
            color: #EF1544;
            font-size: 0.7000000000000001rem
        }

        .goods_list .goods_info i {
            color: #999;
            text-decoration: line-through;
            margin-left: 0.5rem
        }

        .goods_list .goods_info.buy {
            line-height: 1rem
        }

        .goods_list .goods_info.buy span {
            float: right;
            padding-right: 1.75rem;
            position: relative
        }

        .goods_list .goods_info.buy .ui-checkbox {
            position: absolute;
            right: 0;
            top: 0.25rem
        }

        .goods_list .goods_info.buy .realpay {
            margin-top: 0.25rem;
            padding-top: 0.25rem;
            border-top: solid 1px #ccc
        }

        .goods_list .goods_info .dis {
            display: none
        }

        .goods_list .remark {
            clear: both;
            color: #333;
            height: 2rem;
            line-height: 2.05rem;
            padding: 0 0.625rem;
            border-top: solid 1px #ccc;
            overflow: hidden
        }

        .goods_list .remark input {
            height: 2rem;
            width: 11rem
        }

        .submit_wrap {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2.5rem;
            line-height: 2.55rem;
            z-index: 90;
            background: #fff;
            padding: 0 0.625rem;
            font-size: 0.7000000000000001rem;
            color: #666;
        }

        .submit_wrap em {
            color: #EF1544;
        }

        .submit_wrap .ui-btn-submit-xb {
            margin-top: 0.25rem;
            width: 4.875rem;
            height: 2rem;
            line-height: 2rem;
            float: right;
            display: inline-block;
            vertical-align: middle;
            background: #EF1544;
            color: #fff;
            text-align: center;
            -webkit-transition: background .5s;
            transition: background .5s
        }
    </style>
    <div class="page-group">
        <div class="content native-scroll" style="top: 2.2rem;">
            @if(empty($address_info))
                <div class="address" id="J-address">
                    <a class="add_address"
                       onclick="location.href='/h5/user/address-view?product_id={{$product_id }}&period_id={{$period_id}}&sn={{$sn}}'">完善收货信息</a>
                </div>
            @else
                <div class="address" id="J-address">
                    <div style="position:relative;font-size: smaller;left:1.5rem;">
                        <b>收货地址：</b>
                        <a href="/h5/user/address-view?product_id={{$product_id }}&period_id={{$period_id}}&sn={{$sn}}&address_id={{$address_info['address_id']}}">
                            <b style="position:relative;left: 6rem">更换新地址</b></a>

                        <br/>
                        姓名：{{$address_info['username']}}
                        <br/>
                        手机号：{{$address_info['telephone']}}
                        <br/>
                        地址：{{$address_info['address']}}
                        <br/>
                    </div>
                </div>
            @endif
            <div class="ui-block goods_list c">
                <div class="cover">
                    <img src="{{ $img_cover }}">
                </div>
                <div class="goods_info buy">
                    <p>市场价：<span>￥{{ $sell_price }}</span></p>
                    <p class="realpay">实付价格：<span><em id="J-realPay">￥{{ $pay_amount  }}</em></span></p>
                    @if($order_type != 1)
                        <div class='f_row al_itm rpx26 jc_sb margin_b10'>
                            <text>使用购物币：</text>
                            <view>
                                <text>- {{ $discount_amount }}￥</text>
                                <img class="discount" style='width:20px;height:20px; margin-left:2rem;'
                                     src='{{1? "/images/h5/yes.png" : "/images/h5/no.png"}}' mode='aspectFill'>
                            </view>
                        </div>
                    @endif
                </div>
                <div class="remark">
                    买家留言：
                    <input type="text" id="J-remark" style="border: 0;" placeholder="选填：如尺码、颜色">
                </div>
            </div>
            <label for="weuiAgree" class="weui-agree" onclick="changecolor()">
                <input id="weuiAgree" type="checkbox" checked="checked" class="weui-agree__checkbox">
                <span class="weui-agree__text">阅读并同意<a href="/h5/user/user-agreement">《用户协议》</a>
	            </span>
            </label>
        </div>
        @if($status == 10)
        <div class="submit_wrap">实付款：<em id="J-payNums">￥{{ $pay_amount }}</em><a href="javascript:register()"
                                                                                  class="ui-btn-submit-xb">立即支付</a>
        </div>
        @endif
        <input type="hidden" id="used_shopping" value="1">
    </div>
    <div class="popup popup-about">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-right close-popup">
                关闭
            </a>
            <h1 class="title">用户协议</h1>
        </header>
        <div class="content">
            <div class="content-inner">
                <div class="content-block">
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.discount').click(function () {
            if ($(this).attr('src') == '/images/h5/no.png') {
                $(this).attr('src', '/images/h5/yes.png');
                $("#J-realPay").text('￥' + {{ $pay_amount }});
                $("#J-payNums").text('￥' + {{ $pay_amount }});
                $("#used_shopping").val(1);
            } else {
                $(this).attr('src', '/images/h5/no.png');
                $("#J-realPay").text('￥' + {{ $sell_price }});
                $("#J-payNums").text('￥' + {{ $sell_price }});
                $("#used_shopping").val(0);
            }
        });

        function changecolor() {
            if (!$('#weuiAgree').is(":checked")) {
                $('.ui-btn-submit-xb').css('background-color', '#aaa')
            } else {
                $('.ui-btn-submit-xb').css('background-color', '#EF1544')
            }
        }

        if ("{{ $msg }}") {
            $.toast("{{ $msg }}");
        }

        function register() {
            var used_shopping = $("#used_shopping").val();
            var message = $("#J-remark").val();
            if ($('#weuiAgree').is(":checked")) {
                $.get("/h5/user/default-address", {}, function (d) {
                    d = d.data;
                    if (d.username.length > 0) {
                        var remark = $('#J-remark').val();
                        var url = '/h5/pay/pay?product_id='
                            + {{ $product_id }}
                                +'&period_id=' + {{ $period_id }}
                                +'&sn=' + '{{ $sn }}'
                            + '&used_shopping=' + used_shopping
                            + '&message=' + message;
                        window.location.href = url;
                    } else {
                        $.toast('请先完善收货信息');
                    }
                }, "json");
            } else {
                $.toast('请先阅读用户协议');
            }
        }
    </script>
    @parent
@stop

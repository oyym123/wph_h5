@extends('layouts.h5')
@section('title')
    订单详情
@stop
@section('title_head')
    订单详情
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
            <div class="address" id="J-address">
                <div style="position:relative;font-size: smaller;left:1.5rem;">
                    {{--                        <b>收货地址：</b>--}}
                    {{--                        <a href="/h5/user/address-view?product_id={{$product_id }}&period_id={{$period_id}}&sn={{$sn}}&address_id={{$address_info['address_id']}}">--}}
                    {{--                            <b style="position:relative;left: 6rem">更换新地址</b></a>--}}
                    ID:{{ $sn }}
                    <br/>
                    姓名：{{$address_info['username']}}
                    <br/>
                    手机号：{{$address_info['telephone']}}
                    <br/>
                    地址：{{$address_info['address']}}
                    <br/>
                </div>
            </div>
            <div class="ui-block goods_list c">
                <div class="cover">
                    <img src="{{ $product_info['img_cover'] }}">
                </div>

                <div class="goods_info buy">
                    <p>市场价：<span>￥{{ $product_info['sell_price'] }}</span></p>
                    <p class="realpay">实付价格：<span><em id="J-realPay">￥{{ $amount }}</em></span></p>
                </div>


                <div class="remark">
                    京东物流单号：
                    <input type="text" id="J-remark" style="border: 0;" readonly value="{{ $delivery_number?:'' }}">
                </div>
                <div class="remark">
                    创建时间：
                    <input type="text" id="J-remark" style="border: 0;" readonly value="{{ $begin_at }}">
                </div>
{{--                <div class="remark">--}}
{{--                    备注信息：--}}
{{--                    <input type="text" id="J-remark" style="border: 0;" readonly value="{{  }}">--}}
{{--                </div>--}}
            </div>
        </div>
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

    </script>
    @parent
@stop

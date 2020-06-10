@extends('layouts.h5')
@section('title')
    商品详情
@stop
@section('title_head')
    商品详情
@stop
@section('content')
    <div class="page-group">
        <div class="page page-current" id="page-index">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left" style="padding-top: .5rem;"
                   href="javascript:history.go(-1);">
                    <span style="color: #999999;" class="icon icon-left"></span>
                </a>
                <a class="button button-link button-nav pull-left"
                   style="padding-top: .5rem;padding-left: .3rem;color: #999999;"
                   href="/h5/home"><i
                            class="icon iconfont icon-homefill"></i></a>
                <h1 class="title">商品详情</h1>
            </header>
            <div class="content native-scroll infinite-scroll-bottom infinite-scroll" style="padding-bottom: 3rem;">
                <!--拍卖师-->
                <div class="list-block usercenter" style="margin:0;">
                    <ul>
                        <li>
                            <a href="/h5/auctioneer?auctioneer_id={{ $detail['auction_id'] }}"
                               class="item-link item-content">
                                <div class="item-media"><img style="height:2.3rem;width: 2.1rem;"
                                                             src="{{ $detail['auctioneer_avatar'] }}"></div>
                                <div class="item-inner" style="margin-left: .3rem;">
                                    <div class="item-title">
                                        <span class="aucname">{{ $detail['auctioneer_name'] }}</span>
                                        <span class="aucdetail">{{ $detail['auctioneer_tags'] }}</span><br>
                                        <span class="auccode">拍卖师编号:{{ $detail['auctioneer_license'] }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dt_detail" style="background-color: white;padding-bottom: 10px;">
                    <!--商品幻灯片-->
                    <div class="banner swiper-container-horizontal swiper-container-android" id="ban_adv">
                        <div class="swiper-wrapper"
                             style="transform: translate3d(-1800px, 0px, 0px); transition-duration: 0ms;">
                            @foreach ($detail['imgs'] as $k => $v)
                                <div class="swiper-slide" data-swiper-slide-index="{{ $k }}"
                                     style="width: 360px;height:45%">
                                     <span @if($detail['period_status'] == 1) class="endimg" @endif>
                                    <img src="{{ $v }}">
                                     </span>
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


                        .name {
                            font-size: small;
                            position: absolute;
                            left: 3rem;
                        }

                        .time {
                            position: absolute;
                            right: 20px;
                            font-size: small;
                        }

                        .share_li {
                            position: relative;
                            left: -0.3rem;
                            background-color: white;
                        }

                        .share_info {
                            position: absolute;
                            right: -.6rem;
                            top: 1.5rem;
                        }

                        .share_li .share_info .imgs {
                            width: 14.225rem;
                            font-size: 0;
                        }

                        .share_li .share_info .imgs img {
                            width: 4.25rem;
                            height: 4.25rem;
                            background: #ccc;
                            margin: 0.3rem 0.3rem 0 0;
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

                        .dotList {
                            position: absolute;
                            bottom: 5px;
                            right: 10px;
                            z-index: 100;
                        }

                        .pricediv {
                            background-color: #EF1544;
                            border: 1px solid #EF1544;
                            position: relative;
                            height: 2.5rem;
                        }

                        .nowprice {
                            display: inline-block;
                            color: white;
                            width: 43%;
                            margin: 0;
                            position: relative;
                            height: 2.5rem;
                            float: left;
                            line-height: 2.5rem;
                            bottom: 1px;
                            text-align: center;
                        }

                        .pricon {
                            font-size: 18px;
                            position: relative;
                            top: -4px;
                        }

                        .prtxt {
                            font-size: 30px;
                        }

                        .oldprice {
                            display: inline-block;
                            text-align: center;
                            color: white;
                            width: 25%;
                            height: 100%;
                            margin: 0;
                            position: relative;
                            line-height: 1.2rem;
                            bottom: 1px;
                        }

                        .downtime {
                            display: inline-block;
                            width: 28%;
                            text-align: center;
                            background-color: white;
                            color: #EF1544;
                            height: 100%;
                            margin: 0;
                            position: relative;
                            top: 0px;
                            font-size: 14px;
                            float: right;
                            line-height: 1.2rem;
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

                        .infodiv {
                            border: 1px solid #EF1544;
                            padding-top: 1px;
                            padding-bottom: 1px;
                            border-radius: 2px;
                            line-height: 1.2rem;
                        }

                        .infored {
                            color: #EF1544;
                        }

                        .blank20 {
                            height: 0.5rem;
                            clear: both;
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
                    <!--价格与倒计时-->
                    <div class="pricediv">
                        <div class="nowprice">
                            <span class="pricon">￥</span><span class="prtxt" id="prtxt1">{{ $price['c'] }}</span>
                        </div>
                        <div class="oldprice">
                            <p>市场价</p>
                            <p style="text-decoration:line-through;">￥{{ $detail['sell_price'] }}</p>
                        </div>
                        <div class="downtime">
                            <p id="sytxt"> 距结束还剩</p>
                            <p style="font-size: 20px;" id="sytime" sytime="{{ $detail['countdown_length'] }}">
                                00:00:09</p>
                            <input id="endflag" type="hidden" value="0">
                        </div>
                    </div>
                    <!--商品名称-->
                    <div class="goodsname">{{ $detail['title'] }}</div>
                {{--<div class="aucinfo">--}}
                {{--<div class="infodiv havelist" style="display: block;">若无人出价，--}}
                {{--<span class="infored" id="finalname">雨过天晴</span>--}}
                {{--将以<span class="infored">￥--}}
                {{--<span id="prtxt2">578.40</span>--}}
                {{--</span>拍得本商品--}}
                {{--</div>--}}
                {{--<div class="infodiv nolist" style="display: none;">暂无人出价</div>--}}
                {{--</div>--}}
                <!--出价信息-->
                    <div class="aucinfo">
                        <div class="" style="font-size: larger;color: rgb(162, 162, 162)">
                            <span style="position:relative;right: 2.5rem">出价
                                <span style="color:#000;">{{ $detail['bid_users_count'] }} </span>人
                            </span>
                            |
                            <span style="position:relative;left: 2.5rem"> 收藏
                                <span id="collect_num"
                                      style="color:#000;">  {{ $detail['collection_users_count'] }}</span> 人 </span>
                        </div>
                    </div>

                </div>
                <!--商品详情-->

                <!--出价记录-->
                <style>
                    .buysuccess {
                        margin-top: .5rem;
                        background-color: white;
                        padding-left: .5rem;
                        padding-right: .5rem;
                        padding-top: 4px;
                        padding-bottom: 0px;
                        font-size: 16px;
                    }

                    .infoname {
                        display: inline-block;
                        width: 30%;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    .infostatus {
                        display: inline-block;
                        width: 15%;
                    }

                    .infoaddress {
                        display: inline-block;
                        width: 35%;
                    }

                    .infoprice {
                        display: inline-block;
                        float: right;
                    }

                    .infolist {
                        font-size: 13px;
                        padding-top: .3rem;
                        padding-bottom: .3rem;
                    }

                    .infolist > div {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: .25rem 0 .25rem .2rem
                    }

                    .infolist .icon {
                        position: relative;
                    }
                </style>
                <div class="buysuccess">
                    <div onclick="location.href='/h5/bid/record?period_id={{ $detail['id'] }}&limit=100'"
                         style="border-bottom:1px solid #F3F3F3;">
                        <img src="/images/h5/chujia.png" style="height: 25px;width: 25px;"><span
                                style="position: relative;top: -6px;">出价记录</span>
                        <span style="color: #999999;position: relative;top: -6px;margin-left: 5px;"><span
                                    id="auctimes">{{ $detail['bid_count'] }}</span>条</span><span
                                style="float: right;color: #999999;"><i
                                    class="icon iconfont icon-right"></i></span></div>
                    <div class="infolist" id="infolist">
                        @foreach ($bid_records as $k => $v)
                            @if($v['bid_type'] ==1)
                                <div style="color : #EF1544;">
                                    <i class="icon iconfont icon-mobile"></i>
                                    <span class="infoname">{{ $v['nickname'] }}</span>
                                    <span class="infostatus">{{ $v['bid_type'] ? '领先' : '出局' }}</span>
                                    <span class="infoaddress">{{ $v['area'] }}</span>
                                    <span class="infoprice">￥{{ $v['bid_price'] }}</span>
                                </div>
                            @else
                                <div><i class="icon iconfont icon-mobile"></i>
                                    <span class="infoname">{{ $v['nickname'] }}</span>
                                    <span class="infostatus">{{ $v['bid_type'] ? '领先' : '出局' }}</span>
                                    <span class="infoaddress">{{ $v['area'] }}</span>
                                    <span class="infoprice">￥{{ $v['bid_price'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!--是否差价购买-->
                <style>
                    .buyflag {
                        padding: 1px 5px 1px 5px;
                        border: 1px solid rgb(163, 163, 163);

                    }
                </style>
                <div style="background-color: white;margin-top: .5rem;padding: .5rem .8rem;">
                    <span class="buyflag" style="color: rgb(163,163,163)">可差价购买</span>
                    <span style="color: #999999;margin-left: 5px;">我已消费
					<span id="auccoin">{{ $expended['used_real_bids'] }}</span>拍币/
					<span id="givecoin">{{ $expended['used_gift_bids']  }}</span>赠币
				</span>
                    <!--<span style="float: right;color: #999999;"><i class="icon iconfont icon-right"></i></span>-->
                </div>
                <!--价格信息-->
                <style>
                    .shop-manage-bottom {
                        background-color: white;
                        padding-top: 1px;
                        padding-bottom: 10px;
                        font-size: 13px;
                    }

                    .shop-manage-bottom .weui-loadmore_line {
                        margin-top: 10px;
                        margin-bottom: -5px;
                        border: 0;
                    }
                </style>
                <div class="shop-manage-bottom" style="margin-top: .5rem;">
                    <div class="weui-loadmore weui-loadmore_line" style="width: 85%;">
                        <div class="row no-gutter">
                            <div class="col-50" style="text-align: left;">
                                <span style="width: 3rem;display: inline-block;">起拍价</span><span
                                        style="color: #999999;">￥{{ $detail['init_price'] }}</span>
                            </div>
                            <div class="col-50" style="text-align: left;padding-left: 10px;">
                                <span style="width: 3.5rem;display: inline-block;">加价幅度</span><span
                                        style="color: #999999;">￥{{ $detail['price_add_length'] }}</span>
                            </div>
                            <div class="col-50" style="text-align: left;">
                                <span style="width: 3rem;display: inline-block;">手续费</span><span
                                        style="color: #999999;">{{ $detail['bid_step'] }}拍币/次</span>
                            </div>
                            <div class="col-50" style="text-align: left;padding-left: 10px;">
                                <span style="width: 3.5rem;display: inline-block;">倒计时</span><span
                                        style="color: #999999;">{{ $detail['countdown'] }}S</span>
                            </div>
                            <div class="col-50" style="text-align: left;">
                                <span style="width: 3rem;display: inline-block;">差价购买</span><span
                                        style="color: #999999;">  @if($detail['buy_by_diff'] ==1)  有 @else
                                        无 @endif</span>
                            </div>
                            <div class="col-50" style="text-align: left;padding-left: 10px;">
                                <span style="width: 3.5rem;display: inline-block;">退币比例</span><span
                                        style="color: #999999;">{{ $detail['return_proportion'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buysuccess">
                    <div onclick="location.href='/h5/bid/record?period_id={{ $detail['id'] }}&limit=100'"
                         style="border-bottom:1px solid #F3F3F3;">
                        <img src="/images/h5/chujia.png" style="height: 25px;width: 25px;"><span
                                style="position: relative;top: -6px;">往期成交</span>
                        <a href="/h5/product/past-deals?product_id={{ $detail['product_id'] }}">  <span
                                    style="position: relative;top: -9px;left: 9.7rem;">
                            <span id="auctimes">更多</span></span>
                            <span style="float: right;color: #999999;"><i class="icon iconfont icon-right"></i></span>
                        </a>
                    </div>
                    <!-- 最近成交 -->
                    <div class="list-block">
                        <div class="row no-gutter">
                            @if(!empty($past_deal))
                                @foreach ($past_deal[0] as $k => $v)
                                    @if($k<=2)
                                        <div class="col-33"
                                             onclick="location.href='/h5/product/detail?period={{ $v['id'] }}'">
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
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!--拍卖行-->
                <div class="list-block usercenter" style="margin-top:.5rem;">
                    <ul>
                        <li>
                            <a href="/h5/auctioneer?auctioneer_id={{ $detail['auction_id'] }}"
                               class="item-link item-content">
                                <div class="item-media"><img style="height:2.3rem;width: 2.1rem;"
                                                             src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/UYHcYfe8o2EOV00uZ12oEyh81MVC2e.png">
                                </div>
                                <div class="item-inner" style="margin-left: .3rem;">
                                    <div class="item-title">
                                        <span class="aucname">诺诺拍卖行</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--晒单等-->
                <div class="list-block" style="margin-top: .7rem;background-color: #FFFFFF;">
                    <div class="buttons-tab">
                        <a href="#goodslist" class="tab-link button active">拍品展示</a>
                        <a href="#selfing" class="tab-link button">宝贝评价</a>
                        <a href="#collection" class="tab-link button ">竞拍规则</a>
                    </div>
                    <div class="tabs">
                        <div id="goodslist" class="tab active">
                            @foreach($detail['desc_imgs'] as $v)
                                <img style="width: 100%" src="{{ $v }}">
                            @endforeach
                        </div>
                        <div id="selfing" class="tab">


                        </div>
                        <div id="collection" class="tab">
                            <div class="" id="listcol" style="padding: 1rem;">
                                <p>
                                    <span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(89, 89, 89);"></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(1) 所有商品竞拍初始价均为0元起，每出一次出价会消耗一定数量的拍币，同时商品价格以0.1元递增。</span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="color: rgb(89, 89, 89); font-family: 微软雅黑; font-size: 14px;">(2) 在初始倒计时内即可出价，初始倒计时后进入竞拍倒计时，当您出价后，该件商品的计时器将被自动重置，以便其他用户进行出价竞争。如果没有其他用户对该件商品出价，计时器归零时，您便成功拍得了该商品。</span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(3) 若拍卖成功，请在30天内以成交价购买竞拍商品，超过30天未下单，视为放弃，不返拍币。</span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(4) <span
                                                style="font-size:14px;font-family:&#39;微软雅黑&#39;,sans-serif">若拍卖失败，将返还所消耗拍币的100%作为购物币，可用于差价购买当期商品，赠币除外。</span></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);"><br/></span>
                                </p>
                                <p style="margin-top:0;margin-bottom:0;padding:0 0 0 0 ;line-height:28px"><span
                                            style="font-family: 微软雅黑; font-size: 14px; color: rgb(89, 89, 89);">(5) 平台严禁违规操作，最终解释权归微拍行所有。</span>
                                </p>
                                <p>
                                    <span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(89, 89, 89);"><br/></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--底部-->
            <div class="botcell">
                {{--<a class="botcellz" onclick="code()" style="border-right:1px solid #dfdfdf;">--}}
                {{--<i class="icon iconfont icon-service"></i>--}}
                {{--<p>客服</p>--}}
                {{--</a>--}}

                <a class="botcellz collent" onclick="addcollection()" style="border-right:1px solid #dfdfdf;">
                    <i class="icon iconfont icon-like"></i>
                    <p id="sctxt">收藏</p>
                </a>

                <a class="botcellz canclcollent" onclick="cancelcollection()"
                   style="border-right:1px solid #dfdfdf;  display: none; ">
                    <i class="icon iconfont icon-likefill" style="color: #EF1544;"></i>
                    <p>已收藏</p>
                </a>
                <div class="aucing">
                    <div id="J-toolTips" class="tool_tips">
                        选择自动出价
                        <em id="rednum">5</em>次
                        <div class="quick_num">
                            <a class="qunum qu1" href="javascript:;" num="10">10</a>
                            <a class="qunum qu2" href="javascript:;" num="20">20</a>
                            <a class="qunum qu3" href="javascript:;" num="50">50</a>
                            <a class="qunum qu4" href="javascript:;" num="66">66</a>
                        </div>
                    </div>
                    <div class="botcelly numbersel">
                        <div class="selnum">
                            <span onclick="addnum(0)" style="margin-left: 5px;"><i class="icon iconfont icon-move"></i></span>
                            <span style="border: 0;width: 20px;"><input onclick="showtip()" onchange="changenum(this)"
                                                                        id="aucnum" type="tel" value="1"> </span>
                            <span onclick="addnum(1)"><i class="icon iconfont icon-add"></i></span>
                            <span style="border: 0;width: 15px;">次</span>
                        </div>
                        <div class="noselnum" style="display: none;">
                            <span style="border: 0;width: 100%;height: 20px;line-height: 30px;">自动出价中</span>
                            <span style="border: 0;width: 100%;height: 20px;line-height: 20px;">剩<span id="surtime"
                                                                                                       style="width: 30px;color: orangered;border: 0;"></span>次</span>
                        </div>
                    </div>

                    <div class="botcelly offer">
                        <p id="offertext" style="position: relative;top: 6px;">出价</p>
                        <p style="font-size: 12px;position: relative;top: -2px;">{{ $detail['bid_step'] }}拍币/次</p>
                        <input id="surtimes" type="hidden" value="0">
                    </div>

                </div>

                <div class="auced" style="display: none;" onclick="nextPeriod({{ $detail['product_id'] }})">
                    <div>前往下期</div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/html" id="lateauc2">
        @verbatim
        {{# for(var i = 0, len = d.length; i< len; i++){ }}
        <div class="share_li">
            <div class="cover1">
                <img style="border-radius:50%; height: 45px;"
                     src="{{ d[i].avatar }}?imageView2/1/w/45/h/45">
            </div>
            <div>
                <span class="name">{{d[i].nickname }}</span>
                <span class="time">{{ d[i].created_at }}</span>
            </div>
            <a href="/h5/evaluate/detail?id={{  d[i].id  }}">
                <div class="share_info" style="position:relative;margin-bottom: 2rem">
                    <h3 class="hidelong">{{d[i].product_title}}</h3>
                    <div class="desc">{{ d[i].content }}</div>
                    <div class="imgs">
                        {{# $.each(d[i].imgs, function(index, item){}}
                        <img src="{{ item }}?imageView2/1/w/150/h/150">
                        {{#  }); }}
                    </div>
                </div>
            </a>
        </div>
        {{# } }}
        @endverbatim
    </script>


    <script type="text/html" id="lateauc">
        @verbatim
        {{# for(var i = 0, len = d.length; i< len; i++){ }}
        <div class="ui-block deal_list" onclick="location.href='{{d[i].a}}'">
            <span class="time_line">{{d[i].endtime}}</span>
            <span class="cover">
				<img src="{{d[i].avatar}}">
			</span>
            <span class="info_text">
				<span class="deal_user hidelong">成交人：{{d[i].nickname}}</span>
				<span class="market_price">用户人ID：{{d[i].finalmid}}</span>
				<span class="deal_price">成交价：<em>￥{{d[i].finalmoney}}</em></span>
			</span>
            <span class="save_price" style="top: 0.5rem;"><em>{{d[i].rate}}</em>节省</span>
        </div>
        {{# } }}
        @endverbatim
    </script>

    <script type="text/html" id="lists">
        @verbatim
        {{# if(d[0]){ }}
        <div style="color: #EF1544;"><i class="icon iconfont icon-mobile"></i><span
                    class="infoname">{{d[0].nickname}}</span><span class="infostatus">领先</span><span
                    class="infoaddress">{{d[0].area}}</span><span class="infoprice">￥{{d[0].bid_price}}</span>
        </div>
        {{# if(d[1]){ }}
        <div><i class="icon iconfont icon-mobile"></i><span class="infoname">{{d[1].nickname}}</span><span
                    class="infostatus">出局</span><span class="infoaddress">{{d[1].area}}</span><span
                    class="infoprice">￥{{d[1].bid_price}}</span></div>
        {{# } }}
        {{# if(d[2]){ }}
        <div><i class="icon iconfont icon-mobile"></i><span class="infoname">{{d[2].nickname}}</span><span
                    class="infostatus">出局</span><span class="infoaddress">{{d[2].area}}</span><span
                    class="infoprice">￥{{d[2].bid_price}}</span></div>
        {{# } }}
        {{# }else{ }}
        <div style="text-align: center;color: #EF1544;">暂无人出价</div>
        {{# } }}
        @endverbatim
    </script>
    <script>

        $.get("/h5/evaluate", {product_id: "{{ $detail['product_id'] }}"}, function (d) {
            d = d.data;
            if (d !== null) {
                var gettpl = document.getElementById('lateauc2').innerHTML;
                laytpl(gettpl).render(d, function (html) {
                    $("#selfing").append(html);
                });
            } else {
                $("#no-data").remove();
                $("#selfing").append("<p id='no-data' style='text-align: center;margin-top: 5px;'>无更多数据</p>");
            }
        }, "json");


        window.onbeforeunload = function () { //检测是关闭了浏览器页面,关闭后访问的请求量减1，当访问量为0时，不发推送消息
            $.get("/h5/product/cancel-visit", {period_id: "{{ $detail['id'] }}"}, function (d) {

            }, "json");
        };

        @if($detail['period_status']==1)
        $('.auced').show();
        $('.aucing').hide();
        @endif

        connect();

        // 连接服务端
        function connect() {
            // 创建websocket
            @if(PHP_OS == 'WINNT') //本地测试专用
            //   ws = new WebSocket("ws://wph.ouyym.com/ws");
            ws = new WebSocket("ws://122.114.63.148:8082");
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

        //前往最新的一期
        function nextPeriod(product_id) {
            $.get("/h5/period/next-period", {product_id: product_id}, function (d) {
                if (d.code == 0) {
                    d = d.data;
                    location.href = '/h5/product/detail?period_id=' + d.period_id
                }
            }, "json");
        }

        var noticeflag = 1;
        var finalmid = 8;

        function begin() {
            var begintime = $("#sytime").attr('sytime');
            var txt = '';
            getinfo();
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
                $("#sytime").text(txt);
                begintime = begintime - 1;
                $("#sytime").attr('sytime', begintime);
            } else {
                var endflag = $('#endflag').val();
                if (endflag == 1) {
                    $('.swiper-slide').addClass('endimg');
                    $('.auced').show();
                    $('.aucing').hide();
                    $('.downtime').css('color', 'black');
                    $('#sytxt').text('竞拍已结束');
                    $('#sytime').text('00:00:00');
                    $('#sytime').attr('sytime', 0);
                }
            }
        }

        function getinfo() {
            // 当有消息时根据消息类型显示不同信息
            ws.onmessage = function (event) {
                var data = JSON.parse(event.data)
                if (data.period_id == "{{ $detail['id'] }}") {
                    if (data.content[0].status == "1") {
                        $('#endflag').val(1);
                    } else if (data.content[0].status == "0") {
                        if (data.content[0].bid_price) {
                            $('#prtxt1').text(data.content[0].bid_price);
                        } else {
                            $('#prtxt1').text('0.00');
                        }
//                                $('#prtxt2').text(data.prtxt);
//                                $('#finalname').text(data.finalname);
                        $('#auctimes').text(data.f);
                        $('#sytime').attr('sytime', data.content[0].countdown);
                        var gettpl = document.getElementById('lists').innerHTML;
                        laytpl(gettpl).render(data.content, function (html) {
                            $("#infolist").empty();
                            $("#infolist").append(html);
                        });
//                                if (data.auctimes > 0) {
//                                    $('.havelist').show();
//                                    $('.nolist').hide();
//                                }
                        //  自动出价剩余次数大于0，且是当前用户时，弹出出价成功消息
                        if (data.content[0].remain_times > 1 &&
                            data.content[0].user_id == "{{ !empty(session('user_info'))?json_decode(session('user_info'))->id:'木有' }}") {
                            noticeflag = 0;
                            $.toast('自动出价成功');
                            var surtimes = $('#surtimes').val();
                            $('#surtimes').val(data.content[0].total_times);
                            $('#surtime').text(data.content[0].remain_times - 1);

                        } else {
                            if (data.content[0].remain_times == 1 &&
                                data.content[0].user_id == "{{ !empty(session('user_info'))?json_decode(session('user_info'))->id:'木有' }}") {
                                $('#surtimes').val(0);
                                $('.offer').css('background-color', '#ed414a');
                                $('#offertext').text('出价');
                                $('.selnum').show();
                                $('.noselnum').hide();
                                noticeflag = 0;
                            }
                        }
                    }
                }
            };
        }

        if ("{{ $proxy['remain_times'] }}" > 0) {
            $('#surtime').text({{ $proxy['remain_times'] }});
            $('.offer').css('background-color', '#999999');
            $('#offertext').text('竞拍中');
            $('.selnum').hide();
            $('.noselnum').show();
        }

        $(function () {
            //计算剩余时间
            get_late();
            var tt = setInterval("begin()", 1000);
            $('.offer').click(function () {
                var surtimes = $('#surtimes').val();
                if (surtimes < 1) {
                    var offtimes = $('#aucnum').val();
                    var goodsid = "{{ $detail['product_id'] }}";
                    var perid = "{{ $detail['id'] }}";
                    if (offtimes.length == 0 || goodsid.length == 0 || perid.length == 0) {
                        $.alert('页面错误，请刷新重试');
                    } else {
                        $.post("/h5/bid/bidding", {
                            times: offtimes,
                            product_id: goodsid,
                            period_id: perid,
                        }, function (d) {
                            d = d.data
                            if (d.status == 10 || d.status == 20) {
                                $.toast("出价成功");

                                $('#auccoin').text(d.used_real_bids);
                                $('#givecoin').text(d.used_gift_bids);

                                if (offtimes != 1) {
                                    noticeflag = 0;
                                    $('#surtimes').val(d.total_times);
                                    $('#surtime').text(d.total_times);
                                    $('.offer').css('background-color', '#999999');
                                    $('#offertext').text('竞拍中');
                                    $('.selnum').hide();
                                    $('.noselnum').show();
                                }
                            } else if (d.status == 100) { //跳转到登入
                                location.href = "/h5/user/login-view";
                            } else if (d.status == 40) {  //表示自动竞拍出价成功
                                $.toast('您已出价,请等会儿再出价吧！');
                            } else if (d.status == 30) {  //需要进行充值
                                $.alert('您的余额不足', function () {
                                    location.href = "/h5/pay/recharge-center";
                                });
                            } else {
                                $.toast("未知错误");
                            }
                        }, "json");
                    }
                }
            });

            $('.content').click(function () {
                $('.tool_tips').removeClass('pop');
            });
        });

        function showtip() {
            $('.tool_tips').addClass('pop');
        }

        function changenum(aucnum) {
            $('.qunum').each(function () {
                $(this).removeClass('focus');
            });
            var num = parseInt($('#aucnum').val());
            if (num < 1) {
                num = 1;
                $('.tool_tips').removeClass('pop');
            }
            $('#aucnum').val(num);
            $('#rednum').text(num);
            if (num == 10) {
                $('.qu1').addClass('focus');
            } else if (num == 20) {
                $('.qu2').addClass('focus');
            } else if (num == 50) {
                $('.qu3').addClass('focus');
            } else if (num == 66) {
                $('.qu4').addClass('focus');
            }
        }

        function addnum(flag) {
            $('.qunum').each(function () {
                $(this).removeClass('focus');
            });
            var num = parseInt($('#aucnum').val());
            if (flag) {
                num += 1;
            } else {
                num -= 1;
            }
            if (num > 1) {
                $('.tool_tips').addClass('pop');
            }
            if (num < 1) {
                num = 1;
                $('.tool_tips').removeClass('pop');
            }
            $('#aucnum').val(num);
            $('#rednum').text(num);
            if (num == 10) {
                $('.qu1').addClass('focus');
            } else if (num == 20) {
                $('.qu2').addClass('focus');
            } else if (num == 50) {
                $('.qu3').addClass('focus');
            } else if (num == 66) {
                $('.qu4').addClass('focus');
            }
        }

        $('.qunum').click(function () {
            $('.qunum').each(function () {
                $(this).removeClass('focus');
            });
            $(this).addClass('focus');
            var num = $(this).attr('num');
            $('#aucnum').val(num);
            $('#rednum').text(num);
        });

        function get_late() {
            $.post("/?i=37&c=entry&m=_fastauction&p=goods&ac=goods&do=getlate&goodsid=17", {}, function (d) {
                if (d.length != '') {
                    var gettpl = document.getElementById('lateauc').innerHTML;
                    laytpl(gettpl).render(d, function (html) {
                        $("#latelist").append(html);
                    });
                }
            }, "json");
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

        function code() {
            if ("2" == 2) {
                $('#customermask').show();
                $('#customerdia').show();
            }
        }

        $("#customermask").click(function () {
            $('#customermask').hide();
            $('#customerdia').hide();
        });

    </script>
    <style>
        .aucing {
            display: flex;
            -webkit-box-flex: 5.5;
            flex: 5.5;
        }

        .tool_tips {
            position: absolute;
            bottom: 2.9rem;
            left: 21.5%;
            width: 50%;
            height: 3rem;
            line-height: 1.2rem;
            border-radius: .5rem;
            border: solid 1px #ccc;
            background: rgba(240, 240, 240, 0.9);
            font-size: 14px;
            text-align: center;
            color: #333;
            opacity: 0;
            z-index: 20;
            box-shadow: 0 0.05rem 0.08rem rgba(0, 0, 0, 0.15);
            -webkit-transition: all .1s;
            transition: all .1s;
            -webkit-transform: scale(0);
            transform: scale(0);
            -webkit-transform-origin: 50% 120%;
            transform-origin: 50% 120%
        }

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

        .tool_tips:after {
            content: "";
            position: absolute;
            display: block;
            width: .6rem;
            height: .6rem;
            background: rgba(240, 240, 240, 0.9);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            bottom: -0.4rem;
            left: 50%;
            margin-left: -.15rem;
            border: solid 0 #ccc;
            border-width: 0 1px 1px 0
        }

        .tool_tips.pop {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1)
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

        .numbersel {
            width: 50%;
            border-top: 1px solid #dfdfdf;
            color: #999999;
            text-align: center;
        }

        .offer {
            width: calc(50%);
            background: #ed414a;
            text-align: center;
            color: #fff;
        }

        .auced {
            width: calc(85%);
            background: #ed414a;
            text-align: center;
            color: #fff;
            float: right;
        }

        .botcelly { /*height:50px;*/
            position: relative;
            display: inline-block;
        }
    </style>

    @parent
@stop

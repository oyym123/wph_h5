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
                <span class="news"
                      onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=news&amp;ac=news&amp;do=news'"><i
                            style="font-size: 23px;" class="icon iconfont icon-comment"></i></span>
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
                                <div class="swiper-slide"
                                     data-swiper-slide-index="{{ $k }}" style="width: 360px;height:50%"><img
                                            src="{{ $v }}">
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
                                <span style="color:#000;">  {{ $detail['collection_users_count'] }}</span> 人 </span>
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
                                    id="auctimes">{{ $detail['bid_users_count'] }}</span>条</span><span
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
                            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=store&amp;ac=merchant&amp;do=auctionhouse&amp;auchouseid=1"
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


                            <div class="wrap">
                                <div class="mui-content mui-scroll-wrapper" id="mainContainer" data-pullrefresh="1">
                                    <div class="mui-pull-top-pocket">
                                        <div class="mui-pull">
                                            <div class="mui-pull-loading mui-icon mui-icon-pulldown"></div>
                                            <div class="mui-pull-caption">下拉可以刷新</div>
                                        </div>
                                    </div>
                                    <div class="mui-scroll"
                                         style="transform: translate3d(0px, -8px, 0px) translateZ(0px); transition-duration: 0ms;">
                                        <header class="ui-navigation"><a class="icon-back mui-action-back"></a>晒单<a href="share_my.html"
                                                                                                                    class="icon-toshare"></a>
                                        </header>
                                        <div class="share_list" id="J-shareList">
                                            <div class="share_li">
                                                <div class="cover"><img
                                                            src="https://qnimg.gogobids.com/avatar/b1b0aeb05bae50bb015bae5498c23e58?imageView2/1/w/90/h/90">
                                                </div>
                                                <div class="title"><span class="name">好运来哟</span><span class="time">2019-03-29 00:17:21</span></div>
                                                <div class="share_info" data-id="50511"><h3 class="hidelong">泰福高 3层304不锈钢保温饭盒1.5L 颜色随机</h3>
                                                    <div class="desc">非常满意 设计完美合理 非常方便</div>
                                                    <div class="imgs"><img
                                                                src="https://qnimg.gogobids.com/FoSZbaYAweNts9nn39QzJx6t8BEp?imageView2/1/w/150/h/150"><img
                                                                src="https://qnimg.gogobids.com/FjcyYl4VEJu-E-7sKw8OQN8LsFid?imageView2/1/w/150/h/150">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="share_li">
                                                <div class="cover"><img
                                                            src="https://qnimg.gogobids.com/avatar/b1b0aeb05b5c15fa015b5c1e800b09bf?imageView2/1/w/90/h/90">
                                                </div>
                                                <div class="title"><span class="name">睡神</span><span class="time">2019-03-29 00:14:02</span></div>
                                                <div class="share_info" data-id="50496"><h3 class="hidelong">飞利浦 电动剃须刀 S5082/61</h3>
                                                    <div class="desc">宝贝很满意，是正品，物流神速赞一个</div>
                                                    <div class="imgs"><img
                                                                src="https://qnimg.gogobids.com/Fv4dMhRS_Q9xWIVDGzbqckrpwa1o?imageView2/1/w/150/h/150"><img
                                                                src="https://qnimg.gogobids.com/FjVAxu-RO8Pjr8xi8xfQOVd519Ek?imageView2/1/w/150/h/150">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mui-pull-bottom-pocket mui-block mui-visibility">
                                            <div class="mui-pull">
                                                <div class="mui-pull-loading mui-icon mui-spinner mui-hidden"></div>
                                                <div class="mui-pull-caption mui-pull-caption-down"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mui-scrollbar mui-scrollbar-vertical" style="transition-duration: 500ms; opacity: 0;">
                                        <div class="mui-scrollbar-indicator"
                                             style="transition-duration: 0ms; display: block; height: 273px; transform: translate3d(0px, 1px, 0px) translateZ(0px);"></div>
                                    </div>
                                </div>
                            </div>


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
                   style="border-right:1px solid #dfdfdf; display: none; ">
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
                                                                        id="aucnum" type="tel" value="5"> </span>
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
                        <p style="font-size: 12px;position: relative;top: -2px;">1拍币/次</p>
                        <input id="surtimes" type="hidden" value="0">
                    </div>
                </div>
                <div class="auced" style="display: none;"
                     onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=detail&amp;id=17'">
                    <div>前往下期</div>
                </div>
            </div>
        </div>
    </div>
    <div class="diy-layer external">
        <div class="weui_mask" id="customermask" style="display: none;">
        </div>
        <div class="weui_dialog" id="customerdia" style="display: none;">
            <p class="dialog-title">长按识别二维码</p>
            <div class="img-box">
                <img src=""
                     style="max-width:100%">
            </div>
            <span class="vux-close">
	 </span>
        </div>
    </div>
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
        {{# if(d.data[0]){ }}
        <div style="color: #EF1544;"><i class="icon iconfont icon-mobile"></i><span
                    class="infoname">{{d.data[0].nickname}}</span><span class="infostatus">领先</span><span
                    class="infoaddress">{{d.data[0].area}}</span><span class="infoprice">￥{{d.data[0].bid_price}}</span>
        </div>
        {{# if(d.data[1]){ }}
        <div><i class="icon iconfont icon-mobile"></i><span class="infoname">{{d.data[1].nickname}}</span><span
                    class="infostatus">出局</span><span class="infoaddress">{{d.data[1].area}}</span><span
                    class="infoprice">￥{{d.data[1].bid_price}}</span></div>
        {{# } }}
        {{# if(d.data[2]){ }}
        <div><i class="icon iconfont icon-mobile"></i><span class="infoname">{{d.data[2].nickname}}</span><span
                    class="infostatus">出局</span><span class="infoaddress">{{d.data[2].area}}</span><span
                    class="infoprice">￥{{d.data[2].bid_price}}</span></div>
        {{# } }}
        {{# }else{ }}
        <div style="text-align: center;color: #EF1544;">暂无人出价</div>
        {{# } }}
        @endverbatim
    </script>
    <script>
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
            $.post("/h5/bid/newest-bid", {periods: "{{ $detail['id'] }}"}, function (data) {
                console.log(data);
                if (data.f == "1") {
                    $('#endflag').val(1);
                } else if (data.f == "0") {
                    if (finalmid != data.finalmid) {
                        finalmid = data.finalmid;
                        if (data.c) {
                            $('#prtxt1').text(data.c);
                        } else {
                            $('#prtxt1').text('0.00');
                        }
                        $('#prtxt2').text(data.prtxt);
                        $('#finalname').text(data.finalname);
                        $('#auctimes').text(data.f);
                        $('#sytime').attr('sytime', data.countdown);
                        var gettpl = document.getElementById('lists').innerHTML;
                        laytpl(gettpl).render(data, function (html) {
                            $("#infolist").empty();
                            $("#infolist").append(html);
                        });
                        if (data.auctimes > 0) {
                            $('.havelist').show();
                            $('.nolist').hide();
                        }
                        if (data.finalmid == "") {
                            if (noticeflag) {
                                noticeflag = 0;
                                $.toast('自动出价成功');
                                var surtimes = $('#surtimes').val();
                                var newsurtimes = surtimes - 1;
                                $('#surtimes').val(newsurtimes);
                                $('#surtime').text(newsurtimes);
                                if (newsurtimes < 1) {
                                    $('.offer').css('background-color', '#ed414a');
                                    $('#offertext').text('出价');
                                    $('.selnum').show();
                                    $('.noselnum').hide();
                                }
                            }
                        } else {
                            noticeflag = 1;
                        }
                    }
                }
            }, "json");
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
                        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=order&ac=auction&do=offer", {
                            offtimes: offtimes,
                            goodsid: goodsid,
                            perid: perid,
                        }, function (d) {
                            if (d.result == 1) {
                                $.toast("出价成功");
                                noticeflag = 0;
                                $('#auccoin').text(d.auc);
                                $('#givecoin').text(d.give);
                                if (d.newsurtime) {
                                    $('#surtimes').val(d.newsurtime);
                                    $('#surtime').text(d.newsurtime);
                                    $('.offer').css('background-color', '#999999');
                                    $('#offertext').text('竞拍中');
                                    $('.selnum').hide();
                                    $('.noselnum').show();
                                }
                            } else if (d.result == 3) {
                                location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=signin";
                            } else if (d.result == 2) {
                                $.toast(d.msg);
                            } else if (d.result == 4) {
                                $.alert(d.msg, function () {
                                    location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=recharge";
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
            $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getlate&goodsid=17", {}, function (d) {
                if (d.length != '') {
                    var gettpl = document.getElementById('lateauc').innerHTML;
                    laytpl(gettpl).render(d, function (html) {
                        $("#latelist").append(html);
                    });
                }
            }, "json");
        }

        function addcollection(e) {
            var id = "{{ $detail['product_id'] }}";
            $.ajax({
                cache: true,
                type: "POST",
                url: "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=collection",
                data: {
                    'id': id,
                },
                success: function (data) {
                    $('.collent').hide();
                    $('.canclcollent').show();
                }
            });
        }

        function cancelcollection() {
            var id = "17";
            $.ajax({
                cache: true,
                type: "POST",
                url: "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=cancelcollection",
                data: {
                    'id': id,
                },
                success: function (data) {
                    $('.collent').show();
                    $('.canclcollent').hide();
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
            width: calc(70%);
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
    <script>
        wx.ready(function () {
            var shareData = {
                title: "Apple iPhone X 64GB 颜色随机",
                desc: "[粉丝昵称]倾力推荐，赶快来领取！",
                link: "",
                imgUrl: "http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/kF2nPnXnYxmWk2kMgxr1RFwM923rR4.png",
            };
            //分享朋友
            wx.onMenuShareAppMessage({
                title: shareData.title,
                desc: shareData.desc,
                link: shareData.link,
                imgUrl: shareData.imgUrl,
                trigger: function (res) {
                },
                success: function (res) {
                    shareover();
                },
                cancel: function (res) {
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            //朋友圈
            wx.onMenuShareTimeline({
                title: shareData.title,
                link: shareData.link,
                imgUrl: shareData.imgUrl,
                trigger: function (res) {
                },
                success: function (res) {
                    shareover();
                },
                cancel: function (res) {
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        });
    </script>
    @parent
@stop

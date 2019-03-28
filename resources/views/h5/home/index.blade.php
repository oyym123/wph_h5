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
                <div class="col-33"
                     onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=detail&amp;id=13&amp;perid=39009'">
                    <div class="lately">
								<span class="endimg">
									<img class="endlogo"
                                         src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/MhWS4KKskzzcKAk24jkYSeqcYjEz2c.png">
								</span>
                        <p class="endmoney">￥77.40</p>
                        <p class="endmember" style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                            【英国卫裤】代理</p>
                    </div>
                </div>
                <div class="col-33"
                     onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=detail&amp;id=9&amp;perid=39008'">
                    <div class="lately">
								<span class="endimg">
									<img class="endlogo"
                                         src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xN81zXokjXNeLGRNAC9VcxXfnx100k.png">
								</span>
                        <p class="endmoney">￥87.00</p>
                        <p class="endmember" style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                            美美琴15807867833</p>
                    </div>
                </div>
                <div class="col-33"
                     onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=goods&amp;ac=goods&amp;do=detail&amp;id=10&amp;perid=39007'">
                    <div class="lately">
								<span class="endimg">
									<img class="endlogo"
                                         src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/w7XmJw8xMGkut2Azu9mPxTgjmjzP6P.png">
								</span>
                        <p class="endmoney">￥97.50</p>
                        <p class="endmember" style=" overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                            合拾⑩</p>
                    </div>
                </div>
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
                <a href="#goodslist" class="tab-link button active" onclick="get_goods()">热拍商品</a>
                <a href="#selfing" class="tab-link button" onclick="get_goods(2)">我正在拍</a>
                <a href="#collection" class="tab-link button " onclick="get_goods(3)">我的收藏</a>
            </div>
            <div class="tabs">
                <div id="goodslist" class="tab active">
                    <div class="" id="listgoods" style="padding-left: 0;padding-right: 0;position: relative;">
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="7"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="7" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(7)"><span class="goodimg" id="logo38936">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/N91ZRoJJ71O8oTjJMVe1eeeL4Jjj99.png">    </span>
                                <p id="sy38936" sytime="5" perid="38936" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end38936"> <input type="hidden" value="278"
                                                                                      id="mid38936">
                                <p class="goodmoney tipout" id="bg38936">￥<span id="money38936">1386.00</span></p>
                                <p id="name38936" class="goodmember">优能</p>    <span class="toauc"
                                                                                     id="perbutton38936">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="17" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="17"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(17)"><span class="goodimg" id="logo38867">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/kF2nPnXnYxmWk2kMgxr1RFwM923rR4.png">    </span>
                                <p id="sy38867" sytime="10" perid="38867" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end38867"> <input type="hidden" value="263"
                                                                                      id="mid38867">
                                <p class="goodmoney tipout" id="bg38867">￥<span id="money38867">2591.40</span></p>
                                <p id="name38867" class="goodmember">龙海菌业</p>    <span class="toauc"
                                                                                       id="perbutton38867">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="18" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="18"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(18)"><span class="goodimg" id="logo38894">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/JkV20zARKqBd2buaDDmVbu7VdJ8cdc.png">    </span>
                                <p id="sy38894" sytime="13" perid="38894" class="downtime">00:00:14</p>    <input
                                        type="hidden" value="0" id="end38894"> <input type="hidden" value="481"
                                                                                      id="mid38894">
                                <p class="goodmoney tipout" id="bg38894">￥<span id="money38894">1533.50</span></p>
                                <p id="name38894" class="goodmember">艾你依旧</p>    <span class="toauc"
                                                                                       id="perbutton38894">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="19" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="19"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(19)"><span class="goodimg" id="logo13808">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/rQqxS5Gzw8bbq7wK70qJu10Xx6G70C.png">    </span>
                                <p id="sy13808" sytime="-33767" perid="13808" class="downtime">00:00:00</p><input
                                        type="hidden" value="0" id="end13808"> <input type="hidden" value="4816"
                                                                                      id="mid13808">
                                <p class="goodmoney tipout" id="bg13808">￥<span id="money13808">2021.40</span></p>
                                <p id="name13808" class="goodmember">凌枫</p>    <span class="toauc"
                                                                                     id="perbutton13808">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="20" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="20"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(20)"><span class="goodimg" id="logo38992">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Edyv5a2bTAFLdY0aGtzRTAl6buO02D.png">    </span>
                                <p id="sy38992" sytime="10" perid="38992" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end38992"> <input type="hidden" value="449"
                                                                                      id="mid38992">
                                <p class="goodmoney tipout" id="bg38992">￥<span id="money38992">344.70</span></p>
                                <p id="name38992" class="goodmember">＠_＠</p>    <span class="toauc"
                                                                                      id="perbutton38992">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="21" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="21"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(21)"><span class="goodimg" id="logo39012">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/c16FTm1GVftTmmTgmTgZTO43Uj3T2m.png">    </span>
                                <p id="sy39012" sytime="5" perid="39012" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end39012"> <input type="hidden" value="279"
                                                                                      id="mid39012">
                                <p class="goodmoney tipout" id="bg39012">￥<span id="money39012">42.90</span></p>
                                <p id="name39012" class="goodmember"></p>    <span class="toauc"
                                                                                   id="perbutton39012">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="1"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="1" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(1)"><span class="goodimg" id="logo13551">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/pAwP8t3AqiozPm48jfpO8pq3fCJqbz.png">    </span>
                                <p id="sy13551" sytime="-9813" perid="13551" class="downtime">00:00:00</p>    <input
                                        type="hidden" value="0" id="end13551"> <input type="hidden" value="27001"
                                                                                      id="mid13551">
                                <p class="goodmoney tipout" id="bg13551">￥<span id="money13551">1666.90</span></p>
                                <p id="name13551" class="goodmember">梧桐</p>    <span class="toauc"
                                                                                     id="perbutton13551">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="22" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="22"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(22)"><span class="goodimg" id="logo39011">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/RO4n593u53N5o2522Now8esn332WN2.png">    </span>
                                <p id="sy39011" sytime="10" perid="39011" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end39011"> <input type="hidden" value="280"
                                                                                      id="mid39011">
                                <p class="goodmoney tipout" id="bg39011">￥<span id="money39011">56.40</span></p>
                                <p id="name39011" class="goodmember">大唐</p>    <span class="toauc"
                                                                                     id="perbutton39011">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="23" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="23"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(23)"><span class="goodimg" id="logo26089">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/HDUOxwb3b3Zbj3beUu93O3bbt9g9b3.png">    </span>
                                <p id="sy26089" sytime="-119168" perid="26089" class="downtime">00:00:00</p><input
                                        type="hidden" value="0" id="end26089"> <input type="hidden" value="27022"
                                                                                      id="mid26089">
                                <p class="goodmoney tipout" id="bg26089">￥<span id="money26089">919.40</span></p>
                                <p id="name26089" class="goodmember">137****2759</p>    <span class="toauc"
                                                                                              id="perbutton26089">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="24" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="24"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(24)"><span class="goodimg" id="logo39006">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/m8337U47Y1F47YuqC43UIsDuQuIyZd.png">    </span>
                                <p id="sy39006" sytime="9" perid="39006" class="downtime">00:00:10</p>    <input
                                        type="hidden" value="0" id="end39006"> <input type="hidden" value="429"
                                                                                      id="mid39006">
                                <p class="goodmoney tipout" id="bg39006">￥<span id="money39006">131.10</span></p>
                                <p id="name39006" class="goodmember">张明凤</p>    <span class="toauc"
                                                                                      id="perbutton39006">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="25" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="25"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(25)"><span class="goodimg" id="logo38961">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/V444Y924bWu4olAb89wl44wn0OY929.png">    </span>
                                <p id="sy38961" sytime="8" perid="38961" class="downtime">00:00:09</p>    <input
                                        type="hidden" value="0" id="end38961"> <input type="hidden" value="397"
                                                                                      id="mid38961">
                                <p class="goodmoney tipout" id="bg38961">￥<span id="money38961">984.50</span></p>
                                <p id="name38961" class="goodmember">克里夫兰~骑士</p>    <span class="toauc"
                                                                                          id="perbutton38961">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="26" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="26"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(26)"><span class="goodimg" id="logo38984">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/DZ6RhKYhlLBBezNYblrL666c6jNL66.png">    </span>
                                <p id="sy38984" sytime="10" perid="38984" class="downtime">00:00:04</p>    <input
                                        type="hidden" value="0" id="end38984"> <input type="hidden" value="302"
                                                                                      id="mid38984">
                                <p class="goodmoney tipout" id="bg38984">￥<span id="money38984">515.70</span></p>
                                <p id="name38984" class="goodmember">华</p>    <span class="toauc"
                                                                                    id="perbutton38984">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="16" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="16"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(16)"><span class="goodimg" id="logo38907">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/F9mIZiFiuFUoo9XsegduWxUFY96SZX.png">    </span>
                                <p id="sy38907" sytime="5" perid="38907" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end38907"> <input type="hidden" value="324"
                                                                                      id="mid38907">
                                <p class="goodmoney tipout" id="bg38907">￥<span id="money38907">1913.50</span></p>
                                <p id="name38907" class="goodmember">嗯</p>    <span class="toauc"
                                                                                    id="perbutton38907">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="15" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="15"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(15)"><span class="goodimg" id="logo39001">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/f42zvyX547xYLU5zvvhuoIN8y48i88.png">    </span>
                                <p id="sy39001" sytime="6" perid="39001" class="downtime">00:00:07</p>    <input
                                        type="hidden" value="0" id="end39001"> <input type="hidden" value="347"
                                                                                      id="mid39001">
                                <p class="goodmoney tipout" id="bg39001">￥<span id="money39001">204.60</span></p>
                                <p id="name39001" class="goodmember">相信自己</p>    <span class="toauc"
                                                                                       id="perbutton39001">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="14" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="14"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(14)"><span class="goodimg" id="logo38882">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/oPMk5ZTkiYiGkPI2mjmYkhG78emEM4.png">    </span>
                                <p id="sy38882" sytime="10" perid="38882" class="downtime">00:00:03</p>    <input
                                        type="hidden" value="0" id="end38882"> <input type="hidden" value="445"
                                                                                      id="mid38882">
                                <p class="goodmoney tipout" id="bg38882">￥<span id="money38882">2363.10</span></p>
                                <p id="name38882" class="goodmember">时光无声@.</p>    <span class="toauc"
                                                                                         id="perbutton38882">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="2"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="2" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(2)"><span class="goodimg" id="logo39010">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/QwqYfYfRKKGKFgk4wzKgGRQKLfMBOF.png">    </span>
                                <p id="sy39010" sytime="13" perid="39010" class="downtime">00:00:14</p>    <input
                                        type="hidden" value="0" id="end39010"> <input type="hidden" value="386"
                                                                                      id="mid39010">
                                <p class="goodmoney tipout" id="bg39010">￥<span id="money39010">53.60</span></p>
                                <p id="name39010" class="goodmember">学友</p>    <span class="toauc"
                                                                                     id="perbutton39010">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="3"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="3" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(3)"><span class="goodimg" id="logo38978">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/NFYEZld2M7dI9pT6ID4eFps4zc7Hsl.png">    </span>
                                <p id="sy38978" sytime="4" perid="38978" class="downtime">00:00:05</p>    <input
                                        type="hidden" value="0" id="end38978"> <input type="hidden" value="337"
                                                                                      id="mid38978">
                                <p class="goodmoney tipout" id="bg38978">￥<span id="money38978">598.50</span></p>
                                <p id="name38978" class="goodmember">雨过天晴</p>    <span class="toauc"
                                                                                       id="perbutton38978">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="4"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="4" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(4)"><span class="goodimg" id="logo38998">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/dWlWvUmMwMXxiinOX9M294x4YwiwMQ.png">    </span>
                                <p id="sy38998" sytime="8" perid="38998" class="downtime">00:00:09</p>    <input
                                        type="hidden" value="0" id="end38998"> <input type="hidden" value="343"
                                                                                      id="mid38998">
                                <p class="goodmoney tipout" id="bg38998">￥<span id="money38998">248.10</span></p>
                                <p id="name38998" class="goodmember">AAAAAA顺其自然</p>    <span class="toauc"
                                                                                             id="perbutton38998">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="5"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="5" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(5)"><span class="goodimg" id="logo11909">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Ocp9jz53P4IO42EeZpdtAoD8PDPDJ8.png">    </span>
                                <p id="sy11909" sytime="-243079" perid="11909" class="downtime">00:00:00</p><input
                                        type="hidden" value="0" id="end11909"> <input type="hidden" value="27009"
                                                                                      id="mid11909">
                                <p class="goodmoney tipout" id="bg11909">￥<span id="money11909">2829.40</span></p>
                                <p id="name11909" class="goodmember">飞翔</p>    <span class="toauc"
                                                                                     id="perbutton11909">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="6"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="6" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(6)"><span class="goodimg" id="logo38920">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xpCwis9SSawWoBBwboWwIwOWsSc9bw.png">    </span>
                                <p id="sy38920" sytime="10" perid="38920" class="downtime">00:00:04</p>    <input
                                        type="hidden" value="0" id="end38920"> <input type="hidden" value="339"
                                                                                      id="mid38920">
                                <p class="goodmoney tipout" id="bg38920">￥<span id="money38920">1691.70</span></p>
                                <p id="name38920" class="goodmember">冰山上的来客</p>    <span class="toauc"
                                                                                         id="perbutton38920">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="8"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="8" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(8)"><span class="goodimg" id="logo38993">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/KccQH991wNrxQxZ6WX96BAhNnB2H22.png">    </span>
                                <p id="sy38993" sytime="6" perid="38993" class="downtime">00:00:07</p>    <input
                                        type="hidden" value="0" id="end38993"> <input type="hidden" value="263"
                                                                                      id="mid38993">
                                <p class="goodmoney tipout" id="bg38993">￥<span id="money38993">318.60</span></p>
                                <p id="name38993" class="goodmember">龙海菌业</p>    <span class="toauc"
                                                                                       id="perbutton38993">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span id="9"
                                                                                                              onclick="cancelcollection(this)"
                                                                                                              class="scbutton ed cancelcollection"
                                                                                                              style="display: none;">     已收藏    </span>
                                <span id="9" class="scbutton addcollection" onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(9)"><span class="goodimg" id="logo39014">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xN81zXokjXNeLGRNAC9VcxXfnx100k.png">    </span>
                                <p id="sy39014" sytime="6" perid="39014" class="downtime">00:00:07</p>    <input
                                        type="hidden" value="0" id="end39014"> <input type="hidden" value="270"
                                                                                      id="mid39014">
                                <p class="goodmoney tipout" id="bg39014">￥<span id="money39014">8.00</span></p>
                                <p id="name39014" class="goodmember">一只羊</p>    <span class="toauc"
                                                                                      id="perbutton39014">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="10" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="10"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(10)"><span class="goodimg" id="logo39013">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/w7XmJw8xMGkut2Azu9mPxTgjmjzP6P.png">    </span>
                                <p id="sy39013" sytime="4" perid="39013" class="downtime">00:00:05</p>    <input
                                        type="hidden" value="0" id="end39013"> <input type="hidden" value="468"
                                                                                      id="mid39013">
                                <p class="goodmoney tipout" id="bg39013">￥<span id="money39013">14.90</span></p>
                                <p id="name39013" class="goodmember">李慧子</p>    <span class="toauc"
                                                                                      id="perbutton39013">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="12" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="12"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(12)"><span class="goodimg" id="logo38982">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/eX1WvKwc3I7kffK70hU1P0Fup0CqC0.png">    </span>
                                <p id="sy38982" sytime="92" perid="38982" class="downtime">00:01:33</p>    <input
                                        type="hidden" value="0" id="end38982"> <input type="hidden" value="357"
                                                                                      id="mid38982">
                                <p class="goodmoney tipout" id="bg38982">￥<span id="money38982">75.40</span></p>
                                <p id="name38982" class="goodmember">昆仑</p>    <span class="toauc"
                                                                                     id="perbutton38982">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="13" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="13"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(13)"><span class="goodimg" id="logo39015">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/MhWS4KKskzzcKAk24jkYSeqcYjEz2c.png">    </span>
                                <p id="sy39015" sytime="5" perid="39015" class="downtime">00:00:06</p>    <input
                                        type="hidden" value="0" id="end39015"> <input type="hidden" value="285"
                                                                                      id="mid39015">
                                <p class="goodmoney tipout" id="bg39015">￥<span id="money39015">7.40</span></p>
                                <p id="name39015" class="goodmember">SJH</p>    <span class="toauc"
                                                                                      id="perbutton39015">参与竞拍</span>
                            </div>
                        </div>
                        <div class="gooddiv">
                            <div class="collection"><input type="hidden" name="cl" class="cl" value=""> <span
                                        id="27" onclick="cancelcollection(this)"
                                        class="scbutton ed cancelcollection"
                                        style="display: none;">     已收藏    </span> <span id="27"
                                                                                         class="scbutton addcollection"
                                                                                         onclick="addcollection(this)">     <i
                                            class="icon iconfont icon-add"></i>     收藏    </span></div>
                            <div onclick="togoods(27)"><span class="goodimg" id="logo38997">     <img
                                            class="goodlogo"
                                            src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/yFDdZsGhCQ5sqmofOUdfMuq1hHQUqm.png">    </span>
                                <p id="sy38997" sytime="7" perid="38997" class="downtime">00:00:08</p>    <input
                                        type="hidden" value="0" id="end38997"> <input type="hidden" value="414"
                                                                                      id="mid38997">
                                <p class="goodmoney tipout" id="bg38997">￥<span id="money38997">262.40</span></p>
                                <p id="name38997" class="goodmember">cici</p>    <span class="toauc"
                                                                                       id="perbutton38997">参与竞拍</span>
                            </div>
                        </div>
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

    {{--{{# for(var i = 0, len = d.data.length; i< len; i++){ }}--}}
    {{--<div class="gooddiv">--}}
    {{--<div class="collection">--}}
    {{--<input type="hidden" name="cl" class="cl" value="" />--}}
    {{--<span id="{{d.data[i].id}}" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" {{# if(d.data[i].id!=d.data[i].collection){ }} style="display: none;" {{# } }}>--}}
    {{--已收藏--}}
    {{--</span>--}}
    {{--<span id="{{d.data[i].id}}" class="scbutton addcollection" onclick="addcollection(this)"  {{# if(d.data[i].id==d.data[i].collection){ }} style="display: none;" {{# } }}>--}}
    {{--<i class="icon iconfont icon-add"></i>--}}
    {{--收藏--}}
    {{--</span>--}}
    {{--</div>--}}
    {{--<div onclick="togoods({{d.data[i].id}})">--}}
    {{--<span class="goodimg" id="logo{{d.data[i].nowperiods}}">--}}
    {{--<img class="goodlogo" src="{{ d.data[i].logo }}"/>--}}
    {{--</span>--}}
    {{--<p id="sy{{d.data[i].nowperiods}}" sytime='{{d.data[i].countdown}}' perid="{{d.data[i].nowperiods}}" class="downtime">00:00:00</p>--}}
    {{--<input type="hidden" value="0" id="end{{d.data[i].nowperiods}}"  />--}}
    {{--<input type="hidden" value="{{d.data[i].finalmid}}" id="mid{{d.data[i].nowperiods}}"  />--}}
    {{--<p class="goodmoney tipout"id="bg{{d.data[i].nowperiods}}" >￥<span id="money{{d.data[i].nowperiods}}">{{d.data[i].price}}</span></p>--}}
    {{--<p id="name{{d.data[i].nowperiods}}" class="goodmember">{{d.data[i].finalname}}</p>--}}
    {{--<span class="toauc" id="perbutton{{d.data[i].nowperiods}}">{{# if(d.data[i].businessflag == 0){ }}歇业中{{# }else{ }}参与竞拍{{# } }}</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--{{# } }}--}}
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
        get_goods();
        $('#J-deallistWrapper').vTicker();
        var tt = setInterval("begin()", 1000);
        if ($(window).height() > 700) {
            $('.txt').css('margin-top', '67%');
        }
    });
    function togoods(id) {
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=detail&id=" + id;
    }
    function get_goods(type) {

        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getgoods", {
            id: 0,
            type: type
        }, function (d) {
            if (d.data.length != '') {
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
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=signin"
    }
    function cancelcollection(obj) {
        var id = $(obj).attr('id');
        $.post(
            "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=cancelcollection",
            {id: id},
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
                $(this).text(txt);
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
                    $('#sy' + perid).text('00:00:00');
                    $('#sy' + perid).css('color', 'black');
                    $('#bg' + perid).css('color', 'black');
                    $('#logo' + perid).addClass('endimg');
                }
            }
        });
    }

    function getinfo() {
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getindexinfo", {}, function (data) {
            console.log(data);
            $.each(data, function (key, val) {
                if (val.finalmid == 'end') {
                    $('#end' + val.id).val(1);
                } else {
                    var nowmid = $('#mid' + val.id).val();
                    if (val.finalmid != nowmid) {
                        $('#mid' + val.id).val(val.finalmid);
                        $('#sy' + val.id).attr('sytime', val.countdown);
                        $('#name' + val.id).text(val.nickname);
                        $('#bg' + val.id).attr('class', 'goodmoney tipin');
                        var t = setTimeout(function () {
                            $('#bg' + val.id).attr('class', 'goodmoney tipout');
                        }, 20);
                        $('#money' + val.id).text(val.finalmoney);
                    }
                }
            });
        }, "json");
    }


</script>
<script>
    wx.ready(function () {
        var shareData = {
            title: "iPhoneX仅需一折即可到手，快来抢购！！！",
            desc: "[粉丝昵称]倾力推荐，赶快来领取！",
            link: "",
            imgUrl: "http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/JkV20zARKqBd2buaDDmVbu7VdJ8cdc.png",
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

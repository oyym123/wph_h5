@extends('layouts.h5')
@section('title')
    拍卖师主页
@stop
@section('title_head')
    拍卖师主页
@stop
@section('content')
        <div class="content native-scroll">
            <!--拍卖师详情-->
            <div class="list-block usercenter" style="margin:0;">
                <ul>
                    <li>
                        <a href="javascript:;" class="item-content">
                            <div class="item-media"><img style="height:2.3rem;width: 2.1rem;" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Ssi5joYs8IQixmSSs57g000Q7YWO8s.jpg"></div>
                            <div class="item-inner" style="margin-left: .3rem;">
                                <div class="item-title">
                                    <span class="aucname">廉东娜</span>
                                    <span class="aucdetail">中国执业拍卖师</span><br>
                                    <span class="auccode">拍卖师编号:2000707</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!--拍卖师标签-->
            <div style="padding: .75rem;">
                <div>
                    <i class="icon iconfont icon-roundcheck"></i><span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">持有中国拍卖师执业资格证书</span>
                </div>
                <div>
                    <i class="icon iconfont icon-roundcheck"></i><span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">担任5年以上拍卖师</span>
                </div>
                <div>
                    <i class="icon iconfont icon-roundcheck"></i><span style="display: inline-block;margin-left: 5px;position: relative;top: 1px;">现属机构：诺诺拍卖行</span>
                </div>
            </div>
            <!--拍卖师商品-->
            <div class="aucgoodsdiv">
                <div class="goodshead">
                    正在拍卖
                </div>
                <div>
                    <div id="goodslist" class="tab active">
                        <div class="" id="listgoods" style="padding-left: 0;padding-right: 0;position: relative;">    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="1" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="1" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(1)">    <span class="goodimg" id="logo13551">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/pAwP8t3AqiozPm48jfpO8pq3fCJqbz.png">    </span>    <p id="sy13551" sytime="-61959" class="downtime">00:00:00</p>    <input type="hidden" value="27043" id="mid13551">    <p class="goodmoney tipout" id="bg13551">￥<span id="money13551">1667.40</span></p>    <p id="name13551" class="goodmember">133****3118</p>    <span class="toauc" id="perbutton13551">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="2" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="2" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(2)">    <span class="goodimg" id="logo39174">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/QwqYfYfRKKGKFgk4wzKgGRQKLfMBOF.png">    </span>    <p id="sy39174" sytime="13" class="downtime">00:00:14</p>    <input type="hidden" value="395" id="mid39174">    <p class="goodmoney tipout" id="bg39174">￥<span id="money39174">500.90</span></p>    <p id="name39174" class="goodmember">梦瑶</p>    <span class="toauc" id="perbutton39174">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="3" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="3" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(3)">    <span class="goodimg" id="logo39202">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/NFYEZld2M7dI9pT6ID4eFps4zc7Hsl.png">    </span>    <p id="sy39202" sytime="6" class="downtime">00:00:07</p>    <input type="hidden" value="262" id="mid39202">    <p class="goodmoney tipout" id="bg39202">￥<span id="money39202">356.90</span></p>    <p id="name39202" class="goodmember">冰果荳荳</p>    <span class="toauc" id="perbutton39202">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="4" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="4" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(4)">    <span class="goodimg" id="logo39203">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/dWlWvUmMwMXxiinOX9M294x4YwiwMQ.png">    </span>    <p id="sy39203" sytime="3" class="downtime">00:00:04</p>    <input type="hidden" value="37" id="mid39203">    <p class="goodmoney tipout" id="bg39203">￥<span id="money39203">300.10</span></p>    <p id="name39203" class="goodmember">super</p>    <span class="toauc" id="perbutton39203">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="5" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="5" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(5)">    <span class="goodimg" id="logo11909">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Ocp9jz53P4IO42EeZpdtAoD8PDPDJ8.png">    </span>    <p id="sy11909" sytime="-493771" class="downtime">00:00:00</p>    <input type="hidden" value="27009" id="mid11909">    <p class="goodmoney tipout" id="bg11909">￥<span id="money11909">2829.40</span></p>    <p id="name11909" class="goodmember">飞翔</p>    <span class="toauc" id="perbutton11909">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="6" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="6" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(6)">    <span class="goodimg" id="logo39205">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xpCwis9SSawWoBBwboWwIwOWsSc9bw.png">    </span>    <p id="sy39205" sytime="8" class="downtime">00:00:09</p>    <input type="hidden" value="459" id="mid39205">    <p class="goodmoney tipout" id="bg39205">￥<span id="money39205">294.40</span></p>    <p id="name39205" class="goodmember">彬彬有礼</p>    <span class="toauc" id="perbutton39205">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="7" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="7" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(7)">    <span class="goodimg" id="logo39217">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/N91ZRoJJ71O8oTjJMVe1eeeL4Jjj99.png">    </span>    <p id="sy39217" sytime="8" class="downtime">00:00:09</p>    <input type="hidden" value="345" id="mid39217">    <p class="goodmoney tipout" id="bg39217">￥<span id="money39217">74.10</span></p>    <p id="name39217" class="goodmember">A泓毅</p>    <span class="toauc" id="perbutton39217">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="8" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="8" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(8)">    <span class="goodimg" id="logo39195">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/KccQH991wNrxQxZ6WX96BAhNnB2H22.png">    </span>    <p id="sy39195" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="38" id="mid39195">    <p class="goodmoney tipout" id="bg39195">￥<span id="money39195">494.40</span></p>    <p id="name39195" class="goodmember">我憋尿很厉害</p>    <span class="toauc" id="perbutton39195">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="9" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="9" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(9)">    <span class="goodimg" id="logo39218">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xN81zXokjXNeLGRNAC9VcxXfnx100k.png">    </span>    <p id="sy39218" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="461" id="mid39218">    <p class="goodmoney tipout" id="bg39218">￥<span id="money39218">53.50</span></p>    <p id="name39218" class="goodmember">统一结米，漏米私我</p>    <span class="toauc" id="perbutton39218">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="10" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="10" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(10)">    <span class="goodimg" id="logo39219">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/w7XmJw8xMGkut2Azu9mPxTgjmjzP6P.png">    </span>    <p id="sy39219" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="388" id="mid39219">    <p class="goodmoney tipout" id="bg39219">￥<span id="money39219">25.60</span></p>    <p id="name39219" class="goodmember">流星花园</p>    <span class="toauc" id="perbutton39219">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="12" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="12" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(12)">    <span class="goodimg" id="logo39186">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/eX1WvKwc3I7kffK70hU1P0Fup0CqC0.png">    </span>    <p id="sy39186" sytime="78" class="downtime">00:01:19</p>    <input type="hidden" value="38" id="mid39186">    <p class="goodmoney tipout" id="bg39186">￥<span id="money39186">94.10</span></p>    <p id="name39186" class="goodmember">我憋尿很厉害</p>    <span class="toauc" id="perbutton39186">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="13" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="13" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(13)">    <span class="goodimg" id="logo39220">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/MhWS4KKskzzcKAk24jkYSeqcYjEz2c.png">    </span>    <p id="sy39220" sytime="10" class="downtime">00:00:04</p>    <input type="hidden" value="471" id="mid39220">    <p class="goodmoney tipout" id="bg39220">￥<span id="money39220">23.90</span></p>    <p id="name39220" class="goodmember">家有宝贝</p>    <span class="toauc" id="perbutton39220">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="14" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="14" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(14)">    <span class="goodimg" id="logo39169">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/oPMk5ZTkiYiGkPI2mjmYkhG78emEM4.png">    </span>    <p id="sy39169" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="295" id="mid39169">    <p class="goodmoney tipout" id="bg39169">￥<span id="money39169">950.40</span></p>    <p id="name39169" class="goodmember">Charryhan</p>    <span class="toauc" id="perbutton39169">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="15" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="15" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(15)">    <span class="goodimg" id="logo39141">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/f42zvyX547xYLU5zvvhuoIN8y48i88.png">    </span>    <p id="sy39141" sytime="4" class="downtime">00:00:05</p>    <input type="hidden" value="313" id="mid39141">    <p class="goodmoney tipout" id="bg39141">￥<span id="money39141">1435.90</span></p>    <p id="name39141" class="goodmember">寒夜露珠</p>    <span class="toauc" id="perbutton39141">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="16" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="16" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(16)">    <span class="goodimg" id="logo39148">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/F9mIZiFiuFUoo9XsegduWxUFY96SZX.png">    </span>    <p id="sy39148" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="387" id="mid39148">    <p class="goodmoney tipout" id="bg39148">￥<span id="money39148">1277.30</span></p>    <p id="name39148" class="goodmember">煊煊妈～浙江</p>    <span class="toauc" id="perbutton39148">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="17" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="17" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(17)">    <span class="goodimg" id="logo39176">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/kF2nPnXnYxmWk2kMgxr1RFwM923rR4.png">    </span>    <p id="sy39176" sytime="5" class="downtime">00:00:06</p>    <input type="hidden" value="37" id="mid39176">    <p class="goodmoney tipout" id="bg39176">￥<span id="money39176">845.60</span></p>    <p id="name39176" class="goodmember">super</p>    <span class="toauc" id="perbutton39176">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="18" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="18" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(18)">    <span class="goodimg" id="logo39112">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/JkV20zARKqBd2buaDDmVbu7VdJ8cdc.png">    </span>    <p id="sy39112" sytime="13" class="downtime">00:00:14</p>    <input type="hidden" value="395" id="mid39112">    <p class="goodmoney tipout" id="bg39112">￥<span id="money39112">1424.20</span></p>    <p id="name39112" class="goodmember">梦瑶</p>    <span class="toauc" id="perbutton39112">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="19" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="19" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(19)">    <span class="goodimg" id="logo13808">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/rQqxS5Gzw8bbq7wK70qJu10Xx6G70C.png">    </span>    <p id="sy13808" sytime="-284460" class="downtime">00:00:00</p>    <input type="hidden" value="4816" id="mid13808">    <p class="goodmoney tipout" id="bg13808">￥<span id="money13808">2021.40</span></p>    <p id="name13808" class="goodmember">凌枫</p>    <span class="toauc" id="perbutton13808">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="20" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="20" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(20)">    <span class="goodimg" id="logo39215">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Edyv5a2bTAFLdY0aGtzRTAl6buO02D.png">    </span>    <p id="sy39215" sytime="10" class="downtime">00:00:03</p>    <input type="hidden" value="301" id="mid39215">    <p class="goodmoney tipout" id="bg39215">￥<span id="money39215">82.60</span></p>    <p id="name39215" class="goodmember">guqin</p>    <span class="toauc" id="perbutton39215">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="21" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="21" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(21)">    <span class="goodimg" id="logo39180">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/c16FTm1GVftTmmTgmTgZTO43Uj3T2m.png">    </span>    <p id="sy39180" sytime="5" class="downtime">00:00:06</p>    <input type="hidden" value="351" id="mid39180">    <p class="goodmoney tipout" id="bg39180">￥<span id="money39180">796.70</span></p>    <p id="name39180" class="goodmember">互信互联</p>    <span class="toauc" id="perbutton39180">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="22" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="22" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(22)">    <span class="goodimg" id="logo39190">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/RO4n593u53N5o2522Now8esn332WN2.png">    </span>    <p id="sy39190" sytime="7" class="downtime">00:00:08</p>    <input type="hidden" value="277" id="mid39190">    <p class="goodmoney tipout" id="bg39190">￥<span id="money39190">601.60</span></p>    <p id="name39190" class="goodmember">毕正伟江苏量客生物科技有限公司</p>    <span class="toauc" id="perbutton39190">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="23" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="23" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(23)">    <span class="goodimg" id="logo26089">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/HDUOxwb3b3Zbj3beUu93O3bbt9g9b3.png">    </span>    <p id="sy26089" sytime="-369861" class="downtime">00:00:00</p>    <input type="hidden" value="27022" id="mid26089">    <p class="goodmoney tipout" id="bg26089">￥<span id="money26089">919.40</span></p>    <p id="name26089" class="goodmember">137****2759</p>    <span class="toauc" id="perbutton26089">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="24" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="24" class="scbutton addcollection" onclick="addcollection(this)" style="display: none;">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(24)">    <span class="goodimg" id="logo39200">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/m8337U47Y1F47YuqC43UIsDuQuIyZd.png">    </span>    <p id="sy39200" sytime="4" class="downtime">00:00:05</p>    <input type="hidden" value="395" id="mid39200">    <p class="goodmoney tipout" id="bg39200">￥<span id="money39200">387.00</span></p>    <p id="name39200" class="goodmember">梦瑶</p>    <span class="toauc" id="perbutton39200">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="25" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="25" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(25)">    <span class="goodimg" id="logo39153">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/V444Y924bWu4olAb89wl44wn0OY929.png">    </span>    <p id="sy39153" sytime="8" class="downtime">00:00:09</p>    <input type="hidden" value="432" id="mid39153">    <p class="goodmoney tipout" id="bg39153">￥<span id="money39153">1215.00</span></p>    <p id="name39153" class="goodmember">微微^_^</p>    <span class="toauc" id="perbutton39153">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="26" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="26" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(26)">    <span class="goodimg" id="logo39209">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/DZ6RhKYhlLBBezNYblrL666c6jNL66.png">    </span>    <p id="sy39209" sytime="3" class="downtime">00:00:04</p>    <input type="hidden" value="345" id="mid39209">    <p class="goodmoney tipout" id="bg39209">￥<span id="money39209">194.10</span></p>    <p id="name39209" class="goodmember">A泓毅</p>    <span class="toauc" id="perbutton39209">参与竞拍</span>   </div>  </div>    <div class="gooddiv">   <div class="collection">    <input type="hidden" name="cl" class="cl" value="">    <span id="27" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" style="display: none;" data-confirm="确定要取消收藏吗？">     已收藏    </span>    <span id="27" class="scbutton addcollection" onclick="addcollection(this)">     <i class="icon iconfont icon-add"></i>     收藏    </span>   </div>   <div onclick="togoods(27)">    <span class="goodimg" id="logo39216">     <img class="goodlogo" src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/yFDdZsGhCQ5sqmofOUdfMuq1hHQUqm.png">    </span>    <p id="sy39216" sytime="4" class="downtime">00:00:05</p>    <input type="hidden" value="329" id="mid39216">    <p class="goodmoney tipout" id="bg39216">￥<span id="money39216">74.10</span></p>    <p id="name39216" class="goodmember">西瓜</p>    <span class="toauc" id="perbutton39216">参与竞拍</span>   </div>  </div>    <div style="clear: both;"></div>  </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .aucgoodsdiv{background-color: white;}
    .goodshead{font-size: 16px;padding-top: .2rem;padding-bottom: .2rem;padding-left: .75rem;}
</style>

<script type="text/html" id="goodslists">
    @verbatim
    {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
    <div class="gooddiv">
        <div class="collection">
            <input type="hidden" name="cl" class="cl" value="" />
            <span id="{{d.data[i].id}}" onclick="cancelcollection(this)" class="scbutton ed cancelcollection" {{# if(d.data[i].id!=d.data[i].collection){ }} style="display: none;" {{# } }} data-confirm="确定要取消收藏吗？">
				已收藏
			</span>
            <span id="{{d.data[i].id}}" class="scbutton addcollection" onclick="addcollection(this)"  {{# if(d.data[i].id==d.data[i].collection){ }} style="display: none;" {{# } }}>
				<i class="icon iconfont icon-add"></i>
				收藏
			</span>
        </div>
        <div onclick="togoods({{d.data[i].id}})">
			<span class="goodimg" id="logo{{d.data[i].nowperiods}}">
				<img class="goodlogo" src="{{ d.data[i].logo }}"/>
			</span>
            <p id="sy{{d.data[i].nowperiods}}" sytime='{{d.data[i].countdown}}' class="downtime">00:00:00</p>
            <input type="hidden" value="{{d.data[i].finalmid}}" id="mid{{d.data[i].nowperiods}}"  />
            <p class="goodmoney tipout"id="bg{{d.data[i].nowperiods}}" >￥<span id="money{{d.data[i].nowperiods}}">{{d.data[i].price}}</span></p>
            <p id="name{{d.data[i].nowperiods}}" class="goodmember">{{d.data[i].finalname}}</p>
            <span class="toauc" id="perbutton{{d.data[i].nowperiods}}">参与竞拍</span>
        </div>
    </div>
    {{# } }}
    @endverbatim
    <div style="clear: both;"></div>
</script>
<script type="text/javascript">
    // 服务端发来消息时
    function onmessage(e) {
        console.log(e.data);
        var data = JSON.parse(e.data);
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong"}');
                break;
            // 服务端ping客户端
            case 'init':
                onopen(data['client_id']);
                break;
            // 出价信息
            case 'offer':
                $('#sy'+data.perid).attr('sytime',data.countdown);
                $('#name'+data.perid).text(data.finalname);
                $('#bg'+data.perid).attr('class','goodmoney tipin');
                var t = setTimeout(function(){
                    $('#bg'+data.perid).attr('class','goodmoney tipout');
                },20);
                $('#money'+data.perid).text(data.prtxt);
                break;
            case 'end':
                $('#perbutton'+data.perid).text('本期结束');
                $('#perbutton'+data.perid).css('background-color','#999999');
                $('#sy'+data.perid).attr('sytime',0);
                $('#sy'+data.perid).text('00:00:00');
                $('#sy'+data.perid).css('color','black');
                $('#bg'+data.perid).css('color','black');
                $('#logo'+data.perid).addClass('endimg');
                break;
        }
    }
</script>

<script>
    $(function(){
        get_goods();
        var tt = setInterval("begin()",1000);
    });
    function togoods(id){
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=detail&id="+id;
    }
    function get_goods(){
        var auctioneerid = "1";
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getgoods", {id:0,type:4,auctioneerid:auctioneerid},function(d) {
            if(d.data.length!=''){
                var gettpl = document.getElementById('goodslists').innerHTML;
                laytpl(gettpl).render(d, function(html) {
                    $("#listgoods").empty();
                    $(".cl").val('');
                    $("#listgoods").append(html);
                });
            }
        }, "json");
    }
    function addcollection(obj){
        var id = $(obj).attr('id');
        $.ajax({
            cache: true,
            type: "POST",
            url: "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=collection",
            data: {
                'id': id,
            },
            success: function(data) {
                $(obj).hide();
                $(obj).parent('div').find('span.cancelcollection').show();
            }
        });
    }
    function cancelcollection(obj){
        var id = $(obj).attr('id');
        $.confirm("确定要取消收藏吗？",function(){
            $.post(
                "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=cancelcollection",
                {id:id},
                function(d){
                    var a=	$(".cl").val();
                    if(a==1){
                        if(d!=null){
                            var gettpl = document.getElementById('goodslists').innerHTML;
                            laytpl(gettpl).render(d, function(html) {
                                $("#collection").empty();
                                $("#collection").append(html);
                            });
                        }else{
                            $("#collection").empty();
                            var html=''
                            html+='<div class="nodata-default">'+
                                '暂无收藏商品'+
                                '</div>';
                            $("#collection").append(html);
                        }
                    }else{
                        $(obj).hide();
                        $(obj).parent('div').find('span.addcollection').show();
                    }
                },"json");
        });
    }

    function begin(){
        getinfo();
        $('.downtime').each(function(){
            var begintime = $(this).attr('sytime');
            var txt = '';
            if(begintime>0){
                h = Math.floor(begintime  / 3600);
                m = Math.floor((begintime % 3600) / 60);
                s = Math.floor((begintime  % 3600) % 60);
                if(h<10){h = '0'+h;}
                if(m<10){m = '0'+m;}
                if(s<10){s = '0'+s;}
                txt = h+":"+m+":"+s;
                $(this).text(txt);
                begintime = begintime - 1;
                $(this).attr('sytime',begintime);
            }
        });
    }

    function getinfo(){
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getindexinfo",{},function(data){
            console.log(data);
            $.each(data,function(key,val){
                if(val.finalmid == 'end'){
                    $('#perbutton'+val.id).text('本期结束');
                    $('#perbutton'+val.id).css('background-color','#999999');
                    $('#sy'+val.id).attr('sytime',0);
                    $('#sy'+val.id).text('00:00:00');
                    $('#sy'+val.id).css('color','black');
                    $('#bg'+val.id).css('color','black');
                    $('#logo'+val.id).addClass('endimg');
                }else{
                    var nowmid = $('#mid'+val.id).val();
                    if(val.finalmid != nowmid){
                        $('#mid'+val.id).val(val.finalmid);
                        $('#sy'+val.id).attr('sytime',val.countdown);
                        $('#name'+val.id).text(val.nickname);
                        $('#bg'+val.id).attr('class','goodmoney tipin');
                        var t = setTimeout(function(){
                            $('#bg'+val.id).attr('class','goodmoney tipout');
                        },20);
                        $('#money'+val.id).text(val.finalmoney);
                    }
                }
            });
        },"json");
    }
</script>

        @parent
@stop

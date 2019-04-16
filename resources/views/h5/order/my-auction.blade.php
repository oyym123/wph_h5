@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    我的竞拍
@stop
@section('content')
        <div class="buttons-tab" style="top: 2.2rem;">
            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=all" class="button active">全部</a>
            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=1" class="button ">我在拍</a>
            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=wpz" class="button ">我拍中</a>
            <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=cjg" class="button ">差价购</a>
            <a href="javascript:;" class="button  open-popover" data-popover=".popover-order-status">更多 <i class="iconfont icon-unfold"></i></a>
        </div>
        <div class="content infinite-scroll" style="margin-top: 2.2rem;">
            <div>
                <!--全部订单表-->
                <ul class="main_ct ui-tags-ct" id="J-mainCt">
                    <li class="allorder">

                        <div class="ui-block bid_list biding" style="margin-bottom: 0.5rem;background-color: white;">   <div class="timeline">            正在参与竞拍...      <span>进行中</span>         </div>   <div style="padding-left: 0.5rem;" onclick="toperiod('1','13551')">    <div class="cover J-gotoGoods">     <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/pAwP8t3AqiozPm48jfpO8pq3fCJqbz.png">    </div>    <div class="bid_info J-gotoGoods">     <p>市场价：<span>￥8000.00</span></p>     <p>              <span>拍卖价：</span>            <i>￥1667.40</i>     </p>            <p class="hidelong">我出价：5次</p>         </div>    </div>      <div class="user_btn">    <div class="return_bids">           </div>      <div class="btn_wrap">               <a onclick="toperiod('1','13551')">继续竞拍</a>           </div>   </div>  </div>  </li>
                </ul>
                <!--<li id="bidit" style="display: none;">
                 <div class="nodata-default">
                  <a href="category.html">去逛逛</a>
                 </div>
                </li>-->

                <style>
                    .main_ct{padding-bottom:0.5rem}
                    .main_ct.fixed{padding-top:2rem}
                    .bid_list .timeline{height:1.625rem;line-height:1.675rem;font-size:0.6rem;color:#999;position:relative;text-indent:0.5rem}
                    .bid_list .timeline span{font-size:0.7000000000000001rem;color:#EF1544;position:absolute;right:0.5rem;top:0;display:inline-block}
                    .bid_list .cover{width:4.35rem;height:4.35rem;float:left;position:relative;overflow:hidden;padding: 0.2rem;}
                    .bid_list .cover img{width:100%;height:100%;}
                    .bid_list .bid_info{float:left;width:8.875rem;padding:0.3rem 0 0 0.4rem;line-height:1.25rem;font-size:0.6rem;color:#333;}
                    .bid_list .bid_info em{color:#EF1544;}
                    .bid_list .bid_info i{color:#EF1544;font-size:0.65rem}
                    .bid_list .price_save{float:right;width:4.5rem;text-align:center;font-size:0.6rem;color:#999;position:relative;top:0.5rem;right:0.375rem}
                    .bid_list .price_save em{font-size:1.25rem;color:#333;line-height:1.3;display:block;margin:0.5rem auto 0;}
                    .bid_list .user_btn{clear:both;border-top:solid 1px #ddd;height:2.125rem;line-height:2.125rem;padding:0 0.625rem;position:relative}
                    .bid_list .user_btn .return_bids{position:absolute;left:0.625rem;top:0;font-size:0.6rem}
                    .bid_list .user_btn .return_bids em{color:#EF1544;}
                    .bid_list .user_btn .btn_wrap{text-align:right;font-size:0.6rem;color:#EF1544;padding-top: 0.3rem;}
                    .bid_list .user_btn .btn_wrap a{display:inline-block;border:solid 2px #EF1544;height:1.5rem;line-height:1.3rem;padding:0 0.5rem;margin-left:0.5rem;color:#EF1544;}
                    .bid_list .user_btn .btn_wrap a:first-child{margin-left:0;}
                    .bid_list.bidit .cover:after{font-size:0.6rem;content:"拍中了";display:block;width:100%;height:1rem;line-height:1.05rem;background:#EF1544;color:#fff;text-align:center;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:0 0;transform-origin:0 0;position:absolute;left:-21%;top:50%;}
                    .bid_list.error .cover img{opacity:0.5;}
                    .bid_list.error .cover:after{font-size:0.9rem;border:solid 2px #EF1544;content:"退币";display:block;width:2.975rem;height:1.275rem;line-height:1.325rem;color:#EF1544;text-align:center;transform:rotate(-20deg);-webkit-transform:rotate(-20deg);-webkit-transform-origin:0 0;transform-origin:0 0;position:absolute;left:0.775rem;top:2.375rem}
                    .bid_list.notbid.locked a:before,.bid_list.biding.locked a:before{content:"\e615";color:#EF1544;font-family:"iconfont" !important;-webkit-font-smoothing:antialiased;display:inline-block;height:100%;margin-right:0.25rem;position:relative;top:-0.075rem}
                    .bid_list.biding .user_info{font-size:0.7000000000000001rem;color:#EF1544;}
                    .bid_list.biding .price_save{display:none}
                    .bid_list.buy .cover:after{font-size:0.6rem;content:"差价购";display:block;width:100%;height:1rem;line-height:1.05rem;background:#ffb04b;color:#fff;text-align:center;transform:rotate(-45deg);-webkit-transform:rotate(-45deg);-webkit-transform-origin:0 0;transform-origin:0 0;position:absolute;left:-21%;top:50%;}
                    .bid_list.buy .bid_info{width:14rem;padding:0.625rem 0.625rem 0 0.25rem;line-height:1rem}
                    .bid_list.buy .bid_info span{float:right}
                    .bid_list.buy .bid_info .realpay{margin-top:0.125rem;padding-top:0.25rem;border-top:solid 1px #ccc}
                    .bid_list.buy .bid_info .realpay span{color:#EF1544;font-size:13px}
                </style>
                
            </div>
            <div class="weui-loadmore loading_more" style="display: none;">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>
            <div class="weui-loadmore weui-loadmore_line" style="display: none;">
                <span class="weui-loadmore__tips" style="background-color: #EFEFF4;">暂无更多数据</span>
            </div>
        </div>
    </div>
</div>
<div class="popover popover-manage popover-order-status">
    <div class="popover-angle"></div>
    <div class="popover-inner">
        <div class="list-block">
            <ul>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=dfk" class="list-button item-link">待付款</a></li>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=3" class="list-button item-link">待发货</a></li>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=4" class="list-button item-link">待签收</a></li>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=5" class="list-button item-link">待晒单</a></li>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=6" class="list-button item-link">已完成</a></li>
                <li><a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=7" class="list-button item-link">已退款</a></li>
                <li><a href="javascript:;" class="list-button item-link close-popover">关闭</a></li>
            </ul>
        </div>
    </div>
</div>
<script type="text/html" id="orderlist">
    @verbatim
    {{# for(var i = 0, len = d.length; i < len; i++){ }}
    <div class="ui-block bid_list biding"  style="margin-bottom: 0.5rem;background-color: white;">
        <div class="timeline">
            {{# if(d[i].status == 1){ }}
            正在参与竞拍...
            <span>进行中</span>
            {{# }else{ }}
            {{d[i].endtime}}
            {{# } }}
        </div>
        <div style="padding-left: 0.5rem;"  onclick="toperiod('{{d[i].goodsid}}','{{d[i].perid}}')">
            <div class="cover J-gotoGoods">
                <img src="{{d[i].logo}}" />
            </div>
            <div class="bid_info J-gotoGoods">
                <p>市场价：<span>￥{{d[i].oldprice}}</span></p>
                <p>
                    {{# if(d[i].status == 1){ }}
                    <span>拍卖价：</span>
                    {{# }else{ }}
                    <span>成交价：</span>
                    {{# } }}
                    <i>￥{{d[i].finalmoney}}</i>
                </p>
                {{# if(d[i].status == 1){ }}
                <p class="hidelong">我出价：{{d[i].auctimes}}次</p>
                {{# }else{ }}
                <p class="hidelong">成交人：{{d[i].finalname}}</p>
                {{# } }}

            </div>
        </div>

        <div class="user_btn">
            <div class="return_bids">
                {{# if(d[i].status != 1){ }}
                已返还<em>{{d[i].returnbuycoin}}</em>购物币
                {{# } }}
            </div>
            <div class="btn_wrap">
                {{# if(d[i].status == 1){ }}
                <a onclick="toperiod('{{d[i].goodsid}}','{{d[i].perid}}')" >继续竞拍</a>
                {{# }else if(d[i].status == 2 && d[i].type == 2 && d[i].addbuy){ }}
                <a onclick="payorder('{{d[i].id}}')" >差价购买</a>
                {{# }else if(d[i].status == 2 && d[i].type == 1){ }}
                <a onclick="payorder('{{d[i].id}}')" >拍中付款</a>
                {{# }else if( d[i].status == 3){}}
                <a goodid="{{d[i].goodsid}}" style="border-color:#999999;color: #999999;">等待发货</a>
                {{# }else if( d[i].status == 4){}}
                <a onclick="qsgood('{{d[i].id}}')">签收拍品</a>
                {{# }else if( d[i].status == 5){}}
                <a onclick="toshoworder('{{d[i].id}}')">发布晒单</a>
                {{# }else if( d[i].status == 6){}}
                <a style="border-color:#999999;color: #999999;">已晒单</a>
                {{# } }}
            </div>
        </div>
    </div>
    {{# } }}
    @endverbatim
</script>
<script>
    $(function() {
        $(document).on("pageInit", "#page-index", function(e, id, page) {
            var loading = false;
            var pagenum = 1,
                pagesize = 8,
                endmark = 0;
            function addItems() {
                $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=order&ac=userorder&do=orderlist&status=all",{},function(d){
                    if (d.data.length > 0) {
                        var gettpl1 = document.getElementById('orderlist').innerHTML;
                        sessionStorage.setItem("demokey",JSON.stringify(d.data));
                        var contentdata = d.data.slice(0,pagesize);
                        laytpl(gettpl1).render(contentdata, function(html){
                            $(".allorder").append(html);
                        });
                    }else{
                        $(".allorder").html('<div class="nodata-default"><a href="https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=category">去逛逛</a></div>');
                    }
                }, 'json');
            }
            addItems();
            $(page).on('infinite', function() {
                if (endmark || loading) return;
                loading = true;
                $(".loading_more").show();
                setTimeout(function() {
                    loading = false;
                    var dt = JSON.parse(sessionStorage.getItem("demokey"));
                    var xxx = dt.slice(pagenum*pagesize ,pagenum*pagesize+pagesize);
                    addnew(xxx);
                    $.refreshScroller();
                }, 500);
            });
            function addnew(cont){
                if(cont.length){
                    $(".loading_more").hide();
                    var gettpl1 = document.getElementById('orderlist').innerHTML;
                    laytpl(gettpl1).render(cont, function(html){
                        $(".allorder").append(html);
                    });
                    pagenum++;loading = false;
                }else{
                    $(".loading_more").hide();
                    $(".weui-loadmore_line").show();
                    endmark = 1;
                }
            }
        });


        $.init();
    });

    function qsgood(id){
        $.confirm("确定要签收商品吗？",function(){
            $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=order&ac=userorder&do=changestatus&type=qs",{id:id},function(d){
                if (d.status){
                    $.toast('签收成功');
                    location.reload();
                }else{
                    $.toast('签收失败，请重试');
                }
            }, 'json');
        });
    }

    function toperiod(gid,pid){
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=detail&id="+gid+"&perid="+pid;
    }

    function toshoworder(orderid){
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=order&ac=userorder&do=showorder&id="+orderid;
    }

    function payorder(orderid){
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=order&ac=userorder&do=payorder&id="+orderid;
    }
</script>

        @parent
        @stop

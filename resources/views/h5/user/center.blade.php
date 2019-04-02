@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    微排行
@stop
@section('content')
		<div class="content native-scroll">
            <div class="my">
                <div class="my_head" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=myinfo'">
                    <div class="my_head_pic">
                        <img id="uinLogo" class="my_head_img" width="130" height="130" alt="" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/touxiang.png" style="background-color: white;">
                    </div>
                    <div class="my_head_info">
                        <h4 id="nickname" class="my_head_name ">131****7904</h4>
                        <span class="bind_phone">ID:127028</span>
                    </div>
                </div>
                <span class="setup"><i style="font-size: 23px;" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=setuplist'" class="icon iconfont icon-settings"></i></span>
                <span class="news" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=news&amp;ac=news&amp;do=news'"><i style="font-size: 23px;" class="icon iconfont icon-comment"></i><span class="newnum"><div class="" style="display: none;">
		   		0		   	</div></span></span>
                <span class="details"><i style="font-size: 23px;" class="icon iconfont icon-right"></i></span>
            </div>
            <div class="list-block" style="margin: 0.6rem 0;">
                <ul>
                    <li>
		        	<span class=" item-content list-button-order">
		              	<div class="item-inner">
		                	<div class="item-title" style="padding-left: .75rem;">我的财产</div>
		                	<div onclick="recharge()" class="recharge">充值</div>
		              	</div>
		            </span>
                    </li>
                    <li>
                        <div style="padding: 0 .75rem;text-align: center;">
                            <div class="row order-row">
                                <div class="col-33 col-row" onclick="location.href='/h5/user/property'">
                                    <div class="icondiv">
                                        <span class="property">0</span>
                                    </div>
                                    <div class="txt">拍币&gt;</div>
                                </div>
                                <div class="col-33 col-row" onclick="location.href='/h5/user/property'">
                                    <div class="icondiv">
                                        <span class="property">195</span>
                                    </div>
                                    <div class="txt">赠币&gt;</div>
                                </div>
                                <div class="col-33 col-row" >
                                    <div class="icondiv">
                                        <span class="property">10</span>
                                    </div>
                                    <div class="txt">购物币</div>
                                </div>
                                {{--<div class="col-25 col-row" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=mycredit'">--}}
                                    {{--<div class="icondiv">--}}
                                        {{--<span class="property">0</span>--}}
                                    {{--</div>--}}
                                    {{--<div class="txt">积分&gt;</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="list-block" style="margin: 0.6rem 0;">
                <ul>
                    <li>
                        <a href="/h5/order/my-auction?type=100" class="item-link item-content list-button-order">
                            <div class="item-inner">
                                <div class="item-title" style="padding-left: .75rem;">我的竞拍</div>
                                <div class="item-after" style="color: rgb(153,153,153);">全部竞拍</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div style="padding: 0 .75rem;text-align: center;">
                            <div class="row order-row">
                                <div class="col-20" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=1'">
                                    <div class="icondiv">
                                        <img style="height: 32px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/zzp.png">
                                    </div>
                                    <span class="title-num" id="num1"></span>
                                    <div class="txt">正在拍</div>
                                </div>
                                <div class="col-20" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=wpz'">
                                    <div class="icondiv">
                                        <img style="height: 32px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/wpz.png">
                                    </div>
                                    <span class="title-num" id="num2"></span>
                                    <div class="txt">我拍中</div>
                                </div>
                                <div class="col-20" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=cjg'">
                                    <div class="icondiv">
                                        <img style="height: 32px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/cjg.png">
                                    </div>
                                    <span class="title-num" id="num3"></span>
                                    <div class="txt">差价购</div>
                                </div>
                                <div class="col-20" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=dfk'">
                                    <div class="icondiv">
                                        <img style="height: 32px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/dfk.png">
                                    </div>
                                    <span class="title-num" id="num4"></span>
                                    <div class="txt">待付款</div>
                                </div>
                                <div class="col-20" onclick="location.href='https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=order&amp;ac=userorder&amp;do=orderlist&amp;status=5'">
                                    <div class="icondiv">
                                        <img style="height: 32px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/sd.png">
                                    </div>
                                    <span class="title-num" id="num5"></span>
                                    <div class="txt">待晒单</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="list-block usercenter" style="margin: 0.6rem 0;">
                <ul>
                    <li>
                        <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=collection" class="item-link item-content">
                            <div class="item-media"><img style="width: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/shouchang.png"></div>
                            <div class="item-inner" style="margin-left: .3rem;">
                                <div class="item-title">收藏的商品</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=member&amp;ac=user&amp;do=myshoworder" class="item-link item-content">
                            <div class="item-media"><img style="height: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/shaidan.png"></div>
                            <div class="item-inner" style="margin-left: .3rem;">
                                <div class="item-title">我的晒单</div>
                            </div>
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a class="item-link item-content" onclick="code()">--}}
                            {{--<div class="item-media"><img style="height: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/kefu.png"></div>--}}
                            {{--<div class="item-inner" style="margin-left: .3rem;">--}}
                                {{--<div class="item-title">在线客服</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        {{--<div class="diy-layer external">--}}
                            {{--<div class="weui_mask" id="customermask" style="display: none;">--}}
                            {{--</div><div class="weui_dialog" id="customerdia" style="display: none;">--}}
                                {{--<p class="dialog-title">长按识别二维码</p><div class="img-box">--}}
                                    {{--<img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Or4IhjKBRKbmk1RkkIAvXrBe44HMIK.jpg" style="max-width:100%">--}}
                                {{--</div><span class="vux-close">--}}
						 {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=helper&amp;ac=about&amp;do=getall" class="item-link item-content">--}}
                            {{--<div class="item-media"><img style="height: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/jianyi.png"></div>--}}
                            {{--<div class="item-inner" style="margin-left: .3rem;">--}}
                                {{--<div class="item-title">帮助中心</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="https://demo.weliam.cn/app/index.php?i=37&amp;c=entry&amp;m=weliam_fastauction&amp;p=invite&amp;ac=invitation&amp;do=index" class="item-link item-content">--}}
                            {{--<div class="item-media"><img style="height: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/invite.png"></div>--}}
                            {{--<div class="item-inner" style="margin-left: .3rem;">--}}
                                {{--<div class="item-title">邀请好友</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <!--<li>
        <a href="https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=vip&do=open" class="item-link item-content">
            <div class="item-media"><img style="height: 24px;" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/fenxiang.png" /></div>
              <div class="item-inner" style="margin-left: .3rem;">
                <div class="item-title">分享应用</div>
            </div>
        </a>
    </li>-->
                </ul>
            </div>
        </div>


<style>
    .my{position:relative;z-index:1;width:100%;height:130px;background-size:100% auto;background:linear-gradient(to bottom, #f40101 0%, #ff7e7e 100%);}
    .my_head_pic{padding:1.5rem 0 0}
    .my_head_img{width:65px;height:65px;border:solid 2px #fff;border-radius:67px;margin-left: 30px;margin-top: 10px;}
    .my_head_info{color:white;position: absolute;top: 43px;left: 110px;}
    .my_head_name{padding:7.5px 0 5.5px;font-size:17px;line-height:1.2;color: white;}
    .setup{color: white;position: absolute;top: .5rem;right: 2.5rem;}
    .news{color: white;position: absolute;top: .5rem;right: .8rem;}
    .details{color: white;position: absolute;top: 3rem;right: .8rem;}
    .newnum{line-height: 16px;padding: 0 3px;margin-left: 1px;border-radius: 10px;font-size: 10px;color: #f40101;background-color: white;position: absolute;left: .5rem;}
    .recharge{padding: 0px 14px 0px 14px;background-color: #EF1544;color: white;}
    .my_head_prototype{font-size:11px;line-height:1}
    .my_transaction{position:absolute;right:0;bottom:0;left:0;padding: 10px 0 5px 0;background:white;}
    .my_transaction li{position:relative;float:left;color:#000;text-align:center}
    .my_transaction li a{color:#000}
    .my_transaction li:after{position:absolute;top:0;right:0;bottom:0;border-right:1px solid #C5C5C5;content:"";-webkit-transform:scaleX(.5);-webkit-transform-origin:0 0}
    .my_transaction li:last-child:after{border:none}
    .my_transaction1{width:100%}
    .my_transaction2 li{width:50%}
    .my_transaction3 li{width:33.33%}
    .my_transaction li:last-child{border:none}
    .my_transaction_num{font-size:13px;line-height:1;color: #B1B1B1;}
    .my_transaction_num span{font-size:20px;color: #FF5D4F;}
    .my_transaction_txt{padding-top:2px;font-size:14px;line-height:1.2}
    .my_transaction:after{content: " ";position: absolute;left: 0;bottom: 0;width: 100%;height: 1px;border-bottom: 1px solid #D9D9D9;color: #D9D9D9;-webkit-transform-origin: 0 100%;transform-origin: 0 100%;-webkit-transform: scaleY(0.5);transform: scaleY(0.5);}
    .usercenter .iconfont{font-size: 1.3rem;line-height: 1.45rem;}
    .usercenter .icon-crownfill{color: #F26665;}
    .usercenter .icon-vipcard{color: #F26665;}
    .usercenter .icon-likefill{color: #F26665;}
    .usercenter .icon-mark{color: #12ADFF;}
    .usercenter .icon-ticket{color: #12ADFF;}
    .usercenter .icon-taoxiaopu{color: #12ADFF;}
    /*个人中心订单*/
    .order-row .col-row{padding: 15px 0;}
    .order-row .col-20{padding: 15px 0;}
    .order-row .iconfont{font-size: 1.4rem;color: #929292;}
    .order-row .property{font-size: 1.3rem;}
    .order-row .txt{line-height: 12px;font-size: 0.7rem;color: rgb(153,153,153);margin-top: 5px;margin-top: .6rem;}
    .order-row .icondiv{line-height: 24px;}
    .order-row .title-num{line-height: 16px;padding: 0 5px;margin-left: 2px;border-radius: 10px;border: 2px solid #fff;font-size: 10px;color: #fff;background-color: #f76161;}
    .order-row #num1{position: absolute;left:13%;top: 6px;}
    .order-row #num2{position: absolute;left:32%;top: 6px;}
    .order-row #num3{position: absolute;left:51%;top: 6px;}
    .order-row #num4{position: absolute;left:70%;top: 6px;}
    .order-row #num5{position: absolute;left:89%;top: 6px;}
    /*.order-row .icon-pay{color: #99CDFF;}
    .order-row .icon-send{color: #FF8692;}
    .order-row .icon-comment{color: #F0DE44;}
    .order-row .icon-refund{color: #ADB3FF;}*/
    .list-button-order{text-align: center;padding-left: 0!important;}

</style>
<script>
    function recharge(){
        location.href = "/h5/pay/recharge-center";
    }

    function code(){
        if("2"==2){
            $('#customermask').show();
            $('#customerdia').show();
        }
    }
    $("#customermask").click(function(){
        $('#customermask').hide();
        $('#customerdia').hide();
    });


</script>

        @parent
@stop

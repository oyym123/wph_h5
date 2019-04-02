@extends('layouts.h5')
@section('title')
    我的财产
@stop
@section('title_head')
    我的财产
@stop
@section('content')<style>
    .icondiv{line-height: 24px;}
    .title-num{line-height: 16px;padding: 0 5px;margin-left: 2px;border-radius: 10px;border: 2px solid #fff;font-size: 10px;color: #fff;background-color: #f76161;}
    .iconfont{font-size: 1.4rem;color: #929292;}
    .property{font-size: 1.3rem;}
    .txt{font-size: 0.8rem;color: rgb(153,153,153);margin-top: .3rem;}
</style>

        <div class="content native-scroll">
            <div style="padding: .75rem;text-align: center;background-color: white;">
                <div class="row order-row">
                    <div class="col-33">
                        <div class="icondiv">
                            <span class="property">0</span>
                        </div>
                        <div class="txt">拍币</div>
                    </div>
                    <div class="col-33">
                        <div class="icondiv">
                            <span class="property">195</span>
                        </div>
                        <div class="txt">赠币</div>
                    </div>
                    <div class="col-33">
                        <div class="icondiv">
                            <span class="property">10</span>
                        </div>
                        <div class="txt">购物币</div>
                    </div>
                </div>
            </div>
            <div class="list-block">
                <ul><li><a href="javascript:;" class="item-link item-content list-button-order open-popup" data-popup=".popup-about"><div class="item-inner">什么是拍币/赠币/购物币？</div></a></li></ul>
            </div>
            <div class="list-block" style="background-color: white;padding:.3rem .5rem 0 .3rem;margin-top: .6rem;">
                <div class="buttons-tab">
                    <a href="#expenditure" class="tab-link button active">支出明细</a>
                    <a href="#income" class="tab-link button">收益明细</a>
                </div>
                <div class="tabs">
                    <div id="expenditure" class="tab active details_list">
                        <div class="taptop"><span>类型/时间</span><span class="topright">支出</span></div>


                        <div class="li"><div><p>竞拍消费</p><p>2019-03-28 10:48:24</p></div><div>-5赠币</div></div>  </div>
                    <div id="income" class="tab details_list">
                        <div class="taptop"><span>类型/时间</span><span class="topright">收益</span></div>

                        <div class="li"><div><p>新人注册赠币</p><p>2019-03-28 10:45:13</p></div><div>200赠币</div></div>  <div class="li"><div><p>完成任务奖励</p><p>2019-03-28 10:45:13</p></div><div>10购物币</div></div>  </div>
                </div>
            </div>
        </div>
<style>
    .taptop{padding-top: .2rem;padding-bottom: .2rem;font-size: 14px;border-bottom: 1px solid #E8E8E8;padding-left: .75rem;padding-right: .75rem;}
    .topright{float: right;}
    .details_list .li{height:2.5rem;border-bottom:solid 1px #ccc;padding:0 0.75rem;display:-webkit-box;display:-webkit-flex;display:flex}
    .details_list .li div{-webkit-box-flex:1;-webkit-flex:1;flex:1;line-height:2.5rem;font-size:0.7000000000000001rem;text-align:right;color:#333;}
    .details_list .li div:first-child{text-align:left;padding:0.375rem 0;line-height:0.875rem}
    .details_list .li div:first-child p{font-size:0.5rem}
    .details_list .li div:first-child p:first-child{font-size:0.6rem;color:#666;}
    .details_list .li.thead{font-size:0.6rem;height:1.5rem;line-height:1.5rem}
    .details_list .li.thead div{font-size:0.6rem;line-height:1.5rem}
    .details_list .li.thead div:first-child{line-height:1.5rem;padding:0;}
    .details_list .li.thead div:last-child{color:#999 !important}
</style>
<div class="popup popup-about">
    <header class="bar bar-nav">
        <a class="button button-link button-nav pull-left close-popup" style="padding-top: .5rem;">
            <span style="color: #999999;" class="icon icon-left"></span>
        </a>
        <h1 class="title">拍币说明</h1>
    </header>
    <div class="content">
        <div class="content-inner">
            <div class="content-block">
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="lists">
    @verbatim
    {{# for(var i = 0, len = d.length; i< len; i++){ }}
    <div class="li"><div><p>{{d[i].remark}}</p><p>{{d[i].createtime}}</p></div><div>{{d[i].num}}{{d[i].type}}</div></div>
    {{# } }}
    @endverbatim
</script>
<script>
    $(function(){
        get_recode();
    });

    function get_recode(){
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=mybalance",{},function(d) {
            if(d.down.length!=''){
                var gettpl = document.getElementById('lists').innerHTML;
                laytpl(gettpl).render(d.down, function(html) {
                    $("#expenditure").append(html);
                });
            }
            if(d.up.length!=''){
                var gettpl = document.getElementById('lists').innerHTML;
                laytpl(gettpl).render(d.up, function(html) {
                    $("#income").append(html);
                });
            }
        }, "json");
    }

</script>

<script>
    wx.ready(function () {
        var shareData = {
            title: "iPhoneX仅需一折即可到手，快来抢购！！！",
            desc: "131****7904倾力推荐，赶快来领取！",
            link: "",
            imgUrl: "http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/JkV20zARKqBd2buaDDmVbu7VdJ8cdc.png",
        };
        //分享朋友
        wx.onMenuShareAppMessage({
            title: shareData.title,
            desc: shareData.desc,
            link: shareData.link,
            imgUrl:shareData.imgUrl,
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
            imgUrl:shareData.imgUrl,
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

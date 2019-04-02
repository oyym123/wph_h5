@extends('layouts.h5')
@section('title')
    最新成交
@stop
@section('title_head')
    最新成交
@stop
@section('content')
<style>
    .icondiv {
        border: 1px solid #c7c7cc;
        padding-top: 3px;
        padding-bottom: 3px;
        border-radius: 5px;
    }

    .coupon {
        border: 1px solid #c7c7cc;
        padding-top: 3px;
        padding-bottom: 3px;
        border-radius: 5px;
    }

    .payicon {
        width: 2rem;
        height: 2rem;
    }

    .redtip {
        color: #EF1544;
        display: none;
    }

    .smalltip {
        color: #999999;
        font-size: 12px;
    }

    .focus {
        border-color: #EF1544;
        color: #EF1544;
    }
</style>

        <div class="content native-scroll">
            <div class="list-block" style="margin: 0.6rem 0;">
                <ul>
                    <li>
						<span class=" item-content list-button-order">
		              	<div class="item-inner">
		                	<div class="item-title">选择充值金额</div>
		              	</div>
		            </span>
                    </li>
                    <li>
                        <div style="padding: 0 .75rem 1rem;text-align: center;">
                            <div class="row order-row" style="margin-top: 1rem;">
                                <div class="col-33">
                                    <div class="icondiv focus" num="50">
                                        <span class="property">50</span>
                                    </div>
                                </div>
                                <div class="col-33">
                                    <div class="icondiv" num="100">
                                        <span class="property">100</span>
                                    </div>
                                </div>
                                <div class="col-33">
                                    <div class="icondiv" num="200">
                                        <span class="property">200</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row order-row" style="margin-top: 1rem;">
                                <div class="col-33">
                                    <div class="icondiv" num="300">
                                        <span class="property">300</span>
                                    </div>
                                </div>
                                <div class="col-33">
                                    <div class="icondiv" num="500">
                                        <span class="property">500</span>
                                    </div>
                                </div>
                                <div class="col-33">
                                    <div class="											icondiv
											" num="0">
										<span class="property">
											<input onchange="changenum(this)" value="" id="custom" style="height: 24px;color: #EF1544;" type="tel" placeholder="其他金额"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="list-block" style="margin: 0.6rem 0;">
                <ul>
                    <li>
						<span class=" item-content list-button-order">
		              	<div class="item-inner">
		                	<div class="item-title">预计获得</div>
		                	<div class="item-after" style="color:#EF1544;">
		                		<span id="fastauctioncoin">
		                					                					                					                		</span>
		                				                		拍币
			</div>
		</div>
		</span>
                    </li>
                </ul>
            </div>
            <!--<div class="list-block" style="margin: 0.6rem 0;margin-bottom: 0;">
                      <ul>
                        <li>
                            <span class=" item-content list-button-order">
                                  <div class="item-inner">
                                    <div class="item-title" >选择充值方式</div>
                                    <div class="item-after" style="color:#EF1544;">￥<span id="moneynum">50</span></div>
                                    <input type="hidden" id="payprice" value="50" />
                                    <input type="hidden" name="give" id="give" value="" />
                                  </div>
                            </span>
                        </li>
                        <li>
                            <label for="alipay">
                                <span class="item-content list-button-order">
                                      <div class="item-inner">
                                        <div class="item-title" >
                                            <img class="payicon" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/zhifubao.png" />
                                            <div style="display: inline-block;position: relative;top: -4px;">
                                                <span>支付宝</span><span class="redtip">2元起</span><br />
                                                <span class="smalltip">推荐安装支付宝用户使用(2元起)</span>
                                            </div>
                                        </div>
                                        <div class="item-after">
                                            <input class="paytype" type="radio" value="alipay" name="paytype" id="alipay" />
                                        </div>
                                      </div>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label for="wechat">
                                <span class="item-content list-button-order">
                                      <div class="item-inner">
                                        <div class="item-title" >
                                            <img class="payicon" src="https://demo.weliam.cn/addons/weliam_fastauction/app/resource/images/weixin.png" />
                                            <div style="display: inline-block;position: relative;top: -4px;">
                                                <span>微信支付</span><span class="redtip">2元起</span><br />
                                                <span class="smalltip">推荐安装微信用户使用(2元起)</span>
                                            </div>
                                        </div>
                                        <div class="item-after">
                                            <input class="paytype" type="radio" value="wechat" name="paytype" id="wechat" />
                                        </div>
                                      </div>
                                </span>
                            </label>
                        </li>
                      </ul>
                    </div> -->
            <label for="weuiAgree" class="weui-agree" onclick="changecolor()">
                <input id="weuiAgree" type="checkbox" checked="checked" style="width: 16px;height: 16px;" class="weui-agree__checkbox">
                <span class="weui-agree__text" style="font-size: 16px;">
	                                {{--阅读并同意<a href="javascript:;" class="external open-popup" data-popup=".popup-about">《用户协议》</a>--}}
	                                阅读并同意<a href="/h5/user/user-agreement" >《用户协议》</a>
	            </span>
            </label>
            <div class="weui-btn-area" style="margin-top: .6rem;">
                <a class="weui-btn weui-btn_primary external" id="showTooltips" style="background-color: #EF1544;" href="javascript:register()">确认充值</a>
                <input type="hidden" id="payprice" value="
									">
            </div>
        </div>

<div class="popup popup-about">
    <header class="bar bar-nav">
        <a class="button button-link button-nav pull-left close-popup" style="padding-top: .5rem;">
            <span style="color: #999999;" class="icon icon-left"></span>
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


    function changecolor() {
        if(!$('#weuiAgree').is(":checked")) {
            $('#showTooltips').css('background-color', '#aaa')
        } else {
            $('#showTooltips').css('background-color', '#EF1544')
        }
    }

    function changenum(custom) {
        if(($(custom).val().toString()).indexOf(".") > -1) {
            $.toast('充值金额必须为整数');
        }
        var num = Math.round($(custom).val());
        $(custom).val(num);
        $('#fastauctioncoin').text(num);
        $('#moneynum').text(num);
        $('#payprice').val(num);
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=checkgive", {
            num: num
        }, function(d) {
            $('#givecoin').text(d.data);
        }, "json");

        //		if(num<2){
        //			$('.redtip').show();
        //			$('.paytype').hide();
        //			$('.paytype').attr("checked",false);
        //		}else{
        //			$('.redtip').hide();
        //			$('.paytype').show();
        //		}
    }
    $('.icondiv').click(function() {
        $('.icondiv').each(function() {
            $(this).removeClass('focus');
        });
        $(this).addClass('focus');
        $('#custom').val('');
        var num = $(this).attr('num');
        $('#fastauctioncoin').text(num);
        $('#moneynum').text(num);
        $('#payprice').val(num);
        if(num < 2) {
            $('.redtip').show();
            $('.paytype').hide();
            $('.paytype').attr("checked", false);
        } else {
            $('.redtip').hide();
            $('.paytype').show();
        }
    });
    $('.coupon').click(function(e) {

        var kilometre = $(this).find('.kilometre').attr('id');
        $('#moneynum').text(kilometre);
        $('#payprice').val(kilometre);
        var kilmoney = $(this).find('.kilmoney').attr('id');
        $('#fastauctioncoin').text(kilometre);
        $('#givecoin').text(kilmoney);
    })

    function register() {
        if($('#weuiAgree').is(":checked")) {
            var paytype = $('.paytype:checked').val();
            var price = $('#payprice').val();
            if(price <= 0) {
                $.toast('请输入充值金额');
                return false;
            }
            window.location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=member&ac=user&do=recharge&op=topay" + '&price=' + price;
        }
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

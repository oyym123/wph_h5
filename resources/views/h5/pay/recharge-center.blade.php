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
                            <div class="row order-row" style="margin-top: 0rem;">
                                @foreach($list as $key=>$v)
                                    <div class="col-33" style="margin-top: 1rem;">
                                        <div  @if($key==1) class="icondiv focus" @else class="icondiv"   @endif num= "{{ $v['amount'] }}"
                                              num2= "{{ $v['gift_amount'] }}" card_id="{{ $v['id'] }}">
                                            <span class="property" >
                                                {{$v['amount']}}拍币
                                                      <p style="font-size: .3rem;top: 1rem;color: red">赠送{{$v['gift_amount']}}拍币</p>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
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

            <div class="list-block" style="margin: 0.6rem 0;">
                <ul>
                    <li>
						<span class=" item-content list-button-order">
		              	<div class="item-inner">
		                	<div class="item-title">充值金额</div>
		                	<div class="item-after" style="color:#EF1544;">
		                		<span id="fastauctioncoin2">
                                </span>
                                拍币
			                </div>

		                </div>
		            </span>
                    </li>
                </ul>
            </div>
            <label for="weuiAgree" class="weui-agree" onclick="changecolor()">
                <input id="weuiAgree" type="checkbox" checked="checked" style="width: 16px;height: 16px;" class="weui-agree__checkbox">
                <span class="weui-agree__text" style="font-size: 16px;">
	                                {{--阅读并同意<a href="javascript:;" class="external open-popup" data-popup=".popup-about">《用户协议》</a>--}}
	                                阅读并同意<a href="/h5/user/user-agreement" >《用户协议》</a>
	            </span>
            </label>
            <div class="weui-btn-area" style="margin-top: .6rem;">
                <a class="weui-btn weui-btn_primary external" id="showTooltips" style="background-color: #EF1544;" href="javascript:register()">确认充值</a>
                <input type="hidden" id="payprice" value="">
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
        $.post("/?i=37&c=entry&m=_fastauction&p=member&ac=user&do=checkgive", {
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
        var num2 = $(this).attr('num2');
        var card_id = $(this).attr('card_id');

        $('#fastauctioncoin').text(num*1+num2*1);
        $('#fastauctioncoin2').text(num);
        $('#moneynum').text(num);
        $('#payprice').val(card_id);
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
            window.location.href = "/h5/pay/recharge" + '?id=' + price;
        }
    }
</script>

@parent
@stop

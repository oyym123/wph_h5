@extends('layouts.h5')
@section('title')
    首页
@stop

@section('content')
    <script src="{{ asset('js/h5/light7-city-picker.js') }}" type="text/javascript" charset="utf-8"></script>
    <div class="page-group">
        <div class="page page-current" id="page-index">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;"
                   href="javascript:history.go(-1);">
                    <span style="color: #999999;" class="icon icon-left"></span>
                </a>
                <h1 class="title">收货信息</h1>
                <style>
                    * {
                        touch-action: none;
                    }
                </style>
            </header>
            <div class="content native-scroll">
                <div class="list-block" style="margin-top: .75rem;">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">收货人</div>
                                    <div class="item-input">
                                        <input type="text" id="addressname" value="{{$address_info['username']}}"
                                               placeholder="请输入收货人姓名">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">手机号</div>
                                    <div class="item-input">
                                        <input type="tel" id="mobile" value="{{$address_info['telephone']}}" placeholder="用户物流通知">
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">选择地区</div>
                                    <div class="item-input">
                                        <input type="text" id="city-picker" value="  " readonly="">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">详细地址</div>
                                    <div class="item-input">
                                        <input type="text" id="addressdata" value="{{ $address_info['address'] }}" placeholder="请填写具体地址">
                                    </div>
                                </div>
                            </div>
                        </li>
                        {{--<li>--}}
                            {{--<div class="item-content">--}}
                                {{--<div class="item-inner">--}}
                                    {{--<div class="item-title label">其他备注</div>--}}
                                    {{--<div class="item-input">--}}
                                        {{--<input type="text" id="remarks" value="" placeholder="请填写备注">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}

                    </ul>
                </div>
                <br/>
                <br/>
                <button onclick="validate()" class="weui-btn weui-btn_primary"
                        style="background-color: rgb(239, 21, 68)">新增地址
                </button>
            </div>
        </div>
    </div>
    <script>
        $("#city-picker").cityPicker({
            toolbarTemplate: '<header class="bar bar-nav">\
	    <button class="button button-link pull-right close-picker">确定</button>\
	    <h1 class="title">选择收货地址</h1>\
	    </header>'
        });
        function validate() {
            var addressname = $("#addressname").val();
            var mobile = $("#mobile").val();
            var remarks = $("#remarks").val();
            var citys = $('#city-picker').val();
            var addressdata = $("#addressdata").val();

            if (addressname == '') {
                $.toast('请填写收货人姓名');
                return false;
            }
            if (!(/^1[34578]\d{9}$/.test(mobile))) {
                $.toast("手机号码有误，请重填");
                return false;
            }
            if (citys.length == 2) {
                $.toast("请选择您的地区");
                return false;
            }
            if (addressdata == '') {
                $.toast('请填写详细地址');
                return false;
            }

            $.post("address", {
                addressname: addressname,
                mobile: mobile,
                citys: citys,
                addressdata: addressdata,
                remarks: remarks,
            }, function (d) {
                if (d.code >= 0) {
                    $.toast("修改成功");
                    var product_id = '{{ $order_info['product_id'] }}';
                    if (product_id > 0) {
                        var period_id = '{{ $order_info['period_id']}}';
                        var sn = '{{ $order_info['sn'] }}';
                        location.href = "/h5/pay/confirm?product_id=" + product_id + "&period_id=" + period_id + "&sn=" + sn;
                    } else {
                        location.href = "center";
                    }
                } else if (d.code < 0) {
                    $.toast(d.message);
                } else {
                    $.toast("未知错误");
                }
            }, "json");
        }

        document.addEventListener('touchstart', function (event) {
            // 判断默认行为是否可以被禁用
            if (event.cancelable) {
                // 判断默认行为是否已经被禁用
                if (!event.defaultPrevented) {
                    event.preventDefault();
                }
            }
        }, false);
    </script>
    @parent
@stop


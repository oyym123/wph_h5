@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
   购物币专区
@stop
@section('content')


<script type="text/html" id="goodslists">
    @verbatim
    {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
    <div class="gooddiv">
        <div class="collection">
            <input type="hidden" name="cl" class="cl" value=""/>

        </div>
        <div onclick="togoods({{d.data[i].id}})">
    <span class="goodimg" id="logo{{d.data[i].img_cover}}">
    <img class="goodlogo" src="{{ d.data[i].img_cover}}"/>
    </span>
            <p id="sy{{d.data[i].id}}" sytime='{{d.data[i].countdown}}' perid="{{d.data[i].id}}"
               class="downtime"></p>
            <input type="hidden" value="0" id="end{{d.data[i].id}}"/>
            <input type="hidden" value="{{d.data[i].bid_price}}" id="mid{{d.data[i].id}}"/>
            <input type="hidden" id="period_ids" value="{{d.data[i].id}}"/>
            <p class="goodmoney tipout" id="bg{{d.data[i].id}}">￥<span
                        id="money{{d.data[i].id}}">{{d.data[i].bid_price}}</span></p>
            <p id="name{{d.data[i].id}}" class="goodmember">{{d.data[i].title}}</p>
            <span class="toauc" id="perbutton{{d.data[i].id}}">{{# if(d.data[i].businessflag == 0){ }}
                    歇业中{{# }else{ }}参与竞拍{{# } }}</span>
        </div>
    </div>
    {{# } }}
    @endverbatim
    <div style="clear: both;"></div>
</script>
<script>
    $(function () {
        get_goods(6);
        $('#J-deallistWrapper').vTicker();
        var tt = setInterval("begin()", 9000);
        if ($(window).height() > 700) {
            $('.txt').css('margin-top', '67%');
        }
    });
    function get_goods(type) {
        $.get("home/get-period", {
            type: type
        }, function (d) {
            if (d.data.length != '') {
                console.log(d);
                var gettpl = document.getElementById('goodslists').innerHTML;
                laytpl(gettpl).render(d, function (html) {

                    $("#listgoods").empty();
                    if (type == 2) {
                        $("#collection").empty()
                        $("#collection").append(html);
                        $(".cl").val(1);
                        if (d.length > 0) {
                            $("#listcol").hide();
                        }
                    } else if (type == 7) {
                        $("#selfing").empty();
                        $("#selfing").append(html);
                        $(".cl").val('');
                        if (d.length > 0) {
                            $("#listing").hide();
                        }
                    } else {
                        $(".cl").val('');
                        $("#listgoods").append(html);
                    }
                });
            }
        }, "json");
    }


</script>

@parent
@stop

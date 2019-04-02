@extends('layouts.h5')
@section('title')
    出价记录
@stop
@section('title_head')
    出价记录
@stop
@section('content')
<style>
    .buysuccess{margin-top: .5rem;background-color: white;padding-left: .5rem;padding-right: .5rem;padding-top: 4px;padding-bottom: 0px;font-size: 16px;}
    .infoname{display: inline-block;width: 30%;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;}
    .infostatus{display: inline-block;width: 15%;}
    .infoaddress{display: inline-block;width: 35%;}
    .infoprice{display: inline-block;float: right;}
    .infolist{font-size: 13px;padding-top: .3rem;padding-bottom: .3rem;}
    .infolist>div{display: flex;align-items: center;justify-content: space-between;padding:.25rem 0 .25rem .2rem}
    .infolist .icon{position: relative;}
</style>

        <div class="content native-scroll">
            <div class="buysuccess">
                <div class="infolist" id="infolist">
                    <div style="color: #EF1544;"><i class="icon iconfont icon-mobile"></i><span class="infoname">薛宝章</span><span class="infostatus">领先</span><span class="infoaddress">河北保定</span><span class="infoprice">￥919.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">爱飞我所爱</span><span class="infostatus">出局</span><span class="infoaddress">河北张家</span><span class="infoprice">￥919.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥919.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥919.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">等待山花儿开</span><span class="infostatus">出局</span><span class="infoaddress">河北张家</span><span class="infoprice">￥919.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">媛媛</span><span class="infostatus">出局</span><span class="infoaddress">广西柳州</span><span class="infoprice">￥919.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">阳光明媚</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥919.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">刘国</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥918.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥918.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">寒夜露珠</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥918.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">Charryhan</span><span class="infostatus">出局</span><span class="infoaddress">江苏南京</span><span class="infoprice">￥918.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">合拾⑩</span><span class="infostatus">出局</span><span class="infoaddress">湖南郴州</span><span class="infoprice">￥918.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥918.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥918.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">梦瑶</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥918.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">吴玉啄</span><span class="infostatus">出局</span><span class="infoaddress">河北沧州</span><span class="infoprice">￥918.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">安年°</span><span class="infostatus">出局</span><span class="infoaddress">福建厦门</span><span class="infoprice">￥918.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">庆芳__</span><span class="infostatus">出局</span><span class="infoaddress">广东惠州</span><span class="infoprice">￥917.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥917.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">寒夜露珠</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥917.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">Charryhan</span><span class="infostatus">出局</span><span class="infoaddress">江苏南京</span><span class="infoprice">￥917.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">李慧子</span><span class="infostatus">出局</span><span class="infoaddress">河北邯郸</span><span class="infoprice">￥917.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥917.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥917.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">qkvhq</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥917.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">小柯</span><span class="infostatus">出局</span><span class="infoaddress">重庆武隆</span><span class="infoprice">￥917.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">彬哥</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥917.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">心太姥</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥916.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥916.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">寒夜露珠</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥916.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">miaomiaomiao</span><span class="infostatus">出局</span><span class="infoaddress">黑龙江哈尔滨</span><span class="infoprice">￥916.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">暧心少年づ</span><span class="infostatus">出局</span><span class="infoaddress">广州深圳</span><span class="infoprice">￥916.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥916.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥916.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">淡漠</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥916.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">Just Maybe</span><span class="infostatus">出局</span><span class="infoaddress">台湾桃园</span><span class="infoprice">￥916.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">初一</span><span class="infostatus">出局</span><span class="infoaddress">山东东营</span><span class="infoprice">￥916.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">Ronin. （浪人）</span><span class="infostatus">出局</span><span class="infoaddress">广东东莞</span><span class="infoprice">￥915.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥915.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">微客</span><span class="infostatus">出局</span><span class="infoaddress">河北沧州</span><span class="infoprice">￥915.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">紫霞仙子</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥915.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">冰果荳荳</span><span class="infostatus">出局</span><span class="infoaddress">湖南长沙</span><span class="infoprice">￥915.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥915.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥915.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">素子</span><span class="infostatus">出局</span><span class="infoaddress">广东东莞</span><span class="infoprice">￥915.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">影</span><span class="infostatus">出局</span><span class="infoaddress">河北邯郸</span><span class="infoprice">￥915.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">小号2</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥915.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">李慧子</span><span class="infostatus">出局</span><span class="infoaddress">河北邯郸</span><span class="infoprice">￥914.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥914.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">玉帛园林</span><span class="infostatus">出局</span><span class="infoaddress">西藏阿里</span><span class="infoprice">￥914.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">彦</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥914.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">俄罗斯商品批发零售</span><span class="infostatus">出局</span><span class="infoaddress">河北沧州</span><span class="infoprice">￥914.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">。</span><span class="infostatus">出局</span><span class="infoaddress">河南濮阳</span><span class="infoprice">￥914.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥914.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">真帅真帅</span><span class="infostatus">出局</span><span class="infoaddress">山东菏泽</span><span class="infoprice">￥914.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">慧</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥914.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">彬哥</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥914.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">流星花园</span><span class="infostatus">出局</span><span class="infoaddress">河北张家</span><span class="infoprice">￥913.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥913.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">彬彬有礼</span><span class="infostatus">出局</span><span class="infoaddress">河北唐山</span><span class="infoprice">￥913.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">雨中哭泣</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥913.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">介仁移门13806163862邹贤国</span><span class="infostatus">出局</span><span class="infoaddress">江苏无锡</span><span class="infoprice">￥913.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">＠_＠</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥913.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥913.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">S1589484</span><span class="infostatus">出局</span><span class="infoaddress">台湾台北</span><span class="infoprice">￥913.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">心太姥</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥913.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">琴声悠扬</span><span class="infostatus">出局</span><span class="infoaddress">河南驻马</span><span class="infoprice">￥913.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">绿色花相</span><span class="infostatus">出局</span><span class="infoaddress">黑龙佳木</span><span class="infoprice">￥912.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥912.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">芳</span><span class="infostatus">出局</span><span class="infoaddress">河北廊坊</span><span class="infoprice">￥912.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">丫丫</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥912.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">雨过天晴</span><span class="infostatus">出局</span><span class="infoaddress">四川成都</span><span class="infoprice">￥912.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">骄骄</span><span class="infostatus">出局</span><span class="infoaddress">河北沧州</span><span class="infoprice">￥912.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥912.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">欢乐</span><span class="infostatus">出局</span><span class="infoaddress">河北邯郸</span><span class="infoprice">￥912.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">互信互联</span><span class="infostatus">出局</span><span class="infoaddress">福建福州</span><span class="infoprice">￥912.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">琴声悠扬</span><span class="infostatus">出局</span><span class="infoaddress">河南驻马</span><span class="infoprice">￥912.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">花样的年华</span><span class="infostatus">出局</span><span class="infoaddress">河北廊坊</span><span class="infoprice">￥911.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥911.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">芳</span><span class="infostatus">出局</span><span class="infoaddress">河北廊坊</span><span class="infoprice">￥911.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">嗯</span><span class="infostatus">出局</span><span class="infoaddress">香港九龙</span><span class="infoprice">￥911.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">爱飞我所爱</span><span class="infostatus">出局</span><span class="infoaddress">河北张家</span><span class="infoprice">￥911.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">嫣红</span><span class="infostatus">出局</span><span class="infoaddress">河北石家</span><span class="infoprice">￥911.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥911.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">快乐人生</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥911.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">爱你</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥911.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">我憋尿很厉害</span><span class="infostatus">出局</span><span class="infoaddress">陕西西安</span><span class="infoprice">￥911.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">180****4548</span><span class="infostatus">出局</span><span class="infoaddress">海南三亚</span><span class="infoprice">￥910.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥910.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">芳</span><span class="infostatus">出局</span><span class="infoaddress">河北廊坊</span><span class="infoprice">￥910.70</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">赤乌</span><span class="infostatus">出局</span><span class="infoaddress">河南开封</span><span class="infoprice">￥910.60</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">缔宁</span><span class="infostatus">出局</span><span class="infoaddress">山东潍坊</span><span class="infoprice">￥910.50</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">丫丫</span><span class="infostatus">出局</span><span class="infoaddress">河北保定</span><span class="infoprice">￥910.40</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">时光无声@.</span><span class="infostatus">出局</span><span class="infoaddress">河北秦皇</span><span class="infoprice">￥910.30</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">みつは</span><span class="infostatus">出局</span><span class="infoaddress">广东深圳</span><span class="infoprice">￥910.20</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">郑金成（鑫盛大酒店）</span><span class="infostatus">出局</span><span class="infoaddress">福建泉州</span><span class="infoprice">￥910.10</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">太委屈 grievance @</span><span class="infostatus">出局</span><span class="infoaddress">云南昆明</span><span class="infoprice">￥910.00</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">圆圆</span><span class="infostatus">出局</span><span class="infoaddress">河南南阳</span><span class="infoprice">￥909.90</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">繁花入梦</span><span class="infostatus">出局</span><span class="infoaddress">重庆重庆</span><span class="infoprice">￥909.80</span></div>
                    <div><i class="icon iconfont icon-mobile"></i><span class="infoname">芳</span><span class="infostatus">出局</span><span class="infoaddress">河北廊坊</span><span class="infoprice">￥909.70</span></div>
                </div>
            </div>
        </div>
@parent
@stop

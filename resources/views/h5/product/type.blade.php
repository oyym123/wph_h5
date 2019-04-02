@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    微排行
@stop
@section('content')
        <div class="content native-scroll">
            <div class="mui-scroll-wrapper mui-content" id="mainContainer" style="z-index: 1; background-color: white;">
                <div class="mui-scroll" style="transform: translate3d(0px, 0px, 0px) translateZ(0px);">
                    <ul class="ui-tags-ct container" id="J-mainCt" style="padding-bottom: 2rem;">     <li class="" style="display:block" onclick="togoods(7)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39081">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/N91ZRoJJ71O8oTjJMVe1eeeL4Jjj99.png">     </a>     <div class="titles" style="height: 2.2rem;">中国黄金 中国国宝金元宝</div>     <div class="price_wraps" id="end39081">      <div class="price_cur tipout" id="money39081">￥2379.10</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(17)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39176">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/kF2nPnXnYxmWk2kMgxr1RFwM923rR4.png">     </a>     <div class="titles" style="height: 2.2rem;">Apple iPhone X 64GB 颜色随机</div>     <div class="price_wraps" id="end39176">      <div class="price_cur tipout" id="money39176">￥623.90</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(18)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39112">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/JkV20zARKqBd2buaDDmVbu7VdJ8cdc.png">     </a>     <div class="titles" style="height: 2.2rem;">Apple iPhone X 256GB 颜色随机</div>     <div class="price_wraps" id="end39112">      <div class="price_cur tipout" id="money39112">￥1263.80</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(19)">    <div class="goods ui-mark-1">     <a class="cover" id="logo13808">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/rQqxS5Gzw8bbq7wK70qJu10Xx6G70C.png">     </a>     <div class="titles" style="height: 2.2rem;">Apple iPhone 7 Plus 256GB  颜色随机</div>     <div class="price_wraps" id="end13808">      <div class="price_cur tipout" id="money13808">￥2021.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(20)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39181">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Edyv5a2bTAFLdY0aGtzRTAl6buO02D.png">     </a>     <div class="titles" style="height: 2.2rem;">vivo X20Plus 全面屏手机  4GB+64GB 全网通 颜色随机</div>     <div class="price_wraps" id="end39181">      <div class="price_cur tipout" id="money39181">￥548.60</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(21)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39180">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/c16FTm1GVftTmmTgmTgZTO43Uj3T2m.png">     </a>     <div class="titles" style="height: 2.2rem;">华为 Mate 9 Pro 4GB+64GB 颜色随机</div>     <div class="price_wraps" id="end39180">      <div class="price_cur tipout" id="money39180">￥576.80</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(1)">    <div class="goods ui-mark-1">     <a class="cover" id="logo13551">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/pAwP8t3AqiozPm48jfpO8pq3fCJqbz.png">     </a>     <div class="titles" style="height: 2.2rem;">2017款 Apple iMac Pro 27英寸 3.2GHz八核处理器 32GB内存 1TB固态硬盘（发货周期一个月）</div>     <div class="price_wraps" id="end13551">      <div class="price_cur tipout" id="money13551">￥1667.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(22)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39190">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/RO4n593u53N5o2522Now8esn332WN2.png">     </a>     <div class="titles" style="height: 2.2rem;">荣耀 V10全网通 高配版 6GB+64GB 颜色随机</div>     <div class="price_wraps" id="end39190">      <div class="price_cur tipout" id="money39190">￥381.70</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(23)">    <div class="goods ui-mark-1">     <a class="cover" id="logo26089">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/HDUOxwb3b3Zbj3beUu93O3bbt9g9b3.png">     </a>     <div class="titles" style="height: 2.2rem;">大疆 精灵Phantom 4 Pro暗夜版 4K智能航拍无人机</div>     <div class="price_wraps" id="end26089">      <div class="price_cur tipout" id="money26089">￥919.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(24)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39200">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/m8337U47Y1F47YuqC43UIsDuQuIyZd.png">     </a>     <div class="titles" style="height: 2.2rem;">富士INSTAX mini7s一次成像胶片相机 颜色随机</div>     <div class="price_wraps" id="end39200">      <div class="price_cur tipout" id="money39200">￥167.30</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(25)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39153">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/V444Y924bWu4olAb89wl44wn0OY929.png">     </a>     <div class="titles" style="height: 2.2rem;">佳能 EOS 6D Mark II 单反套机（EF 24-105mm f/3.5-5.6 IS STM 镜头）</div>     <div class="price_wraps" id="end39153">      <div class="price_cur tipout" id="money39153">￥994.60</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(26)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39160">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/DZ6RhKYhlLBBezNYblrL666c6jNL66.png">     </a>     <div class="titles" style="height: 2.2rem;">索尼相机 颜色随机</div>     <div class="price_wraps" id="end39160">      <div class="price_cur tipout" id="money39160">￥865.00</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(16)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39148">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/F9mIZiFiuFUoo9XsegduWxUFY96SZX.png">     </a>     <div class="titles" style="height: 2.2rem;">松下 8公斤变频全自动滚筒洗衣机 XQG80-E78S2H</div>     <div class="price_wraps" id="end39148">      <div class="price_cur tipout" id="money39148">￥1058.20</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(15)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39141">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/f42zvyX547xYLU5zvvhuoIN8y48i88.png">     </a>     <div class="titles" style="height: 2.2rem;">荣泰 6125按摩椅 颜色随机</div>     <div class="price_wraps" id="end39141">      <div class="price_cur tipout" id="money39141">￥1215.80</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(14)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39169">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/oPMk5ZTkiYiGkPI2mjmYkhG78emEM4.png">     </a>     <div class="titles" style="height: 2.2rem;">海尔 BCD-458WDVMU1 458升变频风冷无霜多门冰箱</div>     <div class="price_wraps" id="end39169">      <div class="price_cur tipout" id="money39169">￥729.80</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(2)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39174">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/QwqYfYfRKKGKFgk4wzKgGRQKLfMBOF.png">     </a>     <div class="titles" style="height: 2.2rem;">2017款 Apple iPad Pro 12.9英寸 256GB WLAN版</div>     <div class="price_wraps" id="end39174">      <div class="price_cur tipout" id="money39174">￥376.10</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(3)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39202">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/NFYEZld2M7dI9pT6ID4eFps4zc7Hsl.png">     </a>     <div class="titles" style="height: 2.2rem;">ThinkPad X1 Carbon 2017（1DCD）14英寸轻薄笔记本电脑i7 8G 256GSSD FHD</div>     <div class="price_wraps" id="end39202">      <div class="price_cur tipout" id="money39202">￥135.10</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(4)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39203">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/dWlWvUmMwMXxiinOX9M294x4YwiwMQ.png">     </a>     <div class="titles" style="height: 2.2rem;">惠普 Elitebook 1040 G4 14英寸轻薄笔记本电脑（i7-7820HQ 16G 256G ）银色</div>     <div class="price_wraps" id="end39203">      <div class="price_cur tipout" id="money39203">￥79.20</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(5)">    <div class="goods ui-mark-1">     <a class="cover" id="logo11909">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/Ocp9jz53P4IO42EeZpdtAoD8PDPDJ8.png">     </a>     <div class="titles" style="height: 2.2rem;">中国黄金 Au9999黄金薄片投资金条100g</div>     <div class="price_wraps" id="end11909">      <div class="price_cur tipout" id="money11909">￥2829.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(6)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39205">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xpCwis9SSawWoBBwboWwIwOWsSc9bw.png">     </a>     <div class="titles" style="height: 2.2rem;">中国黄金 中国国宝生肖金条套装（2006-2017）2g*12</div>     <div class="price_wraps" id="end39205">      <div class="price_cur tipout" id="money39205">￥72.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(8)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39195">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/KccQH991wNrxQxZ6WX96BAhNnB2H22.png">     </a>     <div class="titles" style="height: 2.2rem;">海洋世家 海鲜礼盒大礼包3688型礼券</div>     <div class="price_wraps" id="end39195">      <div class="price_cur tipout" id="money39195">￥274.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(9)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39207">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/xN81zXokjXNeLGRNAC9VcxXfnx100k.png">     </a>     <div class="titles" style="height: 2.2rem;">三只松鼠 零食干果礼盒 12袋装 坚果大礼包2476g/盒（新老包装随机发放）</div>     <div class="price_wraps" id="end39207">      <div class="price_cur tipout" id="money39207">￥34.10</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(10)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39204">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/w7XmJw8xMGkut2Azu9mPxTgjmjzP6P.png">     </a>     <div class="titles" style="height: 2.2rem;">汤臣倍健 蛋白质粉 450g</div>     <div class="price_wraps" id="end39204">      <div class="price_cur tipout" id="money39204">￥78.50</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(12)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39186">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/eX1WvKwc3I7kffK70hU1P0Fup0CqC0.png">     </a>     <div class="titles" style="height: 2.2rem;">伊蒂之屋 恋恋樱花眼影盘8g 10色</div>     <div class="price_wraps" id="end39186">      <div class="price_cur tipout" id="money39186">￥66.00</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(13)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39206">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/MhWS4KKskzzcKAk24jkYSeqcYjEz2c.png">     </a>     <div class="titles" style="height: 2.2rem;">玉兰油 Olay 护肤套装新生塑颜臻粹音乐礼盒</div>     <div class="price_wraps" id="end39206">      <div class="price_cur tipout" id="money39206">￥51.80</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>     <li class="" style="display:block" onclick="togoods(27)">    <div class="goods ui-mark-1">     <a class="cover" id="logo39164">      <img src="http://operate.oss-cn-shenzhen.aliyuncs.com/images/37/2018/01/yFDdZsGhCQ5sqmofOUdfMuq1hHQUqm.png">     </a>     <div class="titles" style="height: 2.2rem;">索尼 PS4 17版 500G 电脑娱乐游戏主机 黑色</div>     <div class="price_wraps" id="end39164">      <div class="price_cur tipout" id="money39164">￥800.40</div>      <a class="bid_btn" style="margin-left: 2rem;"></a>     </div>    </div>   </li>   </ul>
                    <div class="mui-pull-bottom-pocket mui-block">
                        <div class="mui-pull">
                            <div class="mui-pull-loading mui-icon mui-spinner mui-hidden"></div>
                            <div class="mui-pull-caption mui-pull-caption-down"></div>
                        </div>
                    </div>
                </div>
                <div class="mui-scrollbar mui-scrollbar-vertical">
                    <div class="mui-scrollbar-indicator" style="transition-duration: 0ms; display: block; height: 277px; transform: translate3d(0px, 0px, 0px) translateZ(0px);"></div>
                </div>
            </div>

            <div class="ui-tags-tit" id="J-mainTags">
                <div class=" item-content active" onclick="showclass(this)" data-id="0" id="defut">
                    <div class="item-inner">
                        <a data-href="list27">全部商品</a>
                    </div>
                </div>
                <input type="hidden" name="cateid" id="cateid" value="">
                <div class="item-content" onclick="showclass(this)" data-id="1" id="">
                    <div class="item-inner">
                        <a data-href="list27">珠宝配饰</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="2" id="">
                    <div class="item-inner">
                        <a data-href="list27">电脑平板</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="4" id="">
                    <div class="item-inner">
                        <a data-href="list27">美妆个护</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="3" id="">
                    <div class="item-inner">
                        <a data-href="list27">美食天地</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="5" id="">
                    <div class="item-inner">
                        <a data-href="list27">生活家电</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="6" id="">
                    <div class="item-inner">
                        <a data-href="list27">手机专区</a>
                    </div>
                </div>
                <div class="item-content" onclick="showclass(this)" data-id="7" id="">
                    <div class="item-inner">
                        <a data-href="list27">数码音影</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/html" id="classlist">
    @verbatim
    {{# for(var i = 0, len = d.data.length; i< len; i++){ }}
    <li class="" style="display:block"  onclick="togoods({{d.data[i].id}})">
        <div class="goods ui-mark-1">
            <a class="cover" id="logo{{d.data[i].nowperiods}}">
                <img src="{{ d.data[i].logo }}">
            </a>
            <div class="titles" style="height: 2.2rem;">{{ d.data[i].name }}</div>
            <div class="price_wraps" id="end{{d.data[i].nowperiods}}" >
                <div class="price_cur tipout" id="money{{d.data[i].nowperiods}}">￥{{d.data[i].price}}</div>
                <a class="bid_btn" style="margin-left: 2rem;"></a>
            </div>
        </div>
    </li>
    {{# } }}
    @endverbatim
</script>
<script>
    var cateid=$('#cateid').val();
    if(cateid!=''){
        get_class(cateid);
        $('#'+cateid).addClass('active');
        $('#defut').removeClass('active');
    }else{
        get_class(0);
    }
    function showclass(obj) {

        var dataid = $(obj).attr('data-id');
        $('.item-content').each(function(){
            $(this).removeClass('active');
        });
        $(obj).addClass('active');
        get_class(dataid);
    }
    function get_class(id) {
        $(".container").empty();
        $.post(
            "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=getgoods", {
                id: id
            },
            function(d) {
                if(d.data){
                    $('#mainContainer').css('background-color','white');
                    var gettpl = document.getElementById('classlist').innerHTML;
                    laytpl(gettpl).render(d, function(html) {
                        $(".container").append(html);
                    });
                }else{
                    $(".container").append('<div class="nodata-default"></div>');
                    $('#mainContainer').css('background-color','#efeff4');
                }
            }, "json");
    }
    function togoods(id) {
        location.href = "https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=goods&ac=goods&do=detail&id=" + id;
    }
</script>

<script type="text/javascript">
    var ws, myclinent_id={};
    connect();
    // 连接服务端
    function connect() {
        // 创建websocket
//     	ws = new WebSocket("ws://114.215.91.124:8282");
        ws = new WebSocket("wss://websocket.weliam.cn:8282");
        // 当有消息时根据消息类型显示不同信息
        ws.onmessage = onmessage;
        ws.onclose = function() {
            console.log("连接关闭，定时重连");
            connect();
        };
        ws.onerror = function() {
            console.log("出现错误");
        };
    }

    // 连接建立时发送登录信息
    function onopens(client_id) {
        myclinent_id = client_id;
        $.post("https://demo.weliam.cn/app/index.php?i=37&c=entry&m=weliam_fastauction&p=dashboard&ac=home&do=login", {client_id:client_id}, function(data){
        }, 'html');
    }

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
                onopens(data['client_id']);
                break;
            // 出价信息
            case 'offer':
                $('#money'+data.perid).attr('class','price_cur tipin');
                var t = setTimeout(function(){
                    $('#money'+data.perid).attr('class','price_cur tipout');
                },20);
                $('#money'+data.perid).text('￥'+data.prtxt);
                break;
            case 'end':
                $('#end'+data.perid).addClass('traded');
                $('#logo'+data.perid).addClass('endimg');
                break;
        }
    }
</script>
        @parent
@stop

/**
 * Created by Alienware on 2018/8/17.
 */
var mainFunction = {
    questionList: [{
        ListName: "注册登录",
        content: [{
            question: "如何注册51微拍？",
            answer: ["(1)打开微信，点击‘发现’→‘小程序’", "(2)搜索框输入‘51微拍’，选择‘51微拍精品竞拍’；", "(3)进入小程序，点击授权登录即可。"]
        }]
    }, {
        ListName: "拍卖问题",
        content: [{
            question: "名词释义",
            answer: ["<b>拍币</b><br>51微拍用于竞拍的虚拟货币，每1拍币价值1元。可用于所有商品竞拍，不支持差价购买。<br><br>", "<b>赠币</b><br>非人民币充值所获，通常为活动奖励赠送；可用于实物商品竞拍，不支持虚拟商品竞拍和差价购买。<br><br>", "<b>购物币</b><br>竞拍失败系统自动返还所消耗拍币的100%称为购物币，购物币仅可用于差价购买，不支持任何商品竞拍。<br><br>", "<b>初始倒计时</b><br>商品设定的预热拍卖时间，初始倒计时30分钟即可参与竞拍。<br><br>", "<b>竞拍倒计时</b><br>初始倒计时完毕后，会进入竞拍倒计时，1元区竞拍倒计时为10S，10元区竞拍倒计时为5S，在竞拍倒计时内无人抢拍则拍卖成功。<br><br>", "<b>流拍</b><br>初始倒计时内无人出价，则此次拍卖不成立，商品流拍。<br><br>", "<b>起拍价</b><br>也叫最低成交价，51微拍所有商品按起拍价起拍<br><br>", "<b>成交价</b><br>当计时器为零时，该商品的竞拍价格为最终成交价格<br><br>", "<b>手续费</b><br>竞拍过程中每次出一次价需支付一定数额的拍币手续费"]
        }, {
            question: "竞拍怎么玩？",
            answer: ["步骤一：免费注册会员", "步骤二：充值购买拍币（1元=1拍币）", "步骤三：选择心仪商品出价，等待倒计时为0", "步骤四：竞拍成功，以最终成交价购买商品", "在您拍卖之前，我们建议您花点时间看看规则，以便您能尽快熟悉如何竞拍。"]
        }, {
            question: "如何购买拍币？",
            answer: ["登录后，点击首页的“充值”来购买拍币，1拍币=1元，选择你想要购买的金额，点击支付即可。<br>通过微信充值。"]
        }, {
            question: "竞拍采用什么规则？",
            answer: ["(1) 所有商品竞拍均为初始价开始，每出一次出价会消耗一定数量的拍币，同时商品价格以0.1元递增。", "(2) 在初始倒计时内即可出价，初始倒计时后进入竞拍倒计时，当您出价后，该件商品的计时器将被自动重置，以便其他用户进行出价竞争。如果没有其他用户对该件商品出价，计时器归零时，您便成功拍得了该商品。", "(3) 若拍卖成功，请在30天内以成交价购买竞拍商品，超过30天未下单，视为放弃，不返拍币。", "(4) 若拍卖失败，将返还所消耗拍币的100%，赠币除外。", "(5) 平台严禁违规操作，最终解释权归51微拍所有。"]
        }, {
            question: "竞拍有哪些技巧？",
            answer: ["(1)做好充足的准备<br>参与竞拍之前，准备充足的拍币，防止由于中途充值而错过竞拍时机。", "(2)积累竞拍经验<br>新用户注册后，通过使用赠送的拍币熟悉竞拍流程，从小件商品竞拍出发，积累竞拍经验。", "(3)选择合适的竞拍时段<br>参加竞拍的用户越少，获胜的几率越高，因此选择一个最佳时间参与竞拍是成功的关键，例如其他用户用餐、休息或约会时间。", "(4)变换出价策略<br>经常变换出价策略，让对手无法总结您的出价规律，出其不意取得最后的成功。", "(5)合理的预算<br>不要指望花10块钱就能赢得一台iphone，你需要花费更多的时间和金钱才有机会赢得大奖，我们发现任何参与者只要愿意花费奖品价值的1/3就能有很大几率获得该奖品。", "(6)保持良好的心态<br>娱乐竞拍是是一个游戏竞赛过程，因此良好的心态是获胜的必要条件。"]
        }, {
            question: "拍币/赠币/购物币能提现吗？",
            answer: ["不支持，竞买人充值获得的拍币可用于竞拍；赠币通常为活动奖励赠送，超过一年未使用不可返还；购物币有效期为30天（从获得购物币的时间算起，30天后失效），过期后不可使用不可恢复。"]
        }, {
            question: "什么是购物币？",
            answer: ["竞拍失败系统按比例自动返还所得，购物币仅可用于差价购买和购物币专区使用，不支持任何商品竞拍。<br><br>", "1）全品类的购物币有效期至2018-12-31；", "2）单个具体商品的购物币有效期为30天（从获得购物币的日期算起，30天后失效）同一商品在一元区和十元区所返购物币不可叠加使用<br><br>", "例如：小明在一元区和十元区分别消耗100个拍币竞拍商品“露娜MINI2净透舒缓洁面仪”均未拍中，则系统分两次返还100个购物币至小明财产账户，只能差价购买对应专区此款商品，不可叠加使用。"]
        }, {
            question: "没拍中能退钱吗？",
            answer: ["微拍有别于传统意义上的线下拍卖，对于拍中者而言属于超低价成交，对于未拍中者将有一定损耗，所参与竞拍的钱均无法退还。如果未拍中会退还所消耗拍币100%作为购物币，可用于差价购买和购物币专区使用。"]
        }, {
            question: "1元区和10元区有何区别？",
            answer: ["竞拍倒计时和出价手续费有所差别。<br>1元区：0元起拍，每出价一次消耗1拍币，竞拍倒计时为10S。<br>10元区：0元起拍，每出价一次消耗10拍币，竞拍倒计时为10S。"]
        }, {
            question: "为什么有些商品1元区和10元区同时都有呢？",
            answer: ["同样的商品，在1元区每出一次价消耗的拍币少，竞拍倒计时更长；而10元专区每次出价消耗拍币更多，竞拍倒计时更短，获得商品相对更容易。您可以根据个人喜好，选择不同专区竞拍心仪商品。"]
        }, {
            question: "何为差价购买？",
            answer: ["商品竞拍结束后，没有竞拍成功的用户，系统将自动返还所消耗拍币的100%至账户余额，用户可以通过补差价的方式获得拥有该商品的权利。<br>补差价金额=商品市场价-账户余额<br>例：某商品市场为500元，A用户消耗100拍币未能竞拍成功，系统返还100购物币至账户余额。那么A用户只需补足400元（500-100）支付订单即可获得该商品。"]
        }, {
            question: "为什么微拍商品市场价高于官方价？",
            answer: ["首先，作为竞拍平台，大部分商品均以超低价格成交，为保障平台长期稳定运营，更重要是确保广大用户能持续在平台以低价优势获得商品，部分商品价格需要有一定的上浮空间；<br>其次，为保证后期给用户带来更加实惠的采购价格，目前微拍采购渠道处于不断开发中，因而前期处于过渡阶段，部分商品在采购价格的基础上有一定上浮。随着采购渠道的不断完善，后期价格上浮比例会逐渐拉小。"]
        }, {question: "一场拍卖什么时候结束？", answer: ["当你看到计时器归零的时候就代表这场拍卖结束了。"]}, {
            question: "赢得了竞拍后应该怎么做？",
            answer: ["哇！恭喜您赢得了拍卖！<br>当然首先您需要以成交价格支付该商品，您可以点击“我拍中”-“待付款”-“支付订单”然后支付并填写您的收货信息，我们会及时给您安排发货。<br>请您在拍卖结束的30天内完成支付，否则视为自愿放弃商品。如果您有任何问题请联系客服。"]
        }, {
            question: "竞拍会产生什么费用？",
            answer: ["竞拍过程中每次出一次价需支付一定数额的拍币手续费<br>(1)竞拍成功，所消耗拍币不予返还。<br>(2)竞拍失败，可退还所消耗拍币100%。"]
        }, {
            question: "什么时候为停拍时段？",
            answer: ["为保证用户基本作息时间，51微拍每日凌晨2:00-7:00点为停拍时段，凌晨2:00前已进入10秒竞拍倒计时的商品可继续竞拍，2点前未进入10秒竞拍倒计时的商品将自动延迟到7:00。"]
        }, {
            question: "51微拍与其他拍卖app的差别？",
            answer: ["我知道我们是创新者，但是市面上仍然有许多竞争者，就让我们来告诉你，我们与众不同的优势在哪里，为什么你要把辛苦赚来的钱在51微拍上进行消费。<br><br>", "<b>起源</b><br>51微拍创立于2017年4月，我们的创始人经过自身的经验和详细的调查发现现有的拍卖行业存在一系列问题。我们创造出51微拍是以道德和公平为基础的商业策略，我们希望能够为用户提供一个有趣的拍卖过程，来积累干净的声誉，这是我们公司从始至终的方向。<br>说了这么多，这里有一些方法能让你知道51微拍是如何不同于其他拍卖而脱颖而出的：<br><br>", "<b>建立道德声誉</b><br>现在互联网上有许多所谓一元钱拍卖，但却是以骗钱为目的。我们51微拍认为一个公司如果没有可靠地声誉和道德底线是无法长久的生存下去的，我们开始申请许多社会奖项。<br>微拍最近也在思考邀请其他一家独立公司来监督我们的业务是公平合理的，微拍将来会邀请独立的会计师事务所来审计我们的商业模式以确保用户放在我们这的钱是安全的。<br><br>", "<b>“差价购买”功能</b><br>我们在所有拍卖平台中是为数不多设有“差价购买”功能的，它能保证只要用户需要，就绝不会空手而归。<br><br>", "<b>获胜的用户总占大多数</b><br>我们对比过其他的拍卖平台，微拍的新用户在第一天使用时有40%的人可以拍中奖品，这个比例远高于竞争者，而我们也在努力更加提高这个百分比，让用户快乐的竞拍使我们的使命。<br><br>", "<b>透明度和倾听用户</b><br>就像你们看到的，我们同样的，拍卖领域内为数不多提供许多技巧和窍门甚至透明了我们的商业模式，我们非常愿意倾听用户的声音以便能够更加进步。<br>为什么我们会这么做？因为您，如果没有您就没有我们。我们感激您的每一条建议。<br><br>", "<b>优质的客户服务</b><br>最后一个话题是我们很棒的客户服务，我们每一个工作人员都在努力维护您的利益，我相信我们的客户服务是首屈一指的，服务好您就是我们最高的商业价值。<br>我们工作时间电话永远为您打开，以最快的速度发货等等。<br>未来我们将会有更多优势，希望您能与我们一同见证！"]
        }, {
            question: "51微拍如何向用户提供如此低廉的价格？",
            answer: ["51微拍上每天销售的商品全部低于市场价60%-90%，我们之所以可以以如此低廉的价格拍出是因为我们51微拍内置的独特拍卖模式。<br><br>", "在传统的拍卖行里，每个都需要以更高的价格去压过前一个报价者，对吧？所以在传统拍卖里，最终成交的价格多是以接近市场售价的价格拍得商品。<br><br>", "而微拍却能保证几乎所有用户都能以远低于市场售价的价格来获得商品。<br><br>", "例如：在京东商城上卖的iphone7售价6000元，但在微拍上的拍卖成交价格仅为650元，让我们算一算是怎么回事<br><br>", "微拍在花了6000元买了一台iphone7随后就挂在app上进行拍卖，最终一位用户以650元的价格成交了这部手机。因为每次报价是1拍币，价格上涨是0.1元幅度，所以在这过程中有6500次报价。<br>1拍币=1元<br>微拍的收入：6500拍币 * 1= 6500<br>微拍购买iphone7的成本：6000元<br>用户最终获得手机的成本：650元<br><br>", "在这样一场拍卖中，微拍获得了足够的收入来覆盖成本，而用户也以难以置信的价格获得了一台iphone7，但是那些没有最终胜利的用户呢？<br><br>", "微拍是一个公平公正的平台，所以我们提供了“差价购买”功能能够让没有赢得拍卖的用户有机会以差价的价格来直接购买商品。<br>相信我们，所有用户都不会在微拍上浪费一分钱！"]
        }, {
            question: "为什么会出现竞拍卡顿现象？",
            answer: ["微拍每天都有成千上万的用户参加，我们统计过，仅有万分之一的用户会遇到卡顿的情况，究竟这种情况是怎么发生的？又如何避免呢？请注意以下提到的几点：<br><br>", "1.参与竞拍前请检查您手机当前网络是否通畅。 <br>", "一般网络信号不足2格的时候，就容易出现倒计时停顿的现象，这并不是竞拍停止，而是您当前网络差页面未能及时刷新的现象。而实际竞拍仍在进行中，网络正常的用户的显示也都是同步的。<br><br>", "2.优质的手机配置是顺利竞拍的硬性条件 <br>", "配置较低的手机及系统运行速度会相对缓慢，显示也容易出现延缓的情况。一般来讲同样的网络环境下iPhone7会比iPhone5反应速度更快。所以选择性能较好的手机非常有必要哦。<br><br>", "3.网络信号良好的情况下，4G网络会比WiFi网络更稳定。<br>", "因微拍为减少用户流量和电量的消耗，目前把刷新价格的频率设定为1秒1次，如果竞拍中有1秒网络不稳定，就有可能体验到卡顿1秒的情况。当出现卡顿时，可以尝试在4G和WiFi之间切换试试看。<br>"]
        }]
    }, {
        ListName: "发货说明",
        content: [{
            question: "订单支付后什么时候能发货？",
            answer: ["(1)虚拟商品下一个自然日发货，部分商品支持实时发奖。如您在发货前未正确填写收货信息，则发货延期。", "(2)实物商品一般在10个工作日内下单发货，具体发货时间和物流单号需要依商家而定。", "(3)预售商品发货日需根据实际采购情况而定(一般在90天内发货 )", "(4)恶意注册用户将取消竞拍资格。"]
        }, {
            question: "长期未收到奖品怎么回事呢？",
            answer: ["(1)确保收货地址、邮编、电话、Email、地址等各项信息的准确性；", "(2)配送过程中请确保您的联系方式畅顺无阻，如果联络您的时间超过7天未得到回复，默认您已经放弃此商品。"]
        }, {
            question: "商品是正品吗？",
            answer: ["51微拍挑选优质服务品牌商家，保证全场奖品100%品牌正品。<br><br>", "如果您认为51微拍的奖品是假货，并能提供国家相关质检机构的证明文件，经确认后，在返还奖品金额的同时并提供假一赔十服务保障。为了保障您的利益，对51微拍的奖品，做如下说明：<br>", "(1)51微拍对所有奖品均保证正品行货，正规渠道发货，所有奖品都可以享受生产厂家的全国联保服务，按照国家三包政策，针对所送出奖品履行保修、换货和退货的义务。<br><br>", "(2)出现国家三包所规定的功能性故障时，经由生产厂家指定或特约售后服务中心检测确认故障属实，您可以选择换货或者维修；超过15日且在保修期内，您只能在保修期内享受免费维修服务。为了不耽误您使用，缩短故障奖品的维修时间，我们建议您直接联系生产厂家售后服务中心进行处理。您也可以直接在奖品的保修卡中查找该奖品对应的全国各地生产厂家售后服务中心联系处理。<br><br>", "(3)51微拍真诚提醒广大幸运者在您收到奖品的时候，请尽量亲自签收并当面拆箱验货，如果有问题(运输途中的损坏)请不要签收，并与快递员交涉，拒签，退回!<br><br>", "(4)在收到奖品后发现有质量问题，请您不要私自处理，妥善保留好原包装，第一时间联系51微拍客服人员，由51微拍同发货商城协商在48小时内解决。如有破损或丢失，我们将无法为您办理退货。<br><br>", "如对协商处理结果存在异议，请您自行到当地生产厂家售后服务中心进行检测，并开据正规检测报告（对于有些生产厂家售后服务中心无法提供检测报告的，需提供维修检验单据），如果检测报告确认属于质量问题，然后将检测报告、问题奖品及完整包装附件，一并返还发货商城办理换货手续，产生的相关费用由51微拍追究相关责任方承担。<br><br>", "51微拍上的电子产品及配件因为生成工艺或仓储物流原因，可能会存在收到或使用过程中出现故障的几率，51微拍不能保证所有的奖品都没有故障，但我们保证所售奖品都是全新正品行货，能够提供正规的售后保障。我们保证奖品的正规进货渠道和质量，如果您对收到的奖品质量表示怀疑，请提供生产厂家或官方出具的书面鉴定，我们会按照国家法律规定予以处理。但对于任何欺诈性行为，51微拍将保留依法追究法律责任的权利。本规则最终解释权由51微拍所有。"]
        }, {question: "商品可以退换吗？", answer: ["非质量问题，不在三包范围内，不给予退换货。请尽量亲自签收并当面拆箱验货，如果发现运输途中造成了商品的损坏，请不要签收，可以拒签退回。"]}]
    }], getQuestionTpl: function (e) {
        var t = "";
        return e && e.length > 0 && (e.forEach(function (e, n) {
            t += "<p>" + e + "</p>"
        }), t = '<div class="con">' + t + "</div>"), t
    }, setAllMaxHeight: function (e) {
        for (var t = 0; t < e.length; t++)!function (t) {
            var n = e[t].querySelector(".tit"), r = parseFloat(n.offsetHeight), i = parseFloat(getComputedStyle(e[t], null).paddingTop) + parseFloat(getComputedStyle(e[t], null).borderBottomWidth) + parseFloat(getComputedStyle(e[t], null).paddingBottom);
            e[t].style.maxHeight = r + i + "px"
        }(t)
    }, setLocalMaxHeight: function (e) {
        var t = e.querySelector(".tit"), n = e.querySelector(".con"), r = parseFloat(t.offsetHeight), i = parseFloat(getComputedStyle(e, null).paddingTop) + parseFloat(getComputedStyle(e, null).borderBottomWidth) + parseFloat(getComputedStyle(e, null).paddingBottom), o = parseFloat(n.offsetHeight) + parseFloat(getComputedStyle(n, null).paddingTop) + parseFloat(getComputedStyle(n, null).borderTopWidth) + parseFloat(getComputedStyle(n, null).marginTop);
        e.style.maxHeight = r + i + o + "px"
    }
}, oQuestion = document.getElementById("question"), questionHtml = "";
mainFunction.questionList && mainFunction.questionList.length > 0 && mainFunction.questionList.forEach(function (e, t) {
    questionHtml += '<br><h3 class="intro_tit"><i></i>' + e.ListName + '</h3><div style="border: 1px solid #eee;"><ul class="questions_list">', e.content && e.content.length > 0 && e.content.forEach(function (e, t) {
        questionHtml += '<li><span class="tit iconfont">' + e.question + "</span>" + mainFunction.getQuestionTpl(e.answer) + "</li>"
    }), questionHtml += "</ul></div>"
}), oQuestion.innerHTML = questionHtml, document.querySelector(".copyright").style.display = "block";
var aSpan = oQuestion.querySelectorAll(".tit"), aLi = oQuestion.getElementsByTagName("li");
mainFunction.setAllMaxHeight(aLi);
for (var i = 0; i < aSpan.length; i++)aSpan[i].onclick = function () {
    var e = this.parentNode;
    if (e.classList.contains("focus")) e.classList.remove("focus"), mainFunction.setAllMaxHeight(aLi); else {
        for (var t = 0; t < aLi.length; t++)aLi[t].classList.remove("focus");
        mainFunction.setAllMaxHeight(aLi), e.classList.add("focus"), mainFunction.setLocalMaxHeight(e)
    }
};
var callservice = document.getElementById("J-callservice"), serviceOL = document.getElementById("J-serviceOL"), qqGroup = document.getElementById("qqGroup_wrap"), idx = ua.lastIndexOf("-"), vs = parseInt(ua.substr(idx + 1));
callservice.onclick = function () {
    _p.isInApp() ? ua.match(/android/i) ? native.action("tel", "tel", '{ "tel":"' + this.getAttribute("data-num") + '" }') : vs >= 15 ? win.webkit.messageHandlers.action.postMessage(["tel", "tel", '{ "tel":"' + this.getAttribute("data-num") + '" }']) : native.action("tel", "tel", '{ "tel":"' + this.getAttribute("data-num") + '" }') : location.href = "tel:" + this.getAttribute("data-num")
}, serviceOL.onclick = function () {
    _p.isInApp() ? ua.match(/android/i) ? native.action("service_ol", "service_ol", "{}") : vs >= 15 ? win.webkit.messageHandlers.action.postMessage(["service_ol", "service_ol", "{}"]) : native.action("service_ol", "service_ol", "{}") : location.href = "http://18610331379.udesk.cn/im_client/?web_plugin_id=31594&group_id=45871&cur_title=" + doc.title + "&src_url=&cur_url=" + location.href + "&pre_url=" + location.href
}, mui.ready(function () {
    api.url = "101", api.method = "get", mui.post("api.php", api, function (e) {
        if ("0000" == e.code && e.data.key) {
            var t = doc.createElement("a");
            t.className = "ui-btn-submit-s", t.innerHTML = "一键加群", t.href = "//shang.qq.com/wpa/qunwpa?idkey=" + e.data.key, qqGroup.appendChild(t)
        }
    }, "json")
});
var timer = null;
timer = setInterval(function () {
    Number(window.rem) > 0 && (mainFunction.setAllMaxHeight(aLi), clearInterval(timer))
}, 1e3), setTimeout(function () {
    clearInterval(timer)
}, 5e3);
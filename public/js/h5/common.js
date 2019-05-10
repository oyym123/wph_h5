

var common = {};
common.params = {
    scrolltotop : '' //显示隐藏sheet用的滚动条高度
};
//警告框
common.alert = function(message){
    $.alert(message);
};

/*
 使用微信jssdk上传图片依赖以下html
 <div class="upload_images_wxjs">
 <div class="upload_images_views">
 </div>
 <span class="upload_btn">+</span>
 </div>
 num是限定的图片数量。
 */
common.uploadImageByWxJs = function(num,onck,inname){
    if(!onck) onck = '.upload_btn';
    if(!inname) inname = 'images[]';
    $('body').on('click',onck,function(){
        var elemt = $(this).parent();
        var nownumber = elemt.find('.upload_images_views img').length*1;
        if(nownumber >=num){
            common.alert('图片已达最大数量');return false;
        }
        wxJs.chooseImage(num-nownumber,function(data){
            var imgstr = '';
            for(var i= 0;i<data.length;i++){
                imgstr += '<li class="weui-uploader__file"><img src="'+data[i][0]+'"></li><input value="'+data[i][1]+'" type="hidden" name="'+inname+'">';
            }
            elemt.find('.upload_images_views').append(imgstr);
        });

    })
};

//删除图片
common.deleteImagesInWxJs = function(){
    $('body').on('click','.weui-uploader__file',function(){
        var thisimg = $(this);
        common.confirm('重要提示','确定要删除此图片吗？',function(){
            thisimg.remove();
        });
    });
};

common.squareImage = function(elemt){ //处理正方形图片
    $(elemt).each(function(){
        var thiswidth = $(this).width();
        $(this).css({'height':thiswidth});
    });
};


//确定框
common.confirm = function(title,msg,okcall,cancelcall){
    $.confirm(msg,title,
        function () {
            if(okcall) okcall();
        },
        function () {
            if(cancelcall) cancelcall();
        }
    );
};

//http请求
common.Http = function(type,datatype,url,data,successCall,beforeCall,isLoading,comCall){
    isLoading = !isLoading;
    $.ajax({
        type: type,
        url: url,
        dataType: datatype,
        data : data,
        beforeSend:function(){
            if(isLoading) common.loading(true);
            if(beforeCall) beforeCall();
        },
        success: function(data){
            if(successCall) successCall(data);
        },
        complete:function(){
            if(isLoading) common.loading(false);
            if(comCall) comCall();
        },
        error: function(xhr, type){
            console.log(xhr);
        }
    });
};

//加载中提示
common.loading = function(bool) {
    if(bool){
        $.showIndicator();
    }else{
        $.hideIndicator();
    }
};

//返回顶部
common.goToTop = function(classname){
    var topStr = '<div id="gotoTop" style="display: none;">'
        +'<div class="arrow"></div>'
        +'<div class="stick"></div>'
        +'</div>';
    if($('#gotoTop').length == 0){
        $('.page-group').append(topStr);
    }

    var wheight = $(window).height();
    $('.'+classname).scroll(function() {
        var s = $('.'+classname).scrollTop();
        if( s > wheight*1.5) {
            $("#gotoTop").show();
        } else {
            $("#gotoTop").hide();
        };
    });

    $('body').on('click','#gotoTop',function(){
        $('.'+classname).scrollTop(0);
    });
};


//加载更多数据
common.getMoreData = function(insertBox,page,url,data,callback){
    var isGetFlag = true;
    $(window).scroll(function(){
        if ($(document).height() - $(this).scrollTop() - $(this).height()<10 && isGetFlag){
            isGetFlag = false;
            $.ajax({
                type: 'post',
                url: url + '&page=' + page,
                dataType: 'json',
                data : data,
                beforeSend:function(){
                    $(insertBox).append('<div id="get_more_loading" class="get_more_loading"><img src="../addons/zofui_groupshop/public/images/loading.gif"> 正在加载</div>');
                },
                success: function(data){
                    if(data.status == 'ok'){
                        $(insertBox).append(data.data);
                        isGetFlag = true;
                        if(callback) callback();
                    }else{
                        isGetFlag = false;
                    }
                },
                complete:function(){
                    $('#get_more_loading').remove();
                    if(!isGetFlag){
                        $(insertBox).append('<div class="get_more_loading">已无更多内容</div>');
                    }
                },
                error: function(xhr, type){
                    console.log(xhr);
                }
            });
        };
    });
};



//操作cookie
common.cookie = {
    'prefix' : '',
    // 保存 Cookie
    'set' : function(name, value, seconds) {
        expires = new Date();
        value = encodeURI(value);
        expires.setTime(expires.getTime() + (1000 * seconds));
        document.cookie = this.name(name) + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
    },
    // 获取 Cookie
    'get' : function(name) {
        cookie_name = this.name(name) + "=";
        cookie_length = document.cookie.length;
        cookie_begin = 0;
        while (cookie_begin < cookie_length)
        {
            value_begin = cookie_begin + cookie_name.length;
            if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
            {
                var value_end = document.cookie.indexOf ( ";", value_begin);
                if (value_end == -1)
                {
                    value_end = cookie_length;
                }
                return decodeURI(unescape(document.cookie.substring(value_begin, value_end)));
            }
            cookie_begin = document.cookie.indexOf ( " ", cookie_begin) + 1;
            if (cookie_begin == 0)
            {
                break;
            }
        }
        return null;
    },
    // 清除 Cookie
    'del' : function(name) {
        var expireNow = new Date();
        document.cookie = this.name(name) + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT" + "; path=/";
    },
    'name' : function(name) {
        return this.prefix + name;
    }
};

//倒计时
common.updateTime = function (){
    var date = new Date();
    var time = date.getTime();  //当前时间距1970年1月1日之间的毫秒数
    $(".lasttime").each(function(i){
        var endTime = $(this).attr('data-time') + '000'; //结束时间字符串
        var lag = (endTime - time); //当前时间和结束时间之间的秒数
        if(lag > 0){
            var second = Math.floor(lag/1000%60);
            var minite = Math.floor(lag/1000/60%60);
            var hour = Math.floor(lag/1000/60/60%24);
            var day = Math.floor(lag/1000/60/60/24);
            $(this).find('.day').text(day);
            $(this).find('.hour').text(hour);
            $(this).find('.minite').text(minite);
            $(this).find('.second').text(second);
        }else{
            $(this).html("已经结束啦！");
        }
    });
    setTimeout(function(){common.updateTime()},1000);
};

//绑定事件
common.bind = function(bindelem,config){
    var events = config.events || {};
    for(t in events){
        for(tt in events[t]){
            $(bindelem).on(t,events[t],events[t][tt]);
        }
    }
};

//初始化绑定页面事件方法
common.init = function(config){
    config = config || {};

    for(t in config.events){
        for(tt in config.events[t]){
            $('.page-group').on(tt,t,config.events[t][tt]);
        }
    }
    for(func in config.init){
        config.init[func]();
    }
}

//创建url
common.createUrl = function(pstr,acstr,dostr){
    var str = '&p='+pstr+'&ac='+acstr+'&do='+dostr;
    return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+str+'&m=_fastauction';
};

//懒加载
common.lazyLoadImages = function(){
    $("img.lazy").each(function(){
        var thissrcurl = $(this).attr('src');
        if(thissrcurl == '' || thissrcurl == undefined){
            $(this).lazyload({effect : "fadeIn"});
        }
    });
};

//打印
common.log = function(data){
    console.log(data);
};

//改变下单，加入购物车数量。在good，cart，confirm页面
common.changeNumberBtn = function(elemt){
    var type = elemt.attr('data-type'),
        stock = elemt.parent().attr('data-stock')*1,
        input = elemt.siblings('input'),
        nowvalue = input.val()*1;
    if(type == 'add' && nowvalue < stock){
        input.val(nowvalue+1);
    }else if(type == 'minus' && nowvalue > 1){
        input.val(nowvalue-1);
    }
};

//改变下单，加入购物车数量。在good，cart，confirm页面,根据input变化判断是否正确数值。
common.changeNumberEdit = function(elemt){
    var nowvalue = elemt.val()*1,
        stock = elemt.parent().attr('data-stock')*1;
    if(!common.verify('number','int',nowvalue) || nowvalue > stock){
        elemt.val(1);
    }
};


//将字符串转实体html代码
common .htmlspecialchars_decode = function (str){
    str = str.replace(/&amp;/g, '&');
    str = str.replace(/&lt;/g, '<');
    str = str.replace(/&gt;/g, '>');
    str = str.replace(/&quot;/g, '"');
    str = str.replace(/&#039;/g, "'");
    return str;
}

//加载更多
common.getPage = function(params,succall,comcall){
    if(params.loading || params.isend) return;
    common.Http('post','json',common.createUrl('pagelist',params.op),params,function(data){
        $('.list_container').append(data.data);
        common.squareImage('.nead_square_images img'); //处理图片
        if(data.status != 'ok'){
            //$.detachInfiniteScroll($('.infinite-scroll'));
            params.isend = true;
        }
        params.page ++;
        if(succall) succall(data);
    },function(){
        $('.preloader').show();
        params.loading = true;
    },true,function(){
        $('.preloader').hide();
        if(comcall) comcall();
        params.loading = false;
    });
};

// speed 滚动速度，timer 滚动间隔 ,line 滚动行数
common.scrollNotice = function(elemt,speed,timer,line){
    var lineH=elemt.find("li").first().height(); //获取行高
    if(line==0) line=1;
    var upHeight=0-line*lineH;

    scrollUp = function(elemt){ //滚动函数

        elemt.animate({
            'margin-top':upHeight
        },speed,function(){
            for(i=1;i<=line;i++){
                elemt.find("li").first().appendTo(elemt);
            }
            elemt.css({marginTop:0});
        });
    }
    setInterval(function(){scrollUp(elemt)},timer);
};

//验证
common.verify = function(type,parama,paramb){
    if(type == 'number'){
        if(parama == 'int'){ // 正整数
            var R = /^[1-9]*[1-9][0-9]*$/;
        }else if(parama == 'intAndLetter'){ //数字和字母
            var R = /^[A-Za-z0-9]*$/;
        }else if(parama == 'money'){ //金额,最多2个小数
            var R = /^\d+\.?\d{0,2}$/;
        }
        return R.test(paramb);
    }else if(type == 'mobile'){ //手机
        var R = /^1[3|4|5|7|8]\d{9}$/;
        return R.test(parama);
    }else if(type == 'cn'){ //中文
        var R = /^[\u2E80-\u9FFF]+$/;
        return R.test(parama);
    }

};

common.lazyLoad = function (container,params) {
    var defaults = {
        offset: 20,
        delay: 50,
        placeholder: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA9JREFUeNpi+PTpE0CAAQAFsALXeCy2FAAAAABJRU5ErkJggg=="
    };
    var self = this;
    self.params = $.extend({}, defaults, params || {});
    self.container = $(container);
    var offset = self.params.offset || 0;
    self.params.offsetVertical = self.params.offsetVertical || offset;
    self.params.offsetHorizontal = self.params.offsetHorizontal || offset;

    self.params.delay = self.container.data('lazydelay') || self.params.delay;
    self.timer = null;
    self.toInt = function (str, defaultValue) {
        return parseInt(str || defaultValue, 10);
    };
    self.offset = {
        top: self.toInt(self.params.offsetTop, self.params.offsetVertical),
        bottom: self.toInt(self.params.offsetBottom, self.params.offsetVertical),
        left: self.toInt(self.params.offsetLeft, self.params.offsetHorizontal),
        right: self.toInt(self.params.offsetRight, self.params.offsetHorizontal)
    };

    self.inView = function (element, view) {
        var box = element.getBoundingClientRect();
        return (box.right >= view.left && box.bottom >= view.top && box.left <= view.right && box.top <= view.bottom);
    };

    self.run = function () {

        clearTimeout(self.timer);
        self.timer = setTimeout(self.render, self.params.delay);
    };

    self.render = function (ratio) {

        self.images = self.container.find('img[data-lazy], [data-lazy-background]');

        var view = {  //屏幕区域宽度
            left: 0 - self.offset.left,
            top: 0 - self.offset.top,
            bottom: (container.innerHeight || document.documentElement.clientHeight) + self.offset.bottom,
            right: (container.innerWidth || document.documentElement.clientWidth) + self.offset.right
        };

        $.each(self.images, function (i) {
            var $this = $(this);
            var inview = self.inView(this, view);
            if (inview) {
                if ($this.attr('data-lazyloaded')) {
                    return;
                }
                if ($this.attr('data-lazy-background')) {
                    $this.css({
                        'background-image': "url('" + $this.data('lazy-background') + "')"
                    });
                    $this.removeAttr('data-lazy-background');
                } else {
                    var lazy = $this.attr('data-lazy');
                    $this.removeAttr('data-lazy');
                    if (lazy) {
                        this.src = lazy;
                        this.onload = function () {
                            if (!$(this).height()) {
                                this.style.height = "auto";
                            }
                            this.onload = null;
                        };
                    }
                }
                $this.attr('data-lazyloaded', true);

            } else {
                var placeholder = $this.data('lazy-placeholder') || self.params.placeholder;
                if (placeholder && !$this.attr('data-lazyloaded')) {
                    if ($this.data('lazy-background') !== undefined && $this.data('lazy-background') === '') {
                        this.style.backgroundImage = "url('" + placeholder + "')";
                        $this.removeAttr('data-lazy-background');
                    } else {
                        this.src = placeholder;
                    }
                }
                $this.removeAttr('lazy-placeholder');
            }
            if (self.params.onLoad) {
                self.params.onLoad(self, this);
            }
        });
    };
    self.container.off('scroll', self.run);
    self.container.on('scroll', self.run).transitionEnd(self.run);
    self.run();
};
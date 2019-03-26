@extends('layouts.weui')
@section('title')
    视频中心
@stop
<div class="weui-cell" style="text-align: center;color: red;">
    <a href="javascript:;" class=" weui-btn_default" style="color: red;width: 100%;font-size: large"
       id="showIOSDialog1">德才禅医直播</a>

</div>
<a href="https://www.panda.tv/1627560" target="_blank" class="weui-grid">
    <div class="weui-grid__icon">
        <img src="/images/user-center/xiongmao.png" alt="">
    </div>
    <p class="weui-grid__label">熊猫直播</p>
</a>
<a href="https://www.douyu.com/3775970" target="_blank" class="weui-grid">
    <div class="weui-grid__icon">
        <img src="/images/user-center/douyu.png" alt="">
    </div>
    <p class="weui-grid__label">斗鱼直播</p>
</a>
<a href="https://www.yizhibo.com/l/eJAY4vS0YRshzIV7.html" target="_blank" class="weui-grid">
    <div class="weui-grid__icon">
        <img src="/images/user-center/yizhibo.png" alt="">
    </div>
    <p class="weui-grid__label">一直播</p>
</a>
<video width="100%" controls poster="{{$data['video1']['img'] or ''}}">
    <source src="{{$data['video1']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video1']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">德才师父宣传片</p>
<br>
<video -webkit-playsinline width="100%" controls poster="{{$data['video2']['img'] or ''}}">
    <source src="{{$data['video2']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video2']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">达摩祖师四十二手眼玫瑰掌内功（一）</p>
<br>
<video -webkit-playsinline width="100%" controls poster="{{$data['video3']['img'] or ''}}">
    <source src="{{$data['video3']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video3']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">达摩祖师四十二手眼玫瑰掌内功（二）</p>
<br>
<video -webkit-playsinline width="100%" controls poster="{{$data['video4']['img'] or ''}}">
    <source src="{{$data['video4']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video4']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">达摩禅医养心身</p>
<br>
<video -webkit-playsinline width="100%" controls poster="{{$data['video5']['img'] or ''}}">
    <source src="{{$data['video5']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video5']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">达摩祖师-四十二手眼——修禅打坐</p>
<br>
<video -webkit-playsinline width="100%" controls poster="{{$data['video6']['img'] or ''}}">
    <source src="{{$data['video6']['video'] or ''}}" type="video/mp4">
    <source src="{{$data['video6']['img'] or ''}}" type="video/ogg">
    您的浏览器不支持 HTML5 video 标签。
</video>
<p align="center">达摩禅医中国</p>
<br>
</body>
</html>
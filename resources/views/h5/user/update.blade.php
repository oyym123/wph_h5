@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    修改信息
@stop
@section('content')
    <body>
    <div class="page-group">
        <div class="page page-current" id="page-index">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;"
                   href="javascript:history.go(-1);">
                    <span style="color: #999999;" class="icon icon-left"></span>
                </a>
                <h1 class="title">修改信息</h1>
                <a href="javascript:;" onclick="validate()" style="color: #EF1544;"
                   class="button button-link button-nav pull-right create-actions">保存</a>
            </header>
            <div class="content native-scroll">
                <div class="list-block" style="margin-top: .75rem;">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">昵称：</div>
                                    <div class="item-input">
                                        <input type="text" id="nickname" value="" placeholder="请输入昵称">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validate() {
            var nickname = $("#nickname").val();
            if (nickname == '') {
                $.toast('请输入新昵称');
                return false;
            }
            $.post("update", {nickname: nickname}, function (d) {
                if (d.code >= 0) {
                    $.toast("修改成功");
                    location.href = "center";
                } else if (d.code < 0) {
                    $.toast(d.msg);
                } else {
                    $.toast("未知错误");
                }
            }, "json");
        }
    </script>
    @parent
@stop

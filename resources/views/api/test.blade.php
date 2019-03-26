@extends('layouts.weui')
        <!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>talk in weui--Dialog</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <style>
        .page__hd {
            padding: 40px;
        }

        .page__title {
            text-align: left;
            font-size: 20px;

        }

        .page__desc {
            margin-top: 5px;
            color: #888888;
        }

        /* bd 的一个状态  BEM  Modifier 只有一个下划线 */
        .page__bd_spacing {
            /* 移动页面，在body区域
            内容滚动  左右留白  15px */
            padding: 0 15px;
        }
    </style>
</head>
<body ontouchstart>
<!-- 页面，dialog 特定页面 -->
<div class="page dialog">
    <!-- CSS国际命名规范 BEM
    Block Element __(降级)
    -->
    <div class="page__hd">
        <h1 class="page__title">Dialog</h1>
        <p class="page__desc">对话框</p>
    </div>
    <div class="page__bd page__bd__spacing">
        <!-- weui-btn weui中的基础组件 -->
        <!-- default 灰色背景
        primary 绿色背景
        warn 红色背景 -->

        <a href="#" class="weui-btn weui-btn_default" id="showIOSDialog1">IOS Dialog样式 default</a>
        <a href="#" class="weui-btn weui-btn_primary">IOS Dialog样式 primary</a>
        <a href="#" class="weui-btn weui-btn_warn">IOS Dialog样式 warn</a>

    </div>
    <div class="dialogs">
        <div id="iosDialog1" class="js_dialog" style="display: none">
            <!-- weui-mask 遮罩层 -->
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__hd">
                    <div class="weui-dialog__title">弹窗标题</div>
                </div>
                <div class="weui-dialog__bd">
                    <!-- 任何东西  说明文字， 表单 -->
                    弹窗内容，告知当前状态、信息和解决方法，描述文字尽量控制在三行内
                </div>
                <div class="weui-dialog__ft">
                    <a href="#" class="weui-dialog__btn weui-dialog__btn_default" id="dialogCancle">取消</a>
                    <a href="#" class="weui-dialog__btn weui-dialog__btn_primary">保存</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // zepo是jQuery的移动版
    // jQuery比较大，兼容性 IE678 不适用
    // jQuery api 都支持
    $('#showIOSDialog1').click(function () {
        // show 就是display  block
        $('#iosDialog1').show();
    });
    $('#dialogCancle').click(function () {
        $('#iosDialog1').hide();
    });
    // 弹窗上有多个地方触发关闭
    // js事件，冒泡性质
    // 沿途经过的所有元素上，定义了事件的都触发
    // 冒泡的原因：HTML有层级关系
    // #dialogs
    // .weui-dialog__btn  两个元素都定义了 click 事件
    // $('#dialogs')
</script>
</body>

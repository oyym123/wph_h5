@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    基本信息
@stop
@section('content')

    <div class="page-group">
        <div class="page page-current" id="page-index">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" style="padding-top: .5rem;"
                   href="javascript:history.go(-1);">
                    <span style="color: #999999;" class="icon icon-left"></span>
                </a>
                <h1 class="title">基本信息</h1>
            </header>
            <style>
                .file-box {
                    display: inline-block;
                    position: relative;
                    padding: 3px 5px;
                    overflow: hidden;
                    color: #fff;
                    top: .3rem;
                    background-color: #ccc;
                }

                .file-btn {
                    position: absolute;
                    width: 100%;
                    height: 100%;

                    -moz-opacity: 0;
                    -khtml-opacity: 0;
                    opacity: 0;
                }

                button {
                    position: relative;

                    top: -.2rem;
                }
            </style>

            <div class="content native-scroll">
                <div style="background-color: white;">
                    <div class="list-block">
                        <div class="item-inner" style="height: 3rem;">
                            <div class="item-title" style="padding-left: .75rem;">头像</div>
                            <div>
                                <img style="border-radius:50%; overflow:hidden;position:relative;left: 2rem"
                                     id="uinLogo" class="my_head_img"
                                     style="background-color: white;" width="50" height="50" src="{{ $avatar }}?imageView2/3/w/50/h/50/">
                            </div>
                            <form action="update" enctype="multipart/form-data" method="post">
                                <div class="file-box">
                                    <input type="file" name="img" class="file-btn"/>
                                    选择更换
                                </div>
                                &nbsp; &nbsp; &nbsp;
                                <button type="submit">上传</button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="list-block" style="margin-top: .5rem;">
                    <ul>
                        <li>
                            <div class="item-link item-content" onclick="location.href='update-view'">
                                <div class="item-inner">
                                    <div class="item-title label">昵称</div>
                                    <div class="item-after"></div>
                                </div>
                            </div>
                        </li>
                        {{--<li>--}}
                        {{--<div class="item-link item-content" onclick="location.href='/?i=37&amp;c=entry&amp;m=_fastauction&amp;p=member&amp;ac=user&amp;do=boundphone'">--}}
                        {{--<div class="item-inner">--}}
                        {{--<div class="item-title label">手机号</div>--}}
                        {{--<div class="item-after">未绑定</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        <li>
                            <div class="item-link item-content"
                                 onclick="location.href='address-view'">
                                <div class="item-inner">
                                    <div class="item-title label">我的收货信息</div>
                                    <div class="item-after"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    @parent
@stop

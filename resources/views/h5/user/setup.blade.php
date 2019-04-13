@extends('layouts.h5')
@section('title')
    首页
@stop
@section('title_head')
    设置
@stop
@section('content')
            <div class="content native-scroll" id="con1">
                <div class="list-block">
                    <ul>
                        <li>
                            <div class="item-link item-content">
                                <div class="item-inner" onclick="location.href='/h5/newbie-guide'">
                                    <div class="item-title label">新手指南</div>
                                    <div class="item-input">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                        </li><li>
                            <div class="item-link item-content">
                                <div class="item-inner" onclick="location.href='/h5/user/user-agreement'">
                                    <div class="item-title label">用户协议</div>
                                    <div class="item-input">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                        </li><li>
                            <div class="item-link item-content">
                                <div class="item-inner" onclick="location.href='/h5/common-problems'">
                                    <div class="item-title label">帮助中心</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="weui-btn-area" style="margin-top: .6rem;">
                        <a class="weui-btn weui-btn_primary external" style="background-color: #EF1544;" href="javascript:validate()" id="showTooltips">退出登录</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function validate(){
                $.confirm('确定退出登录?',
                    function() { //确定后操作。
                        $.post("/h5/user/login-out",{},function(d){
                            if(d.code == 0){
                                $.toast('退出成功');
                                location.href = "/h5/home";
                            }else if(d.status < 0){
                                $.toast(d.msg);
                            }else{
                                $.toast("未知错误");
                            }
                        },"json");
                    },
                    function() { //取消后操作。
                    });
            }
        </script>
    </div>
    @parent
@stop

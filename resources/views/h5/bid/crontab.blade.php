@extends('layouts.h5')
@section('title')
    计划任务
@stop
@section('title_head')
    计划任务
@stop
@section('content')
    <div id="msg">

    </div>
    <script>
        var tt1 = setInterval("begin1()", 7000);//机器人竞价
        var tt2 = setInterval("begin2()", 4000);//十元竞价 5秒
        var tt3 = setInterval("begin3()", 9000);//自动竞价
        var tt4 = setInterval("begin4()", 3000);//检测结果
        function begin1() {
            $.post("/h5/bid/crontab-start", {type: 1}, function (data) {
                console.log('机器人竞价：' + data)
            }, "json");
        }
        function begin2() {
            $.post("/h5/bid/crontab-start", {type: 2}, function (data) {
                console.log('十元竞价：' + data)
            }, "json");
        }

        function begin3() {
            $.post("/h5/bid/crontab-start", {type: 3}, function (data) {
                console.log('自动竞价：' + data)
            }, "json");
        }

        function begin4() {
            $.post("/h5/bid/crontab-start", {type: 4}, function (data) {
                console.log('检测结果：' + data)
            }, "json");
        }
    </script>
    @parent
@stop

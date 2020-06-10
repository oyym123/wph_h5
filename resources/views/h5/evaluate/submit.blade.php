@extends('layouts.blank')
@section('title')
    提交评价
@stop
@section('title_head')

@stop
@section('content')
    <style>

        a.button {
            position: relative;
            color: rgba(255, 255, 255, 1);
            text-decoration: none;
            background-color: rgba(219, 87, 5, 1);
            font-family: 'Yanone Kaffeesatz';
            font-weight: 700;
            font-size: 3em;

            display: block;
            padding: 4px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            -webkit-box-shadow: 0px 9px 0px rgba(219, 31, 5, 1), 0px 9px 25px rgba(0, 0, 0, .7);
            -moz-box-shadow: 0px 9px 0px rgba(219, 31, 5, 1), 0px 9px 25px rgba(0, 0, 0, .7);
            box-shadow: 0px 9px 0px rgba(219, 31, 5, 1), 0px 9px 25px rgba(0, 0, 0, .7);
            margin: 100px auto;
            width: 160px;
            text-align: center;

            -webkit-transition: all .1s ease;
            -moz-transition: all .1s ease;
            -ms-transition: all .1s ease;
            -o-transition: all .1s ease;
            transition: all .1s ease;
        }

        a.button:active {
            -webkit-box-shadow: 0px 3px 0px rgba(219, 31, 5, 1), 0px 3px 6px rgba(0, 0, 0, .9);
            -moz-box-shadow: 0px 3px 0px rgba(219, 31, 5, 1), 0px 3px 6px rgba(0, 0, 0, .9);
            box-shadow: 0px 3px 0px rgba(219, 31, 5, 1), 0px 3px 6px rgba(0, 0, 0, .9);
            position: relative;
            top: 6px;
        }

    </style>

    <link href="/css/h5/bootstrap.min.css" rel="stylesheet">
    <link href="/css/h5/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="/js/h5/jquery-2.0.3.min.js"></script>
    <script src="/js/h5/fileinput.js" type="text/javascript"></script>
    <script src="/js/h5/bootstrap.min.js" type="text/javascript"></script>
    <div class="container kv-main" style="width: 90%;position:relative;top: 2rem;">
        <br>
        <form enctype="multipart/form-data">
            <div>
                <div class="form-group" style="position:relative;top:1rem;">
                    <input id="file-1" type="file" multiple class="file" name="imgs" data-overwrite-initial="false"
                           data-min-file-count="2">
                </div>
                <input type="hidden" id="contents" value="">
            </div>
        </form>
            <br/>
            <br/>
        <div class="alert-msg" style="position: relative;top:5rem;left: 3rem">
            <img style="width: 30px;height: 30px" src="/images/h5/pencil.png"/>
            <span>
                我们的成长需要您的宝贵意见
            </span>
        </div>
        <textarea id="area" class="user-msg" name="contents"
                  style="height: 8.6rem;width: 100%;background-color: rgb(248, 248, 248)"></textarea>
        <p><span id="text-count">100</span>/0</p>
        <a style="top:-4rem;" onclick="submit_content()" class="button">提交</a>
    </div>
    <script>
        $('.file-preview').hide();
        $('.close').hide();
        $('.file-drop-zone').hide();
        //获取焦点事件
        $("textarea").focus(function () {
            $('.alert-msg').hide();
        });

        //失去焦点事件
        $("textarea").blur(function () {
            if ($("textarea").val().length == '') {
                $('.alert-msg').show();
            }
        });

        function submit_content() {
            var content = $("textarea").val();
            $.post("/h5/evaluate/submit", {contents: content, sn: "{{ $order_sn }}"}, function (d) {
                if (d.code == 0) {
                    location.href = "/h5/order/my-auction?type=1"; //我拍中列表
                } else {
                    alert(d.message);
                }
            }, "json");
        }

        $("#area").on("input propertychange", function () {
            var $this = $(this),
                _val = $this.val(),
                count = "";
            if (_val.length > 100) {
                $this.val(_val.substring(0, 100));
            }
            count = 100 - $this.val().length;
            $("#text-count").text(count);
            //
        });

        var content = "'" + $("#contents").val() + "'";
        $("#file-1").fileinput({
            uploadUrl: '/h5/evaluate/upload-img?key_img={{ $order_sn }}', // you must set a valid URL here else you will get an error
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize: 1000,
            maxFilesNum: 10,
            //allowedFileTypes: ['image', 'video', 'flash'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

    </script>
    @parent
@stop

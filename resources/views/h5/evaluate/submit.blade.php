@extends('layouts.blank')
@section('title')
    提交评价
@stop
@section('title_head')

@stop
@section('content')
    <link href="/css/h5/bootstrap.min.css" rel="stylesheet">
    <link href="/css/h5/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="/js/h5/jquery-2.0.3.min.js"></script>
    <script src="/js/h5/fileinput.js" type="text/javascript"></script>
    <script src="/js/h5/bootstrap.min.js" type="text/javascript"></script>
    <div class="container kv-main">
        <br>
        <form enctype="multipart/form-data">
            <div class="form-group">
                <input id="file-1" type="file" multiple class="file" name="imgs" data-overwrite-initial="false"
                       data-min-file-count="2">
            </div>
        </form>
    </div>

    <script>

        $("#file-1").fileinput({
            uploadUrl: '/h5/evaluate/submit?sn={{ $order_sn }}', // you must set a valid URL here else you will get an error
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

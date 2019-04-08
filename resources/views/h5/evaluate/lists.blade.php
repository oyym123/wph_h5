@extends('layouts.h5')
@section('title')
    晒单
@stop
@section('title_head')
    晒单
@stop
@section('content')
    <style>

        .name {
            font-size: small;

            position: absolute;
            left: 3rem;

        }

        .time {
            position: absolute;
            right: 20px;

        }

        .share_info {
            position: absolute;
            right: -.6rem;
            top: 1.5rem;
        }
    </style>
    <div id="wrapper" style="">
        <div class="scroller">
            <div class="" id="latelist">
                @foreach($data as $v)
                    <div class="share_li"
                         style="position:relative;top:3rem;left: 0.2rem;float: none;background-color: white">
                        <div class="cover1">
                            <img style="border-radius:50%; height: 45px; overflow:hidden"
                                 src="{{ $v['avatar'] }}?imageView2/1/w/45/h/45">
                        </div>
                        <div>
                            <span class="name">{{ $v['nickname'] }}</span>
                            <span class="time">{{ $v['created_at'] }}</span>
                        </div>
                        <div class="share_info" data-id="50567">
                            <h3 class="hidelong">{{$v['product_title']}}</h3>
                            <div class="desc">{{ $v['content'] }}</div>
                            <div class="imgs">
                                @foreach($v['imgs'] as $img)
                                    <img src="{{ $img }}?imageView2/1/w/150/h/150">
                                @endforeach
                            </div>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
        <div>
            <div class="more"><i class="pull_icon"></i><span></span></div>
        </div>
    </div>
    @parent
@stop

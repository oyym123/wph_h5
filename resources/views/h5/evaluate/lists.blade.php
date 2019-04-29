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
            font-size: small;
        }

        .share_li {
            position: relative;
            left: -0.3rem;
            background-color: white;
        }

        .share_info {
            position: absolute;
            right: -.6rem;
            top: 1.5rem;
        }

        .share_li .share_info .imgs {
            width: 14.225rem;
            font-size: 0;
        }

        .share_li .share_info .imgs img {
            width: 4.25rem;
            height: 4.25rem;
            background: #ccc;
            margin: 0.3rem 0.3rem 0 0;
        }

    </style>
    <div id="wrapper">
        <div class="scroller">
            <div class="" id="latelist">
                @foreach($data as $v)
                    <div class="share_li">
                        <div class="cover1">
                            <img style="border-radius:50%; height: 45px;"
                                 src="{{ $v['avatar'] }}?imageView2/1/w/45/h/45">
                        </div>
                        <div>
                            <span class="name">{{ $v['nickname'] }}</span>
                            <span class="time">{{ $v['created_at'] }}</span>
                        </div>
                        <a href="/h5/evaluate/detail?id={{ $v['id'] }}">
                        <div class="share_info" style="position:relative;margin-bottom: 2rem">
                            <h3 class="hidelong">{{$v['product_title']}}</h3>
                            <div class="desc">{{ $v['content'] }}</div>
                            <div class="imgs">
                                @foreach($v['imgs'] as $img)
                                    <img src="{{ $img }}?imageView2/1/w/150/h/150">
                                @endforeach
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div>
                <div class="more"><i class="pull_icon"></i><span></span></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/h5/iscroll.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/h5/scroller.css')}}">
    <script type="text/html" id="lateauc">
        @verbatim
        {{# for(var i = 0, len = d.length; i< len; i++){ }}
        <div class="share_li">
            <div class="cover1">
                <img style="border-radius:50%; height: 45px;"
                     src="{{ d[i].avatar }}?imageView2/1/w/45/h/45">
            </div>
            <div>
                <span class="name">{{d[i].nickname }}</span>
                <span class="time">{{ d[i].created_at }}</span>
            </div>
            <a href="/h5/evaluate/detail?id={{  d[i].id  }}">
            <div class="share_info" style="position:relative;margin-bottom: 2rem">
                <h3 class="hidelong">{{d[i].product_title}}</h3>
                <div class="desc">{{ d[i].content }}</div>
                <div class="imgs">
                    {{# $.each(d[i].imgs, function(index, item){}}
                    <img src="{{ item }}?imageView2/1/w/150/h/150">
                    {{#  }); }}
                </div>
            </div>
            </a>
        </div>
        {{# } }}
        @endverbatim
    </script>
    <script>
        pages = 0;
        $(function () {
            var myscroll = new iScroll("wrapper", {
                onScrollMove: function () {
                    if (this.y < (this.maxScrollY)) {
                        $('.pull_icon').addClass('flip');

                    } else {
                        $('.pull_icon').removeClass('flip loading');
                    }
                },
                onScrollEnd: function () {
                    if ($('.pull_icon').hasClass('flip')) {
                        pages++;
                        pullUpAction(pages);
                    }
                },
                onRefresh: function () {
                    $('.more').removeClass('flip');
                }
            });

            function pullUpAction(pagenum) {
                setTimeout(function () {
                    $.get("/api/evaluate/lists", {pages: pagenum}, function (d) {
                        d = d.data;
                        if (d !== null) {
                            var gettpl = document.getElementById('lateauc').innerHTML;
                            laytpl(gettpl).render(d, function (html) {
                                $("#latelist").append(html);
                            });
                        } else {
                            $("#no-data").remove();
                            $("#latelist").append("<p id='no-data' style='text-align: center;margin-top: 5px;'>无更多数据</p>");
                        }
                    }, "json");
                    myscroll.refresh();
                }, 100)
            }

            if ($('.scroller').height() < $('#wrapper').height()) {
                $('.more').hide();
                myscroll.destroy();
            }
        });
    </script>
    @parent
@stop

@extends('layouts.h5')
@section('title')
    评价详情
@stop
@section('title_head')
    评价详情
@stop
@section('content')
    <style>
        ::-webkit-scrollbar{
            width: 0px;
            height: 0px;
        }
    </style>
    <div style="overflow: hidden;">
        <div style="position: relative;top:3rem;float: left">
            <span>
            <img style="position: relative;left: 0.3rem" src="{{ $data['img_cover'] }}?imageView2/1/w/70/h/70">
            </span>
            <span><p style="width: 80%;position: relative;top:-3.5rem;left: 4.2rem;font-size: smaller"> {{ $data['product_title'] }}</p>
            </span>
            <span><p style="width: 80%;position: relative;top:-3rem;left: 4.2rem;font-size: small;color: rgb(170, 170, 170)"> {{ $data['created_at'] }}</p></span>
            <p style="position: relative;top:-2rem;left: 0.3rem"> {{ $data['content'] }}</p>
        </div>
        <div style="position: relative;top: 2rem;text-align: center;">
            @foreach($data['imgs'] as $v)
                <img src="{{ $v }}" style="width: 90%">
                <br/>

            @endforeach
        </div>
    </div>
    @parent
@stop

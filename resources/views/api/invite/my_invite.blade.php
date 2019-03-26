@extends('layouts.weui')
@section('title')
    我的推荐奖励
@stop
<div class="weui-mask" id="mask" style="display: none;"></div>

@section('popout')
    <div class="page">
        <div id="dialogs">
            <!--BEGIN dialog2-->
            <div class="js_dialog" id="iosDialog2" style="display: none;">
                <div class="weui-dialog">
                    <div class="weui-dialog__bd">功能正在开发中</div>
                    <div class="weui-dialog__ft">
                        <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                    </div>
                </div>
            </div>
            <!--END dialog2-->
        </div>
    </div>
@stop

@section('content')

    <div class="page">
        <div style="background-color: #6a6e77">
            <br/>
            <div class="weui-flex" style="text-align:center;color:white">
                <div class="weui-flex__item">
                    <a href="javascript:;" style="color:white" id="showIOSDialog1">
                        <div class="weui-grid__icon">
                            <img src="/images/weui/tuiguang.png" alt="">
                        </div>

                        <div class="placeholder">推广</div>
                        <div class="placeholder" style="color:#aeb2bb">
                            <span>{{$user_info->invite_level1_count + $user_info->invite_level2_count}}</span></div>
                    </a>
                </div>

                <div class="weui-flex__item">
                    <a href="javascript:;" style="color:white" id="showIOSDialog1">
                        <div class="weui-grid__icon">
                            <img src="/images/weui/jifen.png" alt="">
                        </div>

                        <div class="placeholder">目前积分</div>
                        <div class="placeholder" style="color:#aeb2bb"><span>{{$user_info->point_total}}</span>

                        </div>
                    </a>
                </div>
                <div class="weui-flex__item" id="showIOSDialog2">
                    <a href="javascript:;">
                        <div class="weui-grid__icon">
                            <img src="/images/weui/lingqian.png" alt="">
                        </div>
                    </a>
                    <div class="placeholder">提现</div>
                    <div class="placeholder" style="color:#aeb2bb">¥00.00
                    </div>
                </div>
            </div>
            <br/>
        </div>
        <div class="page__bd">

            <label class="weui-label"></label>
            <div class="weui-panel">
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_small-appmsg">
                        <div class="weui-cells">
                            <a class="weui-cell weui-cell_access" href="invite/view?type=1">
                                <div class="weui-cell__hd"><img
                                            src="/images/weui/gold.png"
                                            alt="" style="width:20px;margin-right:5px;display:block"></div>
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p>一级奖励</p>
                                </div>
                                <span class="weui-cell__ft"
                                      style="color:orangered">{{$user_info->invite_level1_point}}</span>
                            </a>

                            <a class="weui-cell weui-cell_access" href="invite/view?type=2">
                                <div class="weui-cell__hd"><img
                                            src="/images/weui/silver.png"
                                            alt="" style="width:20px;margin-right:5px;display:block"></div>
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p>二级奖励</p>
                                </div>
                                <span class="weui-cell__ft"
                                      style="color:orangered">{{$user_info->invite_level2_point}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <label class="weui-label"></label>
            <div class="weui-panel">
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_small-appmsg">
                        <div class="weui-cells">
                            <a class="weui-cell weui-cell_access" href="javascript:;">
                                <div class="weui-cell__bd weui-cell_primary">
                                    <p>查看规则</p>
                                </div>
                                <span class="weui-cell__ft"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-btn-area">
                {{--<a class="weui-btn weui-btn_primary" href="invite/qrcode"  id="showTooltips">开始推广</a>  --}}
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="showTooltips">开始推广</a>
            </div>
        </div>

        <script type="text/javascript">
            $(function () {
                var $iosDialog2 = $('#iosDialog2');
                var $mask = $('#mask');

                $('#dialogs').on('click', '.weui-dialog__btn', function () {
                    $(this).parents('.js_dialog').fadeOut(200);
                    $mask.fadeOut(200);
                });

                $('#showIOSDialog2').on('click', function () {
                    $mask.fadeIn(200);
                    $iosDialog2.fadeIn(200);
                });
            });
        </script>
@stop


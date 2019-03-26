
<div class="weui-mask" id="mask" style="display: none;"></div>
<div class="page">
    <div id="dialogs">
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog2" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd">{{$errors->first()}}</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog1" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd"> {{$codeError or ''}}</div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
    </div>
</div>
@section('content')
@if (isset($codeError))
<a href="javascript:;" class="weui-btn weui-btn_default" id="showToast1"></a>
@endif

<script>
    $(function () {
        var $toast = $('#toast');
        if ($("#showToast1").length > 0) {

            var $iosDialog1 = $('#iosDialog1');

            var $mask = $('#mask');

            $('#dialogs').on('click', '.weui-dialog__btn', function () {
                $(this).parents('.js_dialog').fadeOut(200);
                $mask.fadeOut(200);
            });
            $mask.fadeIn(200);
            $iosDialog1.fadeIn(200);
        }
    });
</script>
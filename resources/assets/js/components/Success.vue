<template>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">{{ articles.title }}</h2>
            <p class="weui-msg__desc"></p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="../article" class="weui-btn weui-btn_primary"></a>
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__links">
                    <a href="javascript:void(0);" class="weui-footer__link">微拍行</a>
                </p>
                <p class="weui-footer__text">Copyright &copy; 2008-2017 </p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'app',
        data () {
            return {
                articles: {
                    res: ''
                }
            }
        },
        created: function () {
            this.$http.get('/api/home/success-view',
                {
                    params: {
                        productType: "1",
                        pageNum: 1,
                        pageLimit: 8,
                    }
                },
                {
                    headers: {},
                    emulateJSON: true
                }
            ).then((response) => {
                //this.articles = JSON.parse(response.data);
                this.articles = (response.data).data;
            }).catch(function (response) {
                console.log(response)
            });
        }
    }
</script>

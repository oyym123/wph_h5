/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.VueRouter = require('vue-router');
//import VueResource from 'vue-resource'
window.Vue = require('vue');
Vue.use(VueResource);
//import WeuiDistpicker from 'weui-distpicker'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('weui-distpicker', WeuiDistpicker);
Vue.component('User', require('./components/Example.vue'));
Vue.component('success', require('./components/Success.vue'));

const Success = {template: '<success></success>'};
const User = {template: '<User></User>'};
const UserHome = {template: '<div>Home</div>'};
const UserProfile = {template: '<div>Profile</div>'};
const UserPosts = {template: '<div>Posts</div>'};

const routes = [
    {
        path: '/', component: Success,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            {path: '', component: UserHome},

            // UserProfile will be rendered inside User's <router-view>
            // when /user/:id/profile is matched
            {path: 'profile', component: UserProfile},

            // UserPosts will be rendered inside User's <router-view>
            // when /user/:id/posts is matched
            {path: 'posts', component: UserPosts}
        ]
    }
];

const router = new VueRouter({

  //  routes // （缩写）相当于 routes: routes

});

// // 传统写法
// this.$http.get('http://adcx.api/api/home', [options]).then(function (response) {
//     // 响应成功回调
//     console.log(response)
// }, function (response) {
//     // 响应错误回调
// });

const app = new Vue({
    //router
}).$mount('#app');

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import VeeValidate, { Validator } from 'vee-validate';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.use(VeeValidate);
Validator.localize('zh_CN',zh_CN);
Vue.component('example', require('./components/Example.vue'));
Vue.component('register', require('./components/register.vue'));
Vue.component('war', require('./components/war.vue'));


const app = new Vue({
    el: '#app'
});

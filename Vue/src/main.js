// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuex from 'vuex'
import store from '../src/store.js'


import 'bootstrap/dist/css/bootstrap.min.css'
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import 'jquery'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VeeValidate, { Validator } from 'vee-validate';

Vue.use(VeeValidate);
Validator.localize('zh_CN',zh_CN);
Vue.use(BootstrapVue);
Vue.use(require('vue-moment'));


Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',store,
  router: router,
  components: { App },
  template: '<App/>'})

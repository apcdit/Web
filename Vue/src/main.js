// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuex from 'vuex'
import store from '../src/store.js'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.min.css'
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VeeValidate, { Validator } from 'vee-validate';
// importing the helper
import interceptorsSetup from '../src/interceptors.js'

// and running it somewhere here
interceptorsSetup()

Vue.use(VeeValidate);
Validator.localize('zh_CN',zh_CN);
Vue.use(BootstrapVue);
Vue.use(require('vue-moment'));
//Vue.use(axios);


Vue.config.productionTip = false
const token = localStorage.getItem('token')

if (token) {
  axios.defaults.headers.common['Authorization'] = token
}
/* eslint-disable no-new */
new Vue({
  el: '#app',store,
  router: router,
  components: { App },
  template: '<App/>',
})


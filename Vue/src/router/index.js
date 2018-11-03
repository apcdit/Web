import Vue from 'vue'
import Router from 'vue-router'
import about from '@/components/about'
import contact from '@/components/contact'
import pastyear from '@/components/pastyear'
import rules from '@/components/rules'
import videohub from '@/components/videohub'
import navigation from '@/components/navigation'
import login from '@/components/login'
import register from '@/components/register'
import homepage from '@/components/homepage'
import timer from '@/components/timer'
import lottery from '@/components/lottery'
import store from '../../src/store.js'

Vue.use(Router)

//check if not then route to other place
const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isLoggedIn) {
    next()
    return
  }
  next('/')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isLoggedIn) {
    next()
    return
  }
  next('/login')
}

export default new Router({
  routes: [
    {path:'/about',name: 'about',component:about},
    {path:'/contact',name:'contact',component:contact},
    {path:'/pastyear',name:'pastyear',component:pastyear},
    {path:'/rules',name:'rules',component:rules},
    {path:'/videohub',name:'videohub',component:videohub},
    {path:'/navigation',name:'navigation',component:navigation},
    {path:'/about',name:'about',component:about},
    {path:'/login',name:'login',component:login, beforeEnter: ifNotAuthenticated},
    {path:'/register',name:'register',component:register, beforeEnter: ifNotAuthenticated},
    {path:'/',name:'homepage',component:homepage},
    {path:'/timer',name:'timer',component:timer},
    {path:'/lottery', name:'lottery', component:lottery, beforeEnter: ifAuthenticated}
  ]
})

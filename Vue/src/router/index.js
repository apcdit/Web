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
import lottery from '@/components/lottery'
import store from '../../src/store.js'
import result from '@/components/result'
import user from '@/components/user'
import admin from '@/components/admin'
import resetpw from '@/components/resetpw'
import notifysuccess from '@/components/notifysuccess'
import latestNews from '@/components/latestNews'
import post from '@/components/post'

Vue.use(Router)

//check if not then route to other place
const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isLoggedIn) {
    next()
  }else{
    next('/')
  }
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isLoggedIn) {
    switch(to.meta.permission){
      case 'admin': 
          if(JSON.parse(localStorage.getItem('user')).admin == 1){
            next();
          }else{
            next('/')
          }
          break;
      case 'user':
          next();
          break;
    }
  }else{
    next('/login')
  }
}

/*to being the route we are navigating to, 
from being the route we are navigating from, 
and next being the method we use to navigate to the next route
*/


export default new Router({
  routes: [
    {path:'/about',name: 'about',component:about},
    {path:'/contact',name:'contact',component:contact},
    {path:'/pastyear',name:'pastyear',component:pastyear},
    {path:'/rules',name:'rules',component:rules},
    {path:'/videohub',name:'videohub',component:videohub},
    {path:'/navigation',name:'navigation',component:navigation},
    {path:'/resetpw', name:'resetpw', component:resetpw},
    {path:'/latestNews', name:'latestNews', component:latestNews},
    {
      path:'/post/:id', 
      name:'post', 
      component:post
    },
    {
      path:'/notifysuccess', 
      name:'notifysuccess', 
      component:notifysuccess
      
    },
    {
      path:'/login',
      name:'login',
      component:login, 
      beforeEnter: ifNotAuthenticated
    },
    {
      path:'/register',
      name:'register',
      component:register, 
      beforeEnter: ifNotAuthenticated
    },
    {
      path:'/',
      name:'homepage',
      component:homepage
    },
    {
      path:'/lottery', 
      name:'lottery', 
      component:lottery, 
      beforeEnter: ifAuthenticated,
      meta:{
        permission: 'user'
      }
    },
    {
      path:'/result', 
      name:'result', 
      component:result, 
      beforeEnter: ifAuthenticated,
      meta:{
        permission: 'user'
      }
    },
    {
      path:'/user', 
      name:'user', 
      component:user, 
      beforeEnter: ifAuthenticated,
      meta:{
        permission: 'user'
      }
    },
    {
      path:'/admin', 
      name:'admin', 
      component:admin, 
      beforeEnter: ifAuthenticated,
      meta:{
        permission: 'admin'
      }
    }
  ]
})

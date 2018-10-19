<template>
<div id="app">
<div>
  <div>
<b-navbar type="light" variant="light" toggleable>
    <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
    <b-collapse is-nav id="nav_dropdown_collapse">
      <b-navbar-nav>
        <b-nav-item-dropdown text="关于我们" right >
          <b-dropdown-item router-link to='/about'>赛会简介</b-dropdown-item>
          <b-dropdown-item router-link to='/rules'>参赛事宜</b-dropdown-item>
          <b-dropdown-item router-link to='/pastyear'>历届赛况</b-dropdown-item>
          <b-dropdown-item href="/#">筹委介绍</b-dropdown-item>
        </b-nav-item-dropdown>
        <b-nav-item-dropdown text="活动详情" right >
          <b-dropdown-item href="#">最新消息</b-dropdown-item>
          <b-dropdown-item href="#">最新赛况</b-dropdown-item>
          <b-dropdown-item href="#">赛程</b-dropdown-item>
        </b-nav-item-dropdown>
        <b-navbar-brand href="/"><img src="http://i.imgur.com/zRtdcqV.png"></b-navbar-brand>
        <b-nav-item router-link to='/videohub'>视频库</b-nav-item>
        <b-nav-item router-link to='/contact'>联络我们</b-nav-item>
        <b-nav-item router-link to='/login' v-if="!isLogged">Login</b-nav-item>
        <b-nav-item-dropdown text="大学资料"  v-else>
          <b-nav-item to='profile'>Profile</b-nav-item>
          <b-nav-item> Logout </b-nav-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
    </b-navbar>
  </div>
</div>
  <router-view></router-view>
<footer>
  <div class="col-md-8">
     <img src="http://i.imgur.com/90YSaaO.png" alt="第八届亚太大专华语辩论公开赛" class="site_logo">
              <h6 class="copyright"> NTU APICDT All Rights Reserved &copy 2018 </h6>
          </div>
          <div class="col-md-4" id="social-logo">
              <a href="http://www.apchinesedebate.com/contactus.php" target="_blank"><i class="fa fa-envelope-square fa-2x" aria-hidden="true"></i></a>
              <a href="http://weibo.com/p/1005055398940329" target="_blank"><i class="fa fa-weibo fa-2x" aria-hidden="true"></i></a>
              <a href="https://www.instagram.com/apchinesedebate/" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
              <a href="https://www.facebook.com/NTUCSapchinesedebate/" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
    </div>
  </footer>
</div>


</template>

<script>
import about from './components/about.vue'
import pastyear from './components/pastyear.vue'
import rules from './components/rules.vue'
import contact from './components/contact.vue'
import navigation from './components/navigation.vue'
import videohub from './components/videohub.vue'
import login from './components/login.vue'
import register from './components/register.vue'
import register1 from './components/register1.vue'


export default {
  name: 'App',
  components: {about,pastyear,rules,contact,navigation,videohub,login,register,register1},
  data(){return{isLogged :false,}},
  methods: {
    logout () {
      this.$localStorage.remove('access_token')
      this.isLogged = this.checkIfIsLogged()
      this.$router.push('/')
    },
    checkIfIsLogged () {
      let token = this.$localStorage.get('access_token')
      if (token) {
        return true
      } else {
        return false
      }
    }
  }
}
</script>

<style>

.navbar-nav {
    float:none;
    margin:0 auto;
    display: block;
    text-align: center;
}

.navbar-nav > li {
    display: inline-block;
    float:none;
}
ul{list-style:none;}
</style>

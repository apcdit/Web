<template>
    <div>
        <b-navbar type="light" class="main-nav" variant="white" toggleable fixed="top">
            <b-navbar-brand href="/"><img src="http://i.imgur.com/90YSaaO.png"></b-navbar-brand>
            <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
            <b-collapse is-nav id="nav_dropdown_collapse">
                <!-- <b-navbar-nav>
                    <b-nav-item-dropdown style="font-size: 1.25em; font-weight:bold;" text="关于我们" right >
                        <b-dropdown-item router-link to='/about'>赛会简介</b-dropdown-item>
                        <b-dropdown-item router-link to='/rules' v-if="false">参赛事宜</b-dropdown-item>
                        <b-dropdown-item router-link to='/pastyear'>历届赛况</b-dropdown-item>
                        <b-dropdown-item href="/#">筹委介绍</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown style="font-size: 1.25em; font-weight:bold;" text="活动详情" right >
                        <b-dropdown-item href="#/latestNews">最新消息</b-dropdown-item>
                        <b-dropdown-item href="#">最新赛况</b-dropdown-item>
                        <b-dropdown-item href="#">赛程</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item style="font-size: 1.25em; font-weight:bold;" router-link to='/videohub'>视频库</b-nav-item>
                    <b-nav-item router-link to='/contact' style="font-size: 1.25em; font-weight:bold;">联络我们</b-nav-item>
                </b-navbar-nav> -->

                <b-navbar-nav class="ml-auto" style="font-size: 1.25em; font-weight:bold;">
                    <!-- <b-nav-item router-link to='/login' style="font-size: 1.25em; font-weight:bold;" v-if="!isLogged">登录</b-nav-item>
                    <b-nav-item-dropdown style="font-size: 1.25em; font-weight:bold;" text="大学资料"  v-if="isLogged" >
                        <b-dropdown-item to='user' v-if="!user">个人主页</b-dropdown-item>
                        <b-dropdown-item to='user' v-else>{{user.uniNameCN}}</b-dropdown-item>
                        <b-dropdown-item to='admin' v-if="user.admin">Admin Dashboard</b-dropdown-item>
                        <b-dropdown-item to='lottery' v-if="false">电子抽签</b-dropdown-item>
                        <b-dropdown-item to='result' v-if="drawn==1">电子抽签结果</b-dropdown-item>
                        <b-dropdown-item @click="logout()"> 登出 </b-dropdown-item>
                    </b-nav-item-dropdown> -->
                    <b-nav-item to='user'>{{user.uniNameCN}}</b-nav-item>
                    <b-nav-item to='admin' v-if="false">管理页面</b-nav-item>
                    <b-nav-item to='lottery' target="blank">电子报名</b-nav-item>
                    <b-nav-item to='result' target="blank">电子报名结果</b-nav-item>
                    <b-nav-item @click="logout()"> 登出 </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>

import login from './login.vue'

export default
  {
    name:'oldnav',
    components:{login},
    props:{
      isLogged: Boolean,
      user: Object,
    },
    data(){
      return{
        isLogged: false,
        user: JSON.parse(localStorage.getItem('user')),
      }
    },
    methods:{
        logout: function () {
            this.$store.dispatch('logout')
            .then(() => {
                this.$router.push('/')
            })
        },
    }
  }
</script>

<style scoped>
  
</style>
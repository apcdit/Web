<template>
    <div id="app">
        <div style="height:100px;">
            <div>

                <b-navbar type="light" class="main-nav" variant="white" toggleable fixed="top" style="opacity:1">
                    <b-navbar-brand href="/"><img src="http://i.imgur.com/90YSaaO.png"></b-navbar-brand>
                    <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
                    <b-collapse is-nav id="nav_dropdown_collapse">
                        <b-navbar-nav>
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
                        </b-navbar-nav>

                        <b-navbar-nav class="ml-auto">
                            <b-nav-item router-link to='/register' v-if="!isLoggedIn" style="font-size: 1.25em; font-weight:bold;">账号注册</b-nav-item>
                            <b-nav-item router-link to='/login' v-if="false"><img src="https://i.imgur.com/h5GY79C.png"></b-nav-item>
                            <b-nav-item-dropdown style="font-size: 1.25em; font-weight:bold;" text="大学资料"  v-if="isLoggedIn" >
                                <b-dropdown-item to='user' v-if="!update">个人主页</b-dropdown-item>
                                <b-dropdown-item to='user' v-else>{{update.uniNameCN}}</b-dropdown-item>
                                <b-dropdown-item to='admin' v-if="update.admin">Admin Dashboard</b-dropdown-item>
                                <b-dropdown-item to='lottery' v-if="true">电子抽签</b-dropdown-item>
                                <b-dropdown-item to='result' v-if="drawn==1">电子抽签结果</b-dropdown-item>
                                <b-dropdown-item @click="logout()"> 登出 </b-dropdown-item>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>
            </div>
        </div>
        <transition name="fade"><router-view style="margin-top:2%;" ></router-view></transition>

         <div class="row" style="padding:5%;width:100%">

            <!-- <div class="col-md-8">
                <h6 style="text-align: center" > NTU APICDT All Rights Reserved &copy 2018 </h6>
            </div> -->
            <!-- <div class="col-md-4">
                <div><strong>联络我们</strong></div>
                <a href="http://weibo.com/p/1005055398940329" target="_blank"><img style="position:relative" src="http://cdn.onlinewebfonts.com/svg/img_164924.png" width="11%" height="60%"></a>
                <a href="https://www.instagram.com/apchinesedebate/" target="_blank"><img src="http://pluspng.com/img-png/instagram-png-instagram-png-file-512.png" width="12%" height="68%"></a>
                <a href="https://www.facebook.com/NTUCSapchinesedebate/" target="_blank"><img src="https://i.imgur.com/0rBWRj7.png" width="11%" height="60%"></a>
                </div> -->
            </div>
            </div>

    </div>



</template>

<script>
    import axios from 'axios'
    import about from './components/about.vue'
    import pastyear from './components/pastyear.vue'
    import rules from './components/rules.vue'
    import contact from './components/contact.vue'
    import navigation from './components/navigation.vue'
    import videohub from './components/videohub.vue'
    import login from './components/login.vue'
    import register from './components/register.vue'
    import register1 from './components/register1.vue'
    import lottery from './components/lottery.vue'
    import simlottery from './components/simlottery.vue'
    import result from './components/result.vue'
    import user from './components/user.vue'
    import resetpw from './components/resetpw.vue'
    import admin from './components/admin.vue'
    import notifysuccess from './components/notifysuccess.vue'
    import latestNews from './components/latestNews.vue'
    import post from './components/post.vue'
    import home from './components/home.vue'
    import resetpw1 from './components/resetpw1.vue'

    export default {
        name: 'App',
        components: {admin,about,pastyear,rules,contact,
                    navigation,videohub,login,register,register1,lottery,
                    simlottery,result,user,resetpw,notifysuccess,latestNews,post,home,resetpw1,},
        data(){
            return{
                logged : false,
                user: JSON.parse(localStorage.getItem('user')),
                uniDetails: {},
                drawn: false,
                admin: false,

            }
        },
        computed : {
            isLoggedIn : function(){ this.logged=this.$store.getters.isLoggedIn; return this.$store.getters.isLoggedIn},
            update: function(){ return JSON.parse(localStorage.getItem('user'))}
        },
        created() {
            this.showUser();
        },
        mounted() {
            this.getDrawn();
        },
        methods: {
            logout: function () {
                this.$store.dispatch('logout')
                    .then(() => {
                        this.$router.push('login')
                    })
            },

            showUser: function(){
                // if(localStorage.getItem('token') == null){
                //     return true;
                // }
                axios
                    .get('api/user',{headers: { Authorization: "Bearer " + localStorage.getItem('token')}})
                    .then(resp=>{
                        this.user = resp.data.user
                        this.uniNameCN = resp.data.user.uniNameCN
                        this.uniDetails = resp.data.uniDetails
                        this.admin = this.user.admin
                    })
                    .catch(er=>{
                        //console.log("damn");
                    })
            },
            getDrawn: function(){
                axios
                    .get('api/time/official/getDraw',{
                    headers:{
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                    })
                    .then(resp=>{
                        this.drawn = resp.data.drawn
                        //console.log(this.drawn);
                    })       
                },

        },
    }
</script>

<style>

    @import url('https://fonts.googleapis.com/css?family=Noto+Sans+SC');

    .fade-enter-active, .fade-leave-active {
        transition-property: opacity;
        transition-duration: .50s;
    }

    .fade-enter-active {
        transition-delay: .50s;
    }

    .main-nav{
        border-bottom:0.03px solid lightgray;
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }

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
    #app{top: 100%;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    font-family: 'Noto Sans SC', sans-serif;
    /* background-image: url("https://i.imgur.com/mDsqWbu.jpg") */
    ;}


</style>
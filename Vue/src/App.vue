<template>
    <div id="app">
        <div>
            <div>
                <b-navbar type="light" variant="white" toggleable fixed="top" style="opacity: 60%">
                    <b-navbar-brand href="/"><img src="http://i.imgur.com/90YSaaO.png"></b-navbar-brand>
                    <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
                    <b-collapse is-nav id="nav_dropdown_collapse">
                        <b-navbar-nav>
                            <b-nav-item-dropdown text="关于我们" right >
                                <b-dropdown-item router-link to='/about'>赛会简介</b-dropdown-item>
                                <b-dropdown-item router-link to='/rules' v-if="false">参赛事宜</b-dropdown-item>
                                <b-dropdown-item router-link to='/pastyear'>历届赛况</b-dropdown-item>
                                <b-dropdown-item href="/#">筹委介绍</b-dropdown-item>
                            </b-nav-item-dropdown>
                            <b-nav-item-dropdown text="活动详情" right >
                                <b-dropdown-item href="#">最新消息</b-dropdown-item>
                                <b-dropdown-item href="#">最新赛况</b-dropdown-item>
                                <b-dropdown-item href="#">赛程</b-dropdown-item>
                            </b-nav-item-dropdown>

                            <b-nav-item router-link to='/videohub'>视频库</b-nav-item>
                            <b-nav-item router-link to='/contact'>联络我们</b-nav-item>
                        </b-navbar-nav>

                        <b-navbar-nav class="ml-auto">
                            <!-- <b-nav-item router-link to='/login' v-if="!isLoggedIn"><img src="https://i.imgur.com/h5GY79C.png"></b-nav-item> -->
                            <b-nav-item-dropdown text="大学资料"  v-else >
                                <b-nav-item to='user' v-if="!user">大学资料</b-nav-item>
                                <b-nav-item to='user' v-else>{{user.uniNameCN}}</b-nav-item>
                                <b-nav-item to='lottery'>电子抽签</b-nav-item>
                                <b-nav-item to='simlottery' v-if="false">模拟电子抽签</b-nav-item>
                                <b-nav-item to='result'>电子抽签结果</b-nav-item>
                                <b-nav-item @click="logout()"> 登出 </b-nav-item>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>
            </div>
        </div>
        <transition name="fade"><router-view style="margin-top:150px;"></router-view></transition>
        <b-navbar>
            <div class="col-md-8">

                <h6 class="copyright"> NTU APICDT All Rights Reserved &copy 2018 </h6>
            </div>
            <div class="col-md-4" id="social-logo">
                <a href="http://www.apchinesedebate.com/contactus.php" target="_blank"><i class="fa fa-envelope-square fa-2x" aria-hidden="true"></i></a>
                <a href="http://weibo.com/p/1005055398940329" target="_blank"><i class="fa fa-weibo fa-2x" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/apchinesedebate/" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                <a href="https://www.facebook.com/NTUCSapchinesedebate/" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
            </div>
        </b-navbar>
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

    export default {
        name: 'App',
        components: {about,pastyear,rules,contact,navigation,videohub,login,register,register1,lottery,simlottery,result,user},
        data(){
            return{
                logged : false,
                user: {},
                uniDetails: {},
            }
        },
        computed : {
            isLoggedIn : function(){ this.logged=this.$store.getters.isLoggedIn; return this.$store.getters.isLoggedIn},
            //authUser: function(){ if(this.logged && this.$store.getters.authUser) return JSON.parse(this.$store.getters.authUser);},
            status: function(){ return (this.$store.getters.authStatus) ;},
        },
        created() {
                this.showUser();
        },
        updated() {
            this.showUser();
            // if(this.logged){
            //   this.$forceUpdate()
            // }
        },
        methods: {
            logout: function () {
                this.$store.dispatch('logout')
                    .then(() => {
                        this.$router.push('login')
                    })
            },

            showUser: function(){
                axios
                    .get('api/user',{headers: { Authorization: "Bearer " + localStorage.getItem('token')}})
                    .then(resp=>{
                        this.user = resp.data.user
                        this.uniDetails = resp.data.uniDetails
                    })
            },

        },
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition-property: opacity;
        transition-duration: .50s;
    }

    .fade-enter-active {
        transition-delay: .50s;
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

</style>
<template>
    <div id="app">
        <transition name="fade"><router-view style="margin-top:105px"></router-view></transition>
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
    import CubeSpin from '../node_modules/vue-loading-spinner/src/components/Circle8.vue'
    import foot from './components/foot.vue'
    import navibar from './components/navigation.vue'
    import oldnav from './components/oldnav.vue'
    import homepage from './components/homepage.vue'
    import people from './components/people.vue'

    export default {
        name: 'App',
        components: {admin,about,pastyear,rules,contact,
                    navigation,videohub,login,register,register1,lottery,
                    simlottery,result,user,resetpw,notifysuccess,latestNews,post,home,resetpw1,CubeSpin,foot,navibar,
                    oldnav,homepage,people},
        data(){
            return{
                drawn: false,
                admin: false,
                region: '',
            }
        },
        created() {
            //this.showUser();
        },
        // mounted() {
        //     this.getDrawn();
        // },
        methods: {
            showUser: function(){
                //api/user
                        axios
                    .get('api/user',{headers: { Authorization: "Bearer " + localStorage.getItem('token')}})
                    .then(resp=>{
                        this.user = resp.data.user
                        this.user['uni_details'] = resp.data.uniDetails;
                        localStorage['user'] = JSON.stringify(this.user);
                        this.uniNameCN = resp.data.user.uniNameCN
                        this.uniDetails = resp.data.uniDetails
                        this.admin = this.user.admin
                        this.drawn = resp.data.uniDetails.drawn
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
                    })       
                },

        },
    }
</script>

<style scoped>

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
        color:black;
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
    /* background-color: #fafafa; */
    /* background-image: url("https://i.imgur.com/7MJgWRy.jpg") */
    ;}


</style>
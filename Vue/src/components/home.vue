<template>
    <div>
        <navibar v-bind:isLogged="isLogged"></navibar>
        <login></login>
        <section class="bg">
            <div class="center text-center">
                    <!-- <div><img src="http://i.imgur.com/90YSaaO.png" /></div> -->
                    <div style="text-align: center;">
                        <div id="title"><strong>工行杯</strong></div>
                        <div id="title"><strong>亚太大专辩论公开赛</strong></div>
                        <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月10日至7月14日</h5>
                        <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                        <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5>
                    </div>
                    <br>
                <div class="form-group col-xs-6">
                    <button class="btn btn-reg" @click="$router.push('register')">点击报名</button>
                </div>
                <div class="row">
                    <div class="col-xs-6 ml-1">
                        <h4 style="color:#9A2A1F;">参赛意愿书</h4>
                        <a  class="btn btn-form" href="https://entuedu-my.sharepoint.com/:f:/g/personal/e180063_e_ntu_edu_sg/EjMVXaF8Om9GrD-KbTNiChYBb3fbYe8jeJJe9fClj857sg?e=BicxIo" target="_blank">OneDrive</a>
                        <a class="btn btn-form" href="https://pan.baidu.com/s/1x6gQf8Md9lzU4xJiiAnjUQ" target="_blank">百度云盘</a>
                    </div>
                    <br>
                    <div class="col-xs-6 ml-1">
                        <h4 style="color:#9A2A1F;">比赛章程</h4>
                        <a class="btn btn-form" href="https://entuedu-my.sharepoint.com/:f:/g/personal/tanj0238_e_ntu_edu_sg/EqNFd_nY03NNsQheQR2nqcUBMfH-4KYYJwlGmdHvboFD-A?e=apQnZQ" target="_blank">OneDrive</a>
                        <a class="btn btn-form" href="https://pan.baidu.com/s/1nbNdHc9fY2xOFeRrQJxBLw" target="_blank">百度云盘</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- 最新消息 -->
        <div class="container text-center" id="latestNews">
            <div id="title"><strong>最新消息</strong></div>
            <br>
            <div class="row">
                <div class="col-xs-4" v-for="post in posts" v-bind:key="post.id">
                    <div class="card profile-card-5">
                        <div class="card-img-block">
                            <img class="card-img-top" v-bind:src="post.postPic" alt="图片无法显示">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title">{{post.postTitle}}</h5>
                            <p class="card-text">{{post.postDec}}</p>
                            <router-link :to="{ name: 'post', params: { id: post.id}}" class="btn btn-primary">查看贴文</router-link>
                        </div>
                    </div>
    		    </div>
            </div>
        </div>
        <hr>

        <!-- 赞助 -->
        <div v-if="false" class="container text-center" id="sponsors">
            <div id=title><strong>赞助</strong></div>
            <br>
            <div id="top-sponsor">
                <h3>冠名赞助</h3>
            </div>
        </div>

        <!-- footer -->
        <footer id="footbar"><foot></foot></footer>

    </div>
    
</template>

<script>
import foot from './foot.vue'
import login from './login.vue'
import navibar from './navigation.vue'
import axios from 'axios'

export default {
    name: 'home',
    components:{foot,navibar,login},
    data(){
        return{
            posts: '',
        }
    },
    computed : {
        isLogged : function(){return this.$store.getters.isLoggedIn},
    },
    created() {
        this.fetchPosts()
    },
    methods:{
        fetchPosts(){
            axios
                .get('api/posts/latest')
                .then(response=>{
                    this.posts = response.data;
                })
        },
    }
}
</script>

<style scoped>

    html {
        scroll-behavior: smooth; 
    }
    
    .bg{
        background-image: url("https://i.imgur.com/7MJgWRy.jpg");
        /* Full height */
        height: 100vh;
        min-height: 100vh; 
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-bottom:solid;
        border-bottom-width: 0.01rem;
        border-bottom-color: lightgrey;
        margin-top: -105.05px;
    }

    .btn-form{
        font-family: "Microsoft YaHei", "华文细黑";
        background-color: #9A2A1F;
        color: white;
        padding: .4rem 1rem;
        border-radius: .25rem;
        display: inline-block;
        font-size: 1rem;
        cursor: pointer;
        border-style:none;
        margin-top:5px;
    }
    .btn-form:hover{
        background-color: rgb(107, 1, 1);
    }
    .btn.btn-reg{
        font-family: "Microsoft YaHei", "华文细黑";
        font-size: 1.5rem;
        background: #9A2A1F;
        color: white;
        border-radius: 10px;
    }
    .btn.btn-reg:hover{
        background:rgb(107, 1, 1);
    }
    .bg .center {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    body{
        height: 100%;
    }

    div #title{
        font-size: 2.5rem;
        padding-top: 5%;
        font-family: "Microsoft YaHei","华文细黑";
    }


    /*Profile Card 5*/
    
    .profile-card-5{
        margin-top:20px;
        margin-left: 35px;
        /* margin-right: 35px; */
        margin-bottom: 20px;
        word-wrap: break-word;
        width: 300px;
    }
    .profile-card-5 .btn{
        border-radius:2px;
        text-transform:uppercase;
        font-size:12px;
        padding:7px 20px;
    }
    .profile-card-5 .btn:hover{
        background-color: rgb(116, 0, 0)
    }
    .profile-card-5 .card-img-block {
        width: 91%;
        margin: 0 auto;
        position: relative;
        top: -20px;
        
    }
    .profile-card-5 .card-img-block img{
        border-radius:3px;
        box-shadow:0 0 10px rgba(0,0,0,0.63);
    }
    .profile-card-5 h5{
        color:darkred;
        font-weight:600;
    }
    .profile-card-5 p{
        font-size:14px;
        font-weight:300;
    }
    .profile-card-5 .btn-primary{
        background-color: darkred;
        border-color: darkred;
    }
</style>

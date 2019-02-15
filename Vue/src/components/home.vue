<template>
    <div>
        <navibar v-bind:isLogged="isLogged"></navibar>
        <login></login>
        <section class="bg parallax">
            <div class="center text-center">
                <!-- <div><img src="http://i.imgur.com/90YSaaO.png" /></div> -->
                <div style="text-align: center;" class="col-xs-12">
                    <div id="title"><strong>工行杯亚太大专辩论公开赛</strong></div>
                    <!-- <div id="title"><strong></strong></div> -->
                    <br>
                    <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月10日至7月14日</h5>
                    <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                    <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5>
                </div>
                <br>

                <div class="row">
                    <!--<div class="col-xs-6 ml-1">-->
                        <!--<h4 style="color:#9A2A1F;">参赛意愿书</h4>-->
                        <!--<a  class="btn btn-form" href="https://entuedu-my.sharepoint.com/:f:/g/personal/e180063_e_ntu_edu_sg/EjMVXaF8Om9GrD-KbTNiChYBb3fbYe8jeJJe9fClj857sg?e=BicxIo" target="_blank">OneDrive</a>-->
                        <!--<a class="btn btn-form" href="https://pan.baidu.com/s/1x6gQf8Md9lzU4xJiiAnjUQ" target="_blank">百度云盘</a>-->
                    <!--</div>-->
                    <!--<br>-->
                    <div class="col">
                        <h4 style="color:#9A2A1F;">比赛章程</h4>
                        <a class="btn btn-form" href="https://entuedu-my.sharepoint.com/:f:/g/personal/tanj0238_e_ntu_edu_sg/EqNFd_nY03NNsQheQR2nqcUBMfH-4KYYJwlGmdHvboFD-A?e=apQnZQ" target="_blank">OneDrive</a>
                        <a class="btn btn-form" href="https://pan.baidu.com/s/1nbNdHc9fY2xOFeRrQJxBLw" target="_blank">百度云盘</a>
                    </div>
                </div>
            </div>
        </section>


        <!------------------ Hover Effect Style : Demo - 16 --------------->
        <div class="container mt-40" style="margin-top: 30px;" id="news">
            <h3 class="text-center">最新消息</h3>
            <div class="row mt-30">
                <div class="col-md-4 col-sm-6"  v-for="post in posts" v-bind:key="post.id">
                    <div class="box16">
                        <img v-bind:src="post.postPic" alt="图片无法显示">
                        <div class="box-content">
                            <h3 class="title">{{post.postTitle}}</h3>

                            <ul class="social">
                                <li><span class="post">{{post.postDec}}</span></li>
                                <li><a style="text-decoration:none;"><router-link :to="{ name: 'post', params: { id: post.id}}" class="btn btn-primary">查看贴文</router-link></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="mobileSide">
            <div style="margin:0px auto;">
                <h3 style="text-align:center;"><strong>更多消息</strong></h3>

                <hr style="background:darkred; height:5px;">
                <!-- <ol class="list-group list-group-flush" >
                    <li class="list-group-item" v-for="other in others" v-bind:key="other.id">
                        <a href="#">{{other.postTitle}}</a>
                        <hr style="width:2px;">
                    </li>
                </ol> -->
                <div v-for="post in posts" v-bind:key="post.id">
                    <router-link  :to="{ name: 'post', params: { id: post.id}}"   class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1" style="color:darkred;"><strong>{{post.postTitle}}</strong></h5>
                            <small>{{post.created_at}}</small>
                        </div>
                        <small>{{post.postDec}}</small>
                    </router-link>
                </div>
            </div>
        </div>
        <hr>

        <!-- 赞助 -->

            <div class="container" width="100%" height="100%">
                <h3 style="text-align:center;"><strong>广告</strong></h3>
                <div style="padding:10px;">
            <img src="https://i.imgur.com/UHeT8gn.jpg" width="100%" >
                    <br><br>
                    <img src="https://i.imgur.com/wIteG8a.jpg" width="100%" >
                </div>
             </div>

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
                others:'',
                id:'',
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
        background-attachment: fixed;
        margin-top: -105.05px;
    }
    .mobileSide{display:none;}

    @media only screen and (max-device-width:1000px){
        .mobileSide{display:block;margin-top: 30px ;}
        #news{display:none;}
        .parallax{
            background-attachment: scroll;
        }
    }

    /*@media only screen and (max-device-width:1366px){*/
        /**/
    /*}*/
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
        font-size: 1.95rem;
        padding-top: 5%;
        font-family: "Microsoft YaHei","华文细黑";
        font-weight: bold;
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


    /*********************** Demo - 16 *******************/
    .box16{text-align:center;color:#fff;position:relative}
    .box16 .box-content,.box16:after{width:100%;position:absolute;left:0}
    .box16:after{content:"";height:100%;background:linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,.08) 69%,rgba(0,0,0,.76) 100%);top:0;transition:all .5s ease 0s}
    .box16 .post,.box16 .title{transform:translateY(145px);transition:all .4s cubic-bezier(.13,.62,.81,.91) 0s}
    .box16:hover:after{background:linear-gradient(to bottom,rgba(0,0,0,.01) 0,rgba(0,0,0,.09) 11%,rgba(0,0,0,.12) 13%,rgba(0,0,0,.19) 20%,rgba(0,0,0,.29) 28%,rgba(0,0,0,.29) 29%,rgba(0,0,0,.42) 38%,rgba(0,0,0,.46) 43%,rgba(0,0,0,.53) 47%,rgba(0,0,0,.75) 69%,rgba(0,0,0,.87) 84%,rgba(0,0,0,.98) 99%,rgba(0,0,0,.94) 100%)}
    .box16 img{width:100%;height:auto}
    .box16 .box-content{padding:20px;margin-bottom:20px;bottom:0;z-index:1}
    .box16 .title{font-size:22px;font-weight:700;text-transform:uppercase;margin:0 0 10px;color:white;}
    .box16 .post{display:block;padding:8px 0;font-size:15px;color:white;}
    .box16 .social li a,.box17 .icon li a{font-size:20px;color:#fff}
    .box16:hover .post,.box16:hover .title{transform:translateY(0)}
    .box16 .social{list-style:none;padding:0 0 5px;margin:40px 0 25px;opacity:0;position:relative;transform:perspective(500px) rotateX(-90deg) rotateY(0) rotateZ(0);transition:all .6s cubic-bezier(0,0,.58,1) 0s}
    .box16:hover .social{opacity:1;transform:perspective(500px) rotateX(0) rotateY(0) rotateZ(0)}
    .box16 .social:before{content:"";width:50px;height:2px;background:#fff;margin:0 auto;position:absolute;top:-23px;left:0;right:0}
    .box16 .social li{display:inline-block}
    .box16 .social li a{display:block;height:40px;background-color: #9A2A1F;line-height:40px;margin-right:10px;transition:all .3s ease 0s; text-decoration:none;}
    .box17 .icon li,.box17 .icon li a{display:inline-block}
    .box16 .social li a:hover{background-color: rgb(107, 1, 1); text-decoration:none;}
    .box16 .social li:last-child a{margin-right:0}
    @media only screen and (max-width:990px){.box16{margin-bottom:30px}
    }

</style>

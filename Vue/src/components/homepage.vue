<template>
    <div>
        <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group shadow" style="opacity:0.9">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">活动详情</h4>
                            <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月10日至7月14日</h5>
                            <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                            <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5><hr>
                            <div>
                                <h4 style="color:#9A2A1F;">参赛意愿书</h4>
                                <a  class="btn" href="https://entuedu-my.sharepoint.com/:f:/g/personal/e180063_e_ntu_edu_sg/EjMVXaF8Om9GrD-KbTNiChYBb3fbYe8jeJJe9fClj857sg?e=BicxIo" target="_blank">OneDrive</a>
                                <a class="btn" href="https://pan.baidu.com/s/1x6gQf8Md9lzU4xJiiAnjUQ" target="_blank">百度云盘</a>
                            </div>
                            <hr>
                            <div>
                                <h4 style="color:#9A2A1F;">比赛章程</h4>
                                <a class="btn" href="https://entuedu-my.sharepoint.com/:f:/g/personal/tanj0238_e_ntu_edu_sg/EqNFd_nY03NNsQheQR2nqcUBMfH-4KYYJwlGmdHvboFD-A?e=apQnZQ" target="_blank">OneDrive</a>
                                <a class="btn" href="https://pan.baidu.com/s/1nbNdHc9fY2xOFeRrQJxBLw" target="_blank">百度云盘</a>
                            </div>
                        </li>
                    </ul>
                    <br>
                    <ul class="list-group shadow">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">最新视频<a href="#" class="btn" style="float:right;">查看更多</a></h4>
                            <div class="row" style="padding:1%; width:100%">
                                <iframe src="https://www.youtube.com/embed/U4v2W_V9Fk0" frameborder="0" allow="autoplay; encrypted-media" width="100%" allowfullscreen></iframe>
                            </div>

                        </li>
                    </ul>
                </div>
                <div class="col-md-8 " id="latestPosts" style="opacity:0.85;padding-top:1%">
                    <div class="container1">
                        <h2 style="color:darkred; ">最新消息</h2>
                        <br>
                        <ul>
                            <li v-for="post in posts" v-bind:key="post.id">
                                <div class="col-sm">
                                    <span class="" href="#" style="text-decoration: none;color:black;">
                                        <div class="row" style="width:100%">
                                            <div class="col-sm-4" style="width:100%"><img v-bind:src="post.postPic" width="150px" height="150px"></div>

                                            <div class="col-sm-8" style="width:100%">
                                                <div class="row">
                                                    <router-link :to="{ name: 'post', params: { id: post.id}}">
                                                        <h2 style="color:#9A2A1F;">{{post.postTitle}}</h2></router-link>
                                                </div>
                                                <div class="row">
                                                    <p style="15px">{{post.postDec}}</p>
                                                </div>

                                                <div class="row">
                                                    <p style="9px;color:darkgrey;">发布于{{post.created_at}}</p>
                                                </div>


                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <hr>
                            </li>
                        </ul>

                        <b-tab title="最新赛况" v-if="false"></b-tab>
                        <b-tab title="对垒表" v-if="false"></b-tab>

                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <hr/>
    </div>
</template>

<script>

    import axios from 'axios';
    import oldnav from './oldnav.vue';

    export default
    {
        name:'homepage',
        components:{oldnav,},
        computed : {
            isLogged : function(){ return this.$store.getters.isLoggedIn},
            user: function(){ return JSON.parse(localStorage.getItem('user'))}
        },
        data(){
            return{
                videos:['https://www.youtube.com/embed/U4v2W_V9Fk0'],
                posts: '',
                user: '',
                uni:[],
            }
        },
        created(){
            this.fetchPosts()
            //this.fetchUni()
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
    .pagination-list{
        padding-bottom: 25px
    }
    .container{margin-top:1%;width:100%;}
    .container1{width:100%;}
    .btn{
        background-color: #9A2A1F;
        color: white;
        padding: .4rem 1rem;
        border-radius: .25rem;
        display: inline-block;
        font-size: 1rem;
        cursor: pointer;
        border-style:none;
    }
    .btn:hover{
        background-color: rgb(107, 1, 1);
    }
    .pagination-list{color:black;}
    #latestPosts{
        background-color: white;
        border-style: hidden;
        /* shadows and rounded borders */
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        border-radius: 20px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    }
    .list-group shadow{/* shadows and rounded borders */
        -moz-border-radius: 40px;
        -webkit-border-radius: 40px;
        border-radius: 40px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);}

    .grid {
        display: grid;
        grid-gap: 10px;
        grid-template-columns: repeat(3, 1fr);
        width:90%;
        margin:auto;
    }
    .cell{
        padding: 10px;
        background-color: #9D0000;
        color:#F9F9F6;
        text-align:center;
        border-radius: 25px;
    }
    .btn-form:hover{
        color:white;
    }

</style>

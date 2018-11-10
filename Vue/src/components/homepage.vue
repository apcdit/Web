<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group shadow">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">活动详情</h4>
                            <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月9日至7月15日</h5>
                            <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                            <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5><hr>
                            <h4 style="color:#9A2A1F;">参赛意愿书</h4>
                            <a  class="btn" href="https://entuedu-my.sharepoint.com/:f:/g/personal/e180063_e_ntu_edu_sg/EjMVXaF8Om9GrD-KbTNiChYBb3fbYe8jeJJe9fClj857sg?e=BicxIo" target="_blank">OneDrive</a>
                            <a class="btn" href="https://pan.baidu.com/s/1x6gQf8Md9lzU4xJiiAnjUQ" target="_blank">百度云盘</a>
                            <a class="btn " href="#" v-if="false">领取总决赛门票</a>
                        </li>
                    </ul>
                    <br>
                    <ul class="list-group shadow">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">最新视频<a href="#" class="btn" style="float:right;">查看更多</a></h4>
                            <div class="row" style="padding:1%;">
                                <iframe src="https://www.youtube.com/embed/U4v2W_V9Fk0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>

                        </li>
                    </ul>
                </div>
                <div class="col-md-8 " id="latestPosts">
                    <div class="container">
                            <h4 style="color:darkred; "><strong>最新</strong>消息</h4>
                                <br>
                                <ul>
                                    <li v-for="post in posts">
                                        <div class="col-xs-4">
                                            <a class="" href="#" style="text-decoration: none;color:black;">
                                                <div class="row">
                                                    <div class="col-sm-4"><img v-bind:src="post.postPic" width="180px" height="150px"></div>

                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <h2 style="color:#9A2A1F;">{{post.postTitle}}</h2>
                                                        </div>
                                                        <div class="row">
                                                            <p style="15px">{{post.postDec}}</p>
                                                        </div>

                                                        <div class="row">
                                                            <p style="9px;color:darkgrey;">发布于{{post.created_at}}</p>
                                                        </div>


                                                    </div>
                                                </div>
                                            </a>
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
        <center>
            <h1 v-if="false">参赛队伍</h1>

        </center>
        <hr/>
    </div>
</template>

<script>

    import axios from 'axios';

    export default
    {
        name:'homepage',
        data(){
            return{
                videos:['https://www.youtube.com/embed/U4v2W_V9Fk0'],
                posts: '',
                user: ''
            }
        },
        created(){
            this.fetchPosts()
        },
        methods:{
            fetchPosts(){
                axios
                    .get('api/posts/latest')
                    .then(response=>{
                        this.posts = response.data;
                        //console.log(localStorage.getItem('user'))
                    })
            },

        }

    }
</script>

<style scoped>
    .pagination-list{
        padding-bottom: 25px
    }
    .container{margin-top:1%;}
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
    .pagination-list{color:black;}
    #latestPosts{
        background-color: white;
        border-style: hidden;
    }
</style>
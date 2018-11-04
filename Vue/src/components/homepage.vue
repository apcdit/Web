<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group shadow">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">活动详情</h4>
                            <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月12日至7月16日</h5>
                            <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                            <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5>
                            <a  class="btn" href="https://entuedu-my.sharepoint.com/:b:/g/personal/e180063_e_ntu_edu_sg/EdS_rb-Dd9pMpWSDdmyLmCIB8EGVZVCfHvtSIPzZ9FixqQ?e=zaf8B" target="_blank">参赛意愿书</a>
                            <a class="btn " href="#">领取总决赛门票</a>
                        </li>
                    </ul>
                    <ul class="list-group shadow">
                        <li class="list-group-item">
                            <h4 style="color:#9A2A1F;">最新视频<a href="#" class="btn" style="float:right;">查看更多</a></h4>
                            <div class="row" style="padding:1%;">
                                <iframe src="https://www.youtube.com/embed/U4v2W_V9Fk0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>

                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="jumbotron shadow sidebar">
                        <b-tabs>
                            <b-tab title="最新消息">
                                <br>
                                <ul class="pagination-list">
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
                            </b-tab>
                            <b-tab title="最新赛况"></b-tab>
                            <b-tab title="对垒表"></b-tab>
                            <b-tab title="参赛意愿书"><p  style=" margin: 12px auto 6px auto; font-family: Helvetica,Arial,Sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; display: block;">   <a title="View Registration Form on Scribd" href="https://www.scribd.com/document/392328494/Registration-Form#from_embed"  style="text-decoration: underline;" >Registration Form</a> by <a title="View chinesedebate's profile on Scribd" href="https://www.scribd.com/user/336291034/chinesedebate#from_embed"  style="text-decoration: underline;" >chinesedebate</a> on Scribd</p><iframe class="scribd_iframe_embed" title="Registration Form" src="https://www.scribd.com/embeds/392328494/content?start_page=1&view_mode=scroll&access_key=key-zeRDklw0wGKczBdChOYM&show_recommendations=true" data-auto-height="false" data-aspect-ratio="0.7080062794348508" scrolling="yes" id="doc_6434" width="100%" height="400px" frameborder="0"></iframe></b-tab>
                        </b-tabs>
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
</style>

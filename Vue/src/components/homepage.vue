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
                <a  class="btn" href="#">辩题列表</a>
                <a class="btn " href="#">领取总决赛门票</a>
              </li>
            </ul>
        <ul class="list-group shadow">
          <li class="list-group-item">
               <h4 style="color:#9A2A1F;">最新视频<a href="news.php" class="btn" style="float:right;">查看更多</a></h4>
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
          <b-tab title="人气队伍"></b-tab>
        </b-tabs>
    </div>
  </div>
 </div>
 </div>
 <hr/>
 <center>
 <h1>参赛队伍</h1>

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

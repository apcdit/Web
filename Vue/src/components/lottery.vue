<template>
<div class="container">
  <br>
  <h1 style="text-align:center">模拟电子抽签系统</h1>
  <hr>
  <div class="row">
    <div class="col-md-12" style="text-align:center; color:darkred;"><h2>{{user.uniNameCN}}</h2></div>
    <div class="col-md-4" style="text-align:center;padding:1em 0;">
        <h3><a style="text-decoration:none;">新加坡</a><span style="color:gray;"><br />本地时间</span></h3>
        <iframe src="http://free.timeanddate.com/clock/i5h4olht/n236/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3>
        <a style="text-decoration:none;">当地时间</a>
        <span style="color:gray;"><br/>地区：{{user.region}}</span>
      </h3>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3><a style="text-decoration:none;">系统开放时间</a><span style="color:gray;"><br />(新加坡时间)</span></h3>
      <h6>{{simTimeStart}}</h6>
    </div>

    <br>

    <div class="panel panel-default" >
      <div class="panel-body" >
        <div class="col-md-12">
          <center>
            <h3>请点击下方的按钮进行电子报名。</h3>
            <p>系统开放后，只需点击下方按钮即可完成电子报名程序。</p>
            <br>
              <button v-on:click="recordTime" class="btn btn-primary btn-block " id="register">报名</button>
            <br>
            <a href="apchinesedebate.com/user_dashboard" class="btn btn-lg">个人主页</a>
          </center>
        </div>
      </div>
    </div>
    
  </div>
</div>
</template>
<script>
import axios from 'axios';

export default
{
  name:'lottery',
  created () {
    setInterval(() => this.now = new Date, 1000 * 60)
  },
  data(){
    return{
      pressed: 0,
      simTimeStart: 0,
      user: {},
      uniDetails: {},
    }
  },
  computed: {
    now () {
      return new Date
    },
    authUser: function(){ if(this.$store.getters.authUser) return JSON.parse(this.$store.getters.authUser);},
  },
  created(){
    this.startTime();
    this.showUser();
  },
  methods:{
    recordTime:function(){
      const data = { 'pressed' : 1} //pressed here is to notify backend that user pressed the button
      try{
        axios
          .put('api/time/simulation/store', data, {
            headers: { Authorization: "Bearer " + localStorage.getItem('token')}
          })
          .then(resp=>{
            if(resp.data.status == 200){
              //console.log(resp.data)
              alert("时间已成功记录！")
            }else if(resp.data.status == 304){ alert("只能报名一次！")}
          })
      }catch(e){console.log(e)
      }
    },
    startTime: function(){
      axios
        .get('api/time/simulation/start',{
          headers:{
              Authorization: "Bearer " + localStorage.getItem('token')
          }
        })
        .then(resp=>{
          //console.log(resp.data)
          if(resp.data.status == 200){
              this.simTimeStart = resp.data.simTimeStart;

          }
        })
    },
    showUser: function(){
      axios
        .get('api/user',{headers: { Authorization: "Bearer " + localStorage.getItem('token')}})
        .then(resp=>{
          this.user = resp.data.user
          this.uniDetails = resp.data.uniDetails
          switch(this.user.region){
            case "Malaysia": this.user.region = "马来西亚"; break;
            case "Singapore": this.user.region = "新加坡"; break;
            case "China": this.user.region = "中国"; break;
            case "Hong Kong": this.user.region = "香港"; break;
            case "Macau": this.user.region = "澳门"; break;
            case "Taiwan": this.user.region = "台湾"; break;
            case "Australia": this.user.region = "澳洲"; break;
            default: break;
          }
        })
    },
  }
}
</script>
<style scoped>
  .register{
    background-color: darkred
  }
</style>

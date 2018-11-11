<template>
<div class="container">
  <br>
  <h1 style="text-align:center">电子抽签系统</h1>
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
        <br>
        <span v-if="user.region == '马来西亚'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n122/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '新加坡'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n236/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '澳大利亚'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n240/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '中国'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n33/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '香港'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n102/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '台湾'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n241/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '澳门'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n33/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else><iframe src="http://free.timeanddate.com/clock/i5h4olht/n236/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
      </h3>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3><a style="text-decoration:none;">系统开放时间</a><span style="color:gray;"><br />(新加坡时间)</span></h3>
      <h6>{{offTimeStart}}</h6>
    </div>

    <br>

    <div class="panel panel-default" id="registerBody">
      <div class="panel-body" >
        <div>
          <center>
            <h3>请点击下方的按钮进行电子报名。</h3>
            <p>系统开放后，只需点击下方按钮即可完成电子报名程序。</p>
            <br>
              <button v-on:click="recordTime" class="btn btn-primary btn-block " id="register" :disabled="drawn==1">报名</button>
            <br>
            <button @click="$router.push('user')" class="btn btn-lg">个人主页</button>
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
      offTimeStart: 0,
      user: {},
      uniDetails: {},
      drawn: 1,
      epochTime: 0,
      counter:0,
      token_mystery: '',
      //startTime: 0,
    }
  },
  computed: {
    now () {
      return new Date
    },
    authUser: function(){ if(this.$store.getters.authUser) return JSON.parse(this.$store.getters.authUser);},
  },
  mounted(){
    this.getDrawn();
    
  },
  created(){
    this.startTime();
    this.showUser();
  },
  methods:{
    recordTime:function(){
       //pressed here is to notify backend that user pressed the button
      // try{
      //   var current = (Date.now()+28800)*1000;
      //   console.log("current epoch: "+current);
      //   //this.epochTime = this.epochTime*1000;
      //   console.log("epoch start time: " + this.epochTime*1000);
      //   console.log("Time diff" + (current - this.epochTime*1000));
      //   var timeDiff = (current-this.epochTime*1000)/1000 - 30000;
      //   if((current - this.epochTime*1000) <= 30000000){
      //     //console.log((Date.now()+28800)*1000);
      //     alert("还未到时间");
      //   }else if(this.counter == 0 && timeDiff >= 0){
      //     ++this.counter;
      //     console.log("Time diff: " + timeDiff);
      //     const data = { 'pressed' : 1, 'timeDiff':timeDiff}
      //     console.log("SENT!");
      //     axios
      //     .put('api/time/official/store', data, {
      //       headers: { Authorization: "Bearer " + localStorage.getItem('token')}
      //     })
      //     .then(resp=>{
      //       if(resp.data.status == 200){
      //         //console.log(resp.data)
      //         alert("时间已成功记录！")
      //         this.$router.push('result')
      //       }//else if(resp.data.status == 304){ alert("只能报名一次！")
      //       //}else if(resp.data.status == 201){ alert("还未到时间！")}
      //     })
      //   }
        
      //   }catch(e){console.log(e)
      // }
      
        try{
          const token_mystery = localStorage.getItem('token_mystery');
          //var current = (Date.now()+28800)*1000;
          //console.log("current: "+current + " epochStart: " + this.epochTime*1000 + " diff: " + (current-this.epochTime*1000));
          //if((current - this.epochTime*1000) >= 28000000){
            const data = { 'pressed' : 1, 'token_mystery': token_mystery} //pressed here is to notify backend that user pressed the button
            axios
<<<<<<< HEAD
                .post('/time.php', data, { ///api/time/official/store
=======
                .post('Vue/dist/time.php', data, { ///api/time/official/store
>>>>>>> ab6c05fcb6a759e6c7b77daea339a6bfb40ec44d
                    headers: { Authorization: "Bearer " + localStorage.getItem('token')}
                })
                .then(resp=>{
                    if(resp.data.status == 200){
                        //console.log(resp.data)
                        alert("时间已成功记录！")
                        console.log(resp.data)
                        this.$router.push('result');
                    }else if(resp.data.status == 304){ alert("只能报名一次！")
                    }else if(resp.data.status == 201){ alert("还未到时间！")}
                })
          
        }catch(e){console.log(e)
        }
    },
    startTime: function(){
      axios
        .get('api/time/official/start',{
          headers:{
              Authorization: "Bearer " + localStorage.getItem('token')
          }
        })
        .then(resp=>{
          //console.log(resp.data)
          if(resp.data.status == 200){
              this.offTimeStart = resp.data.offTimeStart; //formatted time
              this.epochTime = resp.data.offTimeStart2; //epoch time
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
            case "Australia": this.user.region = "澳大利亚"; break;
            default: break;
          }

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
            console.log(this.drawn);
        })       
    },
  },
  // watch:{
  //   currentTime: function(){
  //     this.timeNow = new Data()
  //     console.log(this.timeNow)
  //   }
  // }
}
</script>
<style scoped>
  .register{
    background-color: darkred
  }

  #registerBody{
    margin: 0 auto;
    position: relative;
  }
</style>

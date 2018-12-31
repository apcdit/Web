<template>
<div class="container" style="background-color:white">
  <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
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
        <span v-else-if="user.region == '中国大陆'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n33/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '香港'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n102/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '台湾'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n241/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else-if="user.region == '澳门'"><iframe src="http://free.timeanddate.com/clock/i5h4olht/n33/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
        <span v-else><iframe src="http://free.timeanddate.com/clock/i5h4olht/n236/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe></span>
      </h3>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3><a style="text-decoration:none;color:darkred">系统开放时间</a><span style="color:gray;"><br />(新加坡时间)</span></h3>
      <h6>{{offTimeStart}} ~ {{offTimeEnd}}</h6>
    </div>

    <br>

    <div class="panel panel-default" id="registerBody">
      <div class="panel-body" >
        <div>
          <center>
            <h3>请点击下方的按钮进行电子报名。</h3>
            <p>系统开放后，只需点击下方按钮即可完成电子报名程序。</p>
            <p style="color:red;">点击报名次数大于3，必须<b><span style="font-size:18px">刷新网页</span></b>。</p>
            <br>
              <button v-on:click="recordTime" :disabled="counter===1" class="btn btn-primary btn-block " id="register">报名</button>
              <br>
           </center>
           <h1>规则与条例</h1>
            <p>i) 成功位于排行榜的前N位 (根据地区分配名额) 将获得参赛资格 </br>
ii） 如发现任何不恰当行为，本方有权取消参赛资格</br>
iii） 当时间还未到时，点击报名后将会显示 “时间还未到”， 每当点击报名超过<b><span style="font-size:18px">三</span></b>次，将会跳出新页面， 并提醒用户时间还未到达和<b><span style="font-size:18px">刷新页面</span></b>。</br>
iv) 当时间到且成功在有效时间段内点击报名,用户将会跳转去排行榜页面</br>
v）排行榜将会依据用户的点击报名时间与系统开放时间之差进行排列， 时间差最小的N位 (根据地区分配名额) 将获得参赛资格</br>
vi) 本章程的最终解释权属于第九届亚太组委会，主办当局保留增删之权力。

<h1>浏览器设置：</h1>

i)如果本地时间和当地时间无法显示， 请在浏览器右上方点击 “Load Unsafe Script”。</br>
ii)请确保 enable 浏览器的pop out选项。 </br>
iii)如有任何问题，请电邮我们：chinesedebate.it@gmail.com</br></p>


            
            
          
        </div>
      </div>
    </div>
    
  </div>
</div>
</template>
<script>
import axios from 'axios';
import oldnav from './oldnav.vue'


export default
{
  name:'lottery',
  data(){
    return{
      pressed: 0,
      offTimeStart: 0,
      uniDetails: {},
      drawn: 1,
      counter:0,
      token_mystery: '',
      offTimeEnd: 0,
      counter2:0,
    }
  },
  components:{
    oldnav
  },
  computed: {
    isLogged : function(){ return this.$store.getters.isLoggedIn},
    user: function(){
            return JSON.parse(localStorage.getItem('user'));
        }
  },
  created(){
    this.startTime();
    this.showUser();
  },
  methods:{
    recordTime:function(){
        try{
          const token_mystery = localStorage.getItem('token_mystery');
          const drawn = JSON.parse(localStorage.getItem('user')).uni_details.drawn;
            const data = {'token_mystery': token_mystery} //pressed here is to notify backend that user pressed the button
            if(drawn == 1){
              alert("队伍已经成功报名！请等待成绩出炉！")
              return true;
            }
            
            axios
                .put('/Vue/dist/time.php', data, { //api/time/official/store'
                  headers:{
                      Authorization: "Bearer " + localStorage.getItem('token')
                  }
                })
                .then(resp=>{
                    if(resp.data.status == 200){
                        const user = JSON.parse(localStorage['user']);
                        const uni = user.uni_details;
                        uni.drawn = 1;
                        localStorage['user'] = JSON.stringify(user);
                        ++this.counter;
                        alert(resp.data.message);
                        this.$router.push('result');
                    }else{
                        this.counter2++;
                        console.log(this.counter2);
                        if(this.counter2>3){
                        
                            var myWindow=window.open("","MsgWindow","width=200,height=100");
                            alert("请刷新网页！");
                            myWindow.document.write("时间还未到<br/>请刷新网页！");}
                        else{
                        alert("<p>时间还未到。请耐心等待！</p>");}
                        //var myWindow=window.open("","MsgWindow","width=200,height=100");
                        //myWindow.document.write("<p>时间还未到</p>");
                    }
                })
          
        }catch(e){console.log(e)
        }
    },
    startTime: function(){
      const token_mystery = localStorage.getItem('token_mystery');
      const region = JSON.parse(localStorage.getItem('user')).region;
      axios
        .get('/Vue/dist/start.php',{ //api/time/official/start
          params:{
                    'token_mystery': token_mystery,
                    'region': region
                }
        },{
          headers:{
              Authorization: "Bearer " + localStorage.getItem('token')
          }
        })
        .then(resp=>{
          //console.log(resp.data)
          if(resp.data.status == 200){
              this.offTimeStart = resp.data.offTimeStart; //formatted time
              this.offTimeEnd = resp.data.offTimeEnd;
          }
        })
    },
    showUser: function(){
              
      axios
          .get('api/user',  //'/Vue/dist/user.php'
          {headers: { Authorization: "Bearer " + localStorage.getItem('token')}})
          .then(resp=>{
          //reset the drawn everytime get into this page
          const users = resp.data.user;
          users['uni_details'] = resp.data.uniDetails;
          localStorage['user'] = JSON.stringify(users);
          switch(this.user.region){
            case "Malaysia": this.user.region = "马来西亚"; break;
            case "Singapore": this.user.region = "新加坡"; break;
            case "China": this.user.region = "中国大陆"; break;
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
        })       
    },
  },
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

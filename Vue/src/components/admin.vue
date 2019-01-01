<template>
    <div>
        <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
        <!-- control area -->
        <div class="container">
            <h1><strong>管理员页面</strong></h1>
            <hr>
            <b-card>
                <b-tabs pills horizontal class="nav-justified ">
                    <hr>
                    <b-tab title="设置显示时间" active>
                        <!-- control area -->
                        <div class="row">
                            <div class="col-md">
                                    <label>区域:</label>
                                    <select v-model="selected">
                                        <option disabled value="">Region</option>
                                        <option>Singapore</option>
                                        <option>Malaysia</option>
                                        <option>China</option>
                                        <option>Hong Kong</option>
                                        <option>Macau</option>
                                        <option>Taiwan</option>
                                        <option>Australia</option>
                                        <option>Admin</option>
                                        <option>Others</option>
                                    </select>
                                    <div class="form-group">
                                        <label>开始时间:</label>
                                        <input v-model="offTimeStart" class="form-control" placeholder="输入开始时间">
                                        <label>结束时间:</label>
                                        <input v-model="offTimeEnd" class="form-control" placeholder="输入结束时间">
                                    </div>
                            </div>
                            <div class="col-md">
                                <h6 class="alert alert-danger">**(2018-10-21 10:55:00 24 HOURS FORMAT)</h6>
                                <button @click="setTime" class="btn btn-primary btn-block">设置显示时间</button>
                                <!-- <button @click="getTime" class="btn btn-primary btn-block">get time</button> -->
                                <button @click="cache" class="btn btn-primary btn-block">Cache</button>
                                <button @click="optimize" class="btn btn-primary btn-block">Optimze</button>
                            </div>
                        </div>
                        <hr>
                        <!-- data display area -->
                        <div class="container">
                            <h3><strong>各区域显示时间</strong></h3>
                            <br>
                            <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">区域</th>
                                <th scope="col">开始时间</th>
                                <th scope="col">结束时间</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="time in times" v-bind:key="time[0]">
                                <th scope="row">{{time[0]}}</th>
                                    <td>{{time[1]}}</td>
                                    <td>{{time[2]}}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </b-tab>

                    <b-tab title="重置/查询报名时间">
                        <div class="container">
                            <div class="row">
                                <div class="col-md">
                                    <h5 style="color:darkred"><strong>**请勿随意点击此按钮</strong></h5>
                                    <label>区域:</label>
                                    <select v-model="selected1">
                                        <option disabled value="">Region</option>
                                        <option>Singapore</option>
                                        <option>Malaysia</option>
                                        <option>China</option>
                                        <option>Hong Kong</option>
                                        <option>Macau</option>
                                        <option>Taiwan</option>
                                        <option>Australia</option>
                                        <option>Others</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <button @click="reset" class="btn btn-block">重置时间差</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="row">
                                <div class="col-md form-group">
                                    <label>区域:</label>
                                    <select v-model="selected3">
                                        <option disabled value="">Region</option>
                                        <option>Singapore</option>
                                        <option>Malaysia</option>
                                        <option>China</option>
                                        <option>Hong Kong</option>
                                        <option>Macau</option>
                                        <option>Taiwan</option>
                                        <option>Australia</option>
                                        <option>Others</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <button class="btn btn-block" @click="getDiff">查看时间差</button>
                                </div>    
                            </div> 
                        </div>
                        <!-- data display area -->
                        <div class="container">
                            <h3><strong>区域: {{selected3}}</strong></h3>
                            <h3>该地区参赛队伍数量:</h3>
                            <br>
                            <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">大学</th>
                                <th scope="col">时间差(秒)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="timeDiff in timeDiffs" v-bind:key="timeDiff.uniNameCN">
                                <th scope="row">{{timeDiff.uniNameCN}}</th>
                                    <td>{{timeDiff.offTimeDiff}}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </b-tab>

                    <b-tab title="发布帖文">
                        <!-- control area -->
                        <div class="container">
                            <div class="form-group">
                                <label>贴文图片:</label>
                                <input class="form-control" type="url" v-model="postPic">
                                <label>贴文标题:</label>
                                <input class="form-control" placeholder="标题" v-model="postTitle">
                                <label>贴文信息:</label>
                                <input class="form-control" placeholder="贴文信息" v-model="postDec">
                                <label>贴文内容:</label>
                                <textarea class="form-control" type="text" placeholder="贴文内容" v-model="postContent"></textarea>
                            </div>
                            <button @click="submitPost" class="btn btn-primary btn-block">提交帖文</button>
                        </div>
                        <!-- data display area -->
                        <hr>
                        <div class="container text-center" style="text-align:center;">
                            <h3><strong>Preview</strong></h3>
                            <br>
                            <!-- homepage display     -->
                            <div>
                                <div class="col-xs-8" style="display: inline-block;">
                                    <h4>主页显示</h4>
                                    <br>
                                    <div class="card profile-card-5">
                                        <div class="card-img-block">
                                            <img class="card-img-top" v-bind:src="postPic" alt="图片无法显示">
                                        </div>
                                        <div class="card-body pt-0">
                                            <h5 class="card-title">{{postTitle}}</h5>
                                            <p class="card-text">{{postDec}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <h4>贴文显示</h4>
                                <br>
                                <div class="container">
                                    <img v-bind:src="postPic" width="180px" height="150px">
                                    <h1>{{postTitle}}</h1>
                                    <span style="color:grey;font-size:9px;">created_at</span>
                                    <p>{{postContent}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </b-tab>

                    <b-tab title="查询大学">
                        <div class="text-center">
                            <label>区域:</label>
                            <select v-model="selected2">
                                <option disabled value="">Region</option>
                                <option>Singapore</option>
                                <option>Malaysia</option>
                                <option>China</option>
                                <option>Hong Kong</option>
                                <option>Macau</option>
                                <option>Taiwan</option>
                                <option>Australia</option>
                                <option>Admin</option>
                                <option>Others</option>
                            </select>
                            <br>
                            <button @click="getUsers" v-on:click="pressed=true" class="btn btn-primary btn-block">显示该地区大学</button>
                        </div>
                        <div class="container">
                            <div v-if="pressed && numParticipants !== 0">
                                <br>
                                <h3>报名队伍数量: {{numParticipants}} </h3>
                                <b-table responsive hover :items="users" :fields="fields"></b-table>
                            </div>
                            <div v-if="numParticipants === 0">
                                <br>
                                <h3>次区域暂时没有报名队伍</h3>
                            </div>
                        </div>
                    </b-tab>

                    <b-tab title="查询辩题">
                        <!-- <button @click="getQuestions" v-on:click="pressed1=true, pressed=false" class="btn btn-primary">显示所有辩题</button> -->
                        <div class="container">
                            <h3>辩题</h3>
                            <b-table hover stacked :items="questions" :fields="fieldsQ"></b-table> 
                        </div>
                    </b-tab>

                </b-tabs>
            </b-card>
        </div>    
    </div>    
</template>

<script>
import axios from 'axios';
import oldnav from './oldnav.vue';
export default {
    name: 'admin',
    components:{oldnav},
    data(){
        return {
            selected:'',
            selected1:'',
            selected2:'',
            selected3:'',
            offTimeStart:'',
            offTimeEnd:'',
            users: '',
            pressed: false,
            pressed1: false,
            numParticipants: 0,
            times: {},
            questions: '',
            postTitle: '',
            postDec: '',
            postPic: '',
            postContent: '',
            timeDiffs: '',
            fields: {
                id:{
                    label: "编号",
                    sortable: true
                },
                uniNameCN:{
                    label: "大学（中）"
                },
                uniNameEN:{
                    label: "大学（英）"
                },
                nameEn:{
                    label: "联络人（英）"
                },
                nameCn:{
                    label: "联络人（中）"
                },
                contactNumber:{
                    label: "联络号码"
                },
                email:{
                    label: "邮件"
                },
                remember_token:{
                    label: "通过认证",
                    sortable: true
                }
            },
            fieldsQ:{
                    uniNameCN:{
                        label: '大学名称',
                        sortable: false,
                    },
                    debateQues1:{
                        label: '辩题（一）',
                        sortable: false,
                    },
                    debateQues2:{
                        label: '辩题（二）',
                        sortable: false,
                    },
                    debateQues3:{
                        label: '辩题（三）',
                        sortable: false,
                    },
                },       
        }
    },
    created(){
        this.getTime();
        this.getQuestions();
    },
    computed:{
        user: function(){
            return JSON.parse(localStorage['user']);
        },
        loading:function(){
                return this.loading? true: false;
        },
        isLogged : function(){ return this.$store.getters.isLoggedIn},
    },
    methods:{
        setTime(){
            const data = {
                'region' : this.selected,
                'offTimeStart' : this.offTimeStart,
                'offTimeEnd': this.offTimeEnd,
            }
            if(this.selected === ''){
                alert("请选择区域！");
                return true;
            }else if(this.offTimeStart=== '' || this.offTimeEnd ===''){
                alert("时间请勿留空！");
                return true;
            }

            axios
                .put('api/time/official/set', data,{
                    headers :{
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    alert(response.data.message);
                    this.getTime();
                })
        },
        reset(){
            if(this.selected1 === ''){
                alert("请选择区域！");
                return true;
            }
            const data={
                'region': this.selected1
            }
            var answer = prompt("请输入“我想要重置时间”", "");

            if (answer !== "我想要重置时间") {
                alert("重置失败!")
                return true;
            } else {            
                axios
                    .put('api/time/official/reset', data,{
                        headers:{
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response=>{
                        alert("Reset successfully!");
                    })
            }
        },
        getUsers(){
            if(this.selected2 === ''){
                alert("请选择区域！");
                return true;
            }
            // const data={
            //     'region': this.selected
            // }
            axios
                .get('api/user/all',{
                    params:{
                        region: this.selected2
                    },
                    headers:{
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    this.users = response.data;
                    this.numParticipants = this.users.length;
                    // console.log(this.users);
                })
        },
        getTime(){
            axios
                .get('api/time/all',{
                    headers:{
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    this.times = response.data;
                    // console.log(this.times);
                })
        },
        getQuestions(){
            axios
                .get('api/question/all',{
                    headers:{
                        Authorization: "Bearer "+localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    this.questions = response.data;
                })
        },
        cache(){
            axios
                .get('api/config-cache',{
                    headers:{
                        Authorization: "Bearer " +localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    alert(response.data.message);
                })
        },
        optimize(){
            axios
                .get('api/optimize',{
                    headers:{
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                })
                .then(response =>{
                    alert(response.data.message);
                })
        },
        submitPost(){
            if(this.postTitle === '' || this.postPic === '' || this.postDec === '' || this.postContent === ''){
                alert("请勿留空！")
            }
            const data ={
                'postTitle': this.postTitle,
                'postPic': this.postPic,
                'postDec': this.postDec,
                'postContent': this.postContent,
            }

            axios
                .post('api/post',data,{
                    headers:{
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                })
                .then(resp=>{
                    alert(resp.data.message);
                })
        },
        getDiff(){
            if(this.selected3 === ''){
                alert("请选择区域!");
                return true;
            }
            axios
                .get('api/time/get',{ //api/time/official/start
                    params:{'region': this.selected3},
                    headers:{
                        Authorization: "Bearer " + localStorage['token']
                    }
                })
                .then(resp=>{
                    this.timeDiffs = resp.data.data;
                    for(var i = 0; i < this.timeDiffs.length; i++){
                        if(this.timeDiffs[i].offTimeDiff == 1000000000000000000){
                            this.timeDiffs[i].offTimeDiff = "还未报名";
                        }else if(this.results[i].offTimeDiff == 0){
                            this.timeDiffs[i].offTimeDiff = "种子队"
                        }else{
                            this.timeDiffs[i].offTimeDiff = this.timeDiffs[i].offTimeDiff/1000000 //show time in second from micro
                        }
                    }
                })
        }
    }
}
</script>

<style scoped>
    button{
        background:darkred;
        color: white;
    }
    button:hover{
        background: rgb(100, 0, 0)
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
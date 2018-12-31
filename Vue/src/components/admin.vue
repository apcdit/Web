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

                    <b-tab title="重置时间">
                        <div class="container text-center">
                        <h3 style="color:red"><strong>请勿随意点击此按钮</strong></h3>
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
                        <br>
                        <div>
                            <h4>重置所有时间</h4>
                            <button @click="reset" class="btn btn-danger"><h3>Reset</h3></button>
                        </div>
                        </div>
                    </b-tab>

                    <b-tab title="发布帖文">
                        <div>
                            
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
                                <b-table hover :items="users" :fields="fields"></b-table>
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
            
            <br>
            <!-- <div v-if="pressed1 || pressed" class="container" style="margin:auto;border-radius: 2px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);background:white;padding:0.1% 5% 3% 5%;border-radius: 25px;background-color: #F7F7F7;">
                
                <div>
                    
                </div>
            </div> -->
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
            offTimeStart:'',
            offTimeEnd:'',
            users: '',
            pressed: false,
            pressed1: false,
            numParticipants: 0,
            times: {},
            questions: '',
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
                    label: "通过认证"
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
            axios
                .put('api/time/official/reset', data,{
                    headers:{
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response=>{
                    alert("Reset successfully!");
                })
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
                    console.log(this.users);
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
                    console.log(this.times);
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
        }
    }
}
</script>

<style scoped>
    button{
        background:darkred;
    }
    button:hover{
        background: rgb(100, 0, 0)
    }
</style>
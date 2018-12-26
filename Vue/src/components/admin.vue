<template>
    <div class="container">
          <button class="btn btn-primary" @click="showaaa">aaa</button>
        <h1><strong>管理者</strong></h1>
        <hr>           
            <b-card>
                <b-tabs pills card vertical>
                    <b-tab title="设置时间" active>
                    <div class="container">
                    <label>区域</label>
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
                        </select>
                        <br>
                        <div>
                            <div>
                            <h4>开始时间 (2018-10-21 10:55:00 24 HOURS FORMAT)</h4>
                            <input v-model="offTimeStart" placeholder="输入开始时间">
                            </div>
                            <div>
                            <h4>截止时间</h4>
                            <input v-model="offTimeEnd" placeholder="输入截止时间">
                            <br>
                            </div>
                            <button @click="setTime" class="btn btn-primary">设置时间</button>
                            <button @click="getTime" class="btn btn-primary">get time</button>
                            <button @click="cache" class="btn btn-primary">cache</button>
                            <button @click="optimize" class="btn btn-primary">optimize</button>
                             <!-- <ul >
                                <li v-for="index in 8" :key="index">{{times[index][0]}}</li>
                            </ul> -->
                        </div>
                        </div>
                    </b-tab>

                    <b-tab title="重置时间">
                        <div class="container text-center">
                        <h3 style="color:red"><strong>请勿随意点击此按钮</strong></h3>
                        <label>区域</label>
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
                            <label>区域</label>
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
                            </select>
                            <br>
                            <button @click="getUsers" v-on:click="pressed=true, pressed1=false" class="btn btn-primary">显示该地区大学</button>
                        </div>
                    </b-tab>

                    <b-tab title="查询辩题">
                        <button @click="getQuestions" v-on:click="pressed1=true, pressed=false" class="btn btn-primary">显示所有辩题</button>
                    </b-tab>
                </b-tabs>
            </b-card>
            <br>
            <div v-if="pressed1 || pressed" class="container" style="margin:auto;border-radius: 2px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);background:white;padding:0.1% 5% 3% 5%;border-radius: 25px;background-color: #F7F7F7;">
                <div v-if="pressed1">
                    <br>
                    <h3>辩题</h3>
                    <b-table hover stacked :items="questions" :fields="fieldsQ"></b-table> 
                </div>
                <div>
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
            </div>
    </div>    
</template>

<script>
import axios from 'axios';
export default {
    name: 'admin',
    data(){
        return {
            selected:'',
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
                    label: "联络人姓名（英）"
                },
                nameCn:{
                    label: "联络人姓名（中）"
                },
                contactNumber:{
                    label: "联络号码"
                },
                email:{
                    label: "电子邮件"
                },
                rememberToken:{
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
    // mounted(){
    //     this.getTime();
    // },
    computed:{
        user: function(){
            return JSON.parse(localStorage.getItem('user'));
        }
    },
    methods:{
        showaaa(){
            console.log(this.user);
        },
        setTime(){
            const data = {
                'region' : this.selected,
                'offTimeStart' : this.offTimeStart,
                'offTimeEnd': this.offTimeEnd,
            }
            if(this.selected === ''){
                alert("Region is not selected");
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
                })
        },
        reset(){
            if(this.selected === ''){
                alert("Region is not selected");
                return true;
            }
            const data={
                'region': this.selected
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
            if(this.selected === ''){
                alert("Region is not selected");
                return true;
            }
            // const data={
            //     'region': this.selected
            // }
            axios
                .get('api/user/all',{
                    params:{
                        region: this.selected
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

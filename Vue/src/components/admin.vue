<template>
    <div class="container">
        <h1><strong>管理者</strong></h1>
       
        
        <hr>           
            <b-card>
                <b-tabs pills card vertical>
                    <b-tab title="设置时间" active>
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
                            <h4>开始时间 (2018-10-21 10:55:00 24 HOURS FORMAT)</h4>
                            <input v-model="offTimeStart" placeholder="输入开始时间">
                            <h4>截止时间</h4>
                            <input v-model="offTimeEnd" placeholder="输入截止时间">
                            <button @click="setTime" class="btn btn-primary">设置时间</button>
                             <button @click="getTime">get time</button>
                             <ul >
                                <li v-for="index in 8" :key="index">{{times[index]}}</li>
                            </ul>
                        </div>
                    </b-tab>

                    <b-tab title="重置时间">
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
                    </b-tab>

                    <b-tab title="发布帖文">
                        <div>
                            
                        </div>
                    </b-tab>

                    <b-tab title="查询大学">
                        <div>
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
                            <button @click="getUsers">显示该地区大学</button>
                        </div>
                    </b-tab>

                </b-tabs>
            </b-card>
            <br>
            <div class="container" style="margin:auto;border-radius: 2px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);background:white;padding:0.1% 5% 3% 5%;border-radius: 25px;background-color: #F7F7F7;">
                <b-table hover :items="users" :fields="fields"></b-table>
                
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
            users: {},
            showTime: false,
            times: {},
            fields: ['id', 'uniNameCN', 'uniNameEN', 'region', 'nameEn', 'nameCn', 'address', 'contactNumber', 'email'],
        }
    },
    // mounted(){
    //     this.getTime();
    // },
    methods:{
        setTime(){
            const data = {
                'region' : this.selected,
                'offTimeStart' : this.offTimeStart,
                'offTimeEnd': this.offTimeEnd,
            }
            if(this.selected == ''){
                alert("Region is not selected");
                return;
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
            if(this.selected == ''){
                alert("Region is not selected");
                return;
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
            if(this.selected == ''){
                alert("Region is not selected");
                return;
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
        }
    }
}
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <label>Region</label>
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
                <h4>Start Time (2018-10-21 10:55:00 24 HOURS FORMAT)</h4>
                <input v-model="offTimeStart" placeholder="input start time">
                <h4>End Time</h4>
                <input v-model="offTimeEnd" placeholder="input end time">

                <button @click="setTime">Submit</button>
            </div>
            <div class="col-md-6">
                <div class="container">
                    <h4>Click the below button to reset users to drawn = 0 and presstime to infinity</h4>
                    <h4>Remember to select the region before you reset :)</h4>
                    <button @click="reset"><h3>Reset</h3></button>
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
        }
    },
    methods:{
        setTime(){
            const data = {
                'region' : this.selected,
                'offTimeStart' : this.offTimeStart,
                'offTimeEnd': this.offTimeEnd,
            }
            if(this.selected == ''){
                alert("Region is not selected");
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
        }
    }
}
</script>

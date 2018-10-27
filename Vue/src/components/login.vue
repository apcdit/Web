<template>
  <div>
  <b-container fluid style="margin-top:10%;">
    <b-row class="my-1" style="width:50%;margin:auto;">
      <b-col sm="3"><label>Email: </label></b-col>
      <b-col sm="9"><b-form-input v-model="email" style="width:50%"></b-form-input></b-col>
    </b-row>
    <b-row class="my-1" style="width:50%;margin:auto;">
      <b-col sm="3"><label>Password: </label></b-col>
      <b-col sm="9"><b-form-input v-model="password" style="width:50%"></b-form-input></b-col>
    </b-row>
    <center>
      <b-button @click="login()">Submit</b-button>
    </center>
  </b-container>
    <b-button @click="logout()">Submit</b-button>
  </div>
</template>


<script>
import axios from "axios"
import {store} from "../store";

export default{
  name:'login',
  data(){
    return {
      email: "",
      password: ""
    }
  },
  methods:{
      login: function () {

        var data = {
            email: this.email,
            password: this.password
        }

        axios
            .post('api/login',data)
            .then(response=>{
                console.log(response.data);
                if(response.data.message === "Wrong credentials"){
                    alert("邮件或密码不正确!")
                }else if(response.data.status === 200){
                    if(response.data.admin){
                      this.$router.push('/admin_dashboard')
                    }else{
                      this.$router.push('/user_dashboard')
                    }
                }
           })
    },
      logout: function () {
          this.$localStorage.remove('access_token')
      }
  }
}
</script>
<style></style>
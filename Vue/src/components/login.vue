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
      <b-button @click="login()">login</b-button>
    </center>
  </b-container>
    <b-button @click="logout()">logout</b-button>
  </div>
</template>


<script>
import axios from "axios"

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
        let email = this.email 
        let password = this.password
        this.$store.dispatch('login', { email, password })
       .then(this.$router.push('/'))
       .catch(err => console.log(err))
      },
  }
}
</script>
<style></style>
<template>
    <b-modal id="login" busy="true" title="登录账号">
        <!-- login -->
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <div class="form-signin">
            <i class="fa fa-user" aria-hidden="true"></i><input type="email" id="inputEmail" v-model="email" class="form-control" placeholder="电子邮件" required autofocus>
            <i class="fa fa-key" aria-hidden="true"></i><input type="password" id="inputPassword" v-model="password" class="form-control" placeholder="输入密码" required>
            <a href='/#/resetpw/token' target="blank">忘记密码?</a>
        </div>
        <div slot="modal-footer" class="w-100">
         <button class="btn btn-lg btn-primary btn-block btn-signin" @click="login" @keypress="login" v-if="!loading">登录</button>
         <button class="btn btn-lg btn-primary btn-block btn-signin" v-else><cube-spin style="width:60%;height:60%"></cube-spin></button>
       </div>
    </b-modal>
  
</template>


<script>
import axios from "axios"
import CubeSpin from '../../node_modules/vue-loading-spinner/src/components/Circle.vue'

export default{
  name:'login',
  components:{
      CubeSpin
  },
  computed:{
      loading: function(){
          return this.logging;
      },
  },
  data(){
    return {
      email: "",
      password: "",
      logging: false,
    }
  },
  methods:{

    login: function () {
        let email = this.email;
        let password = this.password;
        this.logging = true;
        this.$store.dispatch('login', { email, password })
        //.then(this.$router.push('/'))
      },
  }
}
</script>
<style scoped>
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  .card-container.card {
      max-width: 350px;
      padding: 40px 40px;
      border-radius: 25px;
  }

  .btn {
      font-weight: 700;
      height: 36px;
      -moz-user-select: none;
      -webkit-user-select: none;
      user-select: none;
      cursor: default;
  }

  /*
   * Card component
   */
  .card {
      background-color: #F7F7F7;
      /* just in case there no content*/
      padding: 20px 25px 30px;
      margin: 0 auto 25px;
      margin-top: 50px;
      /* shadows and rounded borders */
      -moz-border-radius: 2px;
      -webkit-border-radius: 2px;
      border-radius: 2px;
      -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  }

  .profile-img-card {
      width: 96px;
      height: 96px;
      margin: 0 auto 10px;
      display: block;
      -moz-border-radius: 50%;
      -webkit-border-radius: 50%;
      border-radius: 50%;
  }

  /*
   * Form styles
   */
  .profile-name-card {
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      margin: 10px 0 0;
      min-height: 1em;
  }

  .reauth-email {
      display: block;
      color: #404040;
      line-height: 2;
      margin-bottom: 10px;
      font-size: 14px;
      text-align: center;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
  }

  .form-signin #inputEmail,
  .form-signin #inputPassword {
      direction: ltr;
      height: 44px;
      font-size: 16px;
  }

  .form-signin input[type=email],
  .form-signin input[type=password],
  .form-signin input[type=text],
  .form-signin button {
      width: 100%;
      display: block;
      margin-bottom: 10px;
      z-index: 1;
      position: relative;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
  }

  .form-signin .form-control:focus {
      border-color: rgb(104, 145, 162);
      outline: 0;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
  }

  .btn.btn-signin {
      /*background-color: #4d90fe; */
      background-color: darkred;
      /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
      padding: 0px;
      font-weight: 700;
      font-size: 14px;
      height: 36px;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      border-radius: 3px;
      border: none;
      -o-transition: all 0.218s;
      -moz-transition: all 0.218s;
      -webkit-transition: all 0.218s;
      transition: all 0.218s;
  }

  .btn.btn-signin:hover,
  .btn.btn-signin:active,
  .btn.btn-signin:focus {
      background-color: red;
  }

  .forgot-password {
      color: rgb(104, 145, 162);
  }

  .forgot-password:hover,
  .forgot-password:active,
  .forgot-password:focus{
      color: rgb(12, 97, 33);
  }
</style>

<template>
    <div class="container col-xs-6 col-lg-4">
        <div class="form-group">
                <span v-if="invalidToken" class="alert alert-danger">验证码无效！</span>
        </div>
        <div class="form-group">
                <span v-if="success" class="alert alert-success">密码成功更改！请检查邮箱确认密码已成功更改！</span>
        </div>
        <form>
            <div>
                <h2><strong>检查你的邮箱</strong></h2>
                <h6>验证码已发到你的邮箱<strong>{{email}}</strong>，请输入邮件里的验证码以重置密码.</h6>
            </div>
            <br>

            <div class="form-group">
                <h6>验证码</h6>
                <input data-vv-as="验证码" v-validate="'required'" class="form-control" name="token" placeholder="输入验证码" v-model="token" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('token')" class="alert alert-danger">{{errors.first('token')}}</span>
            </div>

            <div class="form-group">
                <h6>新密码</h6>
                <input data-vv-as="密码" ref="password" v-validate="'required|min:8'" name="password" class="form-control" placeholder="输入新密码" type="password" v-model="password" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('password')" class="alert alert-danger">{{errors.first('password')}}</span>
            </div>
            <div class="form-group">
                <h6>确认新密码</h6>
                <input data-vv-as="确认密码" v-validate="'required|min:8|confirmed:password'" name="password_confirmation" class="form-control" placeholder="再次输入新密码" type="password" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('password_confirmation')" class="alert alert-danger">{{errors.first('password_confirmation')}}</span>
            </div>

            <button id="btn-submit" class="btn" @click.prevent="resetpw">重置密码</button>
        </form>
    </div>
</template>

<script>

    import axios from 'axios';

    export default{
        name: "resetpw1",
        data(){
            return{
                email: this.$route.params.email? this.$route.params.email: localStorage.getItem('email'),
                token: '',
                password: '',
                invalidToken:0,
                success: 0,
            }
        },
        created() {
            this.getEmail();
        },
        methods:{
            getEmail:function(){
                if(this.$route.params.email === null){
                    this.email = localStorage.getItem('email');
                }else{
                    this.email = this.$route.params.email;
                }
            },
            resetpw: function(){
                this.$validator.validateAll().then(res=>{
                    if(res){
                        this.invalidToken = 0;
                        const data = { 'email': this.email, 'token': this.token, 'password': this.password}
                        axios
                            .post('api/password/reset', data)
                            .then(response=>{
                                console.log(response.data.message)
                                this.success = 1;
                            })
                            .catch(error=>{
                                this.invalidToken = 1;
                                console.log(error.message)
                        })
                    }
                })
            }
        }

    }
</script>

<style scoped>
    #btn-submit{
        background-color:darkred; 
        border-color: 2px darkred;
        color: white; 
        border-radius: 15px
    }

    #btn-submit:hover{
        background-color: rgb(116, 0, 0)
    }
</style>
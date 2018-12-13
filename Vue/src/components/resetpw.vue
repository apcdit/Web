<template>
    <div class="container col-xs-6 col-lg-4">
        <div class="form-group">
                <span v-if="notFound" class="alert alert-danger">此邮件并不存在！</span>    
        </div>
        <form>
            <h2><strong>寻找你的账号</strong></h2>
            <br>
            <div class="form-group">
                <h6 style="margin-bottom:3%">输入你的邮件地址</h6>
                <input data-vv-as="邮件" v-validate="'required|email'" name="email" type="email" class="form-control" placeholder="输入邮件" v-model="email" autofocus>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('email')" class="alert alert-danger">{{ errors.first('email') }}</span>
            </div>

            <button id="btn-submit" class="btn" @click.prevent="getToken">获取验证码</button>
        </form>
        <div class="form-group">
                <span v-if="success" class="alert alert-success">密码成功重置！</span>
        </div>
        <form>
            <!--notification area-->
             <div class="form-group">
                <span v-if="invalidToken" class="alert alert-danger">验证码无效！</span>
            </div>  
            
            <!--email-->
            <div class="form-group">
                <h6 style="margin-bottom:3%">输入你的邮件地址</h6>
                <input data-vv-as="邮件" v-validate="'required|email'" name="email" type="email" class="form-control" placeholder="输入邮件" v-model="email" autofocus>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('email')" class="alert alert-danger">{{ errors.first('email') }}</span>
            </div>

            <!-- token -->
            <div class="form-group">
                <h6>验证码</h6>
                <input data-vv-as="验证码" v-validate="'required'" class="form-control" name="token" placeholder="输入验证码" v-model="token" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('token')" class="alert alert-danger">{{errors.first('token')}}</span>
            </div>

            <!-- password -->
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
        name: "resetpw",
        data(){
            return{
                email: null,
                notFound: 0,
                success: 0,
                invalidToken: 0,
            }
        },
        methods:{
            getToken: function(){
                        const data ={ 'email': this.email}
                        localStorage.setItem('email', this.email)
                        axios
                            .post('api/password/create', data)
                            .then(response=>{
                                // this.$router.push({
                                //     name: 'resetpw1',
                                //     params: {email:this.email}
                                // })
                                console.log(response.data.message);
                            })
                            .catch(er=>{
                                this.notFound = 1;
                            });
            },
            resetpw: function(){
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
                                console.log(error.response.message)
                        })
            },
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

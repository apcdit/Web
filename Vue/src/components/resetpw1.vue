<template>
    <div class="container col-xs-6 col-lg-4">

        <div v-if="false" class="form-group">
                <span v-if="invalidToken" class="alert alert-danger">验证码无效！</span>
        </div>
        <div class="form-group">
                <span v-if="success||invalid" v-bind:class="notification">{{message}}</span>
        </div>
        
        <form>
            <div>
                <h2><strong>更改密码</strong></h2>
                <h6>**请发邮件到chinesedebate.it@gmail.com通知我们协助你们更改密码。</h6>
                <h6>同时请附上学校名称与用于登录的电子邮件。</h6>
                <!-- <h6>验证码已发到你的邮箱<strong>{{email}}</strong>，请输入邮件里的验证码以重置密码.</h6> -->
            </div>
            <br>

            <div v-if="false" class="form-group">
                <h6>验证码</h6>
                <input data-vv-as="验证码" v-validate="'required'" class="form-control" name="token" placeholder="输入验证码" v-model="token" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('token')" class="alert alert-danger">{{errors.first('token')}}</span>
            </div>

            <div class="form-group">
                <h6>电子邮件</h6>
                <input data-vv-as="电子邮件" v-validate="'required|email'" class="form-control" name="email" placeholder="输入邮件" v-model="email" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('email')" class="alert alert-danger">{{errors.first('email')}}</span>
            </div>

            <div class="form-group">
                <h6>旧密码</h6>
                <input data-vv-as="旧密码" v-validate="'required'" name="oldpassword" class="form-control" placeholder="输入旧密码" type="password" v-model="old_password" required>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('oldpassword')" class="alert alert-danger">{{errors.first('oldpassword')}}</span>
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

            <button id="btn-submit" class="btn" @click.prevent="changepw" v-if="!loading">更改密码</button>
            <button id="btn-submit" class="btn" v-else><cube-spin></cube-spin></button>
        </form>
    </div>
</template>

<script>

    import axios from 'axios';
    import CubeSpin from '../../node_modules/vue-loading-spinner/src/components/Circle.vue'

    export default{
        name: "resetpw1",
        components:{
            CubeSpin
        },
        data(){
            return{
                email: '',
                token: '',
                password: '',
                old_password: '',
                invalidToken:0,
                success: 0,
                message: '',
                loading: false,
            }
        },
        computed:{
            notification: function(){
                return this.success? 'alert alert-success': 'alert alert-danger';
            },
            loading:function(){
                return this.loading? true: false;
            }
        },
        // created() {
        //     this.getEmail();
        // },
        methods:{
            // getEmail:function(){
            //     if(this.$route.params.email === null){
            //         this.email = localStorage.getItem('email');
            //     }else{
            //         this.email = this.$route.params.email;
            //     }
            // },
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
            },
            changepw: function(){
                this.$validator.validateAll().then(res=>{
                    if(res){
                        this.invalid = 0;
                        this.success = 0;
                        this.loading = true;
                        const data ={'email': this.email, 'old_password':this.old_password, 'password':this.password}
                        axios
                            .post('api/password/change', data)
                            .then(response=>{
                                this.success = true;
                                this.invalid = false;
                                this.loading = false;
                                this.message = response.data.message;
                            })
                            .catch(error=>{
                                this.invalid = true;
                                this.success = false;
                                this.loading = false;
                                this.message = error.response.data.message;
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
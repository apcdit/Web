<template>
    <div class="container col-xs-6 col-lg-4">
        <div class="form-group" v-if="notFound||found">
                <span v-if="notFound" class="alert alert-danger">此邮件并不存在！</span>
                <span v-if="found" class="alert alert-success">请到邮箱里寻找验证码！</span>    
        </div>
        <div>
            <h2><strong>寻找你的账号</strong></h2>
            <br>
            <div class="form-group">
                <h6 style="margin-bottom:3%">输入你的邮件地址</h6>
                <input data-vv-as="邮件" v-validate="'required|email'" name="email1" type="email" class="form-control" placeholder="输入邮件" v-model="email1" autofocus>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('email1')" class="alert alert-danger">{{ errors.first('email1') }}</span>
            </div>

            <button id="btn-submit" class="btn" v-if="!loading1" @click.prevent="getToken">获取验证码</button>
            <button id="btn-submit" class="btn" v-else><cube-spin></cube-spin></button>
        </div>
        <br>
        <div>
            <h2><strong>重置密码</strong></h2>
            <!--notification area-->
            <br>
             <div class="form-group" v-if="invalidToken" >
                <span class="alert alert-danger">验证码无效！</span>
            </div>  
            <div class="form-group" v-if="success" >
                <span class="alert alert-success">密码成功重置！</span>
            </div>
            <!--email-->
            <div class="form-group">
                <h6 style="margin-bottom:3%">输入你的邮件地址</h6>
                <input data-vv-as="邮件" v-validate="'required|email'" name="email2" type="email" class="form-control" placeholder="输入邮件" v-model="email2" autofocus>
            </div>
            <div class="form-group">
                <span style="padding:0.5%;padding-right:2%;padding-left:2%;" v-show="errors.has('email2')" class="alert alert-danger">{{ errors.first('email2') }}</span>
            </div>

            <!-- token -->
            <div class="form-group">
                <h6>验证码</h6>
                <input data-vv-as="验证码" v-validate="'required'" type="password" class="form-control" name="token" placeholder="输入验证码" v-model="token" required>
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

            <button id="btn-submit" class="btn" v-if="!loading" @click.prevent="resetpw">重置密码</button>
            <button id="btn-submit" class="btn" v-else><cube-spin></cube-spin></button>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import CubeSpin from '../../node_modules/vue-loading-spinner/src/components/Circle.vue'


    export default{
        name: "resetpw",
        components:{
            CubeSpin,
        },
        data(){
            return{
                email1: null,
                email2: null,
                notFound: 0,
                found: 0,
                success: 0,
                invalidToken: 0,
                loading: false,
                loading1: false,
            }
        },
        computed:{
            loading:function(){
                return this.loading? true: false;
            },
            loading1:function(){
                return this.loading1? true:false;
            }
        },
        methods:{
            getToken: function(){
                        const data ={ 'email': this.email1}
                        this.found = 0;
                        this.notFound = 0;
                        this.loading1 = true;
                        axios
                            .post('api/password/create', data)
                            .then(response=>{
                                // this.$router.push({
                                //     name: 'resetpw1',
                                //     params: {email:this.email}
                                // })
                                console.log(response.data.message);
                                this.found = 1;
                                this.loading1 = false;
                                setTimeout(function(){this.found = 0}, 5000);
                            })
                            .catch(er=>{
                                this.notFound = 1;
                                this.loading1 = false;
                            });
            },
            resetpw: function(){
                this.$validator.validateAll().then(res=>{
                    if(res){
                        this.invalidToken = 0;
                        this.loading = true;
                        const data = { 'email': this.email2, 'token': this.token, 'password': this.password}
                        axios
                            .post('api/password/reset', data)
                            .then(response=>{
                                console.log(response.data.message)
                                this.success = 1;
                                this.loading = false;
                            })
                            .catch(error=>{
                                this.invalidToken = 1;
                                this.loading = false;
                                console.log(error.response.message)
                        })
                    }
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

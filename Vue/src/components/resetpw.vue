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
            <button id="btn-submit" class="btn" @click.prevent="getToken">搜索</button>
            
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
            }
        },
        methods:{
            getToken: function(){
                this.$validator.validateAll().then(res=>{
                    if(res){
                        const data ={ 'email': this.email}
                        localStorage.setItem('email', this.email)
                        axios
                            .post('api/password/create', data)
                            .then(response=>{
                                this.$router.push({
                                    name: 'resetpw1',
                                    params: {email:this.email}
                                })
                            })
                            .catch(er=>{
                                this.notFound = 1;
                            });
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

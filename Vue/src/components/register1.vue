<template>
    <div class="row">
        <div class="registerForm">
            <h1 class="text-center"><strong>注册账号</strong></h1>
            <form @submit.prevent="" id="myForm">
                <div class="col-md-6">
                    <h2><strong>大学资料</strong></h2>
                    <div class="form-group">
                        <label for="region">区域</label>
                        <select class="form-control" v-model="region" name="region" id="region">
                            <option>SG</option>
                            <option>CN</option>
                            <option>MY</option>
                            <option>MA</option>
                        </select>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="uniNameCN">大学名称（中文）</label><br>
                        <input v-validate="'required'" data-vv-as="大学名字" :class="{'has-error': errors.has('uniNameCN')}" type="text" name="uniNameCN" id="uniNameCN" v-model="uniNameCN" placeholder="输入大学中文名称"  >
                        <span v-show="errors.has('uniNameCN')" class="alert-empty">{{ errors.first('uniNameCN')}}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="uniNameEN">大学名称（英文）</label><br>
                        <input type="text" name="uniNameEN" v-validate="'required'" data-vv-as="大学名字" :class="{'has-error': errors.has('uniNameEN')}" id="uniNameEN" v-model="uniNameEN" placeholder="输入大学英文名称">
                        <span v-show="errors.has('uniNameEN')" class="alert-empty">{{ errors.first('uniNameEN')}}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="address">学校地址</label><br>
                        <input type="text" name="address" :class="{'has-error': errors.has('address')}" data-vv-as="学校地址" v-validate="'required'" v-model="address" id="address" placeholder="输入大学地址" >
                        <span v-show="errors.has('address')" class="alert-empty">{{errors.first('address')}}</span>
                    </div>

                </div>

                <div class="col-md-6">
                    <h2><strong>联络人资料</strong></h2>
                    <div class="form-group">
                        <label>联络人电子邮件：</label><br>
                        <input name="email" data-vv-as="联络人电子邮件" v-model="email" v-validate="'required|email'" :class="{'has-error': errors.has('email')}" placeholder="输入联络人电子邮件">
                        <span  v-show="errors.has('email')" class="alert-empty">{{ errors.first('email') }}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="nameCn">联络人中文姓名</label><br>
                        <input type="text" v-validate="'required'" :class="{'has-error': errors.has('nameCn')}" name="nameCn" id="nameCn" data-vv-as="联络人中文姓名" v-model="nameCn" placeholder="输入联络人中文姓名">
                        <span v-show="errors.has('nameCn')" class="alert-empty">{{errors.first('nameCn')}}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="nameEn">联络人英文姓名</label><br>
                        <input type="text" name="nameEn" :class="{'has-error': errors.has('nameEn')}" id="nameEn" v-validate="'required'" data-vv-as="联络人英文姓名" v-model="nameEn" placeholder="输入联络人英文姓名">
                        <span v-show="errors.has('nameEn')" class="alert-empty">{{errors.first('nameEn')}}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="contactNumber">联络号码</label><br>
                        <input type="text" name="contactNumber" :class="{'has-error': errors.has('contactNumber')}" v-validate="'required'" data-vv-as="联络号码" v-model="contactNumber" id="contactNumber" placeholder="输入联络号码" >
                        <span v-show="errors.has('contactNumber')" class="alert-empty">{{errors.first('contactNumber')}}</span>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="password">输入账户密码</label><br>
                        <input type="password" ref="password" data-vv-as="密码" :class="{'has-error': errors.has('password')}" v-model="password" v-validate="'required|alpha_num'" name="password" id="password" placeholder="password" >
                        <span v-show="errors.has('password')" class="alert-empty">{{errors.first('password')}}</span>
                    </div>

                    <!--<div class="form-group">-->
                    <!--<label for="password">确认密码</label>-->
                    <!--<input class="form-control" v-validate="'required|confirmed:password'" name="password_confirmation" type="password" :class="{'is-danger': errors.has('password_confirmation')}" placeholder="Password, Again" data-vv-as="password">-->
                    <!--<span v-show="errors.has('password')" class="alert-empty">{{errors.first('password')}}</span>-->
                    <!--</div>-->
                    <br>
                </div>
                <button :disabled="errors.any()" @click="submitForm" class="btnRegister">注册</button>
            </form>
        </div>
    </div>
</template>

<script>
  

    export default {
        name:'register1',
        data(){
            return{
                uniNameCN: '',
                uniNameEN: '',
                email: '',
                nameCn: '',
                nameEn: '',
                address: '',
                password: '',
                region: '',
                contactNumber: '',
                info: '',
            }
        },
        methods:{
            // register(){
            //     let data={
            //         uniNameCN: this.uniNameCN,
            //         uniNameEN: this.uniNameEN,
            //         email: this.email,
            //         nameCn: this.nameCn,
            //         nameEn: this.nameEn,
            //         address: this.address,
            //         password: this.password,
            //         contactNumber: this.contactNumber,
            //         region: this.region
            //     };
            //
            //
            //     axios
            //         .post('api/register',data)
            //         .then(response=>{
            //             this.info = response.data;
            //         });
            //
            // },
            submitForm(){
                this.$validator.validateAll().then(res=>{

                    let data={
                        uniNameCN: this.uniNameCN,
                        uniNameEN: this.uniNameEN,
                        email: this.email,
                        nameCn: this.nameCn,
                        nameEn: this.nameEn,
                        address: this.address,
                        password: this.password,
                        contactNumber: this.contactNumber,
                        region: this.region
                    };

                    if(res){
                        //if user filled in all the information
                        axios
                            .post('api/register',data)
                            .then(response=>{
                                this.info = response.data;
                                console.log(this.info);
                                if(this.info.message === "Duplicate Entry!"){
                                    alert("账号已存在！");
                                }else if(this.info.message === "Successfully registered!"){
                                    alert("成功注册账号！");
                                    document.getElementById("myForm").reset();
                                }
                            });

                    }else{
                        alert("请填上所有资料！")
                    }

                })
            },
        }
    }
</script>

<style scoped>
    .alert-empty {
        color: red;
    }

    .has-error {
        border-color: red;
    }

    .registerForm{
        background-color: white;
        width: 80%;
        border-left: 35px;
        border-right: 35px;
        padding: 25px;
        margin: 0 auto;
    }

    .btnRegister{
        background-color: white;
        width: 100%;
        border-radius: 10px;
        padding: 10px;
    }

    .btnRegister:hover{
        background-color: darkred;
        color: white;
    }

    .form-group{
        color:black;
    }

    input{
        border: 0;
        outline: 0;
        background: transparent;
        width: 100%;
        padding-top: 5px;
        border-bottom: 1px solid black;
    }

</style>

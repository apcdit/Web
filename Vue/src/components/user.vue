<template>

    <section id="user">
        <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
        <div class="containers container">
                <b-progress :max="max" :animated="animate" class="mb-2" height="3.5rem">
                <b-progress-bar :value="value" variant="success">
                    <strong><span style="color:white;font-size: 14px;">注册成功</span></strong>
                </b-progress-bar>

                <b-progress-bar :value="value" variant="secondary" v-if="book==0">
                    <strong><span style="color:white;font-size: 14px;">意愿书</span></strong>
                </b-progress-bar>
                <b-progress-bar :value="value" variant="success" v-if="book==1" >
                    <strong><span style="color:white;font-size: 14px;">意愿书</span></strong>
                </b-progress-bar>

                <b-progress-bar :value="value"   variant="secondary" v-if="drawn==0">
                    <strong> <span style="color:white;font-size: 14px;">电子抽签</span></strong>
                </b-progress-bar>
                <b-progress-bar :value="value"   variant="success" v-if="drawn==1">
                    <strong> <span style="color:white;font-size: 14px;">电子抽签</span></strong>
                </b-progress-bar>

                <b-progress-bar :value="value"   variant="secondary" v-if="qualified==0">
                    <strong><span style="color:white;font-size: 14px;">报名成功</span></strong>
                </b-progress-bar>
                <b-progress-bar :value="value"   variant="success" v-if="qualified==1">
                    <strong><span style="color:white;font-size: 14px;">报名成功</span></strong>
                </b-progress-bar>
            </b-progress>
            <h6>*意愿书会在报名后24小时内批准</h6>
            <br>
                <b-tabs pills horizontal class="mytabs nav-justified ">
                    <hr>
                    <b-tab title="大学资料" active class="tab1">
                        <form>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div>
                                        <label><strong>区域</strong></label>
                                        <br>
                                        <input class="unchangable" type="text" placeholder=region v-model="region" disabled>
                                    </div><br>
                                    <div><label><strong>大学名称(中)</strong></label><br><input  class="unchangable" ref="uni_name_cn1" :value="uni_name_cn" disabled></div><br>
                                    <div><label><strong>大学名称(英)</strong></label><br><input  class="unchangable" ref="uni_name_en1" :value="uni_name_en" disabled></div><br>

                                    <div><label><strong>联络电话</strong></label><br><input type="text" ref="phone1" :value="phone" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                                    <div><label><strong>电子邮件</strong></label><br><input type="email" ref="email1" :value="email" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                                    <div><label><strong>地址</strong></label><br><textarea  ref="address1" :value="address" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></textarea></div><br>
                                </div>
                                <div class="col-sm-4">
                                    <div><label><strong>辩题1</strong></label><br><input class="unchangable" type="text" ref="debate_Ques1" :value="debateQues1" disabled></div><br>
                                    <div><label><strong>辩题2</strong></label><br><input class="unchangable" type="text" ref="debate_Ques2" :value="debateQues2" disabled></div><br>
                                    <div><label><strong>辩题3</strong></label><br><input class="unchangable" type="text" ref="debate_Ques3" :value="debateQues3" disabled></div><br>
                                </div>
                            </div>
                            <div class="row">
                                <button v-if="!isEditing" @click.prevent="isEditing = !isEditing"  class="btn btn-edit1" id="btn-submit"><strong>编辑</strong></button>
                                <button @click.prevent="save" v-else-if="isEditing" class="btn btn-edit" id="btn-submit"><strong>保持更改</strong></button><span>&nbsp&nbsp</span>
                                <button v-if="isEditing" @click.prevent="isEditing = false" class="btn btn-edit" id="btn-submit"><strong>取消更改</strong></button>
                            </div>
                        </form>
                    </b-tab>
                   
                    <b-tab title="意愿书" v-if="book==0">
                        <br>
                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" class="btn btn-default" required/>
                        <h6 class="mt-3">上传文件: {{file && file.name}}</h6><br>
                        <b-button @click="uploadFile" class="btnRegister" id="btn-submit">上传文件</b-button>
                    </b-tab>

                    <b-tab title="更换密码">
                        <div class="form-group">
                            <span v-if="success||invalid" v-bind:class="notification">{{message}}</span>
                        </div>
                        <div>
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
                            <button id="btn-submits" class="btn" v-else><cube-spin></cube-spin></button>
                        </div>
                    </b-tab>
                </b-tabs>
        </div>
    </section>

</template>

<script>

    import axios from 'axios';
    import CubeSpin from '../../node_modules/vue-loading-spinner/src/components/Circle.vue'
    import oldnav from './oldnav.vue'

    export default
    {
        name:'user',
        components:{
            CubeSpin,oldnav
        },
        data() {
            return {
                uni_name_cn :'',
                uni_name_en :'',
                address:'',
                phone:'',
                email:'',
                nameCn:'',
                region:'',
                debateQues1:'',
                debateQues2:'',
                debateQues3:'',
                updateTime:'',
                isEditing:false,
                book:'',
                file: '',
                value:25,
                drawn:'',
                qualified:'',
                loading: 0,
                success: 0,
                invalid: 0,
                password: '',
                old_password: '',
            }
        },
        created(){
            this.getDetails()
        },
        computed:{
            notification: function(){
                return this.success? 'alert alert-success': 'alert alert-danger';
            },
            loading:function(){
                return this.loading? true: false;
            },
            isLogged : function(){ return this.$store.getters.isLoggedIn},
            user: function(){ return JSON.parse(localStorage['user'])}
        },
        methods:{
            handleFileUpload(){
                this.file = this.$refs.file.files[0]; //choose the file
                //console.log(this.file);
            },
            uploadFile(){ //upload the file with submit form
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('uniNameCN', this.uniNameCN);
                //console.log(formData.get('uniNameCN'))
                axios
                    .post('api/uploadFile', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response=>{
                        //console.log(response.data);
                        alert("成功上传文件！");

                    })
                    .catch(function(){
                        console.log("Failure");
                    })
            },
            getDetails:function(){
                axios
                    .get('api/user',{
                        headers:{
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(resp=>{
                        //console.log(resp.data);
                        this.user = resp.data.user
                        this.uni_name_cn=resp.data.user.uniNameCN
                        this.uni_name_en=resp.data.user.uniNameEN
                        this.address=resp.data.user.address
                        this.phone=resp.data.user.contactNumber
                        this.email=resp.data.user.email
                        this.book=resp.data.user.remember_token
                        //console.log(this.book);
                        this.region=resp.data.user.region
                        this.drawn=resp.data.uniDetails.drawn
                        this.qualified=resp.data.uniDetails.qualified

                        const users = resp.data.user;
                        users['uni_details'] = resp.data.uniDetails;
                        localStorage['user'] = JSON.stringify(users);
                        
                        switch(this.user.region){
                            case "Malaysia": this.region = "马来西亚"; break;
                            case "Singapore": this.region = "新加坡"; break;
                            case "China": this.region = "中国大陆"; break;
                            case "Hong Kong": this.region = "香港"; break;
                            case "Macau": this.region = "澳门"; break;
                            case "Taiwan": this.region = "台湾"; break;
                            case "Australia": this.region = "澳大利亚"; break;
                            case "Others": this.region="其他地区"; break;
                            default: break;
                        }
                        this.debateQues1=resp.data.uniDetails.debateQues1
                        this.debateQues2=resp.data.uniDetails.debateQues2
                        this.debateQues3=resp.data.uniDetails.debateQues3
                    })
                    // .catch(error=>{
                    //     localStorage.clear();
                    // })
            },
            editDetails: function(){
                let data = {

                }
                axios
                    .put('api/editUser',data,{
                        headers:{
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
            },
            save: function() {
                this.uni_name_cn= this.$refs['uni_name_cn1'].value
                this.uni_name_en= this.$refs['uni_name_en1'].value
                this.phone= this.$refs['phone1'].value
                this.email= this.$refs['email1'].value
                this.address= this.$refs['address1'].value
                this.debateQues1= this.$refs['debate_Ques1'].value
                this.debateQues2= this.$refs['debate_Ques2'].value
                this.debateQues3= this.$refs['debate_Ques3'].value
                this.isEditing = !this.isEditing
                let data={
                    uni_name_cn:this.uni_name_cn,
                    uni_name_en:this.uni_name_en,
                    phone:this.phone,
                    email:this.email,
                    address:this.address,
                    debateQues1:this.debateQues1,
                    debateQues2:this.debateQues2,
                    debateQues3:this.debateQues3

                }
                axios
                    .put('api/editUser',data,{
                        headers:{
                            Authorization: 'Bearer ' + localStorage.getItem('token')
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
    .containers{margin-top:1%;background-color: #F7F7F7;
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        /* shadows and rounded borders */
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        border-radius: 20px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        width:100%;
        font-size:18px;
    }
    .view {
        border-color: transparent;
        background-color: initial;
        color: initial;
        width:70%;
    }
    .unchangable{ border-color: transparent;
        background-color: initial;
        color: initial;
        width:70%;}
    .changing{
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        width:70%;
        color:lightslategrey;}
    .content{
        width:80%;
        margin:auto;
    }
    .btn-edit{
        border-style:solid;
        border-color: darkred;
        color:white;
        background-color: darkred;
        padding-left: 5%;
        padding-right: 5%;
        padding-top: 1%;
        padding-bottom:1%;
        margin: auto;
         -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
        -moz-box-sizing: border-box;    /* Firefox, other Gecko */
        box-sizing: border-box;         /* Opera/IE 8+ */
    }
    .btn-edit1{
        border-style:solid;
        border-color: darkred;
        color:white;
        background-color: darkred;
        margin: auto;
        padding-left:10%;
        padding-right:10%;
        padding-top: 1%;
        padding-bottom:1%;
        width: 50%;
        -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
        -moz-box-sizing: border-box;    /* Firefox, other Gecko */
        box-sizing: border-box;         /* Opera/IE 8+ */
    }

    #btn-submits{
        background-color:darkred; 
        border-color: 2px darkred;
        color: white; 
        border-radius: 15px
    }

    #btn-submits:hover{
        background-color: rgb(116, 0, 0)
    }
    #__BVID__29___BV_tab_button__.nav-link,#__BVID__25___BV_tab_button__.nav-link,#__BVID__27___BV_tab_button__.nav-link{
        color: black;
    }
    #__BVID__29___BV_tab_button__.nav-link.active,#__BVID__27___BV_tab_button__.nav-link.active{
        color: #fff;
        background-color: darkred;
    }
    #__BVID__25___BV_tab_button__.nav-link.active{
        color: #fff;
        background-color: darkred;
    }
    
</style>

<template>
    <div>
        <br>
        <div style="width:60%;margin:auto;border-radius: 2px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);background:white;padding:0.1% 5% 3% 5%;border-radius: 25px;background-color: #F7F7F7;">
            <br>
            <center><h1>账号注册</h1></center>
            <form class="needs-validation" novalidate id="myForm" enctype="multipart/form-data">
                <h4>区域<span style="color:darkred">*</span></h4>
                <b-form-select v-model="region" :options="options" class="mb-3" />
                <h4>大学名称<span style="color:darkred">*</span></h4>
                <div class="row">
                    <div class="col-md">
                        <input v-model="uniNameCN" type="text" placeholder="输入大学名称(中) 例：新加坡南洋理工大学"  class="form-control" required>
                    </div>
                    <div class="col-md">
                        <input v-model="uniNameEN" type="text" placeholder="输入大学名称(英) 例：Nanyang Technological University Singapore" class="form-control" required >
                    </div>
                </div>
                <br>
                <h4>负责人姓名<span style="color:darkred">*</span></h4>
                <div class="row">
                    <div class="col-md">
                        <input v-model="name_cn" type="text" placeholder="负责人姓名（中）"  class="form-control" required>
                    </div>
                    <div class="col-md">
                        <input v-model="name_en" type="text" placeholder="负责人姓名（英）"   class="form-control" required >
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md">
                        <h4>负责人联络号码<span style="color:darkred">*</span></h4>
                        <input v-model="phone" type="text" placeholder="负责人联络号码 例：+6512345678"  class="form-control" required>
                    </div>
                    <div class="col-md">
                        <h4>负责人电子邮件<span style="color:darkred">*</span></h4>
                        <input v-model="email" type="email" placeholder="电子邮件" class="form-control" required>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md"><h4>密码<span style="color:darkred">*</span></h4></div><div class="w-100"></div>
                    <div class="col-md">
                        <input v-model="password" type="password" placeholder="密码" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="password" v-model="password_confirmation" placeholder="确认密码" class="form-control" required>
                    </div>
                </div>

                <br>

                <h4>地址<span style="color:darkred">*</span></h4>
                <b-form-textarea v-model="address" placeholder="地址" :rows="3" :max-rows="6" required> </b-form-textarea>
                <br>
                <h4>辩题<span style="color:darkred">*</span></h4>
                <input v-model="title_1" type="text" placeholder="辩题一（哲学）" style="width:50%" class="form-control" required>
                <br>
                <input v-model="title_2" type="text" placeholder="辩题二（政策）" style="width:50%" class="form-control" required>
                <br>
                <input v-model="title_3" type="text" placeholder="辩题三（自由发挥）" style="width:50%" class="form-control"  required>
                <br>
                <h4>提交意愿书(PDF格式):<span style="color:darkred">*</span></h4>
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" class="btn btn-default" required/>
                <h6 class="mt-3">上传文件: {{file && file.name}}</h6>
                <!-- <label></label>
                <b-form-checkbox  id="checkbox1"
                                  v-model="status"
                                  value="true"
                                  unchecked-value="false"
                                  required>
                    I accept the terms and use condition
                </b-form-checkbox> -->
                <br>
                <b-button @click="submitForm" class="btnRegister">注册账号</b-button>
            </form>
        </div>


    </div>
</template>
<script>
    import axios from "axios";
    export default
    {
        name:'register',
        data() {return {
            file: '',
            region: null,
            uniNameCN:'',
            uniNameEN:'',
            name_cn:'',
            name_en:'',
            email:'',
            phone:'',
            password:'',
            address:'',
            title_1:'',
            title_2:'',
            title_3:'',
            checked:false,
            status: '',
            password_confirmation: '',
            options: [
                { value: null, text: '选择区域' },
                { value: 'Singapore', text: '新加坡' },
                { value: 'Malaysia', text: '马来西亚' },
                { value: 'China', text: '中国大陆' },
                { value: 'Hong Kong', text: '香港'},
                {value:'Macao',text:'澳门'},
                {value:'Taiwan',text:'台湾'},
                {value:'Australia',text:'澳洲'}
            ]
        }},
       
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
                    })
                    .catch(function(){
                        console.log("Failure");
                    })
            },
            submitForm(){
                
                if(this.uniNameCN === '' || this.uniNameEN === '' || this.email === '' || this.name_cn === '' || this.name_en === '' || this.address === '' || this.password === '' || this.phone === ''|| this.region === null || this.title_1 === '' || this.title_2 === '' || this.title_3 === ''){
                    alert('请填上所有资料！')
                }else if(this.password !== this.password_confirmation){
                    alert("密码不匹配!")
                }else if(this.password.length < 8){
                    alert("密码过短！（最少8个）")
                }else if(this.file === '' || typeof this.file === 'undefined'){
                    alert("请附上意愿书！")
                }
                else{
                    let data={
                            uniNameCN: this.uniNameCN,
                            uniNameEN: this.uniNameEN,
                            email: this.email,
                            nameCn: this.name_cn,
                            nameEn: this.name_en,
                            address: this.address,
                            password: this.password,
                            contactNumber: this.phone,
                            region: this.region,
                            debateQues1: this.title_1,
                            debateQues2: this.title_2,
                            debateQues3: this.title_3,
                        };
                            //if user filled in all the information

                            axios
                                .post('api/register',data)
                                .then(response=>{
                                    this.info = response.data;
                                    //console.log(this.info);
                                    if(this.info.message === "Duplicate Entry!"){
                                        alert("账号已存在！");
                                    }else if(this.info.message === "Successfully registered!"){
                                        this.uploadFile();
                                        //console.log(this.file)
                                        alert("成功注册账号！");
                                        this.$router.push('/')
                                        //document.getElementById("myForm").reset();
                                    }
                                });
                }
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
    span{
        display: inline
    }
    .btnRegister{
        width: 25%;
        border-radius: 10px;
        padding: 10px;
    }
    .btnRegister:hover{
        background-color: darkred;
        color: white;
    }
</style>
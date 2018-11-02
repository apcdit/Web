<template>
  <div>
    <br>
    <div style="width:60%;margin:auto;border-radius: 2px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);background:white;padding:0.1% 5% 3% 5%;border-radius: 25px;background-color: #F7F7F7;">
<br>
      <center><h1>账号注册</h1></center>
      <form class="needs-validation" novalidate id="myForm" enctype="multipart/form-data">
        <h4>区域</h4>
        <b-form-select v-model="region" :options="options" class="mb-3" />
        <h4>大学名称</h4>
        <div class="row">
              <div class="col-md">
                <input v-model="uniNameCN" type="text" placeholder="输入大学名称(中)"  class="form-control" >
              </div>
              <div class="col-md">
                <input v-model="uniNameEN" type="text" placeholder="输入大学名称(英)" class="form-control" >
              </div>
          </div>
        <br>
        <h4>负责人姓名</h4>
        <div class="row">
          <div class="col-md">
          <input v-model="name_cn" type="text" placeholder="负责人姓名（华语）"  class="form-control" >
          </div>
          <div class="col-md">
          <input v-model="name_en" type="text" placeholder="负责人姓名（英语）"   class="form-control" >
          </div>
          </div>
          <br>

            <div class="row">
              <div class="col-md">
                <h4>负责人联络号码</h4>
                <input v-model="phone" type="text" placeholder="负责人联络号码"  class="form-control" >
              </div>
              <div class="col-md">
                <h4>电子邮件</h4>
                <input v-model="email" type="email" placeholder="电子邮件" class="form-control" >
              </div>
          </div>
        <br>

        <div class="row">
          <div class="col-md"><h4>密码</h4></div><div class="w-100"></div>
          <div class="col-md">
          <input v-model="password" type="password" placeholder="密码" class="form-control">
          </div>
          <div class="col">
          <input type="password" placeholder="确认密码" class="form-control" >
          </div>
        </div>

        <br>

        <h4>地址</h4>
        <b-form-textarea v-model="address" placeholder="地址" :rows="3" :max-rows="6"> </b-form-textarea>
        <br>
        <h4>辩题</h4>
        <input v-model="title_1" type="text" placeholder="辩题一（哲学）" style="width:50%" class="form-control">
        <br>
        <input v-model="title_2" type="text" placeholder="辩题二（政策）" style="width:50%" class="form-control">
        <br>
        <input v-model="title_3" type="text" placeholder="辩题三（自由发挥）" style="width:50%" class="form-control" >
        <br>
        <label>提交意愿书:</label>
        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
          <div class="mt-3">Selected file: {{file && file.name}}</div>
        <label></label>
        <b-form-checkbox  id="checkbox1"
                     v-model="status"
                     value="true"
                     unchecked-value="false">
                     I accept the terms and use condition
                   </b-form-checkbox>
        <b-button @click="submitForm">Submit</b-button>
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
        { value: 'China', text: '中国' },
        { value: 'Hong Kong', text: '香港'},
        {value:'Macao',text:'澳门'},
        {value:'Taiwan',text:'台湾'},
        {value:'Australia',text:'澳洲'}
      ]
  }},
    computed:{
        isDisabled(){
            return (this.region === null || this.checked === false);
        }
    },
    methods:{
        handleFileUpload(){
            this.file = this.$refs.file.files[0]; //choose the file
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
            this.$validator.validateAll().then(res=>{
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
                if(res){
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
  span{
      display: inline
  }
</style>

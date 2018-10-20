<template>
  <div>
    <div style="width:60%;margin:auto;">
      <br>
      <h1>注册</h1>
      <hr>
      <form class="needs-validation" novalidate id='myForm'>
        <label>区域</label>
        <b-form-select v-validate="'required'" name="region" vv-data-name="区域" v-model="region" :options="options" class="mb-3" />

        <label>大学名称(中）</label>
        <b-form-input v-validate="'required'" name="uniNameCN" data-vv-as="大学名字" :class="{'has-error': errors.has('uniNameCN')}" v-model="uniNameCN" type="text" placeholder="输入大学名称" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('uniNameCN')" class="alert-empty">{{ errors.first('uniNameCN')}}</h6>

        <label>大学名称(英）</label>
        <b-form-input v-validate="'required'" name="uniNameEN" data-vv-as="大学名字" :class="{'has-error': errors.has('uniNameEN')}" v-model="uniNameEN" type="text" placeholder="输入大学名称" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('uniNameEN')" class="alert-empty">{{ errors.first('uniNameEN')}}</h6>

        <label>负责人姓名(中）</label>
        <b-form-input v-validate="'required'" name="name_cn" data-vv-as="负责人英文姓名" :class="{'has-error': errors.has('name_cn')}" v-model="name_cn" type="text" placeholder="负责人姓名（华语）" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('name_cn')" class="alert-empty">{{ errors.first('name_cn') }}</h6>
        
        <label>负责人姓名(英）</label>
        <b-form-input v-validate="'required'" name="name_en" data-vv-as="负责人中文姓名" :class="{'has-error': errors.has('name_en')}" v-model="name_en" type="text" placeholder="负责人姓名（英语）" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('name_en')" class="alert-empty">{{ errors.first('name_en') }}</h6>

        <label>电子邮件</label>
        <b-form-input v-validate="'required|email'" name="email" data-vv-as="负责人电子邮件" v-model="email" type="email" placeholder="电子邮件" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('email')" class="alert-empty">{{ errors.first('email') }}</h6>

        <label>负责人联络号码</label>
        <b-form-input v-validate="'required'" name="phone" data-vv-as="负责人联络号码" v-model="phone" type="text" placeholder="负责人联络号码" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('phone')" class="alert-empty">{{ errors.first('phone') }}</h6>

        <label>密码</label>
        <b-form-input v-validate="'required'" vv-data-as="password" name="password" v-model="password" type="password" ref="password" placeholder="密码" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('password')" class="alert-empty">{{ errors.first('password') }}</h6>        
        <b-form-input v-model="password_confirmation" v-validate="'required|confirmed:password'" vv-data-as="password" name="password_confirmation" type="password" placeholder="确认密码" style="width:30%" ></b-form-input>
        <h6 v-show="errors.has('password_confirmation')" class="alert-empty">{{ errors.first('password_confirmation') }}</h6>        
        
        <label>地址</label>
        <b-form-textarea v-validate="'required'" data-vv-as="地址" name="address" v-model="address" placeholder="地址" :rows="3" :max-rows="6"> </b-form-textarea>
        <h6 v-show="errors.has('address')" class="alert-empty">{{ errors.first('address') }}</h6>

        <label>辩题</label>
        <b-form-input v-validate="'required'" data-vv-as="辩题1" name="title_1" v-model="title_1" type="text" placeholder="辩题一（哲学）" style="width:50%" ></b-form-input>
        <h6 v-show="errors.has('title_1')" class="alert-empty">{{ errors.first('title_1')}}</h6>
        <b-form-input v-validate="'required'" data-vv-as="辩题2" name="title_2" v-model="title_2" type="text" placeholder="辩题二（政策）" style="width:50%" ></b-form-input>
        <h6 v-show="errors.has('title_2')" class="alert-empty">{{ errors.first('title_2')}}</h6>
        <b-form-input v-validate="'required'" data-vv-as="辩题3" name="title_3" v-model="title_3" type="text" placeholder="辩题三（自由发挥）" style="width:50%" ></b-form-input>
        <h6 v-show="errors.has('title_3')" class="alert-empty">{{ errors.first('title_3')}}</h6>
        
        <label>确认文件</label>
        <b-form-file v-model="file" :state="Boolean(file)" placeholder="Choose a file..."></b-form-file>
          <div class="mt-3">Selected file: {{file && file.name}}</div>
        <label></label>
        
        <input  type="checkbox" id="checkbox" v-model="checked">
        <label for="checkbox"></label>

        <b-button :disabled="!checked" @click="submitForm">Submit</b-button>
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
    file: null,
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

    methods:{
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
label{margin-top:20px;}

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

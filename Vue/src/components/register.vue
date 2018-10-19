<template>
  <div>
    <div style="width:60%;margin:auto;">

      <form class="needs-validation" novalidate>
        <label>区域</label>
        <b-form-select v-model="selected" :options="options" class="mb-3" />
        <label>大学名称</label>
        <b-form-input v-model="University" type="text" placeholder="输入大学名称" style="width:30%" ></b-form-input>
        <label>负责人姓名</label>
        <b-form-input v-model="name_cn" type="text" placeholder="负责人姓名（华语）" style="width:30%" ></b-form-input>
        <b-form-input v-model="name_en" type="text" placeholder="负责人姓名（英语）" style="width:30%" ></b-form-input>
        <label>电子邮件</label>
        <b-form-input v-model="email" type="email" placeholder="电子邮件" style="width:30%" ></b-form-input>
        <label>负责人联络号码</label>
        <b-form-input v-model="phone" type="text" placeholder="负责人联络号码" style="width:30%" ></b-form-input>
        <label>密码</label>
        <b-form-input v-model="password" type="password" placeholder="密码" style="width:30%" ></b-form-input>
        <b-form-input type="password" placeholder="确认密码" style="width:30%" ></b-form-input>
        <label>地址</label>
        <b-form-textarea v-model="address" placeholder="地址" :rows="3":max-rows="6"> </b-form-textarea>
        <label>辩题</label>
        <b-form-input v-model="title_1" type="text" placeholder="辩题一（哲学）" style="width:50%" ></b-form-input>
        <b-form-input v-model="title_2" type="text" placeholder="辩题二（政策）" style="width:50%" ></b-form-input>
        <b-form-input v-model="title_3" type="text" placeholder="辩题三（自由发挥）" style="width:50%" ></b-form-input>
        <label>确认文件</label>
        <b-form-file v-model="file" :state="Boolean(file)" placeholder="Choose a file..."></b-form-file>
          <div class="mt-3">Selected file: {{file && file.name}}</div>
        <label></label>
        <b-form-checkbox  id="checkbox1"
                     v-model="status"
                     value="true"
                     unchecked-value="false">
                     I accept the terms and use
                   </b-form-checkbox>
        <b-button>Submit</b-button>
    </form>
      </div>
      

</div>
</template>
<script>
export default
{
  name:'register',
  data() {return {
    file: null,
    selected: null,
    University:'',
    name_cn:'',
    name_en:'',
    email:'',
    phone:'',
    password:'',
    address:'',
    title_1:'',
    title_2:'',
    title_3:'',
    status:'false',

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

  }}
}
</script>
<style scoped>
label{margin-top:20px;}
</style>

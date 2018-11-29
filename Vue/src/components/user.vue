<template>

    <div>
        <div class="container">
            <div class="content">
                <h1>大学资料</h1><hr>
            <form>
                <div class="row"><span><strong>区域</strong>：</span><input class="unchangable" type="text" placeholder=region v-model="region" disabled></div><br>
                <div class="row"><span><strong>大学名称</strong>：</span><input  class="unchangable" ref="uni_name_cn1" :value="uni_name_cn" disabled></div><br>
                <div class="row"><span><strong>大学名称：</strong></span><input  class="unchangable" ref="uni_name_en1" :value="uni_name_en" disabled></div><br>

                <div class="row"><span><strong>联络电话：</strong></span><input type="text" ref="phone1" :value="phone" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                <div class="row"><span><strong>电子邮件：</strong></span><input type="email" ref="email1" :value="email" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                <div class="row"><span><strong>地址：</strong></span><textarea  ref="address1" :value="address" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></textarea></div><br>
                <div class="row"><span><strong>辩题1：</strong></span><input type="text" ref="debate_Ques1" :value="debateQues1" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                <div class="row"> <span><strong>辩题2：</strong></span><input type="text" ref="debate_Ques2" :value="debateQues2" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>
                <div class="row"><span><strong>辩题3：</strong></span><input type="text" ref="debate_Ques3" :value="debateQues3" :disabled="!isEditing" :class="{view:!isEditing,changing:isEditing}"></div><br>

                    <button @click.prevent="isEditing = !isEditing" v-if="!isEditing" class="btn btn-primary">Edit</button>


                    <button @click="save" v-else-if="isEditing" class="btn btn-primary  ">Save</button>

                    <button v-if="isEditing" @click.prevent="isEditing = false" class="btn btn-primary">Cancel</button>


                    <br>


            </form>
            </div>

        </div>
    </div>

</template>

<script>

    import axios from 'axios';

    export default
    {
        name:'user',
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

            }
        },
        created(){
            this.getDetails()
        },
        methods:{
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

                            this.region=resp.data.user.region
                            switch(this.user.region){
                                case "Malaysia": this.region = "马来西亚"; break;
                                case "Singapore": this.region = "新加坡"; break;
                                case "China": this.region = "中国大陆"; break;
                                case "Hong Kong": this.region = "香港"; break;
                                case "Macau": this.region = "澳门"; break;
                                case "Taiwan": this.region = "台湾"; break;
                                case "Australia": this.region = "澳大利亚"; break;
                                default: break;
                            }
                            this.debateQues1=resp.data.uniDetails.debateQues1
                            this.debateQues2=resp.data.uniDetails.debateQues2
                            this.debateQues3=resp.data.uniDetails.debateQues3

                    })
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


            }
        }

    }

</script>

<style scoped>
    .container{margin-top:1%;background-color: #F7F7F7;
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
    .content{width:80%;margin:auto;}


</style>

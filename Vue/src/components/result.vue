<template>
    <div class="container">
        <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
        <br>
        <h1 style="text-align:center">电子抽签成绩</h1>
        <hr>
        <h3 style="color:darkred;text-align: center;">地区: <strong>{{user.region}}</strong></h3>
        
        <b-table hover :items="results" :fields="fields"></b-table>
    </div>
</template>

<script>
    import axios from 'axios';
    import oldnav from './oldnav.vue';

    export default{
        name:'results',
        components:{oldnav},
        data(){
            return{
                fields:{
                    uniNameCN:{
                        label: '大学名称',
                        sortable: true,
                    },
                    offTimeDiff:{
                        label: '时间(秒)',
                        sortable: true,
                    }
                },
                results:'',
                region: '',
                number:3,
            }
        },
        mounted(){
            this.getResults();
        },
        computed:{
            user: function(){ return JSON.parse(localStorage['user'])},
            isLogged : function(){ return this.$store.getters.isLoggedIn},
        },
        methods:{
            getResults:function(){
                axios
                    .get('api/time/official/get',{
                        headers:{
                            Authorization: "Bearer " + localStorage.getItem('token')
                        }
                    })
                    .then(resp=>{
                        
                        switch(user.region){
                            case 'Singapore': this.number = 3; break;
                            case 'Malaysia': this.number = 4; break;
                            case 'Hong Kong': this.number = 1; break;
                            case 'Macau': this.number= 1; break;
                            case 'China': this.number = 8; break;
                            case 'Australia': this.number = 4; break;
                            case 'Taiwan': this.number= 1; break;
                            case 'Others': this.number=1; break;
                            default:this.number=5; break;
                        }
                        console.log(this.number);

                        this.results = resp.data.data.slice(0,this.number);
                        console.log(this.results);
                        for(var i = 0; i < this.results.length; i++){
                            if(this.results[i].offTimeDiff == 1000000000000000000){
                                this.results[i].offTimeDiff = "还未报名";
                            }else if(this.results[i].offTimeDiff == 0){
                                this.results[i].offTimeDiff = "种子队"
                            }else{
                                this.results[i].offTimeDiff = this.results[i].offTimeDiff/1000000 //show time in second from micro
                            }
                        }
                        
                        this.region = resp.data.region;
                        switch(user.region){
                            case 'Singapore': this.region = "新加坡"; break;
                            case 'Malaysia': this.region = "马来西亚"; break;
                            case 'Hong Kong': this.region = "香港"; break;
                            case 'Macau': this.region = "澳门"; break;
                            case 'China': this.region = "中国"; break;
                            case 'Australia': this.region = "澳大利亚"; break;
                            case 'Taiwan': this.region = "台湾"; break;
                            case 'Others': this.region="其他"; break;
                            default: break;
                        }
                    })
            }
        }
    }
    
</script>
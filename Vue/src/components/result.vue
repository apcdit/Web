<template>
    <div class="container">
        <oldnav v-bind:isLogged="isLogged" v-bind:user="user"></oldnav>
        <br>
        <h1 style="text-align:center">电子报名成绩</h1>
        <hr>
        <h3 style="color:darkred;text-align: center;">地区: <strong>{{region}}</strong></h3>

        <!-- <b-table hover :items="results" :fields="fields"></b-table> -->
        <table class="table table-hover" style="border:none;">
        <thead class="thead">
            <tr class="text-center">
            <th scope="col">大学名称</th>
            <th scope="col">时间差(秒)</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr v-for="result in results" v-bind:key="result.uniNameCN" v-bind:class="{green:result.qualified == 1}">
            <th scope="row" style="border:none;">{{result.uniNameCN}}</th>
                <td style="border:none;">{{result.offTimeDiff}}</td>
            </tr>
        </tbody>
        <caption>*绿色为入围队伍。</caption>
        <caption>此页面仅显示前{{numResults}}名的大学。</caption>
        </table>
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
                        sortable: false,
                    },
                    offTimeDiff:{
                        label: '时间(秒)',
                        sortable: false,
                    }
                },
                results:'',
                region: '',
                number:3,
                numResults: 8,
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
                        //number of qualified teams for each region
                        if (resp.data.region=='Singapore') {this.number = 2;}
                        else if (resp.data.region=='Malaysia') {this.number = 4;}
                        else if (resp.data.region=='Hong Kong') {this.number = 5;}
                        else if (resp.data.region=='Taiwan') {this.number = 5;}
                        else if (resp.data.region=='Macau') {this.number = 1;}
                        else if (resp.data.region=='Australia') {this.number = 3;}
                        else if (resp.data.region=='Admin') {this.number = 5;}
                        else if (resp.data.region=='China') {this.number = 8;}
                        else if (resp.data.region=='Others') {this.number = 1;}
                        
                        this.results = resp.data.data.slice(0,8); //this will slice 8 teams always
                        
                        if(resp.data.region=='China'){
                            this.results = resp.data.data.slice(0,10);
                            this.numResults = 10;
                        }

                        for(var i = 0; i < this.results.length; i++){
                            if(this.results[i].offTimeDiff == 1000000000000000000){
                                this.results[i].offTimeDiff = "还未报名";
                            }else if(this.results[i].offTimeDiff == 0){
                                this.results[i].offTimeDiff = "种子队"
                                this.results[i].qualified = 1;
                            }else{
                                if(i < this.number){
                                    this.results[i].qualified = 1;
                                }
                                this.results[i].offTimeDiff = (this.results[i].offTimeDiff/1000000).toString(); //show time in second from micro
                                this.results[i].offTimeDiff = this.results[i].offTimeDiff + " 秒";
                            }
                        }


                        switch(resp.data.region){
                            case 'Singapore': this.region = "新加坡"; break;
                            case 'Malaysia': this.region = "马来西亚"; break;
                            case 'Hong Kong': this.region = "港台"; break;
                            case 'Macau': this.region = "澳门"; break;
                            case 'China': this.region = "中国"; break;
                            case 'Australia': this.region = "澳大利亚"; break;
                            case 'Taiwan': this.region = "港台"; break;
                            case 'Others': this.region="其他"; break;
                            default: this.region = resp.data.region; break;
                        }
                    })
            }
        }
    }

</script>

<style scoped>
    .green{
        background: rgb(74, 187, 74);
        color: rgb(243, 241, 241);
    }
    .green:hover{
        color: black;
    }
    table{
        border:none;
    }
</style>
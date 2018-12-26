<template>
    <div class="container">
        <br>
        <h1 style="text-align:center">电子抽签成绩</h1>
        <hr>
        <h3 style="color:darkred;text-align: center;">地区: <strong>{{region}}</strong></h3>
        <!-- <ul>
            <li v-for="result in results">
                <h5>{{result.uniNameCN}}   {{result.offTimeDiff}}</h5>
            </li>
        </ul> -->
         <b-table hover :items="results" :fields="fields"></b-table>
    </div>
</template>

<script>
    import axios from 'axios';

    export default{
        name:'results',
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
                region: ''
            }
        },
        mounted(){
            this.getResults();
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
                        //console.log(resp.data)
                        this.results = resp.data.data;
                        for(var i = 0; i < this.results.length; i++){
                            if(this.results[i].offTimeDiff == 1000000000000000000){
                                this.results[i].offTimeDiff = "还未报名";
                            }else{
                                this.results[i].offTimeDiff = this.results[i].offTimeDiff/1000000 //show time in second from micro
                            }
                        }
                        
                        this.region = resp.data.region;
                        switch(this.region){
                            case 'Singapore': this.region = "新加坡"; break;
                            case 'Malaysia': this.region = "马来西亚"; break;
                            case 'Hong Kong': this.region = "香港"; break;
                            case 'Macau': this.region = "澳门"; break;
                            case 'China': this.region = "中国"; break;
                            case 'Australia': this.region = "澳大利亚"; break;
                            case 'Taiwan': this.region = "台湾"; break;
                            default: break;
                        }
                    })
            }
        }
    }
    
</script>
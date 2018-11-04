<template>
    <div class="container">
        <br>
        <h1 style="text-align:center">电子抽签成绩</h1>
        <hr>
        <ul>
            <li v-for="result in results">
                <h5>{{result.uniNameCN}}   {{result.offTimeDiff}}</h5>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';

    export default{
        name:'results',
        data(){
            return{
                results:'',
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
                        console.log(resp.data)
                        this.results = resp.data.data
                    })
            }
        }
    }
    
</script>
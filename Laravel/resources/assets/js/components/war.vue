<template>
    <div class="container">
        <button @click="storeTime">War!!!</button>

        <button @click="getTime">Show result</button>
        <h1>{{ abc.time }}</h1>
    </div>

</template>

<script>
    import axios from 'axios';

    export default{
        name:'war',
        data(){
            return{
                uniNameCN: '',
                pressTime: '',
                info: '',
                pressed: '',
                abc: ''
            }
        },
        methods:{
            storeTime(){
                let data = {
                    //uniNameCN:this.uniNameCN,
                    pressed: 1
                };

                axios
                    .put('api/time/simulation/store',data)
                    .then( response =>{
                        this.info = response.data;
                        console.log(this.info);
                    })
            },

            getTime(){

                axios
                    .get('api/time/simulation/get/'+this.uniNameCN)
                    .then(response=>{
                        this.abc = response.data;
                        console.log(this.abc);
                    })
            }
        }
    }
</script>
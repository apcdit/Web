<template>
    <div class="container">
        <label>Email</label>
        <input placeholder="input your email" v-model="email">
        <button class="btn btn-primary" @click="resetpw">Submit</button>
    </div>
</template>

<script>

    import axios from 'axios';

    export default{
        name: "resetpw",
        data(){
            return{
                email: null,
            }
        },
        methods:{
            resetpw: function(){
                const data ={ 'email': this.email}
                axios
                    .post('api/password/create', data)
                    .then(response=>{
                        console.log(response.data.message)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            }
        }

    }
</script>
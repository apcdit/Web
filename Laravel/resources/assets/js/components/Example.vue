<template>
    <div>

        <div class="loginForm">
            <h1><strong>登陆</strong></h1>
            <hr>
            <form @submit.prevent="submitForm">
                <div>
                    <div class="form-group">
                        <p>
                            <label for="username">Email</label>
                            <input v-validate="'required'" type="email" :class="{'has-error':errors.has('username')}" id="username" name="username" v-model="username">
                            <span class="alert-red">{{errors.first('username')}}</span>
                        </p>
                    </div>


                    <p>
                        <label for="password">Password</label>

                        <input v-validate="'required'" type="password" id="password" name="password" v-model="password">
                    </p>

                    <button @click="doLogin">Login</button>
                </div>
            </form>
        </div>




    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name:'example',
        data() {
            return {
                username: '',
                password: '',
                info: '',
            };
        },

        methods: {
            doLogin() {
                let data = {
                    username: this.username,
                    password: this.password
                };

                axios.post('api/login', data)
                    .then(response =>{
                        console.log(response)
                    });
                    // .then(({data}) => {
                    //     // TODO: store data
                    //     // data.token
                    //     // data.user
                    // })
                    // .catch(({response}) => {
                    //     alert(response.data.message);
                    // });

            },

            submitForm(){

            }
        }
    }
</script>

<style scoped>

    .alert-red{
        color: red;
    }

    .has-error{
        border-color: red;
    }

    .loginForm{
        background-color: white;
        width: 80%;
        border-left: 35px;
        border-right: 35px;
        padding: 25px;
        margin: 0 auto;
    }


</style>
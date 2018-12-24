<template>
    <div>
        <div class="bg">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
        
        <div class="container text-center">
            <div id="title"><strong>最新消息</strong></div>
            <br>
            <div class="row">
                <div class="col-xs-4">
                    <div class="card profile-card-5">
                        <div class="card-img-block">
                            <img class="card-img-top" v-bind:src="post1.postPic" alt="图片无法显示">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title">{{post1.postTitle}}</h5>
                            <p class="card-text">{{post1.postDec}}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
    		    </div>
                <div class="col-xs-4">
                    <div class="card profile-card-5">
                        <div class="card-img-block">
                            <img class="card-img-top" v-bind:src="post2.postPic" alt="Card image cap">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title">{{post2.postTitle}}</h5>
                            <p class="card-text">{{post2.postDec}}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
    		    </div>
                <div class="col-xs-4">
                    <div class="card profile-card-5">
                        <div class="card-img-block">
                            <img class="card-img-top" v-bind:src="post3.postPic" alt="Card image cap">
                        </div>
                        <div class="card-body pt-0">
                            <h5 class="card-title">{{post3.postTitle}}</h5>
                            <p class="card-text">{{post3.postDec}}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
    		    </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <footer><foot></foot></footer>

    </div>
    
</template>

<script>
import foot from './foot.vue'
import axios from 'axios'

export default {
    name: 'home',
    components:{foot,},
    data(){
        return{
            post1: '',
            post2: '',
            post3: '',
        }
    },
    created() {
        this.fetchPosts()
    },
    methods:{
        fetchPosts(){
                axios
                    .get('api/posts/latest')
                    .then(response=>{
                        console.log(response.data[0])
                        this.post1 = response.data[0];
                        this.post2 = response.data[1];
                        this.post3 = response.data[2];
                        //console.log(localStorage.getItem('user'))
                    })
            },
    }
}
</script>

<style scoped>
    .bg{
        background-image: url("https://i.imgur.com/7MJgWRy.jpg");
        /* Full height */
        height: 100%; 
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-bottom:solid;
        border-bottom-width: 0.01rem;
        border-bottom-color: lightgrey;
    }

    body{
        height: 100%;
    }

    div #title{
        font-size: 2.5rem;
        padding-top: 5%;
        font-family: "Microsoft YaHei","华文细黑";
    }

    /*Profile Card 5*/
    .profile-card-5{
        margin-top:20px;
        margin-left: 35px;
        margin-right: 35px;
        margin-bottom: 20px;
    }
    .profile-card-5 .btn{
        border-radius:2px;
        text-transform:uppercase;
        font-size:12px;
        padding:7px 20px;
    }
    .profile-card-5 .card-img-block {
        width: 91%;
        margin: 0 auto;
        position: relative;
        top: -20px;
        
    }
    .profile-card-5 .card-img-block img{
        border-radius:5px;
        box-shadow:0 0 10px rgba(0,0,0,0.63);
    }
    .profile-card-5 h5{
        color:#4E5E30;
        font-weight:600;
    }
    .profile-card-5 p{
        font-size:14px;
        font-weight:300;
    }
    .profile-card-5 .btn-primary{
        background-color: darkred;
        border-color: darkred;
    }
</style>

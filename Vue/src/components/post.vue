<template>
    <div>
        <navibar v-bind:isLogged="isLogged" style="background:white"></navibar>
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h1 style="color:darkred;"><strong>{{posts.postTitle}}</strong></h1>
                    <h6 v-if="admin == 1">编辑</h6>
                    <hr>
                    <img v-bind:src="posts.postPic">
                    <h6 style="color:grey;font-size:14px;padding-top:5px;">发布于:{{posts.created_at}}</h6>
                    <hr style="background:darkred;">
                    <p v-html="posts.postContent">{{posts.postContent}}</p>
                </div>
                <div class="col-sm-4 list-group-flush">
                    <h3><strong>更多消息</strong></h3>

                    <hr style="background:darkred; height:5px;">
                    <!-- <ol class="list-group list-group-flush" >
                        <li class="list-group-item" v-for="other in others" v-bind:key="other.id">
                            <a href="#">{{other.postTitle}}</a>
                            <hr style="width:2px;">
                        </li>
                    </ol> -->
                    <div v-for="other in others" v-bind:key="other.id">
                    <router-link  :to="{ name: 'post', params: { id: other.id}}"   class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1" style="color:darkred;"><strong>{{other.postTitle}}</strong></h5>
                            <small>{{other.created_at}}</small>
                        </div>
                        <small>{{other.postDec}}</small>
                    </router-link>
                    </div>
                </div>
            </div>
        </div>
        <footer><foot></foot></footer>
    </div>
</template>
<script>
    import axios from 'axios';
    import navibar from './navigation.vue';
    import foot from './foot.vue';
    export default{
        name:'post',
        components:{navibar, foot},
        data () {
            return {
                id:'',
                posts:[],
                others: '',
                admin: 0,
            }
        },
        computed:{
            user: function(){ if(typeof localStorage['user'] !== 'undefined') {
                this.admin = JSON.parse(localStorage['user'].admin);
                return JSON.parse(localStorage['user'])
            }
                },
            isLogged : function(){ return this.$store.getters.isLoggedIn},
        },
        created(){
            this.getParams();
            this.getPost();
            this.fetchPosts();
        },
        methods: {
            getParams () {
                // 取到路由带过来的参数
                var routerParams = this.$route.params.id
                // 将数据放在当前组件的数据内
                // if(routerParams===undefined){this.id=localStorage.id;}
                // else{
                // this.id = routerParams
                // console.log(this.id);localStorage.id=this.id;console.log(localStorage.id);}
                if(routerParams !== undefined){
                    this.id = routerParams;
                }
            },

            getPost(){

                axios
                    .get('api/post/'+this.id)
                    .then(response=>{
                        this.posts = response.data;
                    })
            },
            fetchPosts(){
                axios
                    .get('api/posts/latest')
                    .then(response=>{
                        this.others = response.data;
                    })
            },
            refresh(){
                window.location.reload(false);
            }
        },
        watch: {
            // 监测路由变化,只要变化了就调用获取路由参数方法将数据存储本组件即可
            '$route': 'getParams',
            //when the url is changed, it will refresh 
            '$route' (to, from) {
                this.$router.go(0);
            }
        },
        mounted() {


        },

    }

</script>
<style scoped>
    img{
        max-width: 100%;
        height: auto;
    }
    a {
        color: black;
        text-decoration: none !important;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }
</style>
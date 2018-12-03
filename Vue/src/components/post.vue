<template>
    <div>
        <div style="width:100%">

    <div class="container">
        <img v-bind:src="posts.postPic" width="180px" height="150px">
        <h1>{{posts.postTitle}}</h1>
        <span style="color:grey;font-size:9px;">{{posts.created_at}}</span>
        <p>{{posts.postDec}}</p>
        <router-link to='/latestNews'><button >返回最新消息</button></router-link>
    </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default
    { name:'post',
        data () {
            return {
                id:'',
                posts:[],
            }
        },
        created(){
            this.getParams();
            this.getPost();
        },
        methods: {
            getParams () {
                // 取到路由带过来的参数
                var routerParams = this.$route.params.id
                // 将数据放在当前组件的数据内
                if(routerParams===undefined){this.id=localStorage.id;}
                else{
                this.id = routerParams
                console.log(this.id);localStorage.id=this.id;console.log(localStorage.id);}
            },
            getPost(){

                axios
                    .get('api/post/'+this.id)
                    .then(response=>{
                        this.posts = response.data;
            })
        }},
        watch: {
            // 监测路由变化,只要变化了就调用获取路由参数方法将数据存储本组件即可
            '$route': 'getParams'},
        mounted() {


        },

    }

</script>
<style scoped>
    .container{margin:auto;width:80%;text-align: center;}
</style>
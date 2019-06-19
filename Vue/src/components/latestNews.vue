<template>
<div>
    <navibar v-bind:isLogged="isLogged" style="background:white;"></navibar>
    <div class="container">
        <h1>最新消息</h1>
        <hr>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li v-for="n in length" @click="slice1(n)" class="page-item"><a class="page-link">{{n}}</a></li>
            </ul>
            <p style="text-align:center;">当前页数：{{page}}</p>
        </nav>
        <br>
        <!-- <div v-for="new1 in news" v-bind:key="new1.id">
            <span class="" href="#" style="text-decoration: none;color:black;">
                <div class="row">
                    <div class="col-sm-4"><img v-bind:src="new1.postPic" width="70%" height="70%"></div>

                    <div class="col-sm-8">
                        <div class="row">
                            <router-link :to="{ name: 'post', params: { id: new1.id}}">
                                <h2 style="color:#9A2A1F;">{{new1.postTitle}}</h2>
                            </router-link>
                        </div>
                        <div class="row">
                            <p style="font-size:15px;">{{new1.postDec}}</p>
                        </div>

                        <div class="row">
                            <p style="9px;color:darkgrey;">发布于{{new1.created_at}}</p>
                        </div>


                    </div>
                </div>
            </span>
            <hr>
        </div> -->
       
        <div class="container">
            <div v-for="new1 in news" v-bind:key="new1.id">
                <div class="row">
                <div class="col-md-4 text-center">
                    <img v-bind:src="new1.postPic" width="70%" height="auto">
                </div>
                <div class="col-md-8">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1" style="color:darkred;"><strong><router-link :to="{ name: 'post', params: { id: new1.id}}">
                                    <h2 style="color:#9A2A1F;">{{new1.postTitle}}</h2>
                                </router-link></strong></h5>
                    </div>
                    <small>发布于:{{new1.created_at}}</small>
                    <p>{{new1.postDec}}</p>
                </div>
                </div>
                <hr>
            </div>
            </div>
        <div class="container" >

            <div style="padding:10px;">
                <img src="https://i.imgur.com/UHeT8gn.jpg" width="100%" >
            </div>
        </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li v-for="n in length" @click="slice1(n)" class="page-item"><a class="page-link">{{n}}</a></li>
            </ul>
            <p style="text-align:center;">当前页数：{{page}}</p>
        </nav>
        <footer><foot></foot></footer>
</div>

</template>

<script>

    import axios from 'axios';
    import foot from './foot.vue';
    import navibar from './navigation.vue';

    export default
    {name:'latestNews',
    components:{foot,navibar},
        data () {
            return {

                length:'',
                posts:[],
                news:[],
                rowsperpage:3,
                page:1,
            }
        },
        created(){
            this.fetchPosts()
        },
        computed:{
            isLogged : function(){return this.$store.getters.isLoggedIn},
        },
        methods:{
            fetchPosts(){
                axios
                    .get('api/posts')
                    .then(response=>{
                        this.posts = response.data;
                        // console.log(this.posts);
                        this.posts=this.posts.reverse();
                        this.length=this.posts.length;
                        this.news=this.posts.slice(0,this.rowsperpage);
                        this.length=Math.ceil(this.length/this.rowsperpage);
                    })
                    window.scrollTo(0,0);
            },
            slice1(n){ this.page=n;this.news=this.posts.slice((n-1)*this.rowsperpage,n*this.rowsperpage);},



        }}

</script>

<style scoped>

</style>
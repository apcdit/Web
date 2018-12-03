<template>
<div class="container">
    <h1>最新消息</h1>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li v-for="n in length" @click="slice1(n)" class="page-item"><a class="page-link">{{n}}</a></li>
        </ul>
        <p style="text-align:center;">当前页数：{{page}}</p>
    </nav>
    <br/>
    <div class="content">
    <ul>
        <li v-for="new1 in news">
            <div class="col-xs-4">
                                    <span class="" href="#" style="text-decoration: none;color:black;">
                                        <div class="row">
                                            <div class="col-sm-4"><img v-bind:src="new1.postPic" width="180px" height="150px"></div>

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
            </div>
            <hr>
        </li>
    </ul>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li v-for="n in length" @click="slice1(n)" class="page-item"><a class="page-link">{{n}}</a></li>
        </ul>
        <p style="text-align:center;">当前页数：{{page}}</p>
    </nav>



</div>

</template>

<script>

    import axios from 'axios';

    export default
    {name:'latestNews',
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
        methods:{
            fetchPosts(){
                axios
                    .get('api/posts')
                    .then(response=>{
                        this.posts = response.data;
                        console.log(this.posts);
                        this.posts=this.posts.reverse();
                        this.length=this.posts.length;
                        this.news=this.posts.slice(0,this.rowsperpage);
                        this.length=Math.ceil(this.length/this.rowsperpage);
                    })
            },
            slice1(n){ this.page=n;this.news=this.posts.slice((n-1)*this.rowsperpage,n*this.rowsperpage);},



        }}
</script>

<style scoped>
    .content{width:90%;}
</style>
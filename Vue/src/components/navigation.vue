<template>
    <nav class="nav navbar navbar-expand-lg navbar-light fixed-top" v-bind:style="scrolling">
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> -->
        <b-navbar-brand href="/"><img src="http://i.imgur.com/90YSaaO.png"></b-navbar-brand>
        <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
        <b-collapse is-nav id="nav_dropdown_collapse">
            <b-navbar-nav>
                <b-nav-item style="font-size:20px;" href="http://www.apchinesedebate.com">主页</b-nav-item>
                <b-nav-item style="font-size:20px;" href="/latestNews">最新消息</b-nav-item>
                <b-nav-item style="font-size:20px;" href="/people">筹委介绍</b-nav-item>
                <b-nav-item style="font-size:20px;" href="/sponsor">合作赞助</b-nav-item>
                <b-nav-item style="font-size:20px;" v-b-modal.login v-if="!isLogged">登录</b-nav-item>
                <b-nav-item style="font-size:20px;" href="/user" v-if="isLogged">个人主页</b-nav-item>
            </b-navbar-nav>
        </b-collapse>
    </nav>


</template>


<script>

    import login from './login.vue'

    export default
    {
        name:'navigation',
        components:{login},
        props:{
            isLogged: Boolean,
        },
        data(){
            return{
                isLogged: false,
            }
        },
        computed:{
            scrolling:function(){
                window.onscroll = () => {
                    // const nav = document.querySelector('.navbar');
                    // const bg = document.querySelector('.bg');
                    // const foot = document.querySelector('#footbar');
                    // const news = document.querySelector('#latestNews');
                    // const btm = bg.clientHeight+news.clientHeight;
                    // if(scrollY <= bg.clientHeight-nav.clientHeight) {
                    //     nav.style.backgroundColor='';
                    //     return '';
                    // }else if((bg.clientHeight-nav.clientHeight) < scrollY  && (scrollY)<= (btm-nav.clientHeight)){
                    //     nav.style.backgroundColor='white';
                    //     return '';
                    // }else{
                    //     nav.style.backgroundColor='rgb(46, 46, 46)';
                    //     nav.style.color='white';
                    //     return '';
                    // }
                };
            }
        },
    }
</script>

<style scoped>

</style>

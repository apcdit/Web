<template>

<div>
    <navibar v-bind:isLogged="isLogged" style="background:white"></navibar>
    
    <div class="container" style="padding-bottom:10%">
        <div id="guanming">
            <h1 style="padding-bottom:10%;">冠名赞助</h1>
            <a href="http://singapore.icbc.com.cn"><img class="img-responsive" src="https://i.imgur.com/jFeU5Ja.png" width="80%" height="auto" ></a>
            
            <i><h3 style="color:darkred;margin:3%;">"新加坡首选人民币银行"</h3></i>
            <h5>中国工商银行新加坡分行成立于1993年，是中国工商银行第一家海外机构。经过多年的不懈努力，新加坡分行现已成为新加坡领先的商业银行之一，业务领域覆盖了个人金融服务、私人银行金融服务、企业金融服务以及机构金融服务。</h5>
        </div>

        <div id="others">
        <h1 style="padding-bottom:10%;">其他赞助</h1>
        <img src="../assets/CLCF.jpg" width="45%" height="auto">
        <img src="../assets/NYC---YCM-logo-lockup light background.png" width="50%" height="auto">
        </div>
    </div>
    <footer><foot></foot></footer>
</div>

</template>

<script>

    import navibar from './navigation.vue';
    import foot from './foot.vue';
    export default{
        name:'sponsor',
        components:{foot,navibar},
    }
</script>

<style>
    #guanming{
        text-align: center;
        padding: 10%;
    }
    #guanming h1{
        font-size: 250%;
        padding:2%;
    }
    #others{
        text-align: center;
    }
</style>
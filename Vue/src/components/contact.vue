<template>
    <div class="container animated fadeIn content">
        <nav>
            <a style="float:right;" class="btn" href="/"><i class="fa fa-times" aria-hidden="true"></i></a>
        </nav>
        <div class="row ">
            <div class="col-md-12 ">
                <h1 class="title">联络我们</h1><br>
                <hr class="separator">
            </div>
        </div>
        <div class="row">
                <div class="col-sm">
                    <p class="title">竞赛组</p>
                    <p class="info">参赛流程、赛制、章程</p>
                    <a href="mailto:apchinesedebate.adj@gmail.com" class="mail">apchinesedebate.adj@gmail.com</a><br/>
                    <br/>  
                    <p class="title">福利组</p>
                    <p class="info">辩手来新安排、住宿</p>
                    <a href="mailto:apchinesedebate.wel@gmail.com" class="mail">apchinesedebate.wel@gmail.com</a><br/>

                    <br/> <p class="title">筹款组</p>
                        <p class="info">赞助活动</p>
                        <a href="mailto:apchinesedebatebizmag@gmail.com" class="mail"> apchinesedebatebizmag@gmail.com</a><br/>

                </div>
                <div class="col-sm">
                    <p class="title">公关兼宣传组</p>
                        <p class="info">媒体联络、宣传活动、前往观赛</p>
                        <a href="mailto:apchinesedebate.publicity@gmail." class="mail">apchinesedebate.publicity@gmail.com</a><br/>

                    <br/> <p class="title">网持组</p>
                        <p class="info">电子报名系统、网站、社交媒体</p>
                        <a href="mailto:chinesedebate.it@gmail.com" class="mail"> chinesedebate.it@gmail.com</a><br/>
                <br/>
                <p class="title">其他</p>
                <a href="apchinesedebate@gmail.com" class="mail">apchinesedebate@gmail.com</a><br/>
                <br>
                <br>
            </div>
        </div>
    </div>
</template>
<script>
    export default{name:'contact'}
</script>
<style scoped>
    ul{list-style:none;}
    .title{font-size:20px}
    h1.title{
        font-size:2.25rem;
    }
    .info{color: grey;
        font-size: 18px;
        line-height: 60%;}
    .mail{color:red;}
    a{
        color: darkred;
    }
</style>
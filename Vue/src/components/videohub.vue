<template>
<div style="margin-top:1%">
<div class="container animated fadeIn content">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">亚太辩视频库📹</h1>
                <hr>
            </div>
        </div>

        <br>
        <a v-b-toggle.collapseA class="expandB1" @click = "expandA" v-if="!expandedA"><h2>+  第七届亚太辩</h2></a>
        <a v-b-toggle.collapseA class="expandB1" @click = "collapseA" v-else><h2>-  第七届亚太辩</h2></a>
        <!-- elements to collapse -->
        <b-collapse id="collapseA" class="mt-2">
        <b-card>
            <div class="row">
            <div class="col">
            <iframe width="320" height="180" src="https://www.youtube.com/embed/videoseries?list=PLvfHyF5nLEMpPN8oZaxs20T2kU-aSkqaC" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>

            <div class="col"> 
            <iframe height="180" width="320" src='https://player.youku.com/embed/XMTI4MDU3OTkwNA==' frameborder=0 ></iframe>
            </div>
            </div>
        </b-card>
        </b-collapse>

        <hr>

        <a v-b-toggle.collapseB @click = "expand" class="expandB1" v-if="!expanded"><h2>+  第六届亚太辩</h2></a>
        <a v-b-toggle.collapseB @click = "collapse" class="expandB1" v-else><h2>-  第六届亚太辩</h2></a>
        <!-- elements to collapse -->
        <b-collapse id="collapseB" class="mt-2">
        <b-card>
            <div class="row">
            <div class="col">
                <iframe width="320" height="180" src="https://www.youtube.com/embed/videoseries?list=PLvfHyF5nLEMqcgsNu9Jptj0JWHOZtqNCh" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>

            <div class="col"> 
                    <iframe height="180" width="320" src='https://player.youku.com/embed/XNTU5NDgxMjA4==' frameborder=0 ></iframe>
            </div>
            </div>
        </b-card>
        </b-collapse>
        <hr>

        </div>
    </div>

</template>
<script>
   export default{
       data(){
           return{
               expanded:0,
               expandedA:0
           }
       },
       methods:{
           expand: function(){
               if(this.expanded == 0){
                   this.expanded = 1;
               }
           },
           collapse: function(){
               if(this.expanded == 1){
                   this.expanded = 0;
               }
           },
           expandA: function(){
               if(this.expandedA == 0){
                   this.expandedA = 1;
               }
           },
           collapseA: function(){
               if(this.expandedA == 1){
                   this.expandedA = 0
               }
           }
       }
   }
</script>
<style scoped>
    .expandB1{
        border: none;
        padding: 0;
        background: none;
    }
</style>

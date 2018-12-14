<template>
    <div>
        <div class="bg"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
        
        <footer><foot></foot></footer>

    </div>
    
</template>

<script>
import foot from './foot.vue'

export default {
    name: 'home',
    components:{foot,},
    data(){

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
    }

    body{
        height: 100%;
    }
</style>

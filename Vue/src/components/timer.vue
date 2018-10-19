<template>
<div>
  <center>
  <h1>新加坡时间</h1>
  <div class="time"><iframe src="http://free.timeanddate.com/clock/i6gm3rp7/n236/tlsg/fs22/ftbi/tt0/th1/ta1" frameborder="0" width="487" height="28"></iframe></div>
  <b-button disabled>现在报名</b-button><b-button @click="record">模拟报名</b-button>
  <b-tabs title="asd">
    <b-tab title="报名成绩"></b-tab>
    <b-tab title="模拟成绩"></b-tab>
  </b-tabs>
</center>
</div>
</template>
<script>
export default{
  name:'timer',
  data(){return{time:''}},
  methods:{ record() {

    alert(new Date());
  }}
}
</script>
<style scoped>
.time{pointer-events: none;}
</style>

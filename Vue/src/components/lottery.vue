<template>
<div class="container">
  <br>
  <h1 style="text-align:center">电子抽签系统</h1>
  <hr>
  <div class="row">

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
        <h3><a style="text-decoration:none;">新加坡</a><span style="color:gray;"><br />本地时间</span></h3>
        <iframe src="http://free.timeanddate.com/clock/i5h4olht/n236/tlcn8/fn6/fs16/tt0/tm3/th1/ta1/tb4" frameborder="0" width="144" height="45"></iframe>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3>
        <a style="text-decoration:none;">当地时间</a>
        <span style="color:gray;"><br/>地区：{{authUser.region}}</span></h3>
      </h3>
    </div>

    <div class="col-md-4" style="text-align:center;padding:1em 0;">
      <h3><a style="text-decoration:none;">系统开放时间</a><span style="color:gray;"><br />(新加坡时间)</span></h3>
    </div>

    <br>

    <div class="panel panel-default" >
      <div class="panel-body" >
        <div class="col-md-12">
          <center>
            <h3>请点击下方的按钮进行电子报名。</h3>
            <p>系统开放后，只需点击下方按钮即可完成电子报名程序。</p>
            <br>
            <form id="recordtime" method="post" action="php/time.php">
              <a href="php/time.php" class="btn btn-primary btn-block " id="button"type="submit" form="recordtime" value="Submit" target="_blank">报名</a>
            </form>
            <br>
            <a href="private.php" class="btn btn-lg">个人主页</a>
          </center>
        </div>
      </div>
    </div>
    
  </div>
</div>
</template>
<script>
export default
{
  name:'lottery',
  created () {
    setInterval(() => this.now = new Date, 1000 * 60)
  },
  computed: {
    now () {
      return new Date
    },
    authUser: function(){ if(this.$store.getters.authUser) return JSON.parse(this.$store.getters.authUser);}
  }
}
</script>
<style scoped>
  
</style>

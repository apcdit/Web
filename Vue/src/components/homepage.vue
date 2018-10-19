<template>
  <div>
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <ul class="list-group shadow">
              <li class="list-group-item">
                <h4>活动详情</h4>
                <h5><i class="fa fa-calendar-o" aria-hidden="true"></i> 2019年7月12日至7月16日</h5>
                <h5><i class="fa fa-map-marker" aria-hidden="true"></i> 新加坡南洋理工大学 </h5>
                <h5><i class="fa fa-clock-o" aria-hidden="true"></i> 9:00am – 6:00pm </h5>
                <a  class="btn btn-primary">辩题列表</a>
                <a class="btn btn-primary">比赛地点/赛程</a>
              </li>
            </ul>
        <ul class="list-group-item">
          <li class="list-group-item sidebar">
               <h4>最新视频</h4><a href="news.php" class="btn btn-primary">查看更多</a>
               <ul class="list-group">
                 <iframe src="https://www.youtube.com/embed/U4v2W_V9Fk0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
               </ul>
          </li>
        </ul>
        <ul class="list-group shadow">
                  <li class="list-group-item">
                    <h4>领取总决赛门票</h4>
                    <a class="btn btn-primary">如何领取</a>
                    <a class="btn btn-primary">网上预订</a>
                  </li>
        </ul>
    </div>
    <div class="col-md-8">
      <div class="jumbotron shadow sidebar">
        <div class="time"><iframe src="http://free.timeanddate.com/clock/i6gm3rp7/n236/tlsg/fs22/ftbi/tt0/th1/ta1" frameborder="0" width="487" height="28"></iframe></div>
        <b-tabs>
          <b-tab title="最新消息"></b-tab>
          <b-tab title="最新赛况"></b-tab>
          <b-tab title="对垒表"></b-tab>
          <b-tab title="辩题"></b-tab>
          <b-tab title="人气队伍"></b-tab>
        </b-tabs>
    </div>
  </div>
 </div>
 </div>
 <hr/>
 <center>
 <h1>参赛队伍</h1>

</center>
 <hr/>
</div>
</template>

<script>
export default
{
  name:'homepage',
  data(){return{
    videos:['https://www.youtube.com/embed/U4v2W_V9Fk0',]}
    }

}
</script>

<style></style>

<template>

  <div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              关于我们
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="/">赛会简介</a>
              <a class="dropdown-item" href="/pastyear">历届赛况</a>
              <a class="dropdown-item" href="#">筹委介绍</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              活动详情
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">最新消息</a>
              <a class="dropdown-item" href="#">最新赛况</a>
              <a class="dropdown-item" href="#">赛程</a>
              <a class="dropdown-item" href="/rules">参赛事宜</a>
            </div>
          </li>
          <li class="nav-item">
            <a href='/nav'><img src="http://i.imgur.com/zRtdcqV.png"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">视频库</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">联络我们</a>
          </li>

          <li class="nav-item"><a class="nav-link" href="#" v-if="!show"> 登录/注册 </a></li> <!--gt problem here why false can be showed  -->

        </ul>
      </div>
    </nav>

  </div>

</template>


<script>
  export default
  {
    name:'navigation',
    data (){return
    show: true}
  }
</script>
<style></style>

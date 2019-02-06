<template>
    <section id="footer">
		<div class="container">
            <br>
			<div class="row text-center text-xs-center text-sm-left text-md-left">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>工行杯亚太大专辩论公开赛</h5>
					<h6 style="color:white;">由新加坡南洋理工大学举办，为亚太地区高等学府辩论队提供一个交流的平台.</h6>
                    <br>
                    <a href="/#"><img src="http://i.imgur.com/90YSaaO.png"></a>
					<hr style="color:white">

						<h5>冠名赞助:中国工商银行</h5>
                        <br>
                    <div style="margin-left:-80px;margin-top:-60px">
						<img src="https://i.imgur.com/TAvUm1U.png" width="350px" ></div>


				</div>
                <div class="col-xs-12 col-sm-4 col-md-4" id="getHere">
					<h5>抵达这里</h5>
					<br>
					<div class="mapouter">
						<div class="gmap_canvas">
							<iframe width="300" height="250" id="gmap_canvas" src="https://maps.google.com/maps?q=nanyang%20technlogical%20university&t=&z=11&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
							</iframe>
						</div>
						</div>
					</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>链接</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="/#"><i class="fa fa-angle-double-right"></i>主页</a></li>
						<li><a href="/#"><i class="fa fa-angle-double-right"></i>关于我们</a></li>
						<li><a href="/#/contact"><i class="fa fa-angle-double-right"></i>联络我们</a></li>
						<li><a href="/#/videohub"><i class="fa fa-angle-double-right"></i>视频库</a></li>
						<li><a href="/#/latestNews"><i class="fa fa-angle-double-right"></i>最新消息</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
					<ul class="list-unstyled list-inline social text-center">
						<li class="list-inline-item"><a href="https://www.facebook.com/NTUCSapchinesedebate"><i class="fa fa-facebook"></i></a></li>
						<li class="list-inline-item"><a href="https://www.weibo.com/u/5398940329"><i class="fa fa-weibo"></i></a></li>
						<li class="list-inline-item"><a href="https://www.instagram.com/apchinesedebate/"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
				<hr>
			</div>	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
					<p class="h6">&copy All rights Reserved.<a class="text-green ml-2" href="apchinesedebate.com/#/" target="_blank">ICBC Presents - Asia-Pacific Intervarsity Chinese Debate Tournament</a></p>
				</div>
				<hr>
			</div>	
		</div>
	</section>
</template>

<script>
export default {
    name: 'foot',
    data(){
        return{

        }
    },
    methods(){

    }
}
</script>

<style scoped>
/* Footer */
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
section {
    padding: 60px 0;
}

section .section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}
#footer {
    background: rgb(46, 46, 46) !important;
}
#footer h5{
	padding-left: 10px;
    border-left: 3px solid #eeeeee;
    padding-bottom: 6px;
    margin-bottom: 20px;
    color:#ffffff;
}
#footer h3{
    padding-left: 10px;
    border-left: 3px solid #eeeeee;
    padding-bottom: 6px;
    margin-bottom: 20px;
    color:#ffffff;
}
#footer a {
    color: #ffffff;
    text-decoration: none !important;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}
#footer ul.social li{
	padding: 3px 0;
}
#footer ul.social li a i {
    margin-right: 5px;
	font-size:25px;
	-webkit-transition: .5s all ease;
	-moz-transition: .5s all ease;
	transition: .5s all ease;
}
#footer ul.social li:hover a i {
	font-size:30px;
	margin-top:-10px;
}
#footer ul.social li a,
#footer ul.quick-links li a{
	color:#ffffff;
}
#footer ul.social li a:hover{
	color:#eeeeee;
}
#footer ul.quick-links li{
	padding: 3px 0;
	-webkit-transition: .5s all ease;
	-moz-transition: .5s all ease;
	transition: .5s all ease;
}
#footer ul.quick-links li:hover{
	padding: 3px 0;
	margin-left:5px;
	font-weight:700;
}
#footer ul.quick-links li a i{
	margin-right: 5px;
}
#footer ul.quick-links li:hover a i {
    font-weight: 700;
}

@media (max-width:767px){
	#footer h5 {
    padding-left: 0;
    border-left: transparent;
    padding-bottom: 0px;
    margin-bottom: 10px;
}
}

</style>

// JavaScript Document
$(document).ready(function() {
	//首页大图切换
	var $sliders = $("#banner-img li");
	var $count = $sliders.length;
	var $num = 0;
	var $timer = setInterval(function(){
		$sliders.each(function() {
            $(this).removeClass("active");
        });
		//console.log($num);
		$sliders.eq($num).addClass("active");
		$num++;
		if($num==$count)
		{
			$num=0;
		}
	},6000);
	//导航变换
    $(window).scroll(function(){
		if($(window).scrollTop()>460)
		{	
			$("#header").removeClass("home-header");
			$("#logo").find("a img").eq(0).attr("src","images/logo.png");	
		}
		
		if($(window).scrollTop()<=460)
		{
			$("#header").addClass("home-header");	
			$("#logo").find("a img").eq(0).attr("src","images/logo1.png");
		}
	});
});
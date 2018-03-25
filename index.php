<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>美图册 - 共享美好瞬间</title>
	<link rel="stylesheet" href="./css/common.css"/>
	<link rel="stylesheet" href="./css/style.css"/>
    <link rel="stylesheet" href="./css/font_style.css">
</head>
<body>
<div class="header home-header" id="header">
	<div class="container"> 
		<div class="logo" id="logo"> 
			<a href="./index.php"><img src="images/logo1.png" alt="美图册"/></a>
		</div>
		<ul class="nav">
			<li><a href="./index.php">首页</a></li>
			<li><a href="./list.php">分类<span class="caret"></span></a>
            	<ul class="sub-nav">
                    <?php
                        show_header_category($conn);
                    ?>
                </ul>
            </li>
		</ul>

		<form class="search" method="get" action="search.php">
			<input type="text" name="keywords" class="search-text" placeholder="输入搜索关键字..."/>
			<input type="submit" class="search-btn" value=""/>
		</form>
        
		<div class="user-btn">
            <?php 
                show_header_btn($username,$nickname);
            ?>
        </div>
	</div>
</div>

<div class="banner">
	<ul id="banner-img">
    	<li style="background-image:url(./images/8.jpg);" class="active"></li>
        <li style="background-image:url(./images/2.jpg);" ></li>
        <li style="background-image:url(./images/bg.jpg);"></li>
	</ul>		

	<div class="banner-shadow"></div>

	<div class="banner-text center">
		<h1>美图册，共享美好瞬间</h1>
		<p>热门搜索：花，日系摄影，插图</p>
		<form class="banner-search" action="search.php">
			<input type="text" name="keywords" class="search-text" placeholder="输入搜索关键字..."/>
			<input type="submit" class="search-btn" value=""/>
		</form>
	</div>
</div>

<div class="hot">
	<div class="container">
    	<h1 class="home-section-title">热门图片</h1>
        <p class="home-section-detail">推荐大家都喜欢的热门图片给你。</p>
        <a href="./search.php" class="more-btn">查看所有图片</a>

        <?php 
            $query = "select * from photo where p_from_photo is null and p_id in (select l_photo_id as num from add_like group by l_photo_id having count(l_photo_id)>0) order by p_time desc limit 0,6";
            $hot_photo = mysqli_query($conn,$query);            
        
            while($row = mysqli_fetch_assoc($hot_photo))
            {
                if(!get_user_status($conn,$row['p_user_id']))
                    continue;
                $like_num = get_like_num($conn,$row['p_id']);

                echo "<a class='photo-box' href='photo.php?id=".$row['p_id']."' style='background-image:url(photo/".$row['p_url']."'>";
                echo "<div class='photo-info'><div class='photo-detail'>";
                echo "<h1>".$row['p_des']."</h1>";
                echo "<p><span class='icon-heart'></span>&nbsp;".$like_num."</p>";
                echo "</div></div></a>";
            }
        ?>
    </div><div class="clear"></div>
</div>

<div class="album">
    <div class="container">
        <h1 class="home-section-title">推荐图册</h1>
        <p class="home-section-detail">大家都在美图册建立了自己的图册。</p>
        <a href="./search.php?type=album" class="more-btn">查看所有图册</a>
        <?php 
            $query = "select * from album where a_cover_photo is not null order by a_time desc limit 0,4";
            $hot_album = mysqli_query($conn,$query);  

            while($row =  mysqli_fetch_assoc($hot_album))
            {
                $cover_url = mysqli_fetch_assoc(mysqli_query($conn,"select p_url from photo where p_id =".$row['a_cover_photo'])); 
                $user_name = mysqli_fetch_assoc(mysqli_query($conn,"select u_nickname from user where u_id ='".$row['a_user_id']."'")); 
                if(!get_user_status($conn,$row['a_user_id']))
                    continue;
                echo  "<a class='album-box-right' href='album.php?id=".$row['a_id']."' style='background-image:url(photo/".$cover_url['p_url'].");'></a>";
                echo "<div class='album-box-left'><div class='album-info'><a href='album.php?id=".$row['a_id']."'>".$row['a_name']."</a><p>来自<a href='album.php?id=".$row['a_id']."''>".$user_name['u_nickname']."</a></p><p class='describe'>".$row['a_des']."</p></div></div>";
            } 
        ?>
        
        <div class="clear"></div>
    </div>
</div>

<div class="category">
	<div class="container">
    	<h1 class="home-section-title">分类查找</h1>      
        <ul class="category-list">
            <?php
                show_header_category($conn);
            ?>
        </ul>
        
        <div class="clear"></div>
    </div>
</div>

<div class="footer">
	<div class="container">
    	<div class="footer-box">
        	<img src="images/logo2.png"/>
            <p>copyright&copy;from 2017 all rights reserved</p>
        </div>

    	<div class="footer-box">
        	<h1>关于</h1>
            <p>美图册是长沙理工大学的年糕同学的第一次的实训项目，是一个分享美图的地方，意在让大家发现美丽。</p>
        </div>

    	<div class="footer-box">
            <h1>帮助</h1>
            <ul>
            	<li><a href="#">常见问题</a></li>
                <li><a href="#">使用手册</a></li>
                <li><a href="#">投诉举报</a></li>
                <li><a href="#">规章条约</a></li>
                <li><a href="./admin/login.html">后台管理</a></li>
            </ul>
        </div>

    	<div class="footer-box">
        	<h1>联系我们</h1>
            <a href="#"><span class="icon-sina-weibo"></span> 新浪微博</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><span class="icon-bubbles"></span> 微信公众号</a>
            </br>
            <a href="#"><span class="icon-qrcode"></span>&nbsp;网站二维码</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#"><span class="icon-smile"></span> 糕の物语</a>
        </div>
        
        <div class="clear"></div>
    </div>
    
</div>

<script src="./js/jquery-1.8.3.min.js"></script>
<script src="./js/main.js"></script>
</body>
</html>
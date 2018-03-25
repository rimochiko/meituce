<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

    $category = $_GET['category'];
    $page = $_GET['page'];

    if(empty($page))
    {
        $page=1;
    }

    if(!empty($category))
    {     
        if(!check_category_exist($conn,$category))
            go_to_404();

        $photo_result = mysqli_query($conn,"select * from photo where p_album_id in(select a_id from album where a_category_id = ".$category.") order by p_time desc limit ".(10*($page-1)).",10"); 
        $photo_num_result = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo where p_album_id in(select a_id from album where a_category_id = ".$category.")")); 
        $album_num_result = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from album where a_category_id =".$category)); 
    }
    else
    {
        $photo_result = mysqli_query($conn,"select * from photo order by p_time desc limit ".(20*($page-1)).",20");
        $photo_num_result = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo")); 
        $album_num_result = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from album")); 
    }
    $page_num = ceil($photo_num_result['num']/20);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>全部分类 - 美图册</title>
	<link rel="stylesheet" href="css/font_style.css"/>
	<link rel="stylesheet" href="./css/common.css"/>
	<link rel="stylesheet" href="./css/style.css"/>
</head>
<body>

<div class="header" id="header">
    <div class="container"> 
        <div class="logo" id="logo"> 
            <a href="./index.php"><img src="images/logo.png" alt="美图册"/></a>
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

<div class="main-wrapper">
	<div class="category-box">
         <span>分类：</span>
         <?php
            if(empty($category))
            {
                echo "<a href='./list.php' class='active'>全部<span class='num'>".($photo_num_result['num']+$album_num_result['num'])."</span></a>";       
            }
            else
            {
                echo "<a href='./list.php'>全部<span class='num'>".($photo_num_result['num']+$album_num_result['num'])."</span></a>";
            }

            $num_result = mysqli_query($conn,"select a_category_id,ca_name,count(*) as num from photo, album,category where photo.p_album_id = album.a_id and a_category_id=ca_id group by a_category_id ORDER BY a_category_id ASC");          
            while($row = mysqli_fetch_assoc($num_result)) 
            {
                if($row['a_category_id']==$category && isset($category))
                {
                    echo "<a href='list.php?category=".$row['a_category_id']."' class='active'>".$row['ca_name']."</a><span class='num'>".$row['num']."</span></li>";
                }
                else
                {
                    echo "<a href='list.php?category=".$row['a_category_id']."'>".$row['ca_name']."</a><span class='num'>".$row['num']."</span></li>";                
                }
            }
        ?>
    </div>
    

	<div class="search">
        <div class="search-result">
        	<p>共有&nbsp;<?php  if(empty($photo_num_result['num'])) echo "0";else echo $photo_num_result['num'];?>&nbsp;张图片，&nbsp;<?php if(empty($album_num_result['num'])) echo "0";else echo $album_num_result['num'];?>&nbsp;个图册，现在是第<?php echo $page;?>页，共<?php echo $page_num;?>页。</p>
        </div>
        
        <div class="index">
        	<span>顺序：</span>
            <a href="#">热度</a>
            <a href="#">时间</a>
        </div>
        
        <div class="clear"></div>
    </div>

    <div class="result">
         <?php 
            display_photo_box($conn,$photo_result);
        ?>
    	  
  	<div class="clear"></div>

    </div>   
</div>
    <ul class="page-btn">
        <?php 
            for($i=1;$i<=$page_num;$i++)
            {
                if($i==$page)
                    echo "<li><a href='list.php?page=".$i."' class='active'>".$i."</a><li>";
                else
                    echo "<li><a href='list.php?page=".$i."'>".$i."</a><li>";
            }

        ?>
    </ul>
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
<script src='js/jquery-1.8.3.min.js'></script>
<script src='js/images.js'></script>
</body>
</html>
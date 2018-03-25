<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

    $keywords = $_GET['keywords'];
    $page = $_GET['page'];

    if(empty($page))
    {
        $page=1;
    }

    $type = $_GET['type'];
    if(empty($type))
    {
         $result = mysqli_query($conn,"select * from photo where p_album_id in(select a_id from album where a_des like '%".$keywords."%' or a_name like '%".$keywords."%') or p_des like '%".$keywords."%' limit ".(20*($page-1)).",20");        
    }
    else
    {
        if($type="album")
        {
            $result = mysqli_query($conn,"select * from album where a_des like '%".$keywords."%' or a_name like '%".$keywords."%' limit ".(20*($page-1)).",20");                
        }
        else
        {
            go_to_404();
        }        
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>搜索结果 - 美图册</title>
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
            <input type="text" name="keywords" class="search-text" placeholder="输入搜索关键字..." value="<?php echo $keywords; ?>"/>
            <input type="submit" class="search-btn" value=""/>
        </form>
        
        <div class="user-btn">
            <?php 
                show_header_btn($username,$nickname);
            ?>
        </div>
    </div>
</div>
    <?php
        $photo_result_num = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo where p_album_id in(select a_id from album where a_des like '%".$keywords."%' or a_name like '%".$keywords."%') or p_des like '%".$keywords."%'"));
        $album_result_num = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from album where a_des like '%".$keywords."%' or a_name like '%".$keywords."%'"));
    ?>
<div class="main-wrapper">
	<div class="category-box">
    	<span>对象：</span><a href='./search.php?keywords=<?php echo $keywords."'"; if(empty($type)) echo " class='active'";?>">图片<span class="num"><?php ;echo $photo_result_num['num']?></span></a><a href="./search.php?type=album&keywords=<?php echo $keywords."\"";if(!empty($type)) echo " class='active'";?> >图册<span class="num"><?php echo $album_result_num['num'];?></span></a>
    </div>

	<div class="search">
        <?php
            if($type=='album')
                $page_num = ceil($album_result_num['num']/20);
            else
                $page_num = ceil($photo_result_num['num']/20);
        ?>
        <div class="search-result">
        	<p>搜索“<?php echo $keywords; ?>”，共有<?php ;echo $photo_result_num['num']?>张图片，<?php echo $album_result_num['num'];?>个相册。现在是第<?php echo $page;?>页，共有<?php echo $page_num;?>页。</p>
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
            if(empty($type))
                display_photo_box($conn,$result);

            if($type="album")
                display_album_box($conn,$result);
        ?>
       
    </div>
    
  	<div class="clear"></div>
    <ul class="page-btn">
        <?php
            if(type=="album")
                $url = "search.php?type=album&keywords=".$keywords;
            else
                $url = "search.php?keywords=".$keywords; 

            for($i=1;$i<=$page_num;$i++)
            {
                if($i==$page)
                    echo "<li><a href='".$url."&page=".$i."' class='active'>".$i."</a><li>";
                else
                    echo "<li><a href='".$url."&page=".$i."'>".$i."</a><li>";
            }

        ?>
    </ul> 
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
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/images.js"></script>
</body>
</html>
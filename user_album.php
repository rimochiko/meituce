<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

    $get_id = $_GET['id'];
    if(empty($get_id))
    {
        if($username)
        {
            go_to_page("./user_album.php?id=".$username,"");
            exit();
        }
        go_to_404();
        exit;
    }  

    $page = $_GET['page'];

    if(empty($page))
    {
        $page=1;
    }

    $query = "select * from user where u_id = '".$get_id."'";
    $info = mysqli_fetch_assoc(mysqli_query($conn,$query));  

    if(empty($info))
    {
        go_to_404();
        exit;
    }  
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $info['u_nickname'] ?>的图册 - 美图册</title>
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

<div class="self-wrapper">
	<div class="self-banner">
    	<img src="images/8.jpg"/>
       
    </div>
    <div class="self-info">
    	<div class="self-head-image">
            <img src='<?php if(empty($info['u_head_image'])) echo "images/default.jpg'"; else echo "photo/user_avatar/".$get_id.".jpg";?>'/>
        </div>
        <?php
            if($username)
            {
                echo "<div class='add-btn'><a class='follow-btn' id='btn_upload_photo'>上传图片</a><a class='follow-btn' id='btn_build_album'>创建图册</a></div>";
            }    
        ?>

    <?php 
        $query = "select count(*) as num from photo where p_user_id='".$get_id."'";
        $photo_num = get_sql_result($conn,$query);

        $query = "select count(*) as num from album where a_user_id='".$get_id."'";
        $album_num = get_sql_result($conn,$query);

        $query = "select count(*) as num from add_like where l_user_id='".$get_id."'";
        $like_num = get_sql_result($conn,$query);
    ?>

        <div class="self-detail">
            <h1><?php echo $info['u_nickname']; ?></h1>
            <p id="self-describe"><?php if(isset($row['u_introduction'])) echo $row['u_introduction']; else echo "主人比较懒~还未填写任何介绍哦~"; ?></p>
            <p id="self-follow"><?php echo $like_num['num'];?>次被喜欢&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $photo_num['num'];?>个收集&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $album_num['num'];?>个相册&nbsp;&nbsp;&nbsp;&nbsp;<span class="icon-location2"></span><?php if(empty($row['u_location']))echo "未知的星球";else echo $row['u_location'];?></p>
        </div>
    </div>

     <?php 
        $query = "select count(*) as num from photo where p_user_id='".$get_id."'";
        $photo_num = get_sql_result($conn,$query);

        $query = "select count(*) as num from album where a_user_id='".$get_id."'";
        $album_num = get_sql_result($conn,$query);
    ?>

    <div class="self-menu">
    <ul>
        <li><a href="user.php?id=<?php echo $get_id ?>" ><span class="icon-image"></span>图片（<?php echo $photo_num['num'];?>）</a></li>
        <li><a href="user_album.php?id=<?php echo $get_id ?>" class="active"><span class="icon-images"></span>图册（<?php echo $album_num['num'];?>）</a></li>
        </ul>
    </div>

	<div class="result">
         <?php 
            $user_album = mysqli_query($conn,"select * from album where a_user_id='".$get_id."'");
            display_album_box($conn,$user_album)
        ?>       
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

<div class="upload-image tip-buble" id="upload-image">
    <form class='upload-box tip-buble-box center' method="post" action="user/upload.php" enctype="multipart/form-data">
        <h1>上传图片</h1>
        <a class='close-btn' onclick='closeLoadPhoto()'></a>
        <table>
            <tr>
                <td>选择图片</td>
                <td><input type="file" id="file-upload" name="file-upload" onchange="photoPreview(this)"  accept="image/gif, image/jpeg, image/jpg,image/png,image/bmp"/><div id="file-btn" onclick="document.getElementById('file-upload').click()"/></td>
                <td><span>*选择上传图片</span></td>
            </tr>
            <tr>
                <td>选择图册</td>
                <td><select name='photo_select_album'>
                    <?
                        $query = "select * from album where a_user_id ='".$username."'";
                        $album_result = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_assoc($album_result)) 
                        {
                            echo "<option value='".$row['a_id']."'>".$row['a_name']."</option>";
                        }                        
                    ?>
                    </select>
                </td>
                <td><span>*选择一个图册</span></td>
            </tr>
            <tr>
                <td>一句话描述</td><td><textarea name="photo_des"></textarea></td>
                <td><span>*输入图片描述</span></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="confirm-btn" value="上传图片"></td>
            </tr>
        </table>
    </form>
</div>

<div id="build-album" class="build-album tip-buble">
    <form class='tip-buble-box new-album-box center' action="user/build_album.php" method="post">
        <a class='close-btn' onclick='closeNewAlbum()'></a>
        <h1>新建图册</h1>
        <table>
            <tr>
                <td>图册名字</td>
                <td><input type='text' name="new_album_title"></td>
                <td><span>*输入相册名字</span></td>
            </tr>
            <tr>
                <td>图册分类</td>
                <td><select name="new_album_category">
                    <?php
                        show_select_category($conn);
                    ?>                    
                    </select>

                </td>
                <td><span>*选择相册分类</span></td>
            </tr>
            <tr>
                <td>图册简介</td>
                <td><textarea name="new_album_des"></textarea></td>
                <td><span>输入相册描述</span></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class='confirm-btn' value="确认新建"/></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/images.js"></script>
<script src="js/show.js"></script>
</body>
</html>
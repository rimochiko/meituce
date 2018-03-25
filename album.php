<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

    $album_id = $_GET['id'];
    if(!isset($album_id))
    {
        go_to_page('./search.php?type=album&keywords=');      
        exit; 
    }

    $page = $_GET['page'];

    if(empty($page))
    {
        $page=1;
    }

    $album_result = mysqli_fetch_assoc(mysqli_query($conn,"select * from album where a_id=".$album_id));

    if(empty($album_result))
    {
        go_to_404();
    }
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $album_result['a_name'];?> - 图册全部图片 - 美图册</title>
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
	<div class="main-album-info">
        <?php
            if(empty($album_result['a_cover_photo']))
                $cover_url  = "images/default_album.jpg";
            else
            {
                $cover_url = get_album_cover($conn,$album_result['a_id']);
                $cover_url  = "photo/".$cover_url['p_url'];
            }
        ?>
    	<div class="album-face" style="background-image:url(<?php echo $cover_url;?>)">
        </div>
        
        <div class="album-detail">
            <p id="album_id" style="display:none"><?php echo $album_id;?></p>
    		<p><span>图册名称：</span><?php echo $album_result['a_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>创建人：</span><a href="./user.php?id=<?php echo $album_result['a_user_id'];?>"><?php  $name=get_user_info($conn,$album_result['a_user_id']);echo $name['u_nickname'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>创建时间：</span><?php echo substr($album_result['a_time'],0,10);?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;图册类型：</span><?php $ca=get_ca_name($conn,$album_result['a_category_id']);echo $ca['ca_name'];?></p>
            <p><span>图册描述：</span><?php echo $album_result['a_des'];?></p>
        </div>
        
        <?php 
            if(isset($username))
            echo  "<div class='album-btn'><a class='confirm-btn' id='btn_update_album'>编辑图册</a> <a href='#' class='confirm-btn' id='btn_delete_album'>删除图册</a></div>";
        ?>

        <div class="clear"></div>
    </div>

	<div class="search">
    <?php
        $num = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo where p_album_id=".$album_result['a_id']." limit ".(10*($page-1)).",10"));
    ?>
        <div class="search-result">
        	<p>共有<?php echo $num['num'];$page_num=ceil($num['num']/10);?>个采集</p>
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
            $query = "select * from photo where p_album_id='".$album_id."'";
            $photo_result =  mysqli_query($conn, $query);            
            display_photo_on_album($username,$conn,$photo_result);
        ?>            
 
    </div>
    
  	<div class="clear"></div>
    <ul class="page-btn">
     <?php 
        for($i=1;$i<=$page_num;$i++)
        {
            if($i==$page)
                echo "<li><a href='album.php?id=".$album_id."&page=".$i."' class='active'>".$i."</a><li>";
            else
                echo "<li><a href='album.php?id=".$$album_id."&page=".$i."'>".$i."</a><li>";
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

<div class="tip-buble" id="update-album">
    <div class="tip-buble-box center">
        <a class='close-btn' onclick='closeUpdateAlbum()'></a>
        <h1>编辑图册</h1>
        <table>
            <tr style="display:none;">
                <td>图册</td>
                <td><input type='text' name="update_album_id" value="<?php echo $album_id;?>" disabled="disabled"/></td>
                <td></td>
            </tr>
            <tr>
                <td>图册名字</td>
                <td><input type='text' name="update_album_title" value="<?php echo $album_result['a_name'];?>"></td>
                <td><span>*输入相册名字</span></td>
            </tr>
            <tr>
                <td>图册分类</td>
                <td><select name="update_album_category">
                    <?php
                        show_edit_catogory($conn);
                    ?>                    
                </select>
                </td>
                <td><span>*选择相册分类</span></td>
            </tr>
            <tr>
                <td>图册简介</td>
                <td><textarea name="update_album_des"><?php echo $album_result['a_describe'];?></textarea></td>
                <td><span>输入相册描述</span></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class='confirm-btn' value="确认修改" id="yes-update"/></td>
                <td></td>
            </tr>
        </table>        
    </div>
</div>

<div class="tip-buble" id="delete-album">
    <div class="tip-buble-box center">
        <a class='close-btn' onclick='closeDeleteAlbum()'></a>
        <h1>删除图册</h1>
        <table>
            <tr style="display:none;">
                <td>图册</td>
                <td><input type='text' name="delete_album_id" value="<?php echo $album_id;?>"/></td>
                <td><span>*逗号隔开填写标签</span></td>
            </tr>
            <tr>
                <td></td>
                <td>您真的要删除该图册吗?</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" class='confirm-btn' id="yes-delete" value="确认"></a></td>
                <td><input type="button" class='confirm-btn' id="cancel" value="取消" onclick='closeDeleteAlbum()'/></td>
            </tr>
        </table>       
    </div>
</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/images.js"></script>
<script src="js/show.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".be-cover").click(function(){
        $str = $(this).parent().parent().prev().attr('href').split('=');
        console.log($str);
        html = $.post("user/update_album.php",{
            update_album_id:$("#album_id").html(),
            cover_id:$str[$str.length-1]
        },
            function(data){
                if(data=='ok')
                {
                    alert("设置成功");
                    history.go(0);
                }  
                else
                {
                    alert(data);
                }      
        });

    });
    $("#yes-update").click(function(){
        html = $.post("user/update_album.php",{
            update_album_id:$("#album_id").html(),
            update_album_title:$("input[name='update_album_title']").val(),
            update_album_category:$("select[name='update_album_category']").val(),
            //如果用textarea会有bug
            update_album_des:$("textarea[name='update_album_des']").val()
        },function(data){
            if(data=='ok')
            {
                alert("修改成功");
                history.go(0);
            }
            else
            {
                alert(data);
            }
        });

    });

    $("#yes-delete").click(function(){
        if($(".result").html().trim())
        {
            alert("不能删除有图片的相册");
            return;
        }
        else
        {   
            html = $.post("user/delete_album.php",{
                delete_album_id:$("input[name='delete_album_id']").val()
            },function(data){
                if(data=='ok')
                {
                    alert("删除成功");
                    window.location.href="./user_album.php";
                }
                else
                {
                    alert(data);
                }
            });            
        }
    });
});
</script>
</body>
</html>
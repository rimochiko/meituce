<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";
    $photo_id = $_GET['id'];

    if(!isset($photo_id))
    {
        go_to_page("list.php");
    }

    //获取图片
    $photo_info = mysqli_fetch_assoc(mysqli_query($conn,"select * from photo where p_id =".$photo_id));

    if(empty($photo_info))
    {
       go_to_404(); 
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $photo_info['p_des'];?> - 美图册</title>
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
	<div class="left">
    	<a class="user-info" href="./user.php?id=<?php echo $photo_info['p_pick_user']; ?>">
            <?php
                $photo_user = mysqli_fetch_assoc(mysqli_query($conn,"select u_nickname,u_head_image from user where u_id ='".$photo_info['p_user_id']."'"));     
             ?>     	
            <div class="user-image">
                <span id="image_id" style="display:none;"><?php echo $photo_id;?></span>
            	<img src="<?php if($photo_user['u_head_image']) echo "photo/user_avatar/".$photo_info['p_user_id'];else echo "images/default"?>.jpg"/>
            </div>
            <div class="user-detail">
            	<p><?php echo $photo_user['u_nickname'];?></p>
            </div>
        </a>
        
    	<div class="choose-menu">
            <?php 
                if(isset($username) && ($username != $photo_info['p_user_id']))
                {
                    echo "<a id='btn_add_photo'><span class='icon-star-full'></span>采集</a>";
                    $result = mysqli_fetch_assoc(mysqli_query($conn,"select * from add_like where l_user_id='".$username."' and l_photo_id = ".$photo_id));
                    
                    if(empty($result))
                    {
                        echo "<a id='btn_like_photo'><span class='icon-heart'></span>喜欢</a>";
                    }
                    else
                    {
                        echo "<a id='btn_like_photo' class='enable'><span class='icon-heart'></span>喜欢</a>";
                    }
                }

                if(isset($username) && ($username == $photo_info['p_user_id']))
                {
                    echo "<a id='btn_delete_photo'><span class='icon-bin'></span>删除</a><a id='btn_update_photo'><span class='icon-pencil'></span>修改</a>";
                }
            ?>
            <a id="btn_show_photo"><span class="icon-zoom-in"></span>查看大图</a>
        </div>
        
        <div class="clear"></div>
        <a class="photo-box">
        	<img src="photo/<?php  echo $photo_info['p_url'];?>"/>
        </a>
        
        <?php 
            $pick_num = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo where p_from_photo = ".$photo_id));
        ?>
        <div class="photo-detail">
            <p class="photo-info">收到喜欢<span id="like-num"><?php echo get_like_num($conn,$photo_info['p_id']);?></span>次&nbsp;&nbsp;|&nbsp;&nbsp;<?php if($photo_info['p_from_photo']) { $info = get_sql_result($conn,"select u_id,u_nickname from user where u_id =(select p_user_id from photo where p_id=".$photo_info['p_from_photo'].")");echo "原上传者&nbsp;<a href='./user.php?id=".$info['u_id']."'>".$info['u_nickname']."</a>&nbsp;|&nbsp;采集于&nbsp;";}else echo "被采集<span id='like-num'>".$pick_num['num']."</span>次&nbsp;&nbsp;|&nbsp;上传于&nbsp;";?>&nbsp;<?php echo $photo_info['p_time'];?></p>
        	<p class="photo-describe"><?php echo $photo_info['p_des'];?></p>
        </div>
    </div>
    
    <div class="right">

        <?php
            $query ="select count(*) as num from comment where c_photo_id=".$photo_id;
            $co_num = mysqli_fetch_assoc(mysqli_query($conn,$query));

            $query ="select * from comment where c_photo_id=".$photo_id;
            $co_result = mysqli_query($conn,$query);
        ?>
    	<p class="title">全部评论（<?php echo $co_num['num'] ;?>条）</p>
    	<div class="comment-box"> 
            <?php 
                while($row = mysqli_fetch_assoc($co_result))
                {
                    $c_name = get_user_info($conn,$row['c_user_id']);
                    echo "<div class='comment-detail'><div class='comment-time'>";
                    echo "<a href='./user.php?id=".$row['c_user_id']."'>".$c_name['u_nickname']."</a><span>".$row['c_time']."说：</span></div>";
                    echo "<div class='comment-content'><p>".$row['c_content']."</p></div></div>";
                }
            ?>            
        </div>
    	<form class="write-comment">
        	<p class="title">我要评论</p>
            <?php 
                if(!isset($username)) 
                    echo "<textarea placeholder='先登录再评论...' id='ta_write_comment' disabled='disabled'></textarea>";
                else 
                    echo "<textarea placeholder='写下您的评论...' id='ta_write_comment'></textarea><input type='button' value='添加评论' id='add_comment'/>";
            ?>

            
        </form>
    </div>
        
    <div class="clear"></div>
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

<div class="tip-buble delete-photo" id="delete-photo">
    <form class="tip-buble-box delete-box center" method="post" action="user/delete.php" id="delete-box">
        <h1>删除</h1>
        <a onclick='closeDeleteShow()' class='close-btn'></a>
        <table>
            <tr>
                <td></td>
                <td>您真的要删除图片吗?</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" class='confirm-btn' id="yes_delete" value="确认"></a></td>
                <td><input type="button" class='confirm-btn' id="cancel" value="取消" onclick='closeDeleteShow()'/></td>
            </tr>
        </table>
    </form>
</div>

<div class="tip-buble update-photo" id="update-photo">
    <form class="tip-buble-box update-box center" method="post" action="user/update.php" id="update-box">
        <h1>修改</h1>
        <a onclick='closeUpdateShow()' class='close-btn'></a>
        <table>
            <tr>
                <td>选择图册</td>
                <td><select name="update_photo_album" value="<?php echo $photo_info['p_album']; ?>">
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
                <td>一句话描述</td><td><textarea name="update_photo_des"><?php echo $photo_info['p_describe'];?></textarea></td>
                <td><span>*输入图片描述</span></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" class="confirm-btn" value="确认" id="yes_update"/></td>
                <td><input type="button" class="confirm-btn" value="取消" onclick="closeUpdateShow()"/></td>
            </tr>
        </table>
    </form>
</div>

<div class="tip-buble show-pick" id="show-pick">
    <form class='tip-buble-box pick-box center' id="pick-form" method="post" action="./pick.php">
        <h1>采集</h1>
        <a onclick='closePickShow()' class='close-btn'></a>
        <table>
            <tr>
                <td>选择图册</td>
                <td>
                    <select name="pick_album">
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
                <td>
                    <span>*选择一个自己的图册</span>
                </td>
            </tr>
            <tr>
                <td>一句话描述</td>
                <td><textarea name="pick_des"></textarea></td>
                <td><span>*逗号隔开填写标签</span></td>
            </tr>
            <tr>
                <td></td>
                <td><a class='confirm-btn' id="yes_pick">确认采集</a></td>
            </tr>
        </table>
    </form>
</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/show.js"></script>
<script>
$(document).ready(function(){
    $("#btn_like_photo").click(function(){
        if($(this).hasClass("enable"))
        {
            html = $.post("user/dislike_photo.php",{
                photo_id:$("#image_id").html().trim()
                },function(data){
                if(data='ok')
                {
                    $("#btn_like_photo").removeClass("enable");
                    var num = parseInt($("#like-num").html());
                    $("#like-num").html(num-1);
                }
                else
                {
                    alert("取消失败");
                }
            }); 
        }
        else
        {
            html = $.post("user/like_photo.php",{
                photo_id:$("#image_id").html().trim()
                },function(data){
                if(data='ok')
                {
                    $("#btn_like_photo").addClass("enable");
                    var num = parseInt($("#like-num").html());
                    console.log(num+1);
                    $("#like-num").html(num+1);

                }
                else
                {
                    alert("喜欢失败");
                }
            }); 
        }

    });

    $("#yes_pick").click(function(){
        html = $.post("user/pick.php",{
                pick_photo_id:$("#image_id").html().trim(),
                pick_album:$("select[name='pick_album']").val(),
                pick_des:$("textarea[name='pick_des']").val()
            },function(data){
                if (data=='ok') 
                {
                    alert("采集成功");
                    $("#show-pick").fadeOut();   
                    var num = parseInt($("#pick-num").html());
                    $("#pick-num").html(num+1);
                 
                }
                else
                {
                    alert("采集失败");
                    var num = parseInt($("#pick-num").html());
                    $("#pick-num").html(num-1);
                }

            }  
        );
    });

    $("#yes_delete").click(function(){
         html = $.post("user/delete_photo.php",{
                delete_photo_id:$("#image_id").html().trim()
            },function(data){
                if (data=='ok') 
                {
                    alert("删除成功");
                    window.location.href = './list.php';
                }
                else
                {
                    alert(data);
                }
            }  
        );
    });


    $("#yes_update").click(function(){
         html = $.post("user/update_photo.php",{
                update_photo_id:$("#image_id").html().trim(),
                update_photo_album:$("select[name='update_photo_album']").val(),
                update_photo_des:$("textarea[name='update_photo_des']").val()                
            },function(data){
                if (data=='ok') 
                {
                    alert("修改成功");
                    window.location.href="./photo.php?id="+$("#image_id").html().trim();
                }
                else
                {
                    alert(data);
                }
            }  
        );
    });

    $("#add_comment").click(function(){
        $content = $("#ta_write_comment").val();
        if(!$content)
        {
            alert("请填写评论");
            return;
        }

        html = $.post('user/add_comment.php',
            {
                id:$("#image_id").html().trim(),
                content:$content,
            },
            function(data){
                if(data=='ok')
                {
                    alert("评论成功");
                    window.location.reload();
                }
                else
                {
                    alert(data);
                }
            });
    });
});
</script>
</body>
</html>
<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

    is_login($username);

    $info = mysqli_fetch_assoc(mysqli_query($conn,"select * from user where u_id='".$username."'"));
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>个人设置 - 美图册</title>
	<link rel="stylesheet" href="./css/common.css"/>
	<link rel="stylesheet" href="./css/style.css"/>
    <link rel="stylesheet" href="./css/jquery.Jcrop.min.css"/>
    <style type="text/css">
#imghead{max-width:400px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=image);}
</style>
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
	<div class="self-set">
    	<h1>个人设置</h1>
        <form action="user/set_user_info.php" method="post">
        	<table>
            	<tr>
                	<td><p>账号</p></td>
                    <td id="username"><?php echo $username; ?></td>
                    <td><span class="tips">*账号不能更改</span></td>
                </tr>
            	<tr>
                	<td><p>昵称</p></td>
                    <td><input type="text" name="nickname" value="<?php echo $nickname ?>"/></td>
                    <td><span class="tips">*昵称应该在十个字符以内</span></td>
                </tr>
            	<tr>
                	<td><p>性别</p></td>
                    <td><?php if($info['u_sex']=='男') echo "<input type='radio' name='sex' checked='checked' value='male'/><span>男</span><input type='radio' name='sex' value='female'/><span>女</span>"; else echo "<input type='radio' name='sex'/><span>男</span><input type='radio' name='sex' checked='checked'/><span>女</span>"?></td>
                    <td><span class="tips">*默认性别为男</span></td>
                </tr>
            	<tr>
                	<td><p>所在地</p></td>
                    <td><input type="text" value="<?php echo $info['u_location'];?> " name="location"/></td>
                    <td><span class="tips">请填写一个地区</span></td>
                </tr>
            	<tr>
                	<td><p>个人简介</p></td>
                    <td><textarea name="describe"><?php echo $info['u_des']; ?></textarea></td>
                    <td><span class="tips">最多50字</span></td>
                </tr>
            	<tr>
                	<td></td>
                    <td><input type="submit" class="confirm-btn"/></td>
                    <td></td>
                </tr>
            </table>
        </form>

        <h1>头像设置</h1>
        <form action="user/change_head_image.php" method="post" onsubmit="return checkCoords();">
            <input type="text" id="x" name="x" style="display:none;"/>
            <input type="text" id="y" name="y" style="display:none;"/>
            <input type="text" id="w" name="w" style="display:none;"/>
            <input type="text" id="h" name="h" style="display:none;"/>
            <table> 
                <tr>
                    <td>选择图片</td>
                    <td>
                        <form id="avatar-form" enctype="multipart/form-data">
                            <input type="file" id="avatar-upload" name="avatar-upload" onchange="upload_image()" accept="image/jpg"/>
                        </form>
                    </td>
                    <td><span class="tips" id="upload_tip">*请选择jpg格式的图片</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div id="prevDiv"></div></td>
                    <td><span class="tips">*拖动划出截取区域</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="confirm-btn" value="提交"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.Jcrop.min.js"></script>
<script language="Javascript">
function updateCoords(c)
{
    jQuery('#x').val(c.x); //选中区域左上角横
    jQuery('#y').val(c.y); //选中区域左上角纵坐标
    //jQuery("#x2").val(c.x2); //选中区域右下角横坐标
    //jQuery("#y2").val(c.y2); //选中区域右下角纵坐标
    jQuery('#w').val(c.w); //选中区域的宽度
    jQuery('#h').val(c.h); //选中区域的高度
}

function checkCoords()
{
    if (parseInt(jQuery('#w').val())>0) return true;
    alert('请选择需要裁切的图片区域.');
    return false;
}

function upload_image()
{
    var form = new FormData();
    var type = $("#avatar-upload").val().split('.'); 

    if(type[type.length-1].toLowerCase()!='jpg')
    {
        alert("请选择jpg格式的图片。");
        $("#avatar-upload").val("");
        return;
    }
    form.append("file",$("#avatar-upload")[0].files[0]);



    $("#upload_tip").html("图片上传中...");
    $("#avatar-upload").attr("disabled","true");
    $.ajax({  
      url:"user/upload_image.php",  
      type:"post",  
      data:form,  
      cache: false,  
      processData: false,  
      contentType: false,  
      success:function(data){  
        if(data!='no')
        {
            $("#upload_tip").html("图片上传成功");
            $("#prevDiv").html("<img id='imghead' border=0 src='./photo/user_avatar/"+$("#username").html()+"."+data+"' />");
            document.getElementById('imghead').onload=function(){
                jQuery(function(){
                        jQuery('#imghead').Jcrop({
                        aspectRatio: 1,
                        onSelect: updateCoords, //选中区域时执行对应的回调函数
                        onChange: updateCoords, //选择区域变化时执行对应的回调函数
                    });
                });                
            }

        }
        else   
            $("#upload_tip").html("图片上传出错");
        $("#avatar-upload").attr("disabled","false");

      }
      });          
}
</script>
</body>
</html>
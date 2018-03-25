<?php

function go_to_page($url,$text)
{
    if(!empty($text))
    {
        echo "<script>alert('".$text."');</script>";
    }
    echo "<script>window.location.href='".$url."';</script>";

}

function go_to_404()
{
	header("Location: ./404.php");
	exit;
}

function is_login($username)
{
    if(!isset($username))
    {
        go_to_page("./login.php");
        exit;
    }       
}

//首页分类展示
function show_header_category($conn)
{
    $ca_result = mysqli_query($conn,"select * from category");
    while($row = mysqli_fetch_assoc($ca_result)) 
    {
        echo "<li><a href='list.php?category=".$row['ca_id']."'>".$row['ca_name']."</a></li>";
    }	
}

//头部操作按钮显示
function show_header_btn($username,$nickname)
{
    if($username)
    {
        echo "<a class='user-menu'>".$nickname."<span class='caret'></span><ul class='sub-nav'><li><a href='user.php?id=".$username."'>个人主页</a></li><li><a href='./self_set.php'>账号设置</a></li><li><a href='loginout.php'>退出登录</a></li></ul></a>";
    }
    else
    {
        echo "<a href='./login.php' class='login'>登录</a><a href='./register.php' class='register'>注册</a>";
    }	
}

//显示select的图片分类??
function show_select_category($conn)
{
    $query = "select * from category";
    $ca_result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($ca_result)) 
    {
        if($photo_info['p_category'] == $row['ca_id'])                            
            echo "<option value='".$row['ca_id']."' selected='selected'>".$row['ca_name']."</option>";
        else
            echo "<option value='".$row['ca_id']."'>".$row['ca_name']."</option>";
    }                                
}

//显示编辑图片分类
function show_edit_catogory($conn)
{
    $query = "select * from category";
    $ca_result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($ca_result)) 
    {
        if($row == $album_result['a_category_id'])
            echo "<option value='".$row['ca_id']."' selected='selected'>".$row['ca_name']."</option>";
        else 
            echo "<option value='".$row['ca_id']."'>".$row['ca_name']."</option>";
    }    
}

//查询该分类是否存在
function check_category_exist($conn,$category)
{
    $category_result = mysqli_fetch_assoc(mysqli_query($conn,"select * from category where ca_id=".$category));
    if(isset($category_result))
    {
        return true;
    }
    return false;
}

//输出图片列表
function display_photo_box($conn,$result)
{
    while($row = mysqli_fetch_assoc($result))
    {
      if(!get_user_status($conn,$row['p_user_id']))
      continue;
        $p_username = get_user_info($conn,$row['p_user_id']);
        $p_album = get_album_info($conn,$row['p_album_id']);
        $p_comment = get_comment_num($conn,$row['p_id']);
        $like_num = get_like_num($conn,$row['p_id']);
        $pick_num = get_pick_num($conn,$row['p_id']);

    echo "<div class='photo-box'>";
    echo "<a class='photo' href='./photo.php?id=".$row['p_id']."'><img src='photo/".$row['p_url']."'/></a>";
    echo "<div class='photo-info'><p>".$row['p_des']."</p>";
    echo "<div class='photo-info-detail'><p><span class='icon-heart'></span>".$like_num."</p><p><span class='icon-bubbles'></span>".$p_comment['num']."</p>";
    if(!isset($row['p_from_photo']))
        echo "<p><span class='icon-folder-plus'></span>".$pick_num['num']."</p>";
    echo "</div><div class='clear'></div></div><div class='user-info'>";
    echo "<a class='user-image' href='./user.php?id=".$p_username['u_id']."'><img src='";
    if(empty($p_username['u_head_image'])) echo "images/default.jpg'"; 
    else echo "photo/user_avatar/".$p_username['u_id'].".jpg";
    echo "'/></a><div class='user-detail'><a href='user?id=".$row['p_user_id']."'>".$p_username['u_nickname'];
    if(!isset($row['p_from_photo']))
        echo "</a>上传到</br>";
    else
        echo "</a>采集到</br>";
    echo "<a href='album.php?id=".$row['p_album_id']."'>".$p_album['a_name']."</a>";
    echo "</div><div class='clear'></div></div></div>";      
    }  
}

function display_photo_on_album($username,$conn,$result)
{
    while($row = mysqli_fetch_assoc($result))
    {
        if(!get_user_status($conn,$row['p_user_id']))
            continue;
        $p_username = get_user_info($conn,$row['p_user_id']);
        $p_album = get_album_info($conn,$row['p_album_id']);
        $p_comment = get_comment_num($conn,$row['p_id']);
        $like_num = get_like_num($conn,$row['p_id']);
        $pick_num = get_pick_num($conn,$row['p_id']);

        echo "<div class='photo-box'>";
        echo "<a class='photo' href='./photo.php?id=".$row['p_id']."'><img src='photo/".$row['p_url']."'/></a>";
        echo "<div class='photo-info'><p>".$row['p_des']."</p>";
        echo "<div class='photo-info-detail'><p><span class='icon-heart'></span>".$like_num."</p><p><span class='icon-bubbles'></span>".$p_comment['num']."</p><p><span class='icon-folder-plus'></span>".$pick_num['num']."</p>";
        if($username==$row['p_user_id'])
            echo "<a class='be-cover'><span class='icon-home3'></span>设为封面</a>";
        echo "</div><div class='clear'></div></div><div class='user-info'>";
        echo "<a class='user-image' href='./user.php?id=".$p_username['u_id']."'><img src='";
        if(empty($p_username['u_head_image'])) echo "images/default.jpg'"; 
        else echo "photo/user_avatar/".$p_username['u_id'].".jpg";
        echo "'/></a><div class='user-detail'><a href='user?id=".$row['p_pick_user']."'>".$p_username['u_nickname'];
        if($row['p_is_self'])
            echo "</a>上传到</br>";
        else
            echo "</a>采集到</br>";
        echo "<a href='album.php?id=".$row['p_album_id']."'>".$p_album['a_name']."</a>";
        echo "</div><div class='clear'></div></div></div>";      
    }
}

//输出相册列表
function display_album_box($conn,$result)
{         
    while($row = mysqli_fetch_assoc($result))
    {
        if(!get_user_status($conn,$row['a_user_id']))
           continue;
        echo "<a class='album-box' href='album.php?id=".$row['a_id']."'>";
        echo "<div class='album-face' style='background-image:url(";
        if(empty($row['a_cover_photo']))
            echo "./images/default_album.jpg";
        else 
        {
            $cover_url = mysqli_fetch_assoc(mysqli_query($conn,"select p_url from photo where p_id=(select a_cover_photo from album where a_id = ".$row['a_id'].")"));
            echo "./photo/".$cover_url['p_url'];
        }
        echo ")'></div><div class='album-info'><p>".$row['a_name']."</p></div></a>";     
    }    
}

/*SQL获取数据*/
//返回结果
function get_sql_result($conn,$sql)
{
    return mysqli_fetch_assoc(mysqli_query($conn,$sql));
}
//用户ID -> 用户ID，昵称和头像
function get_user_info($conn,$id)
{
   $info = mysqli_fetch_assoc(mysqli_query($conn,"select u_id,u_nickname,u_head_image from user where u_id='".$id."'"));    
   return $info;
}

//用户ID -> 用户ID，昵称和头像
function get_user_status($conn,$id)
{
   $info = mysqli_fetch_assoc(mysqli_query($conn,"select u_status from user where u_id='".$id."'"));    
   return $info['u_status'];
}

//图册ID -> 图册名称
function get_album_info($conn,$id)
{
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select a_name from album where a_id=".$id));
    return $info;
}

//图片ID -> 图片评论数量
function get_comment_num($conn,$id)
{
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from comment where c_photo_id =".$id));
    return $info;
}

//图片ID -> 返回喜欢数量
function get_like_num($conn,$id)
{
    $num=0;
    //看是否有被采集，是则计算采集后被点赞的总数
    $info = mysqli_query($conn,"select p_id from photo where p_from_photo=".$id);
    while($row = mysqli_fetch_assoc($info))
    {
        $ex = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from add_like where l_photo_id = ".$row['p_id']));
        $num+=$ex['num'];
    }
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from add_like where l_photo_id = ".$id));
    $num+=$info['num'];
    

    return $num;
}

//图片ID -> 返回采集数量
function get_pick_num($conn,$id)
{
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo where p_from_photo = ".$id));
    return $info;
}

//相册ID -> 相册封面
function get_album_cover($conn,$id)
{
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select p_url from photo where p_id=(select a_cover_photo from album where a_id = ".$id.")"));
    return $info;    
}

//类别ID -> 类别名
function get_ca_name($conn,$id)
{
    $info = mysqli_fetch_assoc(mysqli_query($conn,"select ca_name from category where ca_id=".$id));
    return $info;    
}

?>
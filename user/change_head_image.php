<?php
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php"; 
    header("Content-type: text/html; charset=utf-8");

    is_login($username);

   	$targ_w = $targ_h = 150;
    $jpeg_quality = 90;
    $src = '../photo/user_avatar/'.$username.'.jpg';
    $img_r = imagecreatefromjpeg($src);
    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
    imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
    $targ_w,$targ_h,$_POST['w'],$_POST['h']);
    imagejpeg($dst_r,'../photo/user_avatar/'.$username.'.jpg',$jpeg_quality);
    $query = "update user set u_head_image =1 where u_id='".$username."'";

    if(mysqli_query($conn,$query))
    	go_to_page("../self_set.php","头像修改成功");
    else
        go_to_page("../self_set.php","头像修改失败");	
?>
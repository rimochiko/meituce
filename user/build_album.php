<?php 
	include "../include/conn.php";
    include "../include/session_start.php";
    include "../include/functions.php";

	is_login($username);
	$new_album_title = $_POST['new_album_title'];
	$new_album_category = $_POST['new_album_category'];
	$new_album_des = $_POST['new_album_des'];

	if(empty($new_album_category) || empty($new_album_title))
	{
        echo "<script>alert('信息填写不完整');window.location.href='./user.php';</script>";
        exit;		
	} 

	$query = "insert into album(a_name,a_user_id,a_category_id,a_time,a_des) values('".$new_album_title."','".$username."',".$new_album_category.",'".date("Y-m-d H:i:s")."','".$new_album_des."')";

	if(mysqli_query($conn,$query))
	{
		go_to_page("../user_album.php?id=".$username,"新建成功");
	}
	else
	{
        echo "<script>alert('新建失败');window.location.href='../user_album.php?id=".$username."';</script>";		
	}
?>
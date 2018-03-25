<?php
	include "../include/conn.php";
    include "../include/session_start.php";
    include "../include/functions.php";

	if(!$conn)
	{
		session_destroy();
		go_to_page("../login.php","数据库连接失败");
		exit;		
	}

   	$username = $_POST['login_id'];
	$password = $_POST['login_psw'];

	$query = "select * from user where u_id = '".$username."'and u_psw = '".sha1($password)."'";
	$row = mysqli_fetch_assoc(mysqli_query($conn,$query));

	if(empty($row))
	{ 
		session_destroy();
		go_to_page("../login.php","密码或者账号错误");
		exit;
	}
	else
	{
		$_SESSION['user_id'] = $username;
		$_SESSION['user_name'] = $row['u_nickname'];
		go_to_page("../index.php","");
		exit;	
	}
?>
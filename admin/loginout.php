<?php
	header("Content-type: text/html; charset=utf-8");
	session_start();
	$username = $_SESSION['valid_user'];

	unset($_SESSION['valid_user']);
	$result = session_destroy();

	if(!empty($username))
	{
		header("Location: ./login.html");
		//确保重定向后，后续代码不会被执行 
		exit;			
	}
	else
	{
		echo "<script>alert('不能退出')</script>";
	}
?>
<?php
	header("Content-type: text/html; charset=utf-8");
	$conn = @mysqli_connect("localhost","meituce","123456","meituce");
	session_start();

	if(!$conn)
	{
		//重定向浏览器 
		session_destroy();
		echo "<script>alert('数据库连接失败');window.location.href='./login.html';</script>";
		//确保重定向后，后续代码不会被执行 
		exit;		
	}

   	$username = $_POST['login_name'];
	$password = $_POST['login_psd'];

	$query = "select * from admin_user where username = '".$username."'and password = '".$password."'";
	$row = mysqli_fetch_assoc(mysqli_query($conn,$query));

	if(empty($row))
	{
		//重定向浏览器 
		session_destroy();
		echo "<script>alert('密码或者账号错误');window.location.href='./login.html';</script>";
		//确保重定向后，后续代码不会被执行 
		exit;
	}
	else
	{
		//重定向浏览器 
		$_SESSION['valid_user'] = $username;
		header("Location: ./index.php");
		//确保重定向后，后续代码不会被执行 
		exit;	
	}
?>
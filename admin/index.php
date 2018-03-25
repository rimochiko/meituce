<?php 
	session_start();
	if(!$_SESSION['valid_user'])
	{
		header("Location: ./login.html");
		exit;
	}
	$conn = @mysqli_connect("localhost","meituce","123456","meituce");
	$AllUserNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(u_id) from user"));
	$AllAlbumNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(a_id) from album"));
	$TodayUserNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(u_id) from user where u_reg_time like '%".date("Y-m-d")."%'"));
	$TodayAlbumNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(a_id) from album where a_time like '%".date("Y-m-d")."%'"));
	$AllPhotoNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(p_id) from photo"));
	$TodayPhotoNum = mysqli_fetch_assoc(mysqli_query($conn,"select count(p_id) from photo where p_time like '%".date("Y-m-d")."%'"));	
?>	
<!doctype html>
<head>
	<meta charset="UTF-8">
	<title>后台管理 - 美图册</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css"/>
</head>
<body>
	<div class="header">
		<div class="container">
		<div class="logo">
			<img src="../images/logo1.png"/>
		</div>
		<ul class="nav">
			<li><a href="./index.html" class="active">后台主页</a>
				<ul class="sub-nav">
					<li><a href="./admin.php">管理员设置</a></li>
					<li><a href="./help.php">帮助手册</a></li>
				</ul>
			</li>
			<li><a href="#">设置</a>
				<ul class="sub-nav">
					<li><a href="./basic_set.php">基本设置</a></li>
					<li><a href="./home_set.php">首页设置</a></li>
				</ul>
			</li>
			<li><a href="#">管理</a>
				<ul class="sub-nav">
					<li><a href="./user.php">用户</a></li>
					<li><a href="./photo.php">图片</a></li>
					<li><a href="./album.php">图册</a></li>
					<li><a href="./category.php">分类</a></li>
					<li><a href="./tag.php">标签</a></li>
				</ul>
			</li>
			<div class="clear"></div>
		</ul>

		<div class="admin">
			<a href="#"><?php echo $_SESSION['valid_user']; ?>欢迎您</a>
			<a href="loginOut.php">退出登录</a>
			<a href="../index.php" target="_blank">网站</a>
			<div class="clear"></div>
		</div>
		</div>
	</div>
	<div class="main container">
		<div class="site-simple-info">
			<h1 class="title">网站概要</h1>
			<p>目前有<span><?php echo $AllPhotoNum['count(p_id)'];?></span>张图片, <span><?php echo $AllAlbumNum['count(a_id)'];?></span>个图册，<span><?php echo $AllUserNum['count(u_id)'];?></span>个用户。</p>
			<p>点击下面的链接快速开始:</p>
			<a href="./basic_set.php">网站基本设置</a> <a href="#">网站帮助手册</a> <a href="#">账号设置</a>
		</div>

		<div class="site-simple-info">
			<h1 class="title">今日概要</h1>
			<p>今日新上传图片<span><?php echo $TodayPhotoNum['count(p_id)'];?></span>张，新建图册<span><?php echo $TodayAlbumNum['count(a_id)'];?></span>个，新注册用户<span><?php echo $TodayUserNum['count(u_id)'] ?></span>个。</p>
		</div>

		<div class="clear"></div>
	</div>
</body>
</html>
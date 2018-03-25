<?php 
	session_start();
	if(!$_SESSION['valid_user'])
	{
		header("Location: ./login.html");
		exit;
	}	
?>
<!doctype html>
<html>
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
			<p>目前有<span>32</span>张图片, <span>5</span>个图册，<span>10</span>个用户。</p>
			<p>点击下面的链接快速开始:</p>
			<a href="#">网站基本设置</a> <a href="#">网站帮助手册</a> <a href="#">账号设置</a>
		</div>

		<div class="site-simple-info">
			<h1 class="title">今日概要</h1>
			<p>今日新上传图片<span>3</span>张，新建图册<span>3</span>个，新注册用户<span>2</span>个。</p>
		</div>

		<div class="clear"></div>
	</div>
</body>
</html>
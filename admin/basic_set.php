<?php 
		session_start();
		if(!$_SESSION['valid_user'])
		{
			header("Location: ./login.html");
			exit;
		}	
?>
<!doctype html>
<head>
	<meta charset="UTF-8">
	<title>基本设置 - 后台管理 - 美图册</title>
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
		<h1 class="title">设置 - 基本设置</h1>
		<form class="normal-form">
			<label>网站标题</label>
			<input type="text" value="美图册 - 共享美好瞬间"/>
			<span>站点的名称将显示在网页的标题处.</span>

			<label>网站地址</label>
			<input type="text" value=""/>
			<span>站点的名称将显示在网页的标题处.</span>

			<label>网站描述</label>
			<input type="text" value=""/>
			<span>将会更加有利于搜索.</span>

			<label>关键词</label>
			<input type="text" value=""/>
			<span>请以半角,分割词语，将更加有利于网站搜索.</span>
			
			<input type="submit" value="提交"/>		
		</form>
	</div>
</body>
</html>
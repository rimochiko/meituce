<?php 
		session_start();
		if(!$_SESSION['valid_user'])
		{
			header("Location: ./login.html");
			exit;
		}	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户 - 后台管理 - 美图册</title>
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
			<a href="../index.html" target="_blank">网站</a>
			<div class="clear"></div>
		</div>
		</div>
	</div>
	<div class="main container">
		<h1 class="title">管理 - 标签</h1>
		<h2 class="sub-title">标签列表</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>选择</th>
					<th>标签ID</th>
					<th>标签内容</th>
					<th>图片数量</th>
					<th>图册数量</th>
				</tr>
				<tr>
					<td><input type="checkbox" name="is_auto"/></td>
					<td>T000001</td>
					<td>小清新</td>
					<td>3</td>
					<td>6</td>
				</tr>

			</table>
			<input type="submit" value="修改"/>	
			<input type="submit" value="删除"/>	
		</form>


	</div>
</body>
</html>
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
	<title>首页设置 - 后台管理 - 美图册</title>
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
		<h1 class="title">设置 - 首页设置</h1>
		<h2 class="sub-title">首页头图设置</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>系统自动选择</th>
					<th>人工输入</th>
					<th>输入图片编号</th>
					<th>提交按钮</th>
				</tr>
				<tr>
					<td><input type="radio" name="is_auto"/></td>
					<td><input type="radio" name="is_auto"/></td>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
					<td><input type="submit" value="提交"/></td>
				</tr>
			</table>	
		</form>

		<h2 class="sub-title">热门图片设置</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>系统自动选择</th>
					<th>人工输入</th>
					<th>输入图片编号</th>
					<th>提交按钮</th>
				</tr>
				<tr>
					<td rowspan="6"><input type="radio" name="is_auto"/></td>
					<td rowspan="6"><input type="radio" name="is_auto"/></td>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
					<td rowspan="6"><input type="submit" value="提交"/></td>
				</tr>

				<tr>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="人工输入图片编号..."/></td>
				</tr>
			</table>	
		</form>

		<h2 class="sub-title">首页标签设置</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>标签显示个数</th>
					<th>提交按钮</th>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="输入数字..."/></td>
					<td><input type="submit" value="提交"/></td>
				</tr>
			</table>	
		</form>

		<h2 class="sub-title">首页分类设置</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>分类显示个数</th>
					<th>提交按钮</th>
				</tr>
				<tr>
					<td><input type="text" name="" placeholder="输入数字..."/></td>
					<td><input type="submit" value="提交"/></td>
				</tr>
			</table>	
		</form>
	</div>
</body>
</html>
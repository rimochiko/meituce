<?php 
		include "./connect.php";
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
			<li><a href="./index.html" >后台主页</a>
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
			<li><a href="#" class="active">管理</a>
				<ul class="sub-nav">
					<li><a href="./user.php">用户</a></li>
					<li><a href="./photo.php">图片</a></li>
					<li><a href="./album.php">图册</a></li>
					<li><a href="./category.php">分类</a></li>
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
		<h1 class="title">管理 - 用户</h1>
		<h2 class="sub-title">用户列表</h2>
		<form class="table-form">
			<table>
				<tr>
					<th>账号</th>
					<th>昵称</th>
					<th>注册时间</th>
					<th>性别</th>
					<th>所在地</th>
					<th>描述</th>
					<th>头像</th>
					<th>状态</th>
					<th>删除</th>
					<th>封禁</th>
					<th>取消封禁</th>
				
				<?php 
					$user = mysqli_query($conn,"select * from user");
					while($row=mysqli_fetch_assoc($user))
					{
						echo "<tr><td>".$row['u_id']."</td>";
						echo "<td>".$row['u_nickname']."</td>";
						echo "<td>".$row['u_reg_time']."</td>";
						echo "<td>".$row['u_sex']."</td>";
						echo "<td>".$row['u_location']."</td>";
						echo "<td>".$row['u_describe']."</td>";
						if($row['u_head_image'])
						echo "<td><img class='table-img' src='../photo/user_avatar/".$row['u_id'].".jpg'>";
						else echo "<td></td>";
						if($row['u_status'])
						{
							echo "<td>正常</td>";
						}
						else
						{
							echo "<td>被封禁</td>";
						}
						echo "<td><a onclick='deleteUser(\"".$row['u_id']."\")'>删除</a></td>";
						echo "<td><a onclick='NoUser(0,\"".$row['u_id']."\")'>封禁</a></td>";
						echo "<td><a onclick='NoUser(1,\"".$row['u_id']."\")'>取消封禁</a></td></tr>";
					}
				?>
			</table>
		</form>
	</div>
<script src="../js/jquery-1.8.3.min.js"></script>
<script>
function NoUser(op,id)
{
	if(op==0)
	{
		if(confirm("真的要封禁该用户吗？"))
		{
			$.post("option/no.php",{
				type:0,
				id:id
			},function(data){
			if(data=='ok')
			{
				alert("封禁成功");
				history.go();
			}
			else
			{
				alert(data);
			}
		});
		}
	}		
	else
	{
		if(confirm("真的要取消封禁该用户吗？"))
		{
			$.post("option/no.php",{
				type:1,
				id:id
			},function(data){
			if(data=='ok')
			{
				alert("取消成功");
				history.go();
			}
			else
			{
				alert(data);
			}}
			);
		}
	}			
}

function deleteUser(id)
{
	if(confirm("真的要删除该用户吗？"))
	{
		$.post("option/delete.php",{
			type:'user',
			id:id
		},function(data){
			if(data=='ok')
			{
				alert("删除成功");
				history.go();
			}
			else
			{
				alert("不能删除有相册/图片的用户");
			}
		});
	}
}
</script>
</body>
</html>
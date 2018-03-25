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
<html>
<head>
	<meta charset="UTF-8">
	<title>分类 - 后台管理 - 美图册</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css"/>
</head>
<body>
	<div class="header">
		<div class="container">
		<div class="logo">
			<img src="../images/logo1.png"/>
		</div>
		<ul class="nav">
			<li><a href="./index.html">后台主页</a>
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
		<h1 class="title">设置 - 分类</h1>
		<h2 class="sub-title">分类列表</h2>
		<form class="table-form left">
			<table>
				<tr>
					<th>分类ID（展示顺序）</th>
					<th>分类内容</th>
					<th>分类描述</th>
					<th>修改</th>
					<th>删除</th>
				</tr>
				<?php 
            		$ca_result = mysqli_query($conn,"select * from category");          

					while($row = mysqli_fetch_assoc($ca_result))
					{
						echo "<tr>";
						echo "<td>".$row['ca_id']."</td><td>".$row['ca_name']."</td>";
						echo "<td>".$row['ca_describe']."</td><td><a onclick='updateName(".$row['ca_id'].")'>修改</a></td>";
						echo "<td><a onclick='deleteCa(".$row['ca_id'].",'".$row['ca_name']."','".$row['ca_describe']."')'>删除</a></td></tr>";
					}

				?>
			</table>
		</form>
		<form class="right" method="post" action="option/insert_ca.php">
		<h2 class="title">插入分类</h2>
		<label>分类名</label>
		<input type="text" name="ca_name"/>
		<input type="submit"/>
		</form>

		<form class="right" method="post" action="option/update.php">
		<h2 class="title">修改分类</h2>
		<label>分类ID</label>
		<input type="text" name="u_ca_order"/>
		<label>分类名</label>
		<input type="text" name="u_ca_name"/>
		<label>分类描述</label>
		<input type="text" name="u_ca_des"/>
		<input type="submit" />
		</form>
		<div class="clear"></div>
	</div>


<script src="../js/jquery-1.8.3.min.js"></script>
<script>
function deleteCa(id)
{
	if(confirm("真的要删除该分类吗？"))
	{
		$.post("option/delete.php",{
			type:'category',
			id:id
		},function(data){
			if(data=='ok')
			{
				alert("删除成功");
				history.go();
			}
			else
			{
				alert(data);
			}
		});
	}
}

function updateName(id,name,de)
{
	$("input[name='u_ca_order']").val(id);
	$("input[name='u_ca_name']").val(name);
	$("input[name='u_ca_des']").val(de);
}
</script>
</body>
</html>
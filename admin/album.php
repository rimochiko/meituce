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
	<title>图册 - 后台管理 - 美图册</title>
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
			<a href="../index.html" target="_blank">网站</a>
			<div class="clear"></div>
		</div>
		</div>
	</div>
	<div class="main container">
		<h1 class="title">图册 - 标签</h1>
		<h2 class="sub-title">标签列表</h2>
		<form class="table-form left">
			<table>
				<tr>
					<th>图册ID</th>
					<th>图册标题</th>
					<th>创建人</th>
					<th>创建时间</th>
					<th>图册描述</th>
					<th>修改</th>
					<th>删除</th>
				</tr>
				<?php 
					$query = "select * from album";
					$a_result = mysqli_query($conn,$query);
					while($row = mysqli_fetch_assoc($a_result))
					{
						echo "<tr>";
						echo "<td>".$row['a_id']."</td><td>".$row['a_name']."</td><td>".$row['a_user_id']."</td><td>".$row['a_time']."<td>".$row['a_describe']."</td></td>";
						echo "<td><a onclick='updateA(".$row['a_id'].",\"".$row['a_name']."\")'>修改</a></td>";
						echo "<td><a onclick='deleteA(".$row['a_id'].")'>删除</a></td></tr>";
					}
				?>
			</table>
		</form>
			<form class="right" method="post" action="option/update_album.php">
	
			<h2 class="title">修改图册</h2>
			<label>图册ID</label>
			<input type="text" name="a_id"/>
			<label>图册名字</label>
			<input type="text" name="a_name"/>
			<label>图册分类</label>
			<select name="a_ca">
			<?php 
    			$query = "select * from category";
   				$ca_result = mysqli_query($conn,$query);
    			while($row = mysqli_fetch_assoc($ca_result)) 
    			{
        			if($row == $album_result['a_category_id'])
            			echo "<option value='".$row['ca_id']."' selected='selected'>".$row['ca_name']."</option>";
        			else 
            			echo "<option value='".$row['ca_id']."'>".$row['ca_name']."</option>";
    			}  
			?>
			</select>
			<label>图册描述</label>
			<textarea type="text" name="a_des"></textarea>
			<input type="submit" />
			</form>
	</div>
</body>
<script src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
function updateA(id,name)
{
	$("input[name='a_id']").val(id);
	$("input[name='a_name']").val(name);	
}

function deleteA(id)
{
	if(confirm("真的要删除该相册吗？"))
	{
		$.post("option/delete.php",{
			type:'album',
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
</script>
</html>
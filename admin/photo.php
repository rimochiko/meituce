<?php 
		include "./connect.php";
		session_start();
		if(!$_SESSION['valid_user'])
		{
			header("Location: ./login.html");
			exit;
		}	

	$page = $_GET['page'];
	if(empty($page))
	{
		$page=1;
	}	

	$num = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as num from photo"));
	$page_num= ceil($num['num']/5);
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
			<a href="../index.php" target="_blank">网站</a>
			<div class="clear"></div>
		</div>
		</div>
	</div>
	
	<div class="main container">
		<h1 class="title">设置 - 图片</h1>
		<h2 class="sub-title">图片列表（<span>第<?php echo $page;?>页 - 共<?php echo $page_num;?>页</span>）</h2>
		<form class="table-form left">

			<table>
				<tr>
					<th>图片ID</th>
					<th>图片描述</th>
					<th>上传人</th>
					<th>创建时间</th>
					<th>喜欢数</th>
					<th>图片预览</th>
					<th>修改</th>
					<th>删除</th>
				</tr>
				<tr>
				<?php 
					$query = "select * from photo limit ".(5*($page-1)).",5";
					$p_result = mysqli_query($conn,$query);
					while($row = mysqli_fetch_assoc($p_result))
					{
						echo "<tr>";
						echo "<td>".$row['p_id']."</td><td>".$row['p_des']."</td><td>".$row['p_user_id']."</td><td>".$row['p_time']."</td>";
						echo "<td>0</td><td><img src='../photo/".$row['p_url']."'/></td>";
						echo "<td><a onclick='updateP(".$row['p_id'].",\"".$row['p_describe']."\")'>修改</a></td>";
						echo "<td><a onclick='deleteP(".$row['p_id'].")'>删除</a></td></tr>";
					}
				?>
				</tr>

			</table>
			<ul class="page-btn">
			<?php 
				for($i=1;$i<=$page_num;$i++)
				{
					echo "<li><a href='photo.php?page=".$i."'>".$i."</a></li>";
				}
			?>				

			</ul>
		</form>

			<form class="right" method="post" action="option/update_photo.php">
			<h2 class="title">修改图片</h2>
			<label>图片ID</label>
			<input type="text" name="p_id"/>
			<label>图片描述</label>
			<input type="text" name="p_des"/>
			<input type="submit" />
			</form>

		<div class="clear"></div>


	</div>
<script src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
function updateP(id,des)
{
	$("input[name='p_id']").val(id);
	$("input[name='p_des']").val(des);	
}

function deleteP(id)
{
	if(confirm("真的要删除该图片吗？"))
	{
		$.post("option/delete.php",{
			type:'photo',
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
</body>
</html>

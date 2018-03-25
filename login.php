<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php"; 
    if(isset($username))
    {
    	go_to_page("./index.php");
    	exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>登录 - 美图册</title>
	<link rel="stylesheet" href="./css/common.css"/>
	<link rel="stylesheet" href="./css/style.css"/>
</head>
<body>

<div class="header" id="header">
    <div class="container"> 
        <div class="logo" id="logo"> 
            <a href="./index.php"><img src="images/logo.png" alt="美图册"/></a>
        </div>
        <ul class="nav">
            <li><a href="./index.php">首页</a></li>
            <li><a href="./list.php">分类<span class="caret"></span></a>
                <ul class="sub-nav">
                    <?php
                        show_header_category($conn);
                    ?>
                </ul>
            </li>
        </ul>

        <form class="search" method="get" action="search.php">
            <input type="text" name="keywords" class="search-text" placeholder="输入搜索关键字..."/>
            <input type="submit" class="search-btn" value=""/>
        </form>
        
        <div class="user-btn">
            <?php 
                show_header_btn($username,$nickname);
            ?>
        </div>
    </div>
</div>

<div class="user-wrapper">
	<div class="user-box login">
		<h1>登录 美图册</h1>
    	<form action="user/checklogin.php" method="post">
    	   <label>用户名</label></br>
    	   <input type="text" name="login_id" /></br>
    	   <label>密码</label></br>
    	   <input type="password" name="login_psw" /></br>
    	   <input type="submit" value="登录" /></br>
    	</form>
        <div class="tips">
        	<p>尚未拥有账号？<a href="./register.php">注册</a></p>
        </div>
        
	</div>
</div>
</body>
</html>
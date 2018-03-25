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
<head>
	<meta charset="UTF-8">
	<title>注册 - 美图册</title>
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
    <div class="user-box register">
        <h1>加入 美图册</h1>
        <p>一同分享生活的美好</p>
    
        <form action="user/checkregister.php" method="post" onsubmit="return checkRegister();">
            <label>账号</label></br>
            <input type="text" name="username" /></br>
            <label>昵称</label></br>
            <input type="text" name="nickname" /></br>
            <label>密码</label></br>
            <input type="password" name="password" /></br>
            <label>确认密码</label></br>
            <input type="password" name="re_password" /></br>
            <input type="submit" value="注册" /></br>
        </form>
        
        <div class="tips">
            <p>注册即表示您同意我们的<a href="#">服务条款</a></p>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>
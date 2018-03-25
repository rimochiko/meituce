<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>您碰到了传说中的404 - 美图册</title>
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

<div class="main-wrapper">
	<div class="page-404">
    	<div class="container">
    		<h1>你迷路啦！</h1>
            <p>可能是手抖了，</br>服务器炸了，链接过期了</p>
            <a href="./index.php" class="confirm-btn"><span id="num">5</span>秒后跳转首页</a>
        </div>
    </div>
</div>
<script>
window.onload=function()
{
    var num=5;
    var timer= setInterval(function(){
        document.getElementById('num').innerHTML=num;
        num--;
        if(num==0)
        {
            clearInterval(timer);
            window.location.href="./index.php";
        }
    },1000);
}
</script>
</body>
</html>
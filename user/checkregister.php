<?php
    include "../include/conn.php";
    include "../include/functions.php";
    session_start();

    if(!$conn)
    {
        session_destroy();
        echo "<script>alert('数据库连接失败');history.go(1);</script>";
        exit;       
    }

    $username = $_POST['username'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $query = "insert into user(u_id,u_nickname,u_psw,u_sex,u_reg_time,u_status) values('".$username."','".$nickname."','".sha1($password)."','男',
        '".date("Y-m-d H:i:s")."',1)";


    if(mysqli_query($conn,$query))
    {
        $_SESSION['user_id'] = $username;
        $_SESSION['user_name'] = $nickname;
        go_to_page("../index.php","注册成功");
        exit; 
    }
    else
    {
        session_destroy();
        go_to_page("../register.php","注册失败");
        exit;  
    }
?>
<?php 
    include "../include/conn.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $new_nickname = $_POST['nickname'];
    $new_sex = $_POST['sex'];
    $new_des = $_POST['describe'];
    $new_loc = $_POST['location'];

    if(!$new_nickname||!$new_sex)
    {
        echo "<script>alert('信息填写不完整');window.location.href='./user.php';</script>";
        exit;       
    }

    if($new_sex=="male")
    {
        $new_sex = "男";
    }
    else
    {
        $new_sex = "女";
    }

    $query = "update user set u_nickname='".$new_nickname."',u_sex='".$new_sex."',u_location='".$new_loc."',u_describe='".$new_des."' where u_id='".$username."'";
    ;
    if(mysqli_query($conn,$query))
    {
        echo "<script>alert('修改成功');window.location.href='../self_set.php';</script>";
        exit;          
    }
    else
    {
        echo $query."<script>alert('修改失败');window.location.href='../self_set.php';</script>";
        exit;        
    }

?>
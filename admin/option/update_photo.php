<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $des= $_POST['p_des'];
    $id = $_POST['p_id'];

    if(!isset($des)&&!isset($id))
    {
        echo 'no';
        exit;
    }

    $query = "update photo set p_des='".$des."' where p_id=".$id;

    if(mysqli_query($conn,$query))
    {
        echo "<script>alert('修改成功');window.location.href='../photo.php';</script>";
        exit;          
    }
    else
    {
        echo "<script>alert('修改失败');window.location.href='../photo.php';</script>";
        exit;         
    }

?>
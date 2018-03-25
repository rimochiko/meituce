<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $des= $_POST['a_des'];
    $id = $_POST['a_id'];
    $name = $_POST['a_name'];
    $ca = $_POST['a_ca'];

    if(!isset($name)&&!isset($id)&&!isset($ca))
    {
        echo 'no';
        exit;
    }

    $query = "update album set a_des='".$des."',a_category_id = ".$ca.",a_name = '".$name."' where a_id=".$id;

    if(mysqli_query($conn,$query))
    {
        echo "<script>alert('修改成功');window.location.href='../album.php';</script>";
        exit;          
    }
    else
    {
        echo $query;
        //echo "<script>alert('修改失败');window.location.href='../album.php';</script>";
        exit;         
    }

?>
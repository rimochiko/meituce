<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $des= $_POST['u_ca_des'];
    $id = $_POST['u_ca_order'];
    $name = $_POST['u_ca_name'];

    if(!isset($id)&&!isset($name))
    {
        echo 'no';
        exit;
    }

    $query = "update category set ca_des='".$des."' ,ca_name='".$name."' where ca_id=".$id;

    if(mysqli_query($conn,$query))
    {
        echo "<script>alert('修改成功');window.location.href='../category.php';</script>";
        exit;          
    }
    else
    {
        echo $query;
        //echo "<script>alert('修改失败');window.location.href='../category.php';</script>";
        exit;         
    }

?>
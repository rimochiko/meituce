<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $id = $_POST['id'];
    $type = $_POST['type'];


    if(!isset($id)&&!isset($type))
    {
        echo 'no';
        exit;
    }

    if($type)
    {
        $query = "update user set u_status=1 where u_id='".$id."'";
    }
    else
    {
        $query = "update user set u_status=0 where u_id='".$id."'";
    }
    

    if(mysqli_query($conn,$query))
    {
        echo "ok";
        exit;          
    }
    else
    {
        echo $query;
        //echo "<script>alert('修改失败');window.location.href='../user.php';</script>";
        exit;         
    }

?>
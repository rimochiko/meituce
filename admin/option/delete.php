<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $type=$_POST['type'];
    $id = $_POST['id'];

    if($type=='user')
    $query = "delete from user where u_id=".$id;
    
    if($type=='category')
    $query = "delete from category where ca_id=".$id;

    if($type=='photo')
    $query = "delete from photo where p_id=".$id;

    if($type=='album')
    $query = "delete from album where a_id=".$id;

    if(mysqli_query($conn,$query))
    {
        echo "ok";
        exit;          
    }
    else
    {
        echo $query;
        exit;        
    }

?>
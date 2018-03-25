<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php";
    is_login($username);

    $photo_id = $_POST['update_photo_id'];
    $photo_album = $_POST['update_photo_album'];
    $photo_des = $_POST['update_photo_des'];
    if(empty($photo_id))
    {
        echo "no";
        return;
    }

    $query = "update photo set p_album_id = ".$photo_album.",p_des = '".$photo_des."' where p_id=".$photo_id;
    if(mysqli_query($conn,$query))
    {
        echo "ok";
    }
    else
    {
        echo $query;
    }

?>
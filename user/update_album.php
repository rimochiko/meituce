<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php"; 
    is_login($username);

    $album_id = $_POST['update_album_id'];
    $album_ca = $_POST['update_album_category'];
    $album_title = $_POST['update_album_title'];
    $album_des = $_POST['update_album_des'];
    $album_cover = $_POST['cover_id'];

    if(isset($album_cover))
    {
        $query = "update album set a_cover_photo=".$album_cover." where a_id=".$album_id;
    } 
    else
    {
        if(!isset($album_id)||!isset($album_ca)||!isset($album_title))
        {
            echo $album_id;
            exit;
        }
        $query = "update album set a_category_id=".$album_ca.",a_name = '".$album_title."',a_des = '".$album_des."' where a_id=".$album_id;
    }   
    



   
    if(mysqli_query($conn,$query))
    {
        echo "ok";
    }
    else
    {
        echo $query;
    }

?>
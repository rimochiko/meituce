<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 

    $photo_id = $_POST['photo_id']; 
    if(empty($photo_id))
    {
        echo "no";
        return;
    }

    $query = "insert into add_like(l_photo_id,l_user_id) values(".$photo_id.",'".$username."')";
    if(mysqli_query($conn,$query))
    {
        echo "ok";
    }
    else
    {
        echo "no";
    }

?>
<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 

    $photo_id = $_POST['photo_id']; 
    if(empty($photo_id))
    {
        echo "no";
        return;
    }

    $query = "delete from add_like where l_photo_id=".$photo_id." and l_user_id='".$username."'";
    if(mysqli_query($conn,$query))
    {
        echo "ok";
    }
    else
    {
        echo "no";
    }

?>
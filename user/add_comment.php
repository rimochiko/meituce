<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php"; 
    is_login($username);

    $photo_id = $_POST['id'];
    $content = $_POST['content'];

    if(empty($photo_id)||empty($content))
    {
    	echo 'no';
    	return;
    }

    $query = "insert into comment(c_photo_id,c_user_id,c_time,c_content) values(".$photo_id.",'".$username."','".date("Y-m-d H:i:s")."','".$content."')";
    if(mysqli_query($conn,$query))
    {
        echo 'ok';
    }
    else
    {
        echo $query;
    }

?>
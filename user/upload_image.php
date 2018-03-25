<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php"; 
	is_login($username);
	$upload_image = $_FILES['file'];

	if(!isset($upload_image))
	{
		echo "no";
		return;
	}
	$upload_name = explode('.',$upload_image['name']);

	if(!is_uploaded_file($upload_image['tmp_name']))
	{
        echo "no";
        exit;	
	}
	
	$photo_url = $username.".".$upload_name[count($upload_name)-1];
	$upload_path = "../photo/user_avatar/"; 

	if(move_uploaded_file($upload_image['tmp_name'],$upload_path.$photo_url))
	{
		echo $upload_name[count($upload_name)-1];
	}
	else
	{
		echo "no";
	}

?>
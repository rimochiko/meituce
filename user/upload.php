<?php 
    include "../include/conn.php";
    include "../include/session_start.php"; 
    include "../include/functions.php"; 

	$photo_select_album = $_POST['photo_select_album'];
	$photo_des = $_POST['photo_des'];

	if(empty($photo_select_album) )
	{
		go_to_page("../user.php?id=".$username,"图片信息不全");
        exit;			
	}

	$upload_image = $_FILES['file-upload'];
	$upload_name = explode('.',$upload_image['name']);

	if(!is_uploaded_file($upload_image['tmp_name']))
	{
		go_to_page("../user.php?id=".$username,"上传出错");
        exit;	
	}

	$query = "select p_id from photo order by p_id desc limit 1";
	$row = mysqli_fetch_assoc(mysqli_query($conn,$query));

	//确定ID号进行取名
	if(empty($row))
	{
		$photo_url = 1;
	}
	else
	{
		$photo_url = $row['p_id']+1;
	}
	
	$photo_url = $photo_url.".".$upload_name[count($upload_name)-1];
	$upload_path = "../photo/"; 

	if(move_uploaded_file($upload_image['tmp_name'],$upload_path.$photo_url))
	{
 	 	$query = "insert into photo(p_user_id,p_album_id,p_time,p_url,p_des) values('".$username."',".$photo_select_album.",'".date("Y-m-d H:i:s")."','".$photo_url."','".$photo_des."')";
 	 	if(mysqli_query($conn,$query))
 	 	{
 	 		go_to_page("../user.php?id=".$username,"上传成功");
 	 	}
 	 	else
		{
			go_to_page("../user.php?id=".$username,"上传出错");
        	exit;	
		}
	}
	else
	{
		go_to_page("../user.php?id=".$username,"上传出错");
        exit;	
	}

?>
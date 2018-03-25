<?php 
    include "../include/conn.php";
    include "../include/session_start.php";
    include "../include/functions.php";

    $photo_id = $_POST['pick_photo_id'];
    $photo_select_album = $_POST['pick_album'];
    $photo_des = $_POST['pick_des'];

    if(!isset($username))
    {
        echo "请重新登录";
        return;
    }	

    if(empty($photo_id))
    {
    	echo $photo_id;
    	return;
    }

    $old = mysqli_fetch_assoc(mysqli_query($conn,"select * from photo where p_id = ".$photo_id));
    if(isset($old['p_from_photo']))
    $query = "insert into photo(p_user_id,p_album_id,p_time,p_url,p_des,p_from_photo) values('".$username."',".$photo_select_album.",'".date("Y-m-d H:i:s")."','".$old['p_url']."','".$photo_des."',".$old['p_from_photo'].")";
    else
	$query = "insert into photo(p_user_id,p_album_id,p_time,p_url,p_des,p_from_photo) values('".$username."',".$photo_select_album.",'".date("Y-m-d H:i:s")."','".$old['p_url']."','".$photo_des."',".$photo_id.")";

	if(mysqli_query($conn,$query))
	{
        echo "ok";		
	}
	else
	{
        echo $query;		
	}
?>
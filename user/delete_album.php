<?php 
	include "../include/conn.php";
    include "../include/session_start.php";
    include "../include/functions.php";

    $album_id = $_POST['delete_album_id'];

    if(!isset($username))
    {
        echo "no";
        return;
    }	

    if(!isset($album_id))
    {
    	echo "no";
    	return;
    }

    $query = "select * from photo where p_album_id=".$album_id;
    $row = mysqli_fetch_assoc(mysqli_query($conn,$query));

    if(!empty($row))
    {
        echo "no";
        return;
    }


    $query = "delete from album where a_id =".$album_id;
    if(mysqli_query($conn,$query))
    {
        echo "ok";
    }
    else
    {
        echo "no";
    } 

    
?>
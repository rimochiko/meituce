<?php 
    include "../include/conn.php";
    include "../include/session_start.php";

    $photo_id = $_POST['delete_photo_id'];
    if(empty($photo_id))
    {
        echo "no";
        return;
    }

    $query = "select * from photo where p_id=".$photo_id;
    $row = mysqli_fetch_assoc(mysqli_query($conn,$query));

    if($username == $row['p_user_id'])
    {
        //如果图片被设置了封面，把相册封面设为默认
        $query = "select * from album where a_cover_photo=".$photo_id;
        $row = mysqli_fetch_assoc(mysqli_query($conn,$query));

        if($row)
        {
            mysqli_query($conn,"update album set a_cover_photo = null where a_id ='".$row['a_id']."'");
        }

        $query = "delete from photo where p_id =".$photo_id;
        if(mysqli_query($conn,$query))
        {
            echo "ok";
        } 
        else
        {
            echo "no";
        }
    }
    else
    {
        echo "请先登录";
    }



?>
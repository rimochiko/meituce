<?php 
    include "../include/conn.php";
    include "../include/session_start.php";
    include "../include/functions.php"; 

    is_login($username);

    $new_nickname = $_POST['nickname'];
    $new_sex = $_POST['sex'];
    $new_des = $_POST['describe'];
    $new_loc = $_POST['location'];

    if(!$new_nickname||!$new_sex)
    {
        go_to_page("../self_set.php","信息填写不完整");
        exit;       
    }

    if($new_sex=="male")
    {
        $new_sex = "男";
    }
    else
    {
        $new_sex = "女";
    }

    $query = "update user set u_nickname='".$new_nickname."',u_sex='".$new_sex."',u_location='".$new_loc."',u_des='".$new_des."' where u_id='".$username."'";
    ;
    if(mysqli_query($conn,$query))
    {
        go_to_page("../self_set.php","修改成功");
        exit;          
    }
    else
    {
        go_to_page("../self_set.php","修改失败");
        exit;        
    }

?>
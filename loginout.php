<?php
    include "include/conn.php";
    include "include/session_start.php";
    include "include/functions.php";

	unset($_SESSION['user_id']);
	$result = session_destroy();

	if(isset($username))
	{
		go_to_page("./index.php","");
		exit;			
	}
	else
	{
		go_to_page("./index.php","不能退出");
	}
?>
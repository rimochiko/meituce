<?php 
    include "../connect.php";
    session_start();
    if(!$_SESSION['valid_user'])
    {
        header("Location: ../login.html");
        exit;
    }

    $name = $_POST['ca_name'];

    $query = "insert into category(ca_name) values('".$name."')";
    ;
    if(mysqli_query($conn,$query))
    {
        echo "<script>alert('添加成功');window.location.href='../category.php'</script>";
        exit;          
    }
    else
    {
        echo "<script>alert('添加失败');window.location.href='../category.php'</script>";
        exit;        
    }

?>
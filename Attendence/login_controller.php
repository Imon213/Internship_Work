<?php
session_start();
require_once('db.php');
$conn = getConnection();
$uname=$_POST['email'];
$pass=$_POST['pass'];

if($uname!='' && $pass!='')
{
    
    $sql= "select * from registration where email='{$uname}' and password='{$pass}'";
    $result=mysqli_query($conn, $sql);
   
    if(mysqli_num_rows($result)>0 )
    {
        while($row=mysqli_fetch_array($result))
     {
        
        $_SESSION['user']=$row['id'];
        $_SESSION['flag']='true';
        header('location:profile.php');
     }

    }
    else{
        echo"failed";
    }
}
else{
    echo"failed";
}

?>
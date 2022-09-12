<?php
session_start();
require_once('db.php');
$conn = getConnection();
$id=$_POST['u_id'];
$date=$_POST['date'];
$attendence=$_POST['inlineRadioOptions'];
$sql2 = "INSERT INTO `attendance`(`attendance`, `userid`, `date`) VALUES('$attendence','$id', '$date')";
 $result2 = mysqli_query($conn, $sql2); 
        


?>
<?php
require('./db.php');
$conn = getConnection();
$data = $_POST['mydata'];
$mydata = json_decode($data);
$name=  $mydata->name;
$email= $mydata->email;
$uname= $mydata->uname;
$password= $mydata->password;

   $sql2 = "INSERT INTO `registration`(`name`,  `username`, `email`, `type`,`password`) VALUES('$name', '$uname','$email',
    'user','$password')";
        $result2 = mysqli_query($conn, $sql2); 
        

?>
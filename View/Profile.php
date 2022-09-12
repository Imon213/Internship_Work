<?php
require('db.php');
session_start();
if(isset($_SESSION['flag']))
{
    $id = $_SESSION['user'];
    $date = date("Y-m-d");
    $conn=getConnection();
$sql="select * from registration where id=$id";
$result= mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <?php while($row=mysqli_fetch_array($result)){?>
         <form action="profile_controller.php" method="post">
            <input type="name"  class="form-control" value="<?php echo $row['name'];?>">
          <input type="text" name="date" value="<?php echo $date;?>" id="date">
            <label for="inlineRadio1">Attendence    </label>

           <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="P">
           <label class="form-check-label" for="inlineRadio1">Present</label>

           <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="A">
           <label class="form-check-label" for="inlineRadio2">Absence</label><br>

           <input class="form-check-input" type="hidden" name="u_id" id="u_id" value="<?php echo $row['id'];?>">
           <input type="submit"  class="btn btn-success text-center sign_up_btn" value="SUBMIT">
            
         </form>
        <?php } ?>
    </div>
</body>
</html>

<?php
}
else{
  header('location:login.php');
}

?>
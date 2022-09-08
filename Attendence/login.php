<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <script type="text/javascript" src="registration.js"></script>
    <title>Login</title>
</head>
<body>
 
    <div class="reg_form">
    <h3 class="text-center text-success">LOGIN</h3>
    <br>
    <form action="login_controller.php" method="post">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email"><br>


        <label for="pass">Password</label>
        <input type="password" id="pass" class="form-control" name="pass" placeholder="Enter Password"><br>
        
        <div class="text-center">
        <span class="text-success">Don't have any account? <a href="index.php">Registration Now</a></span><br><br>
            <input type="submit" class="btn btn-success text-center sign_up_btn" value="LOGIN">
        </div>
    </form>
   </div>
   
  </div>
</body>
</html>
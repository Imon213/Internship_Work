<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="registration.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Registration</title>
    <style>
        body{
    background-image: url('Image/reg.jpg');
    margin: 50px;
    background-repeat: no-repeat;
   background-attachment: fixed;
   background-size: 100% 100%;
}
.reg_form{
    width: 50%;
    margin: 20px auto;
    box-shadow: 5px 5px 10px gray;
    padding: 50px;
    background-color: black;
    opacity: .7;
    border-radius: 10px;
}   

.sign_up_btn{
    width: 50%;
}
label{
    color: white;
}
input{
    height: 42px;
    
}
    </style>
</head>
<body>
   <div class="reg_form">
    <h3 class="text-center text-success">REGISTRATION FORM</h3>
    <br>
    <form action="#" method="post">
        <label for="name">Full Name</label>
        <input  type="text" id="name" class="form-control" placeholder="Enter Name"><br>
        <label for="uname">User Name</label>
        <input  type="text" id="uname" class="form-control" placeholder="User Name"><br>
        <label for="email">Email Address</label>
        <input type="email" id="email" class="form-control" placeholder="Enter Email"><br>
        <label for="pass">Password</label>
        <input type="password" id="pass" class="form-control" placeholder="Enter Password"><br>
        
        <div class="text-center">
        <span class="text-success">Already  have an account? <a href="login.php">Login Now</a></span><br><br>
            <input type="button"  onclick="registration()" class="btn btn-success text-center sign_up_btn" value="SIGN UP">
        </div>
    </form>
   </div>
</body>
</html>

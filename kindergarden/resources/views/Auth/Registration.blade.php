<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="registration.js"></script>
    <title>Registration</title>
</head>
<body>
   <div class="reg_form">
    <h3 class="text-center text-success">REGISTRATION FORM</h3>
    <br>
    <form action="{{route('register')}}"  method="post">
        @csrf
        <label >Full Name</label>
        <input  type="text" name="name" class="form-control" placeholder="Enter Name"><br>
        <label >User Name</label>
        <input  type="text" name="username" class="form-control" placeholder="User Name"><br>
        <label >Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter Email"><br>
        <label >Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter Password"><br>
        
        <div class="text-center">
        <span class="text-success">Already  have an account? <a href="login.php">Login Now</a></span><br><br>
        <input type="submit" class="btn btn-primary" value="SIGN UP" >
        </div>
    </form>
   </div>
</body>
</html>
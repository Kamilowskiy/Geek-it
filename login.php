<?php
  session_start();

  $connect = new mysqli('sql113.lh.pl', 'serwer244499', 'Kamil123#$#', 'serwer244499_geek');
  if ($connect->connect_error)
      echo "Error" . $connect;

  if(isset($_GET['submit'])){
    $email = $_GET['email'];
    $password = $_GET['password'];

    $query = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();  

    $row = $result->fetch_object();
    $tempEmail = $row->email;
    $tempPassword = $row->password;

    if($email==$tempEmail && $password==$tempPassword){
      echo "You have successfully logged in";
      header("location: index-logged.php");
    }
    else{
      echo "Wrong email or password";
    }
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Sign in</title>
</head>
<body>
  <section class="vh-100 bg-dark text-white">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image"></div>
        
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form>
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Sign in</p>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form3Example3" class="form-control form-control-lg"
                placeholder="Enter a valid email address" name="email" />
              <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Enter password" name="password" />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">Remember me</label>
              </div>
              <a href="#!" class="text-body">Forgot password?</a>
            </div>
            
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-warning btn-lg" name="submit" value="$_SESSION['loggedin']"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Did you forgot your password? <a href="./passwordReset.php"
                  class="link-danger">Reset</a></p>
            </div>

            <div class="text-center text-lg-start ">
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="./register.php"
                  class="link-danger">Register</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-warning">
      <div class="text-black mb-3 mb-md-0">Copyright © 2024. All rights reserved.</div>
    </div>
  </section>
</body>
</html>
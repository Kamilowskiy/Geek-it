<?php
  $connect = new mysqli('sql113.lh.pl', 'serwer244499', 'Kamil123#$#', 'serwer244499_geek');
  if ($connect->connect_error)
      echo "Error" . $connect;

  if(isset($_GET['submit'])){
    $email = $_GET['email'];
    $password = $_GET['password'];
    $passwordConfirm = $_GET['passwordConfirm'];
    $verification_token=bin2hex(random_bytes(16));

    if($password==$passwordConfirm){
      $query = $connect->prepare("INSERT INTO users (email, password, verification_token) VALUES(?, ?, ?)");
      $query->bind_param("sss", $email, $password, $verification_token);
      $query->execute();
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
    <title>Register</title>
</head>
<body>
  <section class="vh-100 bg-dark text-white">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <div class="divider d-flex align-items-center my-4"><p class="text-center fw-bold mx-3 mb-0">Register</p></div>
          
        <form method="get">

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form3Example3" class="form-control form-control-lg"
                placeholder="Enter email address" name="email" />
              <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Enter password" name="password" />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

            <!-- Password confirm input -->
            <div class="form-outline mb-3">
              <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Confirm password" name="passwordConfirm" />
              <label class="form-label" for="form3Example4">Confirm Password</label>
            </div>
            
            <!-- Register button -->
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-warning btn-lg" action=""
                style="padding-left: 2.5rem; padding-right: 2.5rem;" name="submit">Register</button>
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
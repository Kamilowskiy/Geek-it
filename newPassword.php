<?php
    $connect = new mysqli('sql113.lh.pl', 'serwer244499', 'Kamil123#$#', 'serwer244499_geek');
    if($connect->connect_error)
    echo "Error" . $connect;
   
    if(isset($_GET['submit'])){
        if(isset($_GET['token'])){
            $verification_token = $_GET['token'];
            $newPassword = $_GET['newPassword'];
            $newPasswordConfirm=$_GET['newPasswordConfirm'];
            if($newPassword==$newPasswordConfirm){ 
                $query = $connect->prepare("UPDATE users SET password=? WHERE verification_token=?");
                $query->bind_param("ss", $newPassword, $verification_token);
                $query->execute();
                echo "Password successfully changed";
            }
            else
                echo "Passwords do not match";
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
    <title>Set new password</title>
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
              <p class="text-center fw-bold mx-3 mb-0">Set new password</p>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Enter password" name="newPassword" />
              <label class="form-label" for="form3Example4">Password</label>
            </div>

             <!-- Password confirm input -->
            <div class="form-outline mb-3">
                <input type="password" id="form4Example4" class="form-control form-control-lg"
                placeholder="Confirm password" name="newPasswordConfirm" />
                <label class="form-label" for="form4Example4">Confirm Password</label>
            </div>

            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">          
            
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-warning btn-lg" action=""
                style="padding-left: 2.5rem; padding-right: 2.5rem;" name="submit" value="submit">Set</button>
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
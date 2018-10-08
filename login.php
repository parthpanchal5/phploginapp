<?php  
session_start();
  // Include db config
  require_once 'config/config.php';

  // Init vars
  $userinput = $password = '';
  $userinput_err = $password_err = '';

  // Process form when post submit
  if(isset($_POST['login'])){
    // Sanitize POST
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // Put post vars in regular vars
    $userinput = mysqli_real_escape_string($conn, $_POST['userinput']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate email
    if(empty($userinput) || empty($password)){
      $userinput_err = 'Please enter email or username';
      $password_err = 'Please enter password';
    } else{
      $sql = "SELECT * FROM reg WHERE username = '$userinput' OR email = '$userinput'";
      $result = mysqli_query($conn, $sql);
      $checkResult = mysqli_num_rows($result);
      if($checkResult < 1){
        header("Location:login.php?err");
        exit;
      }else{
          while($row = mysqli_fetch_assoc($result)){
            $hashCheck = password_verify($password, $row['password']);
            if($hashCheck == false){
              $password_err = "Invalid Password";
            }elseif($hashCheck == true){
              $_SESSION['username'] = $row['username'];
              $_SESSION['firstname'] = $row['firstname'];
              $_SESSION['lastname'] = $row['lastname'];
              $_SESSION['email'] = $row['email'];
              header("Location:welcome.php");
              exit;
            }
          } 
        }
      }  
    }
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta charset="UTF-8">
 	<link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
 	<title>Login</title>
 </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
          <h2 class="text-center">Login</h2>
          <p class="text-center text-success">Fill in your credentials</p>
          <hr>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">   
            <div class="form-group">
              <label for="userinput">Email or Username <i class="text-danger">*</i></label>
              <input type="text" name="userinput" placeholder="Enter username or email" class="form-control <?php echo (!empty($userinput_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $userinput; ?>">
              <span class="invalid-feedback"><?php echo $userinput_err; ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password <i class="text-danger">*</i></label>
              <input type="password" name="password" placeholder="Enter password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="submit" name="login" value="Login" class="btn btn-info btn-block">
              </div>
              <div class="col">
                <a href="reg.php" class="btn btn-light btn-block">No account? Register</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
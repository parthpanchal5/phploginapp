<?php  
  // Include db config
  require_once 'config/config.php';

  // Init vars
  $firstname = $lastname = $username = $email = $password = $confirm_password = '';
  $firstname_err = $lastname_err = $username_err = $email_err = $password_err = $confirm_password_err = '';

  // Submit
  if(isset($_POST['submit'])){
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    // Empty
    if(empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($confirm_password)){
      $firstname_err =  "Firstname is required";
      $lastname_err = "Lastname is required";
      $username_err = "Username is required (It must contain lowercase and digits)";
      $email_err = "Email is required";
      $password_err = "Password is required";
      $confirm_password_err = "Confirm Password is required";      
    }else{
      if(!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname)){
        $firstname_err =  "Firstname is required";
        $lastname_err = "Lastname is required";
      }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $email_err = "Email is invalid";                        
        }else{
          if(strlen($password) < 8){
            $password_err = "Password must be 8 characters long";
          }else{
            if($confirm_password != $password){
              $confirm_password_err = "Password Mismatch";      
            }else{
              $sql = "SELECT * FROM reg WHERE username = '$username'";
              $result = mysqli_query($conn, $sql);
              $countRows = mysqli_num_rows($result);
    
              if($countRows > 0){
                $username_err = "Username is not available";
              }else{
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                // Insert user in DB
                $sql = "INSERT INTO reg (firstname, lastname, username, email, password) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashedPass')";
                // echo $sql;
                $result = mysqli_query($conn, $sql);
                header("Location:login.php");
                exit;
              }
            }
          }
        }
      }
    }
  }
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
 	<title>Registration</title>
 </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-4">
          <h2 class="text-center">Create Account</h2>
          <p class="text-center text-success">Fill in this form to register</p>
          <hr>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="firstname">Firstname <i class="text-danger">*</i></label>
              <input type="text" name="firstname" class="form-control form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
              <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group">
              <label for="lastname">Lastname <i class="text-danger">*</i></label>
              <input type="text" name="lastname" class="form-control form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
              <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group">
              <label for="username">Username <i class="text-danger">*</i></label>
              <input type="text" name="username" class="form-control form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
              <label for="email">Email Address <i class="text-danger">*</i></label>
              <input type="email" name="email" class="form-control form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password <i class="text-danger">*</i></label>
              <input type="password" name="password" class="form-control form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password <i class="text-danger">*</i></label>
              <input type="password" name="confirm_password" class="form-control form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
              <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="submit" name="submit" value="Register" class="btn btn-success btn-block">
              </div>
              <div class="col">
                <a href="login.php" class="btn btn-light btn-block">Have an account? Login</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body> 
</html>
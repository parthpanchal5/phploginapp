<?php
  // Init session
  session_start();

  // Include db config
  require_once 'config.php';

  // Validate login
  if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location: login.php');
    exit;
  }
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header('location: login.php');
    exit;
  }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
</head>
<style>
	body{
		background-image: url("img.jpeg");
	  	position: relative;
  		background-size: cover;
  		background-position: center;
  		height: 92vh;
	}
	.container{
		background: #f2f2f2;
		opacity: 0.8;
		border-radius: 30px;
	}
</style>
<body>
	<div class="container animated fadeIn">
    	<div class="mt-3 mb-3 ml-4 pt-5">
        	<h2>Hi, <b class="text-success animated fadeIn"><?php echo $_SESSION['firstname']; ?>.</b><br> <span class="animated fadeIn">Welcome to our site.</span></h2>
    	</div>
    	<p><a href="logout.php" class="btn btn-outline-danger btn-sm mb-4 ml-4">Logout</a></p>
   </div>
</body>
</html>

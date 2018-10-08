<?php 
  $dbhost = 'localhost';
  $dbuser = 'parth';
  $dbpass = 'root';
  $dbname = 'user';

  // Connection string
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

  // Check connection
  if($conn == true){
    // echo "Connection success";
  }else{
    echo "Unable to connect".mysqli_error();
  }
  
?>
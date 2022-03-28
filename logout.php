<?php
  session_start();
  
  //unset currentUser and validLogin session variables
  unset($_SESSION['validLogin']);
  unset($_SESSION['currentUser']);
  
  //redirect back to the login screen
  header("Location: login.php");
?>

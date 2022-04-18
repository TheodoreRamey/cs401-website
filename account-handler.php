<?php
  session_start();
  
  //Get all of the entered data from the POST
  $handledEmail = $_POST['email'];
  $handledName = $_POST['name'];
  $handledUsername = $_POST['accountUsername'];
  $handledPassword = hash('sha256', $_POST['accountPassword']);
  $handledRePassword = hash('sha256', $_POST['re-accountPassword']);

  require_once 'Dao.php';
  $dao = new Dao();

  //Validate the username, checking length and if the username is taken
  if (strlen($handledUsername) == 0) {
    $_SESSION['accountMessage'][] = "Please enter a username.";
  }
  elseif (strlen($handledUsername) > 32) {
    $_SESSION['accountMessage'][] = "Your username is too long. It must be 32 characters or less.";
  }
  elseif (!$dao->checkUsernameAvailable($handledUsername)) {
    $_SESSION['accountMessage'][] = "This username is taken. Be creative enough to think of a new one.";
  }
  
  //Validate the email using a regular expression and checking its length
  $emailPattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
  if (strlen($handledEmail) == 0) {
    $_SESSION['accountMessage'][] = "Please enter an email.";
  }
  elseif (strlen($handledEmail) > 256) {
    $_SESSION['accountMessage'][] = "Your email is too long. It must be 256 characters or less.";
  }
  elseif (preg_match($emailPattern, $handledEmail) === 0) {
    $_SESSION['accountMessage'][] = "Invalid email. Please enter a valid email and try again.";
  }
  
  //Validate full name length
  if (strlen($handledName) == 0) {
    $_SESSION['accountMessage'][] = "Please enter your name.";
  }
  if (strlen($handledName) > 256) {
    $_SESSION['accountMessage'][] = "Your name is too long. It must be 256 characters or less. If your name is longer than this consider a legal name change.";
  }
  
  //Check if password and re-password match
  if (strlen($handledPassword) == 0) {
    $_SESSION['accountMessage'][] = "Please enter a password.";
  }
  elseif (strlen($handledRePassword) == 0) {
    $_SESSION['accountMessage'][] = "Please enter your password in both password fields.";
  }
  elseif (strlen($_POST['accountPassword']) < 6) {
    $_SESSION['accountMessage'][] = "Your password must be at least 6 characters long.";
  }
  elseif ($handledPassword != $handledRePassword) {
    $_SESSION['accountMessage'][] = "The passwords you entered don't match, please try again.";
  }
  
  //If 'message' was set, we need to pass back the POST data
  if (isset($_SESSION['accountMessage'])) {
    //redirect the user back to 'login.php' using the header function
    header('Location: login.php');
    $_SESSION['post'] = $_POST;
    exit();
  }
  
  //If this is reached the account data is valid, so we create the account and redirect
  unset($_SESSION['post']);
  header('Location: account.php');
  $dao->createAccount($handledEmail, $handledName, $handledUsername, $handledPassword);
  $_SESSION['validLogin'] = TRUE;
  $_SESSION['currentUser'] = $handledUsername;
  exit();
?>

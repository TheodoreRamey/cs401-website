<?php
  session_start();
  
  //Get username and password from POST
  $handledUsername = $_POST['loginUsername'];
  $handledPassword = $_POST['loginPassword'];
  
  //Validate the username, which must be max 32 characters
  if (strlen($handledUsername) == 0) {
    $_SESSION['loginMessage'][] = "Please enter a username.";
  }
  elseif (strlen($handledUsername) > 32) {
    $_SESSION['loginMessage'][] = "Are you sure your username is right? What you entered is too long.";
  }
  
  if (strlen($handledPassword) == 0) {
    $_SESSION['loginMessage'][] = "Don't forget your password!";
  }
  
  //Validate the username/password combo against the user table in the SQL database
  require_once 'Dao.php';
  $dao = new Dao();
  
  //If we already know the username is too long there is no reason to check for valid combo
  if (!isset($_SESSION['loginMessage'])) {
    $credentials = $dao->checkLogin($handledUsername, $handledPassword);
    if (!$credentials) {
      $_SESSION['loginMessage'][] = "Invalid username/password combination, please try again.";
    }
  }
  
  //If 'message' is set, then we need to pass back the POST data
  if (isset($_SESSION['loginMessage'])) {
    //redirect the user back to 'login.php' using the header function
    header('Location: login.php');
    $_SESSION['sentiment'] = 'bad';
    $_SESSION['post'] = $_POST;
    exit();
  }
  
  //If this code is reached 'message' wasn't set, so we redirect to the account landing page
  unset($_SESSION['post']);
  header('Location: account.php');
  $_SESSION['validLogin'] = TRUE;
  $_SESSION['currentUser'] = $handledUsername;
  exit();
?>

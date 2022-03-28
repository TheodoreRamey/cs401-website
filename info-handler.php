<?php
  session_start();
  
  //Get all of the entered data from the form input
  $game = $_POST['game'];
  $platform = $_POST['platform'];
  $yearMin = $_POST['yearMin'];
  $yearMax = $_POST['yearMax'];
  $genre = $_POST['genre'];
  $publisher = $_POST['publisher'];
  $region = $_POST['region'];
  $sales = $_POST['sales'];
  
  require_once 'Dao.php';
  $dao = new Dao();
  
  //Check length of input for text user input, and if they actually exist
  if (strlen($game) > 256) {
    $_SESSION['infoMessage'][] = "The name of the game you entered is too long. Please enter a max of 256 characters.";
  }
  elseif (strlen($game) != 0 && !$dao->checkGame($game)) {
    $_SESSION['infoMessage'][] = "The game you entered doesn't exist in our database. Please enter another.";
  }
  
  if (strlen($publisher) > 256) {
    $_SESSION['infoMessage'][] = "The publisher of the game you entered is too long. Please enter a max of 256 characters.";
  }
  elseif (strlen($game) != 0 && !$dao->checkPublisher($publisher)) {
    $_SESSION['infoMessage'][] = "The publisher you entered doesn't exist in our database. Please enter another.";
  }
  
  
  //If all the data isn't correct, put it all in SESSION and send it back to the user
  if (isset($_SESSION['infoMessage'])) {
    //redirect the user back to 'login.php' using the header function
    header('Location: map.php');
    $_SESSION['post'] = $_POST;
    exit();
  }
  
  //If the data is valid, send the user back but with an infographic
  unset($_SESSION['post']);
  require_once 'Dao.php';
  $dao = new Dao();
  $_SESSION['currentQuery'] = $dao->createInfographic($game, $platform, $yearMin, $yearMax, $genre, $publisher, $region, $sales);
  header("Location: map.php");
  exit();
?>
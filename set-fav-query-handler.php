<?php
  session_start();
  require_once 'Dao.php';
  $dao = new Dao();
  
  //Check if this exact combo already exists in the logged in users
  //Dao gets the data from SESSION
  $checkFavorite = $dao->checkFavoriteQuery();
  if (!$checkFavorite) {
    //call a dao.php method to put the query info into the savedqueries table
    $dao->addFavoriteQuery();
  }
    
  //Send the user back to map.php
  header('Location: map.php');
  exit();
?>

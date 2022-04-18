<?php
  session_start();
  require_once 'Dao.php';
  $dao = new Dao();
  
  $favQueryID = $_POST['query_id'];
  $dao->deleteFavoriteQuery($favQueryID);
  
  header('Location: account.php');
  exit();
?>

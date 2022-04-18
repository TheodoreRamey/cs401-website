<?php
  session_start();
  require_once 'Dao.php';
  $dao = new Dao();
  
  $favQueryID = $_POST['query_id'];
  $resultSet = $dao->getSingleQuery($favQueryID);
  $row = $resultSet->fetch();
  
  $_SESSION['currentGame'] = $row['game'];
  $_SESSION['currentPlatform'] = $row['platform'];
  $_SESSION['currentYearMin'] = $row['yearMin'];
  $_SESSION['currentYearMax'] = $row['yearMax'];
  $_SESSION['currentGenre'] = $row['genre'];
  $_SESSION['currentPublisher'] = $row['publisher'];
  $_SESSION['currentRegion'] = $row['region'];
  $_SESSION['currentSales'] = $row['sales'];
  $_SESSION['currentQuery'] = true;
  
  //After we set the SESSION variables as needed to meet the favorite query,
  //we redirect the user to the map page to see the search
  header('Location: map.php');
  exit();
?>

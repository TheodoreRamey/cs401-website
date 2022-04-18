<?php 
  session_start();
  $current = 'account';
  require_once 'header.php';
  
  //Check if a user is logged in, if not redirect them to the login page
  if (!$_SESSION['validLogin']) {
    header("Location: login.php");
  }
  
  //If the user is logged in, get their account information and saved queries to display
  require_once 'Dao.php';
  $dao = new Dao();
  $accountInfo = $dao->getAccountInfo()->fetch();
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content">
      <h2>Welcome <?php echo $accountInfo[1]; ?></h2>
      <h3>Account Info</h3>
      <div id="user_info">
        <ul>
          <li><strong>User Email: </strong><?php echo htmlspecialchars($accountInfo[0]); ?></li>
          <li><strong>Name: </strong><?php echo htmlspecialchars($accountInfo[1]); ?></li>
          <li><strong>Username: </strong><?php echo htmlspecialchars($accountInfo[2]); ?></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="background_card">
    <div class="content" id="favorite_queries">
      <?php
      //Get all favorited queries for the user
      $userFavs = $dao->getFavoriteQueries();
      
      //If they don't have any print out a message so they know of the feature
      if (!$userFavs) {
        echo "<h3>You don't have any saved queries!</h3>";
        echo "<p>You can save any search you perform to be a part of your favorited queries, which show up here! Simply press the 'Favorite This Search!' button when you are logged in and have performed a search for it to be saved here for future reference.</p>";
      }
      
      //Else print out a table of all the favorited queries
      else {
        echo "<h3>Saved Queries</h3>";
        echo "<table>";
        echo "<tr><th>Game Name</th><th>Platform</th><th>Min Year</th><th>Max Year</th><th>Genre</th><th>Publisher</th><th>Region</th><th>Sales (Millions)</th><th>Reuse Favorite</th><th>Delete Favorite</th></tr>";
        
        while ($row = $userFavs->fetch()) {
          echo "<tr><td>" . $row['game'] . "</td><td>" . $row['platform'] . "</td><td>" . $row['yearMin'] . "</td><td>" . $row['yearMax'] . "</td><td>" . $row['genre'] . "</td><td>" . $row['publisher'] . "</td><td>" . $row['region'] . "</td><td>" . $dao->getSalesFromIndex($row['sales']) . "</td><td>" . "<form action='activate-query-handler.php' method='post'><input type='hidden' name='query_id' value='" . $row['query_id'] . "'><button type='submit'>Use This Search</button></form>" . "</td><td>" . "<form action='delete-query-handler.php' method='post'><input type='hidden' name='query_id' value='" . $row['query_id'] . "'><button type='submit'>Delete This Search</button></form>" . "</td></tr>";
        }
        
        echo "</table>";
      }
      ?>
      
    </div>
  </div>

<?php 
  require_once 'footer.php';
?>

<?php 
  session_start();
  $current = 'mapped_data';
  require_once 'header.php';
  
  //Messages to the user about form input
  $infoMessages = array();
  if (isset($_SESSION['infoMessage'])) {
    $infoMessages = $_SESSION['infoMessage'];
    unset($_SESSION['infoMessage']);
  }
  
  if ($_SESSION['currentQuery']) {
    $currentGame = $_SESSION['currentGame'];
    $currentPlatform = $_SESSION['currentPlatform'];
    $currentYearMin = $_SESSION['currentYearMin'];
    $currentYearMax = $_SESSION['currentYearMax'];
    $currentGenre = $_SESSION['currentGenre'];
    $currentPublisher = $_SESSION['currentPublisher'];
    $currentRegion = $_SESSION['currentRegion'];
    $currentSales = $_SESSION['currentSales'];
  }
  
  //Function to get valid form data to repopulate forms
  function getValidData($lookup) {
    return (isset($_SESSION['post'][$lookup])) ? $_SESSION['post'][$lookup] : "";
  }
  
  //Arrays to hold all options for form input
  $platformOptions = array("ANY", "PC", "XOne", "X360", "XB", "PS4", "PS3", "PS2", "PS", "PSV", "PSP", "DC", "SAT", "SCD", "GEN", "WiiU", "Wii", "3DS", "DS", "GBA", "GB", "GC", "N64", "SNES", "NES", "TG16", "NG", "WS", "2600");
  
  $genreOptions = array("ANY", "Sports", "Platform", "Racing", "Role-Playing", "Puzzle", "Shooter", "Simulation", "Action", "Fighting", "Adventure", "Misc");
  
  $regionOptions = array("Global", "Japan", "Europe", "North America", "Other");
  
  $salesOptions = array(0, 1, 2, 3, 4, 5, 6);
  $salesComments = array("Any Amount of Units Sold", "At Least 100,000 Units Sold", "At Least 250,000 Units Sold", "At Least 1,000,000 Units Sold", "At Least 2,500,000 Units Sold", "At Least 10,000,000 Units Sold", "At Least 25,000,000 Units Sold");
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content">
      <h3>Infographics: How To Use</h3>
      <p>
        While our selection of games is large, please refrain from being hyper-specific unless you are looking for a specific game or small-subset of games. Saved form data will reset on page refresh. Select search parameters for the infographic. Different parameters include: <strong>Name, Platform, Year of Release, Genre, Publisher, Region, and Minimum Sales.</strong> 
      </p>
      
      <form class="data_entry_form" action="info-handler.php" method="post">
        <label for="game">Game Name:</label>
        <input type="text" id="game" placeholder="Leave blank for any/all games..." name="game" value="<?php echo getValidData('game'); ?>"></input>
        <label for="platform">Game Platform:</label>
        <select name="platform" id="platform">
          <?php foreach($platformOptions as $eachPlatform): ?>
            <option value="<?php echo $eachPlatform ?>"<?php if(getValidData('platform') == $eachPlatform) { echo ' selected="selected"'; } ?>><?php echo $eachPlatform ?></option>
          <?php endforeach ?>
        </select>
        <label for="yearMin">Year of Release Minimum:</label>
        <input type="number" id="yearMin" name="yearMin" min="1980" max="2016" value="<?php echo (isset($_SESSION['post']['yearMin'])) ? $_SESSION['post']['yearMin'] : 1980; ?>"></input>
        <label for="yearMax">Year of Release Maximum:</label>
        <input type="number" id="yearMax" name="yearMax" min="1980" max="2016" value="<?php echo (isset($_SESSION['post']['yearMax'])) ? $_SESSION['post']['yearMax'] : 2016; ?>"></input>
        <label for="genre">Genre:</label>
        <select name="genre" id="genre" selected="<?php echo getValidData('genre'); ?>">
          <?php foreach($genreOptions as $eachGenre): ?>
            <option value="<?php echo $eachGenre ?>"<?php if(getValidData('genre') == $eachGenre) { echo ' selected="selected"'; } ?>><?php echo $eachGenre ?></option>
          <?php endforeach ?>
        </select>
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" placeholder="Leave blank for any/all publishers..." name="publisher" value="<?php echo getValidData('publisher'); ?>"></input>
        <label for="region">Region:</label>
        <select name="region" id="region">
          <?php foreach($regionOptions as $eachRegion): ?>
            <option value="<?php echo $eachRegion ?>"<?php if(getValidData('region') == $eachRegion) { echo ' selected="selected"'; } ?>><?php echo $eachRegion ?></option>
          <?php endforeach ?>
        </select>
        <label for="sales">Sales:</label>
        <select name="sales" id="sales" selected="<?php echo getValidData('sales'); ?>">
          <?php foreach($salesOptions as $eachSales): ?>
            <option value="<?php echo $eachSales ?>"<?php if(getValidData('sales') == $eachSales) { echo ' selected="selected"'; } ?>><?php echo $salesComments[$eachSales] ?></option>
          <?php unset($_SESSION['post']); endforeach ?>
        </select>
        <button type="submit">Submit</button>
      </form>
      
      <?php
        foreach ($infoMessages as $infoMessage) {
          echo "<div class='message'>{$infoMessage}</div>";
        }
      ?>
      
    </div>
  </div>
  
  <div class="background_card">
    <div class="content">
      <div id="map_infographic">
        <?php 
        if ($_SESSION['currentQuery']) {
          //Grab the data from the database
          require_once 'Dao.php';
          $dao = new Dao();
          $resultSet = $dao->createInfographic($currentGame, $currentPlatform, $currentYearMin, $currentYearMax, $currentGenre, $currentPublisher, $currentRegion, $currentSales);
          
          echo "<h2>Result Set: " . $resultSet->rowCount() . " Games That Match Your Parameters</h2>";
          echo "<p><strong>Name:</strong> " . $currentGame . ", <strong>Platform: </strong>" . $currentPlatform . ", <strong>Release Year: </strong>" . $currentYearMin . "-" . $currentYearMax . ", <strong>Genre: </strong>" . $currentGenre . ", <strong>Publisher: </strong>" . $currentPublisher . ", <strong>Region: </strong>" . $currentRegion . ", <strong>Sales: </strong>" . $currentSales . "</p>";
          
          //Print it all out in a table for the user to see until the infographic works
          //Potentially keep this but move it to another webpage
          echo "<table>";
            echo "<tr><td><strong>Game Name</strong></td><td><strong>Platform</strong></td><td><strong>Release Year</strong></td><td><strong>Genre</strong></td><td><strong>Publisher</strong></td><td><strong>NA Sales</strong></td><td><strong>EU Sales</strong></td><td><strong>JP Sales</strong></td><td><strong>Other Sales</strong></td><td><strong>Global Sales</strong></td></tr>";
          while($row = $resultSet->fetch()) {
            echo "<tr><td>" . $row['game_name'] . "</td><td>" . $row['platform'] . "</td><td>" . $row['release_year'] . "</td><td>" . $row['genre'] . "</td><td>" . $row['publisher'] . "</td><td>" . $row['na_sales'] . "</td><td>" . $row['eu_sales'] . "</td><td>" . $row['jp_sales'] . "</td><td>" . $row['other_sales'] . "</td><td>" . $row['global_sales'] . "</td></tr>";
          }
          
          echo "</table>";
        }
        ?>
        
        
        <h1>Placeholder Infographic</h1>
        <p>Creating a programatically created infographic required far too much Javascript knowledge compared to my knowledge base. Because of this, I've decided to just present the data returned from the query to the user as is. This should show that forms/validation/data-driven website requirements are all met. I will continue to work on the infographic portion, and hopefully have it working for homework 7.</p>
        <img id="infographic" src="../images/placeholder.webp" alt="infographic"></img>
      </div>
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

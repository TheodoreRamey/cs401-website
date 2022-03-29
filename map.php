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
        Select search parameters for the infographic. Different parameters include: <strong>Name, Platform, Year of Release, Genre, Publisher, Region, and Sales.</strong>
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
        <input type="number" id="yearMin" name="yearMin" placeholder="1980" min="1980" max="2016" value="<?php echo getValidData('yearMin'); ?>"></input>
        <label for="yearMax">Year of Release Maximum:</label>
        <input type="number" id="yearMax" name="yearMax" placeholder="2016" min="1980" max="2016" value="<?php echo getValidData('yearMax'); ?>"></input>
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
          <?php endforeach ?>
        </select>
        <button type="submit">Submit (non-functional)</button>
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
        <h1>Placeholder Infographic</h1>
        <img id="infographic" src="../images/placeholder.webp" alt="infographic"></img>
      </div>
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

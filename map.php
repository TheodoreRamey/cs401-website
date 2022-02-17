<?php 
  $current = 'mapped_data';
  require_once 'header.php';
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content">
      <h3>Infographics: How To Use</h3>
      <p>
        Select search parameters for the infographic. Different parameters include: <strong>Name, Platform, Year of Release, Genre, Publisher, Region, and Sales.</strong>
      </p>
    </div>
  </div>
  
  <div class="background_card">
    <div class="content">
      <form class="form_inline" action="create_info.php">
        <label for="game">Game Name:</label>
        <input type="text" id="game" placeholder="Leave blank for all games..." name="game"></input>
        <label for="platform">Game Platform:</label>
        <select name="platform" id="platform">
          <option value="TBD">TBD</option>
        </select>
        <label for="year">Year of Release:</label>
        <input type="number" id="year" name="year" placeholder="1980" min="1980" max="2016"></input>
        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
          <option value="TBD">TBD</option>
        </select>
        <label for="publisher">Publisher:</label>
        <select name="publisher" id="publisher">
          <option value="TBD">TBD</option>
        </select>
        <label for="region">Region:</label>
        <select name="region" id="region">
          <option value="TBD">TBD</option>
        </select>
        <label for="sales">Sales:</label>
        <select name="sales" id="sales">
          <option value="TBD">TBD</option>
        </select>
        <button type="submit">Submit (non-functional)</button>
      </form>
      <div id="map_infographic">
        <h1>Placeholder Infographic</h1>
        <img id="infographic" src="../images/placeholder.webp" alt="infographic"></img>
      </div>
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

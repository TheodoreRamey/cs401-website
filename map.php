<?php 
  session_start();
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
      <form class="data_entry_form" action="info-handler.php" method="get">
        <label for="game">Game Name:</label>
        <input type="text" id="game" placeholder="Leave blank for any/all games..." name="game"></input>
        <label for="platform">Game Platform:</label>
        <select name="platform" id="platform">
          <option value="ANY">Any Platform</option>
          <option value="PC">Personal Computer (PC)</option>
          <option value="XOne">Xbox One</option>
          <option value="X360">Xbox 360</option>
          <option value="XB">Xbox</option>
          <option value="PS4">Playstation 4</option>
          <option value="PS3">Playstation 3</option>
          <option value="PS2">Playstation 2</option>
          <option value="PS">Playstation</option>
          <option value="PSV">PSV</option>
          <option value="PSP">PSP</option>
          <option value="DC">Dreamcast</option>
          <option value="SAT">Saturn</option>
          <option value="SCD">Sega CD</option>
          <option value="GEN">Genesis</option>
          <option value="WiiU">WiiU</option>
          <option value="Wii">Wii</option>
          <option value="3DS">3DS</option>
          <option value="DS">DS</option>
          <option value="GBA">Gameboy Advance</option>
          <option value="GB">Gameboy</option>
          <option value="GC">Gamecube</option>
          <option value="N64">N64</option>
          <option value="SNES">SNES</option>
          <option value="NES">NES</option>
          <option value="TG16">TurboGrafx-16</option>
          <option value="NG">Neo Geo</option>
          <option value="WS">Wonderswan</option>
          <option value="2600">Atari 2600</option>
        </select>
        <label for="yearMin">Year of Release Minimum:</label>
        <input type="number" id="yearMin" name="yearMin" placeholder="1980" min="1980" max="2016"></input>
        <label for="yearMax">Year of Release Maximum:</label>
        <input type="number" id="yearMax" name="yearMax" placeholder="2016" min="1980" max="2016"></input>
        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
          <option value="ANY">Any Genre</option>
          <option value="Sports">Sports</option>
          <option value="Platform">Platforming</option>
          <option value="Racing">Racing</option>
          <option value="Role-Playing">Role-Playing (RPG)</option>
          <option value="Puzzle">Puzzle</option>
          <option value="Shooter">Shooter</option>
          <option value="Simulation">Simulation</option>
          <option value="Action">Action</option>
          <option value="Fighting">Fighting</option>
          <option value="Adventure">Adventure</option>
          <option value="Strategy">Strategy</option>
          <option value="Misc">Misc</option>
        </select>
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" placeholder="Leave blank for any/all publishers..." name="publisher"></input>
        <label for="region">Region:</label>
        <select name="region" id="region">
          <option value="ANY">Global (All Regions)</option>
          <option value="JP">Japan</option>
          <option value="EU">Europe</option>
          <option value="NA">North America</option>
          <option value="OT">Other</option>
        </select>
        <label for="sales">Sales:</label>
        <select name="sales" id="sales">
          <option value="ANY">Any amount of units sold</option>
          <option value="Low">0 - 100,000 Units Sold</option>
          <option value="1">100,000 - 250,000 Units Sold</option>
          <option value="2">250,000 - 1,000,000 Units Sold</option>
          <option value="3">1,000,000 - 2,500,000 Units Sold</option>
          <option value="4">2,500,000 - 10,000,000 Units Sold</option>
          <option value="5">10,000,000 - 25,000,000 Units Sold</option>
          <option value="6">25,000,000 - 100,000,000 Units Sold</option>
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

<?php 
  session_start();
  $current = 'index';
  require_once 'header.php';
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content">
      <h1>Video Game Sales Visualized: 1980 to 2016</h1>
      <div class="normal_text">
        <p>
          Like many people my age, video games are a passion of mine. They have come a long way, from simple games like Asteroids to modern hits like Minecraft or Mario Cart. Now more than ever video games have a huge audience, and are able to appeal to people of many varied interests. Looking back at how games have been rated and how well they sold in different regions can tell us a lot about the growth of the industry and its fans. Using regional sales and ratings data we can visualize the history of video games!
        </p>
        <p>
          Using our infographic tool you are able to visualize the history of video games. Want to see where shooters have sold best? Or role-playing games? Our data visualization tool can help us see where different types of video games thrive, and which markets may have untapped fans of genres, just waiting for a breakout hit. If you want to know who was the best selling publisher in the 1990's we can show you, and even break it down by region.
        </p>
        <p>
          Using the <a href="https://www.kaggle.com/rush4ratio/video-game-sales-with-ratings">"Video Game Sales with Ratings"</a> dataset from Rush Kirubi, we can provide over 11,000 titles to visualize. There are endless combinations to explore, and you are doubtlessly going to find new video games that strike your interest. Discover cool tidbits of video game history: did you know the Yakuza series sold well inside Japan, but failed to strike it big in the foreign market until their last few games?
        </p>
      </div>
    </div>
  </div>
  
  <div class="background_card">
    <div class="content">
      <h2>Getting Started</h2>
      <div class="normal_text">
        <p>
          To get started with the data visualization tools, you can either <a href="map.php">jump right in</a> or you can look at some of the example queries below to get an idea for how the tool works.
        </p>
        <!--<h3>Examples to be filled in once the infographic tool works</h3>-->
      </div>
    </div>
  </div>
  
<?php 
  require_once 'footer.php';
?>

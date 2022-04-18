<?php 
  session_start();
  $current = 'login';
  require_once 'header.php';
  
  //Messages to the user about form input
  $loginMessages = array();
  if (isset($_SESSION['loginMessage'])) {
    $loginMessages = $_SESSION['loginMessage'];
    unset($_SESSION['loginMessage']);
  }
  
  $accountMessages = array();
  if (isset($_SESSION['accountMessage'])) {
    $accountMessages = $_SESSION['accountMessage'];
    unset($_SESSION['accountMessage']);
  }
  
  //Function to get any valid data to repopulate forms
  function getValidData($lookup) {
    return (isset($_SESSION['post'][$lookup])) ? $_SESSION['post'][$lookup] : "";
  }
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content"> 
      <h2>Login</h2>
      
      <!-- Print messages about valid/invalid form data to user -->
      <?php
        foreach ($loginMessages as $loginMessage) {
          echo "<div class='message'>{$loginMessage}<span class='removeClick'>x</span></div>";
        }
      ?>
      
      <form class="data_entry_form" action="login-handler.php" method="post">
        <label for="loginUsername">Username:</label>
        <input type="text" placeholder="Username" name="loginUsername" value="<?php echo getValidData('loginUsername'); ?>"></input>
        <label for="loginPassword">Password:</label>
        <input type="password" placeholder="Password" name="loginPassword"></input>
        <button type="submit">Submit</button>
      </form>
      
      <h2>Don't have an account? Create one now!</h2>
      
      <!-- Print messages about valid/invalid form data to user -->
      <?php
        foreach ($accountMessages as $accountMessage) {
          echo "<div class='message'>{$accountMessage}<span class='removeClick'>x</span></div>";
        }
      ?>
      
      <form class="data_entry_form" action="account-handler.php" method="post">
        <label for="email">Email:</label>
        <input type="text" placeholder="example@gmail.com" name="email" value="<?php echo getValidData('email'); ?>"></input>
        <label for="name">Full Name:</label>
        <input type="text" placeholder="Full Name" name="name" value="<?php echo getValidData('name'); ?>"></input>
        <label for="accountUsername">Username:</label>
        <input type="text" placeholder="Username" name="accountUsername" value="<?php echo getValidData('accountUsername'); ?>"></input>
        <label for="accountPassword">Password:</label>
        <input type="password" placeholder="Password" name="accountPassword"></input>
        <label for="re-accountPassword">Reenter Password:</label>
        <input type="password" placeholder="Reenter Password" name="re-accountPassword"></input>
        <button type="submit">Submit</button>
      </form>
      
      <!-- Script to fade user feedback on input -->
      <script>
      $(document).ready(function() {
        //Fade out the parent div when clicked using jQuery
        $(".removeClick").click(function() {
          $(this).parent("div").fadeOut(1250);
        });
        
        //Fade out messages to user after 15 seconds
        setTimeout(
        function fadeOutAfterSleep() {
          $(".message").fadeOut(1250);
        }, 15000);
      });
      </script>
      
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

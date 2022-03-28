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
      <form class="data_entry_form" action="login-handler.php" method="post">
        <label for="loginUsername">Username:</label>
        <input type="text" placeholder="Username" name="loginUsername" value="<?php echo getValidData('loginUsername'); ?>"></input>
        <label for="loginPassword">Password:</label>
        <input type="password" placeholder="Password" name="loginPassword"></input>
        <button type="submit">Submit</button>
      </form>
      
      <!-- Print messages about valid/invalid form data to user -->
      <?php
        foreach ($loginMessages as $loginMessage) {
          echo "<div class='message'>{$loginMessage}</div>";
        }
      ?>
      
      <h2>Don't have an account? Create one now!</h2>
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
      
      <!-- Print messages about valid/invalid form data to user -->
      <?php
        foreach ($accountMessages as $accountMessage) {
          echo "<div class='message'>{$accountMessage}</div>";
        }
      ?>
      
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

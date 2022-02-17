<?php 
  $current = 'login';
  require_once 'header.php';
?>

<!-- Body of HTML page -->
  <div class="background_card">
    <div class="content">
      <h2>Login</h2>
      <form class="data_entry_form" action="check_login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" placeholder="Username" name="username"></input>
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Password" name="password"></input>
        <button type="submit">Submit (non-functional)</button>
      </form>
      
      
      <h2>Don't have an account? Create one now!</h2>
      <form class="data_entry_form" action="create_account.php">
        <label for="email">Email:</label>
        <input type="text" id="email" placeholder="example@gmail.com" name="email"></input>
        <label for="name">Full Name:</label>
        <input type="text" id="name" placeholder="Full Name" name="name"></input>
        <label for="username">Username:</label>
        <input type="text" id="username" placeholder="Username" name="username"></input>
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Password" name="password"></input>
        <button type="submit">Submit (non-functional)</button>
      </form>
    </div>
  </div>
<?php 
  require_once 'footer.php';
?>

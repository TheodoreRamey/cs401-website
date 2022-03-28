<div id="navigation">
  <hr>
  <ul>
    <img id="logo"src="../images/logo2.jpeg" alt="Website Logo">
    
    <li <?php if ($current == 'index') {echo "class='current_page'";}?>><a href="index.php">Home</a></li>
    <li <?php if ($current == 'mapped_data') {echo "class='current_page'";}?>><a href="map.php">Dive Into Data</a></li>
    <li <?php if ($current == 'account') {echo "class='current_page'";}?>><a href="account.php">Account</a></li>
    <li <?php if ($current == 'login') {echo "class='current_page'";}?>><a href="login.php">Login</a></li>
    <?php if ($_SESSION['validLogin']) : ?>
    <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
  </ul>
  <hr>
</div>

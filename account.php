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
      <h2>Account Info</h2>
      <div id="user_info">
        <ul>
          <li><strong>User Email: </strong><?php echo $accountInfo[0]; ?></li>
          <li><strong>Name: </strong><?php echo $accountInfo[1]; ?></li>
          <li><strong>Username: </strong><?php echo $accountInfo[2]; ?></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="background_card">
    <div class="content">
      <h2>Saved Queries</h2>
    </div>
  </div>

<?php 
  require_once 'footer.php';
?>

<?php
  session_start();
  require_once 'KLogger.php';

  class Dao {
    
    //Create a logger for error messages
    private $logger = null;
    
    //Login credentials for Heroku database
    private $host = "us-cdbr-east-05.cleardb.net";
    private $db = "heroku_9d91e0ec2736e56";
    private $user = "b31db98315920b";
    private $pass = "3ef2a0c7";
    
    /* Credentials for testing on local machine
    private $host = "localhost";
    private $db = "test";
    private $user = "root";
    private $pass = "";
    */
    
    //Create a log file named 'log.txt' and instantiate our logger
    public function __construct() {
      $this->logger = new KLogger("log.txt", KLogger::DEBUG);
      $this->logger->LogDebug("Created instance of KLogger");
    }
    
    //Creates a connection to the database using PDO
    public function getConnection() {
      $this->logger->LogDebug("Creating a database connection...");
      try {
        return new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
      }
      catch(Exception $e) {
        $this->logger->LogFatal("Failed to create a connection to the database. ERROR: " . print_r($e,1));
        exit;
      }
    }

    //Checks if a username is taken in the users table
    //Returns true if the username is available, false otherwise
    public function checkUsernameAvailable($username) {
      $conn = $this->getConnection();
      
      //Use a prepared statement as username is user input
      $usernameQuery = "SELECT * FROM user WHERE username = :username";
      $q = $conn->prepare($usernameQuery);
      $q->bindParam(":username", $username);
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check username availability failed to execute");
        return false;
      }
      //Check if there are any results
      if ($q->rowCount() > 0) {
        return false;
      }
      
      return true;
    }
    
    //Checks if a username/password combination is valid
    //Returns true is valid, false if not
    public function checkLogin($username, $password) {
      $conn = $this->getConnection();
      
      $this->logger->LogDebug("Attempting to login with username: " . $username);
      
      $loginQuery = "SELECT * FROM user WHERE username = :username AND password = :password";
      $q = $conn->prepare($loginQuery);
      $q->bindParam(":username", $username);
      $q->bindParam(":password", $password);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check username/password failed to execute");
        return false;
      }
      
      //Check if there are any results
      if ($q->rowCount() > 0) {
        $this->logger->LogDebug("Successfully logged in with username: " . $username);
        return true;
      }
      
      return false;
    }
    
    //Add a user to the users table
    public function createAccount($email, $name, $username, $password ) {
      $conn = $this->getConnection();
      $this->logger->LogDebug("Attempting to create an account with data: " . $email . ", " . $name . ", " . $username);
      
      $accountQuery = "INSERT INTO user (email, fullname, username, password) VALUES (:email, :fullname, :username, :password)";
      $q = $conn->prepare($accountQuery);
      $q->bindParam(":email", $email);
      $q->bindParam(":fullname", $name);
      $q->bindParam(":username", $username);
      $q->bindParam(":password", $password);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to create account failed to execute");
        exit();
      }
    }
    
    //Get account info for the currently logged in account
    public function getAccountInfo() {
      $conn = $this->getConnection();
      $username = $_SESSION['currentUser'];
      $this->logger->LogDebug("Getting account information for " . $username . ".");
      
      $infoQuery = "SELECT email, fullname, username FROM user WHERE username = :username";
      $q = $conn->prepare($infoQuery);
      $q->bindParam(":username", $username);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve account data failed to execute");
        exit();
      }
      
      return $q;
    }
  }
?>

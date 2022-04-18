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
    
    
    /*// Credentials for testing on local machine
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
    
    //Check if a game name exists in the database
    public function checkGame($game) {
      $conn = $this->getConnection();
      
      $game = "%" . $game . "%";
      
      $gameQuery = "SELECT * FROM gameData WHERE game_name LIKE :game";
      $q = $conn->prepare($gameQuery);
      $q->bindParam(":game", $game);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check game existance failed to execute");
        return false;
      }
      //Check if there are any results
      if ($q->rowCount() > 0) {
        $this->logger->LogDebug("Found game with name " . $game);
        return true;
      }
      $this->logger->LogDebug("Failed to find game with name " . $game);
      return false;
    }
    
    //Check if a game name exists in the database
    public function checkPublisher($publisher) {
      $conn = $this->getConnection();
      
      $publisher = "%" . $publisher . "%";
      
      $publisherQuery = "SELECT * FROM gameData WHERE publisher LIKE :publisher";
      $q = $conn->prepare($publisherQuery);
      $q->bindParam(":publisher", $publisher);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check publisher existance failed to execute");
        return false;
      }
      //Check if there are any results
      if ($q->rowCount() > 0) {
        $this->logger->LogDebug("Found publisher with name " . $publisher);
        return true;
      }
      $this->logger->LogDebug("Failed to find publisher with name " . $publisher);
      return false;
    }
    
    public function checkInfoParams($game, $platform, $yearMin, $yearMax, $genre, $publisher, $region, $sales) {
      $conn = $this->getConnection();
      
      //Check for unfilled data/ones that represent all data 
      //(select/option basically, as text is validated in the handler)
      $game = "%" . $game . "%";
      $publisher = "%" . $publisher . "%";
      if ($platform == "ANY" || $platform == "") {
        //Replace ANY with blank, as all platforms will 'contain' the empty string
        $platform = "%" . "" . "%";
      }
      if (!isset($yearMin) || $yearMin == "") {
        $yearMin = 1980;
      }
      if (!isset($yearMax) || $yearMax == "") {
        $yearMin = 2016;
      }
      if ($genre == "ANY" || $genre == "") {
        $genre = "%" . "" . "%";
      }
      $sales = $this->getSalesFromIndex($sales);
      
      $this->logger->logDebug("Checking if games exist with parameters: " . $game . ", " . $platform . ", " . $yearMin . ", " . $yearMax . ", " . $genre . ", " . $publisher . ", " . $region . ", " . $sales);
      
      $query = "SELECT * FROM gameData WHERE game_name LIKE :game AND platform LIKE :platform AND release_year >= :yearMin AND release_year <= :yearMax AND genre LIKE :genre AND publisher LIKE :publisher AND global_sales >= :sales";
      $q = $conn->prepare($query);
      $q->bindParam(":game", $game);
      $q->bindParam(":platform", $platform);
      $q->bindParam(":yearMin", $yearMin);
      $q->bindParam(":yearMax", $yearMax);
      $q->bindParam(":genre", $genre);
      $q->bindParam(":publisher", $publisher);
      $q->bindParam(":sales", $sales);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check gameData records failed to execute");
        return false;
      }
      //Check if there are any results
      if ($q->rowCount() > 0) {
        $this->logger->LogDebug("Successfully found " . $q->rowCount() . " game records");
        return true;
      }
      $this->logger->LogDebug("Failed to find game records");
      return false;
    }
    
    public function createGameDataTable($game, $platform, $yearMin, $yearMax, $genre, $publisher, $region, $sales) {
      $conn = $this->getConnection();
      
      //Check for unfilled data/ones that represent all data 
      //(select/option basically, as text is validated in the handler)
      $game = "%" . $game . "%";
      $publisher = "%" . $publisher . "%";
      if ($platform == "ANY" || $platform == "") {
        //Replace ANY with blank, as all platforms will 'contain' the empty string
        $platform = "%" . "" . "%";
      }
      if (!isset($yearMin) || $yearMin == "") {
        $yearMin = 1980;
      }
      if (!isset($yearMax) || $yearMax == "") {
        $yearMin = 2016;
      }
      if ($genre == "ANY" || $genre == "") {
        $genre = "%" . "" . "%";
      }
      $sales = $this->getSalesFromIndex($sales);
      
      $query = "SELECT * FROM gameData WHERE game_name LIKE :game AND platform LIKE :platform AND release_year >= :yearMin AND release_year <= :yearMax AND genre LIKE :genre AND publisher LIKE :publisher AND global_sales >= :sales";
      $q = $conn->prepare($query);
      $q->bindParam(":game", $game);
      $q->bindParam(":platform", $platform);
      $q->bindParam(":yearMin", $yearMin);
      $q->bindParam(":yearMax", $yearMax);
      $q->bindParam(":genre", $genre);
      $q->bindParam(":publisher", $publisher);
      $q->bindParam(":sales", $sales);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to check gameData records failed to execute");
        return false;
      }
      
      //Return the result set to be parsed by info-handler/map.php
      return $q;
    }
    
    public function getSalesFromIndex($sales) {
      switch ($sales) {
        case 0:
          return 0.0;
        case 1:
          return 0.1;
        case 2:
          return 0.25;
        case 3:
          return 1.0;
        case 4:
          return 2.5;
        case 5:
          return 10.0;
        case 6:
          return 25.0;
        default:
          return 0;
      }
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
        return $q->fetchColumn(0);
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
    
    //Check if a certain query exists in a user's favorites
    public function checkFavoriteQuery() {
      $conn = $this->getConnection();
      $user_id = $_SESSION['currentUserID'];
      $game = $_SESSION['currentGame'];
      $platform = $_SESSION['currentPlatform'];
      $yearMin = $_SESSION['currentYearMin'];
      $yearMax = $_SESSION['currentYearMax'];
      $genre = $_SESSION['currentGenre'];
      $publisher = $_SESSION['currentPublisher'];
      $region = $_SESSION['currentRegion'];
      $sales = $_SESSION['currentSales'];
    
      $checkFavQuery = "SELECT * FROM savedqueries WHERE user_id = :user_id AND game = :game AND platform = :platform AND yearMin = :yearMin AND yearMax = :yearMax AND genre = :genre AND publisher = :publisher AND region = :region AND sales = :sales";
      $q = $conn->prepare($checkFavQuery);
      $q->bindParam(":user_id", $user_id);
      $q->bindParam(":game", $game);
      $q->bindParam(":platform", $platform);
      $q->bindParam(":yearMin", $yearMin);
      $q->bindParam(":yearMax", $yearMax);
      $q->bindParam(":genre", $genre);
      $q->bindParam(":publisher", $publisher);
      $q->bindParam(":region", $region);
      $q->bindParam(":sales", $sales);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve query data failed to execute");
        exit();
      }
      
      if ($q->rowCount() > 0) {
        return true;
      }
      
      return false;
    }
    
    //Add a query to a user's favorite's
    public function addFavoriteQuery() {
      $conn = $this->getConnection();
      $user_id = $_SESSION['currentUserID'];
      $game = $_SESSION['currentGame'];
      $platform = $_SESSION['currentPlatform'];
      $yearMin = $_SESSION['currentYearMin'];
      $yearMax = $_SESSION['currentYearMax'];
      $genre = $_SESSION['currentGenre'];
      $publisher = $_SESSION['currentPublisher'];
      $region = $_SESSION['currentRegion'];
      $sales = $_SESSION['currentSales'];
      
      $addFavQuery = "INSERT INTO savedqueries (user_id, game, platform, yearMin, yearMax, genre, publisher, region, sales) VALUES (:user_id, :game, :platform, :yearMin, :yearMax, :genre, :publisher, :region, :sales)";
      $q = $conn->prepare($addFavQuery);
      $q->bindParam(":user_id", $user_id);
      $q->bindParam(":game", $game);
      $q->bindParam(":platform", $platform);
      $q->bindParam(":yearMin", $yearMin);
      $q->bindParam(":yearMax", $yearMax);
      $q->bindParam(":genre", $genre);
      $q->bindParam(":publisher", $publisher);
      $q->bindParam(":region", $region);
      $q->bindParam(":sales", $sales);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve query data failed to execute");
        exit();
      }
    }
    
    //Return all of a user's favorited queries
    public function getFavoriteQueries() {
      $conn = $this->getConnection();
      $user_id = $_SESSION['currentUserID'];
      
      $query = "SELECT query_id, game, platform, yearMin, yearMax, genre, publisher, region, sales FROM savedqueries WHERE user_id = :user_id";
      $q = $conn->prepare($query);
      $q->bindParam(":user_id", $user_id);
         
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve query data failed to execute");
        return false;
      }
      else if ($q->rowCount() < 1) {
        return false;
      }
      
      return $q;
    }
    
    //Get a single queries data to update the SESSION array
    public function getSingleQuery($query_id) {
      $conn = $this->getConnection();
      
      $query = "SELECT game, platform, yearMin, yearMax, genre, publisher, region, sales FROM savedqueries WHERE query_id = :query_id";
      $q = $conn->prepare($query);
      $q->bindParam(":query_id", $query_id);
         
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve query data failed to execute");
        exit();
      }
      
      return $q;
    }
    
    //Delete a favorite query from a user's account page
    public function deleteFavoriteQuery($query_id) {
      $conn = $this->getConnection();
      
      $query = "DELETE FROM savedqueries WHERE query_id = :query_id";
      $q = $conn->prepare($query);
      $q->bindParam(":query_id", $query_id);
      
      if (!$q->execute()) {
        $this->logger->LogFatal("SQL statement to retrieve query data failed to execute");
        return false;
      }
      
      return true;
    }
  }
?>

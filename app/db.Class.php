<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-03-2016
-->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include database class
include 'db.Creds.php';
class DB {

    private $dbh;
    private $stmt;
    private $error;
    private $priority;
    private $client;
    private $req;
    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;
    private $server    = 'HTTP_HOST';



    // Constructor to connect to the DB and catch any errors.
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }

        // Get our values from url
        if (isset($_GET['priority']) and isset($_GET['req'])) {
          $this->priority = $_GET['priority'];
          $this->req = $_GET['req'];
        }else{
          $this->priority = NULL;
          $this->req = NULL;
        }

        if (isset($_GET['client'])) {
          $this->client = $_GET["client"];
        }else{
          $this->client = NULL;
        }
    }

    //Build the query
    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    //Execute our query
    public function execute() {
        return $this->stmt->execute();
    }

    //Use this to see the fetchAll() array PDO function
    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Used this to get one result from a query
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    //Used to bind our query parameters
    public function bind($param, $value, $type = null) {
      if (is_null($type)) {
          switch (true) {
            case is_int($value):
              $type = PDO::PARAM_INT;
              break;
            case is_bool($value):
              $type = PDO::PARAM_BOOL;
              break;
            case is_null($value):
              $type = PDO::PARAM_NULL;
              break;
            default:
              $type = PDO::PARAM_STR;
        }
      }
    $this->stmt->bindValue($param, $value, $type);
    }

    //Used to get our req ID and load it to the UI
    public function processReq($req) {
      $this->query("SELECT id, title, client, priority, ticketurl FROM request
                    WHERE id = :req");
      $this->bind(':req', $req);
      $row = $this->single();
      return $row;
    }

    public function getClientReq($client) {
      $this->query("SELECT * FROM request
                    WHERE client = :client");
      $this->bind(':client', $client);
      $row = $this->single();
      return $row;
    }
    // Used to count our rows from the query
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Get the last inserted ID from the DB
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }

    // Get the client priority int value.
    public function clientPriority($priority) {
      $this->query("SELECT priority FROM request WHERE priority = :priority");
      $this->bind(':priority', $priority);
      $row = $this->single();
      return $row;
    }

    public function convertClient($client) {
      if ($client == 0) {
        echo "Client A";
      }elseif ($client == 1){
        echo "Client B";
      }elseif ($client == 2 ){
        echo "Client C";
      }
    }

}



?>

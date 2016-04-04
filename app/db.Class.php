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
    private $server;
    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;




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

    public function getTickets($client) {
      $this->query("SELECT * FROM request WHERE client = :client");
      $this->bind(':client', $client);
      $row = $this->resultset();
      return $row;

    }

    public function getDeveloper($ticket) {
      $this->query("SELECT client, ticket_number, developer FROM request
                    WHERE ticket_number = :ticket");
      $this->bind(':ticket', $ticket);
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

    public function convertClient($client) {
      switch ($client) {
        case 0:
          $client = "Client A";
          break;
        case 1:
          $client = "Client B";
          break;
        case 2:
          $client = "Client C";
          break;
        default:
          echo "No client selected";
        }
        return $client;

    }

    public function assigned($assigned) {
      switch ($assigned) {
        case 1:
          $assigned = "No";
          break;
        case 2:
          $assigned = "Yes";
          break;
        default:
          $assigned = "No";
          break;
      }

    }
    public function pickDeveloper($dev) {

      switch($dev){
        case 1:
          $dev = "Billy R Baldwin";
          break;
        case 2:
          $dev = "Robert Heinlein";
          break;
        case 3:
          $dev = "Superman Jones";
          break;
        case 4:
          $dev = "Harry Potter";
          break;
        default:
          $dev = "None Assigned";
      }
      return $dev;
    }

    public function server() {
      $server = $_SERVER['HTTP_HOST'];
      return $server;
    }

}



?>

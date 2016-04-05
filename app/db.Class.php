<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
// Include Application Globals
include('db.Config.php');

// Declare main App class
class DB {

    private $dbh;
    private $stmt;
    private $error;
    private $priority;
    private $client;
    private $ticket;
    private $server;
    private $assigned;
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
        if (isset($_GET['priority']) and isset($_GET['ticket'])) {
          $this->priority = $_GET['priority'];
          $this->ticket = $_GET['ticket'];
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

    // Used to count our rows from the query
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Get the last inserted ID from the DB
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }

    /** Application Queries **/

    //Used to get our req ID and load it to the UI
    public function processReq($req) {
      $this->query("SELECT * FROM request
                    WHERE id = :req");
      $this->bind(':req', $req);
      $row = $this->single();
      return $row;
    }
    // Used to Rotate our priority numbers for each client
    public function rotatePriority($client, $priority) {
      $this->query("SELECT client, priority FROM request
                    WHERE client = :client AND priority = :priority");
      $this->bind(':client', $client);
      $this->bind(':priority', $priority);
      $row = $this->single();
      return $row;

    }

    public function getClientReq($client, $ticket) {
      $this->query("SELECT * FROM request
                    WHERE client = :client
                    AND ticket_number = :ticket");
      $this->bind(':client', $client);
      $this->bind(':ticket', $ticket);
      $row = $this->single();
      return $row;
    }

    public function getTickets($c) {
      $this->query("SELECT * FROM request WHERE client = :client");
      $this->bind(':client', $c);
      $row = $this->resultset();
      return $row;

    }

    public function convertClient($client) {
      $this->query("SELECT clientid, clientname FROM clients
                    WHERE clientid = :client ");
      $this->bind(':client', $client);
      $row = $this->single()['clientname'];
      return $row;

    }
    public function pickDeveloper(){
      $this->query("SELECT * FROM developer");
      $rows = $this->resultset();
      return $rows;
    }

    public function showDeveloper($dev) {
      $this->query("SELECT devid, devname FROM developer
                    WHERE devid = :dev ");
      $this->bind(':dev', $dev);
      $row = $this->single()['devname'];
      return $row;
      }
    public function getURL($ticket) {
      $this->query("SELECT ticketurl FROM request
                    WHERE ticket_number = :ticket ");
      $this->bind(':ticket', $ticket);
      $row = $this->single()['ticketurl'];
    }

    public function convertPriority($priority   ) {
      $this->query("SELECT priority from request
                    WHERE priority = :priority");
        $this->bind(':priority', $priority);
        $row = $this->single();
        return $row;
    }


    /** Process functions for valuation of objects and methods **/
    public function server() {
      $server = $_SERVER['SERVER_NAME'];
      return $server;
    }

    public function checkAssigned($check){
      $checkY = "Yes";
      $checkN = "No";
      if($check == 0) {
        return $checkN;
      }elseif($check == 1){
        return $checkY;
      }

    }

}



?>

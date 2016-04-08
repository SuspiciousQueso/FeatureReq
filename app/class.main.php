<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-08-2016
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
    private $name      = SITE_NAME;
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

    /***********************************
    **   Application Queries          **
    ***********************************/

    //Used to get our req ID and load it to the UI
    public function processReq($req) {
      $this->query("SELECT * FROM request
                    WHERE id = :req");
      $this->bind(':req', $req);
      $row = $this->single();
      return $row;
    }

    public function listTickets(){
      $this->query("SELECT * FROM request
                    WHERE assigned = 0");
      $rows = $this->resultset();
      return $rows;
    }

    public function pastDueTickets(){
      $this->query("SELECT id,client,targetdate,developer,ticket_number FROM request
                    WHERE targetdate <= CURDATE()");
      $rows = $this->resultset();
      return $rows;

    }
    // Used to Rotate our priority numbers for each client
    public function getPriority($client, $priority) {
      $this->query("SELECT client, priority, targetdate FROM request
                    WHERE client = :client AND priority = :priority");
      $this->bind(':client', $client);
      $this->bind(':priority', $priority);
      $row = $this->single();
      return $row;
    }

    // Used to get all data and return a single value from the request table
    public function getClientReq($client, $ticket) {
      $this->query("SELECT * FROM request
                    WHERE client = :client
                    AND ticket_number = :ticket");
      $this->bind(':client', $client);
      $this->bind(':ticket', $ticket);
      $row = $this->single();
      return $row;
    }

    // Used to select an array of client tickets
    public function getTickets($c) {
      $this->query("SELECT client, title, ticket_number, priority, assigned, created_date
                    FROM request WHERE client = :client");
      $this->bind(':client', $c);
      $row = $this->resultset();
      return $row;

    }

    // Used to convert client ID from INT value to it's Sting
    public function convertClient($client) {
      $this->query("SELECT clientid, clientname FROM clients
                    WHERE clientid = :client ");
      $this->bind(':client', $client);
      $row = $this->single()['clientname'];
      return $row;

    }

    // Used to populate a drop-down menu of developers
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


    /** Process functions for valuation of objects and methods **/

    // Populate server name variable
    public function server() {
      $server = $_SERVER['SERVER_NAME'];
      return $server;
    }

    // Used to see if a ticket for a client is assigned, and return a string value.
    public function checkAssigned($check){
      $checkY = "Yes";
      $checkN = "No";
      if($check == 0) {
        return $checkN;
      }elseif($check == 1){
        return $checkY;
      }

    }

    // Mthod to rotate priority for ticket based on form post, and date.
    public function rotatePriority($priority, $client){
      $pr = $priority;
      $c  = $client;
      $this->query("UPDATE request
        SET priority = CASE priority  WHEN 1 THEN 2
                        WHEN 2 THEN 3
                        ELSE priority
                        END
                WHERE priority = :priority AND client = :client
                AND targetdate <= CURDATE()");
      $this->bind(':priority', $priority);
      $this->bind(':client', $client);
      $this->execute();
    }

   public function genDate(){
     $createdDate = date('Y-m-d');
     return $createdDate;
   }

   public function navBar() {
     echo '';
   }
   public function header() {
     $title = $this->name;
     $head = '<!DOCTYPE html>
              <html lang="en">
              <head>
               <meta charset="UTF-8">
               <title>'.$title.'</title>
               <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
               <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
               <script src="bootstrap/js/bootstrap.min.js"></script>
               <style type="text/css">
                   body{
                   	padding-top: 70px;
                   }
               </style>
               </head>
               <body>
           	    <nav id="Navbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
           	    <!-- Brand and toggle get grouped for better mobile display -->
           	    <div class="container">
           		   <div class="navbar-header">
           			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
           				<span class="sr-only">Toggle navigation</span>
           				<span class="icon-bar"></span>
           				<span class="icon-bar"></span>
           				<span class="icon-bar"></span>
           			</button>
           			<a class="navbar-brand" href="#">Feature Request</a>
           		</div>
           		<!-- Collect the nav links, forms, and other content for toggling -->
           		<div class="collapse navbar-collapse" id="navbarCollapse">
           			<ul class="nav navbar-nav">
           				<li class="active"><a href="http://www.tutorialrepublic.com" target="_blank">Home</a></li>
           				<li><a href="http://www.tutorialrepublic.com/about-us.php" target="_blank">Login</a></li>
           				<li><a href="http://www.tutorialrepublic.com/contact-us.php" target="_blank">Contact</a></li>
           			</ul>
           		</div>
           	</div>
           </nav>';
    return $head;
       }
}


?>

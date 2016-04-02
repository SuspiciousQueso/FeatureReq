<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-02-2016
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
    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;
    private $req       = '_GET';
    private $server    = 'HTTP_HOST';

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
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

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

    public function getReq($req) {
      global ${$this->req};
      $this->query("SELECT id, title, client, priority from request where id = :req");
      $this->bind(':req', $req);
      $row = $this->single();
      return $row;
    }

    public function processReq($formData) {
      //global ${$this->formData};
      var_dump($this->formData);
      if(!empty($this->formData)) {
        $this->query('INSERT INTO request
          (client, title, description, target, product)
          VALUES (:client, :ftitle, :description, :datepicker, :product)');
          $this->bind(':client',      $this->formData["client"]);
          $this->bind(':ftitle',      $this->formData["ftitle"]);
          $this->bind(':description', $this->formData["description"]);
          $this->bind(':datepicker',  $this->formData["datepicker"]);
          $this->bind(':product',     $this->formData["product"]);
          $this->execute();
          $last = $this->lastInsertID();
          //header("Location: //192.168.0.3/FeatureReq/landing.php?req=$last");
          var_dump($this->formData);
          }else{
          var_dump($this->formData);
      }

    }

}



?>

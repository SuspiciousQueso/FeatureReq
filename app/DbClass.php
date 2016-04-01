<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
class DB {

    private $dbh;
    private $stmt;

    public function __construct($user, $pass, $dbname) {
        $this->dbh = new PDO(
            "mysql:host=localhost;dbname=$dbname",
            $user,
            $pass,
            array( PDO::ATTR_PERSISTENT => true )
        );
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
    public function insert_req() {
      
    }
}



?>

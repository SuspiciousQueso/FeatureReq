<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-02-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-02-2016
-->
<?php
include("db.Class.php");

class reqProcess extends DB {


  //public

  public function getReq($req) {
      $req = $_GET["req"];
      $db = new DB();
      $db->query("SELECT * from request where id = :req");
      $db->bind(':req', $req);
      $rows = $db->single();

      var_dump($rows);
    }


}


 ?>

<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
include("db.Class.php");
$req = $_GET["req"];

if (isset($_GET["req"])){
  $db = new DB();
  $db->query("SELECT * from request where id = :req");
  $db->bind(':req', $req);
  while ($rows = $db->resultset()) {
    $client = $rows['client'];
    
  }


}


 ?>

<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-04-2016
-->
<?php
require("db.Class.php");
$client    =  $_GET['ticket'];
$developer =  $_POST['developer'];
$ticket    =  $_GET['ticket'];
$server    =  $_SERVER['HTTP_HOST'];
if(isset($_POST["assign"])){
  $db = new DB();
    $db->query("UPDATE request SET assigned = 1, developer = :developer WHERE ticket_number = :ticket");
      $db->bind(':developer', $developer);
      $db->bind(':ticket',    $ticket);
      $db->execute();
      header("Location: http://$server/index.php?client=$client&ticket=$ticket");
}



 ?>

<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
require("../app/db.Class.php");
if(isset($_POST['submit'])) {
  $db = new DB();
  $server = $db->server();
    $db->query("UPDATE request SET assigned = :assigned, developer = :developer WHERE ticket_number = :ticket");
      $db->bind(':assigned',  $_POST['assigned']);
      $db->bind(':developer', $_POST['developer']);
      $db->bind(':ticket',    $_POST['ticket']);
      $db->execute();
      $client    =  $_POST['client'];
      $ticket    =  $_POST['ticket'];
      header("Location: http://$server/views/req.client.php?client=$client&ticket=$ticket&priority=1");
    }else{
      echo "Somethings not right";

    }
?>

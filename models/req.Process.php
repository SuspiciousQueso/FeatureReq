<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
require("../app/db.Class.php");
$db = new DB();
$server = $db->server();
// Instantiate DB class, and insert data from form.
if(isset($_POST["submit"])){
    // Insert into request tabel our Feature Request information
    $db->query("INSERT INTO request (title, description, client, priority, targetdate, product, created_date)
    VALUES (:title, :description, :client, :priority, :targetdate, :product, :created_date)");
      $db->bind(':title',       $_POST["title"]);
      $db->bind(':description', $_POST["description"]);
      $db->bind(':client',      $_POST["client"]);
      $db->bind(':priority',    $_POST["priority"]);
      $db->bind(':targetdate',  $_POST["targetdate"]);
      $db->bind(':product',     $_POST["product"]);
      $db->bind('created_date', $_POST['createdDate']);
      $db->execute();

      // Get our last inserted ID and generate our ticket_number and ticket URL
      $last = $db->lastInsertID();
      $db->query("UPDATE request SET ticket_number = concat('iws', :last) WHERE id = :last");
      $db->bind(':last', $last);
      $db->execute();

      $customer = $db->processReq($last);
      $url = 'http://' . $server . '/views/req.ticket.php?ticket=' . $customer['ticket_number'] . '&priority=' . $customer['priority'] . '&client=' . $customer['client'];
      $db->query("UPDATE request SET ticketurl = :url WHERE id = :last");
      $db->bind(':url', $url);
      $db->bind(':last', $last);
      $db->execute();
      header("Location: $url" );
      }else{
        echo "Something went wrong!";
}
?>

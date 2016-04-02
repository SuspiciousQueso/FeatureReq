<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-02-2016
-->
<?php
print_r($_POST);
require("db.Class.php");
$server = getenv('HTTP_HOST');
// Instantiate DB class, and insert data from form.
if(isset($_POST["submit"])){
  $db = new DB();
    $db->query("INSERT INTO request (title, description, client, priority, targetdate, ticketurl, product)
    VALUES (:title, :description, :client, :priority, :datepicker, :ticketurl, :product)");
      $db->bind(':title',       $_POST["title"]);
      $db->bind(':description', $_POST["description"]);
      $db->bind(':client',      $_POST["client"]);
      $db->bind(':priority',    $_POST["priority"]);
      $db->bind(':datepicker',  $_POST["datepicker"]);
      $db->bind(':ticketurl',   $_POST["ticketurl"]);
      $db->bind(':product',     $_POST["product"]);
      $db->execute();
      $last = $db->lastInsertID();
      header("Location: //$server/FeatureReq/index.php?req=$last");
      }else{
        echo "Something went wrong!";
}
?>

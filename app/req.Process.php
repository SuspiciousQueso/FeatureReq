<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-03-2016
-->
<?php
//print_r($_POST);
require("db.Class.php");
$server = getenv('HTTP_HOST');
// Instantiate DB class, and insert data from form.
if(isset($_POST["submit"])){
  $db = new DB();
    $db->query("INSERT INTO request (title, description, client, priority, targetdate, product)
    VALUES (:title, :description, :client, :priority, :datepicker, :product)");
      $db->bind(':title',       $_POST["title"]);
      $db->bind(':description', $_POST["description"]);
      $db->bind(':client',      $_POST["client"]);
      $db->bind(':priority',    $_POST["priority"]);
      $db->bind(':datepicker',  $_POST["datepicker"]);
      $db->bind(':product',     $_POST["product"]);
      $db->execute();
      $last = $db->lastInsertID();
      $priority = $_POST["priority"];
      $client = $_POST["client"];
      header("Location: http://$server/index.php?req=$last&priority=$priority&client=$client");
      }else{
        echo "Something went wrong!";
}
?>

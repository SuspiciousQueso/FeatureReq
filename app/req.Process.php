<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
require("db.Class.php");
$datestring = (isset($_POST['date_3'])) ? $_POST['date_3'] : "not";
$datestring = str_replace('/', '-', $datestring);
$datestamp = date("mm/dd/yyyy", strtotime($datestring));
echo   $datestring;
echo   var_dump($datestamp);
// Instantiate DB class, and insert data from form.
if(isset($_POST["submit"])){
  $db = new DB();

    $db->query('INSERT INTO request (client, title, description, target, product) VALUES (:client, :ftitle, :description, :datestamp, :product)');
      $db->bind(':client',      $_POST["client"]);
      $db->bind(':ftitle',      $_POST["ftitle"]);
      $db->bind(':description', $_POST["description"]);
      $db->bind(':datestamp',   $datestamp);
      $db->bind(':product',     $_POST["product"]);

      $db->execute();

      echo $db->lastInsertId();
}else{
  echo "Something went wrong!";
}
?>

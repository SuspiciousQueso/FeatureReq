<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
require("../cont/AppVars.php");


try {
    $db = new PDO($dsn, $un, $pw);
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}



?>

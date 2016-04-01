<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("DbClass.php");

$db = new DB('root', '!iG00gl311!', 'feartureREQ');

$row = $db->query('SELECT * FROM request WHERE id > ? LIMIT ?')
   ->bind(1, 2)
   ->bind(2, 1)
   ->single();

$db->bind(2,2);
$rs = $db->resultset();
?>

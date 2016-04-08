<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-08-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-08-2016
-->
<?php
include("app/db.Class.php");
$html = new DB();
$head = $html->head();
$nav  = $html->navBar();
?>

<?php echo $head;?>
<?php echo $nav; ?>


</body>
</html>

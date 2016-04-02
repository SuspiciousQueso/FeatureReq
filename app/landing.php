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
$db = new DB();
$db->query("SELECT * from request where id = :req");
$db->bind(':req', $req);
$rows = $db->single();



?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>IWS Feature Request</title>
 <link rel="stylesheet" type="text/css" href="../style/view.css" media="all">
  </head>
 <body id="main_body" >

 	<img id="top" src="../images/top.png" alt="">
 	<div id="form_container">
 		<h1><a>IWS Feature Request</a></h1>
    <form class="request"  method="post" action="">
      <div class="form_description">
         <h2>IWS Feature Request</h2>
            <p>Below you will find the details of your feature request.</p>
      </div>
    <label class="description" for="client">Customer</label>
    <p><?php echo $rows['client']; ?></p>
    </div>
  </form>
 	<img id="bottom" src="../images/bottom.png" alt="">
 </body>
</html>

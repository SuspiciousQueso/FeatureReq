<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-04-2016
-->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../app/db.Class.php');

$r = new DB();
$server   = $r->server();
$req      = $_GET["req"];
$priority = $_GET["priority"];
$c        = $_GET["client"];
$client   = $r->convertClient($c);

//$ticket   = $_GET['ticket'];
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
    <h1><a href="<?php echo "http://$server/"; ?>">IWS Feature Request</a></h1>
		<form class="request"  method="post" action="">
					<div class="form_description">
			         <h2>Thank you, your request has been processed. Please see the details below.</h2>
			          <p>Click on the link below to track all open tickets for <?php echo $client;?>.</p>
		</div>
    <table style="width:100%">
      <tr>
        <th>Customer Name</th>
        <th>Request Title</th>
        <th>Priority</th>
        <th>Expected Date</th>
        <th>Ticket Tracking URL</th>
      </tr>

     <tr>
        <td><?php echo $r->convertClient($client);?></a></td>
        <td><?php echo $r->processReq($req)['title']; ?></td>
        <td><?php echo $r->processReq($req)['priority']; ?></td>
        <td><?php echo $r->processReq($req)['targetdate'];?></td>
        <td><a href="<?php echo "http://$server/views/req.tickets.php?client=$c"; ?>">Open Tickets</a></td>
      </tr>


    </table>
  </div>
  </form>
 	<img id="bottom" src="../images/bottom.png" alt="">
 </body>
</html>

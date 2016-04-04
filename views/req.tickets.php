<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-04-2016
-->
<?php
if(isset($_GET['client']) && !isset($_GET['req'])) {
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  include('../app/db.Class.php');
  $r          = new DB();
  $server = $r->server();
  $client     = $_GET['client'];
  $title      = $r->getClientReq($client)['title'];
  $targetDate = $r->getClientReq($client)['targetdate'];
  $ticket     = $r->getClientReq($client)['ticket_number'];
  $assigned   = $r->getClientReq($client)['assigned'];
  $converted  = $r->convertClient($client);
  $status     = $r->assigned($assigned);
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
   <h1><a href="<?php echo $server; ?>">IWS Feature Request</a></h1>
   <form class="request"  method="post" action="">
     <div class="form_description">
        <h2>Open Tickets For <?php echo $converted; ?></h2>
           <p>Below you will find an overview for all open requests. Click the link to follow for a specific ticket.</p>
     </div>
      <table style="width:100%">
        <tr>
          <th>Feature Title</th>
          <th>Ticket Number</th>
          <th>Assigned</th>
          <th>Date Created</th>
        </tr>

<?php  foreach($r->getTickets($client) as $res) { ?>
        <tr>
          <td><a href="<?php echo "http://$server/views/req.client.php?client=$client&ticket=$ticket";?>"><?php echo $res['title'];?></a></td>
          <td><?php echo $res['ticket_number']; ?></td>
          <td><?php echo $status; ?></td>
          <td><?php echo $res['created_date']; ?></td>
        </tr>
<?php    } ?>

      </table>
   </div>
 </form>
 <img id="bottom" src="../images/bottom.png" alt="">
</body>
</html>
<?php } ?>

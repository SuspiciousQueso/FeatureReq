<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../app/db.Class.php');
  $r          = new DB();
  $server     = $r->server();
  $c          = $_GET['client'];
  $converted  = $r->convertClient($c);
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
   <h1><a href="<?php echo "http://$server"; ?>">IWS Feature Request</a></h1>
   <form class="request"  method="post" action="">
     <div class="form_description">
        <h2>Open Tickets For <?php echo $converted; ?></h2>
           <p>Below you will find an overview for all open requests. Click the links to individual tickets.</p>
     </div>
      <table style="width:100%">
        <tr>
          <th>Feature Title</th>
          <th>Ticket Number</th>
          <th>Priority</th>
          <th>Assigned</th>
          <th>Date Created</th>
        </tr>

<?php  foreach($r->getTickets($c) as $res) {
        $ticketnum = $res['ticket_number'];
        ?>
        <tr>
          <td><a href="<?php echo "http://$server/views/req.clientticket.php?client=$c&ticket=$ticketnum";?>"><?php echo $res['title'];?></a></td>
          <td><?php echo $res['ticket_number']; ?></td>
          <td><?php echo $res['priority'];?></td>
          <td><?php echo $r->checkAssigned($res['assigned']);?></td>
          <td><?php echo $res['created_date']; ?></td>
        </tr>
<?php } ?>
      </table>
      <br />
      <br />
      Or click <a href="<?php echo "http://$server/index.php";?>">here</a> to return to the form. 
   </div>
 </form>
 <img id="bottom" src="../images/bottom.png" alt="">
</body>
</html>

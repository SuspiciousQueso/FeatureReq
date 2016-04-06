<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
if(isset($_GET['ticket']) && isset($_GET['client'])){
  include('../app/db.Class.php');
  $r            = new DB();
  $server       = $r->server();
  $client       = $_GET['client'];
  $ticket       = $_GET['ticket'];
  $query        = $r->getClientReq($client, $ticket);
  $dev          = $query['developer'];
  $assignedTo   = $r->showDeveloper($dev);
  $converted    = $r->convertClient($client);
  $isassigned   = $query['assigned'];
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
   <h1><a href="<?php echo $server;?>">IWS Feature Request</a></h1>
   <form class="request"  method="post" action="">
     <div class="form_description">
        <h2>Ticket <?php echo $ticket; ?> For <?php echo $converted; ?></h2>
           <p>This ticket is currently <?php if($isassigned == 0){ ?> not assigned.
              Click <a href="<?php echo "http://$server/views/req.assign.php?ticket=$ticket&client=$client";?>">
               here</a> to assign the ticket.
            <?php }else{ ?> assigned to <?php echo $assignedTo; }?>
          </p>
     </div>
      <table style="width:100%">
        <tr>
            <th>Feature Title</th>
            <th>Ticket Number</th>
            <th>Assigned</th>
            <th>Date Created</th>
            <th>Date Expected</th>
        </tr>
        <tr>
          <td><?php echo $query['title'];?></a></td>
          <td><?php echo $query['ticket_number'];?></td>
          <td><?php echo $r->checkAssigned($isassigned);?></td>
          <td><?php echo $query['created_date']; ?></td>
          <td><?php echo $query['targetdate']; ?></td>
        </tr>
      </table>
   </div>
 </form>
 <img id="bottom" src="../images/bottom.png" alt="">
</body>
</html>
<?php } ?>

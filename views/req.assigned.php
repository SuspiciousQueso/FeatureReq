<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-05-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php /** Assignment update retun **/
include('../app/db.Class.php');
$r          = new DB();
$server     = $r->server();
$client     = $_GET['client'];
$ticket     = $_GET['ticket'];
$query      = $r->getClientReq($client, $ticket);
$dev        = $query['developer'];
$assignedTo = $r->showDeveloper($dev);
$converted  = $r->convertClient($client);
$assigned = $query['assigned'];
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
   <h1><a href="">IWS Feature Request</a></h1>
   <form class="request"  >
     <div class="form_description">
        <h2>Ticket# <?php echo $ticket; ?> for <?php echo $converted; ?> is NOW assigned to developer: <br /> <?php echo $assignedTo; ?></h2>
     </div>
      <table style="width:100%">
        <tr>
            <th>Title</th>
            <th>Ticket Number</th>
            <th>Priority</th>
            <th>Date Created</th>
            <th>Date Expected</th>
        </tr>
        <tr>
          <td><?php echo $query['title'];?></td>
          <td><?php echo $query['ticket_number'];?></td>
          <td><?php echo $query['priority']; ?></td>
          <td><?php echo $query['created_date']; ?></td>
          <td><?php echo $query['targetdate']; ?></td>
        </tr>
      </table>
			<br />
			<br />
			Click <a href="<?php echo "http://$server/views/req.ticketlist.php?client=$client"?>">Here</a> To Return To Ticket List for <?php echo $converted;?>
   </div>
 </form>
 <img id="bottom" src="../images/bottom.png" alt="">
</body>
</html>

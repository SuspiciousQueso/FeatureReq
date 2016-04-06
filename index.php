<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-06-2016
-->
<?php
  include('app/db.Class.php');
  $r = new DB();
  $server = $r->server();
  $createdDate = date('Y-m-d');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>IWS Feature Request</title>
<link rel="stylesheet" type="text/css" href="views/style/view.css" media="all">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="views/js/view.js"></script>
</head>
<body id="main_body" >

<img id="top" src="views/images/top.png" alt="">
	<div id="form_container">
		<h1><a href="<?php echo $r->server(); ?>">IWS Feature Request</a></h1>
		<form class="request" >
					<div class="form_description">
			         <h2>Welcome to the IWS Feature Request System.</h2>
			            <p>Please use the links below to navigate in the system.</p>
		      </div>
          <h3>All unassigned tickets per client</h3>
          <table width="100%">
                    <tr>
                        <th>Ticket Number</th>
                        <th>Client Name</th>
                        <th>Date Created</th>
                    </tr>

            <?php  foreach($r->listTickets() as $res) {
                    $clientname = $r->convertClient($res['client']);
                    ?>
                    <tr>
                      <td><a href="<?php echo "http://$server/views/req.clientticket.php?client=$c&ticket=$ticketnum";?>"><?php echo $res['ticket_number'];?></a></td>
                      <td><?php echo $clientname; ?></td>
                      <td><?php echo $res['created_date'];?></td>
                    </tr>
            <?php } ?>
          </table>
          <br />
          <br />
          <h3>Tickets that are assigned, but past due.</h3>
          <table width="100%">
                    <tr>
                        <th>Ticket Number</th>
                        <th>Assigned To</th>
                        <th>Client Name</th>
                        <th>Date Created</th>
                    </tr>

            <?php  foreach($r->pastDueTickets() as $res) {
                    $clientname = $r->convertClient($res['client']);
                    $dev        = $r->showDeveloper($res['developer']);
                    ?>
                    <tr>
                      <td><a href="<?php echo "http://$server/views/req.clientticket.php?client=$c&ticket=$ticketnum";?>"><?php echo $res['ticket_number'];?></a></td>
                      <td><?php echo $dev;?></td>
                      <td><?php echo $clientname; ?></td>
                      <td><?php echo $res['created_date'];?></td>
                    </tr>
            <?php } ?>
          </table>
          <br />
          <br />
          <h3>System Navigation Links</h3>
          <table width="100%">
                    <tr>
                        <th>Open A New Request</th>
                        <th>View All Tickets By client</th>
                        <th>Login To Admin</th>
                    </tr>
                    <tr>
                        <td><a href="<?php echo "http://$server/views/req.form.php"?>"</a>Request Form</td>
                        <td>
                          <script type="text/javascript">
                              <!--//
                                  change(val) {
                                  document.clientselect.action = "http://<?php $server;?>/views/req.ticketlist.php?client="+val;}
                                  //-->
                          </script>
                          <form id="clientselect" method="post" name="clientselect" action=http://<?php $server;?>/views/req.ticketlist.php?client='' target="_self" >
                            <select onChange="change(this.value)" class="element select medium" id="client" name="client" >
              			            <option value="3" selected="selected">Choose client</option>
              			            <option value="0" >Client A</option>
              			            <option value="1" >Client B</option>
              			            <option value="2" >Client C</option>
                            </select>
                            <li class="buttons">
                            <input id="createdDate" type="hidden" name="" value="" />
                            <input id="pickclient" class="button_text" type="submit" name="submit" value="Submit" />
                        </td>
                        <td><a href="">Admin Login</a></td>
                    </tr>
	        </div>

		</form>
	</div>
	<!-- <img id="bottom" src="views/images/bottom.png" alt=""> -->
	</body>
</html>

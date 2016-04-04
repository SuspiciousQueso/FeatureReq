<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-04-2016
-->
<?php
if(isset($_GET['ticket'])) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include('../app/db.Class.php');
  $r          = new DB();
  $server     = $r->server();
  $client     = $_GET['client'];
  $title      = $r->getClientReq($client)['title'];
  $targetDate = $r->getClientReq($client)['targetdate'];
  $ticket     = $r->getClientReq($client)['ticket_number'];
  $assigned   = $r->getClientReq($client)['assigned'];
  $developer  = $r->getClientReq($client)['developer'];
  $created    = $r->getClientReq($client)['created_date'];
  $assignedTo = $r->pickDeveloper($developer);
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
   <h1><a href="<?php echo $server;?>">IWS Feature Request</a></h1>
   <form class="request"  method="post" action="../app/db.Assign.php">
     <div class="form_description">
        <h2>IWS Assign Ticket To Developer.</h2>
           <p>Please choose what developer you want to assign the ticket <?php echo $ticket;?> to. </p>
     </div>
     <ul >
       <li id="li_4" >
 		    <label class="description" for="client">Select the developer </label>
 		      <div>
 		          <select class="element select medium" id="developer" name="developer">
 			            <option value="" selected="selected"></option>
 			            <option value="1" >Billy R Baldwin</option>
 			            <option value="2" >Robert Heinlein</option>
 			            <option value="3" >Superman Jones</option>
                  <option value="4" >Harry Potter</option>
              </select>
              <li class="buttons">
              <input id="assigned" type="hidden" name="assigned" value="1" />
              <input id="developer" type="hidden" name="developer" value="<?php echo $dev;?>" />
              <input id="createdDate" type="hidden" name="createdDate" value="<?php echo $createdDate;?>" />

    				<input id="saveForm" class="button_text" type="submit" name="assign" value="Assign" />
    		</li>
      </ul>
 	      </div>
      </div>
    </form>
    <img id="bottom" src="../images/bottom.png" alt="">
  </body>
</html>
<?php }?>

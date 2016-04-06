<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-04-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
-->
<?php
if(isset($_GET['ticket'])) {
  include('../app/db.Class.php');
  $r          = new DB();
  $server     = $r->server();
  $client     = $_GET['client'];
  $ticket     = $_GET['ticket'];
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
   <form class="request"  method="post" action="../models/req.Assign.php">
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
            <?php
            foreach ($r->pickDeveloper() as $res){?>

 			            <option value="<?php echo $res['devid'];?>" ><?php echo $res['devname']; ?></option>

              <?php } ?>
              </select>
              <li class="buttons">

            <input id="" type="hidden" name="client" value="<?php echo $client;?>"></input>
            <input id="" type="hidden" name="assigned" value="1" />
            <input id="" type="hidden" name="ticket" value="<?php echo $ticket;?>"></input>
            <input id="assign" class="button_text" type="submit" name="submit" value="Submit" />
    		</li>
      </ul>
 	      </div>
      </div>
    </form>
    <img id="bottom" src="../images/bottom.png" alt="">
  </body>
</html>
<?php }?>

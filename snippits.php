<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-08-2016
-->
<select class="element select medium" id="developer" name="developer">
    <option value="" selected="selected"></option>
    <option value="1" >Billy R Baldwin</option>
    <option value="2" >Robert Heinlein</option>
    <option value="3" >Superman Jones</option>
    <option value="4" >Harry Potter</option>
</select>

<?php
$num_of_ids = 10000;
$i = 0;
$n = 0;
$l = "IWSA";

while ($i <= $num_of_ids) {
    $id = $l . sprintf("%04d", $n);
    echo $id;

    if ($n == 9999) {
        $n = 0;
        $l++;
    }

    $i++; $n++;
}

 ?>

public function insert($table, $fields = array()) {
    $keys   = array_keys($fields);
    $values = null;
    $x      = 1;

    foreach($fields as $value) {
        $values .= "?";
        if($x < count($fields)) {
            $values .= ', ';
        }
        $x++;
    }

    $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

    if(!$this->query($sql, $fields)->error()) {
        return true;
    }

    return false;
}



// Get our values from url
if (isset($_GET['priority']) and isset($_GET['ticket'])) {
  $this->priority = $_GET['priority'];
  $this->ticket = $_GET['ticket'];
}else{
  $this->priority = NULL;
  $this->req = NULL;
}

if (isset($_GET['client'])) {
  $this->client = $_GET["client"];
}else{
  $this->client = NULL;
}



    client ftitle description date date_1 date_2 date_3 product


    /** old inde.php **/

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
                        $c = $res['client'];
                        $ticketnum =$res['ticket_number'];
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
                            <th>Target Date</th>
                        </tr>

                <?php  foreach($r->pastDueTickets() as $res) {
                        $clientname = $r->convertClient($res['client']);
                        $dev        = $r->showDeveloper($res['developer']);
                        ?>
                        <tr>
                          <td><a href="<?php echo "http://$server/views/req.clientticket.php?client=$c&ticket=$ticketnum";?>"><?php echo $res['ticket_number'];?></a></td>
                          <td><?php echo $dev;?></td>
                          <td><?php echo $clientname; ?></td>
                          <td><?php echo $res['targetdate'];?></td>
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
                              <form id="clientselect" method="post" name="clientselect" action="" target="" >
                                <select class="element select medium" id="client" name="client" >
                  			            <option value="3" selected="selected">Choose client</option>
                  			            <option value="0" >Client A</option>
                  			            <option value="1" >Client B</option>
                  			            <option value="2" >Client C</option>
                                </select>
                                <li class="buttons">
                                <input id="pickclient" class="button_text" type="submit" name="submit" value="Submit" />
                            </td>
                            <td><a href="">Admin Login</a></td>
                          </tr>
                  </div>
            </form>
    	</div>
    	<!-- <img id="bottom" src="views/images/bottom.png" alt=""> -->

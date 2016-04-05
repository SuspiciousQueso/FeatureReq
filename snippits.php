<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-05-2016
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

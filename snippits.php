<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
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


if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (!$_POST['name'] || !$_POST['email'] || !$_POST['phone'] || !$_POST['detail'] || !$_POST['cost']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {
                $DBH = new PDO($dsn, $user, $pass, $opt);
                $STH = $DBH->prepare("INSERT INTO data (name,email,phone,detail,cost) VALUES (:name,:email,:phone,:detail,:cost)");

                $STH->bindParam(':name', $_POST['name']);
                $STH->bindParam(':email', $_POST['email']);
                $STH->bindParam(':phone', $_POST['phone']);
                $STH->bindParam(':detail', $_POST['detail']);
                $STH->bindParam(':cost', $_POST['cost']);

                $STH->execute();

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo "<p>Data submitted successfully</p>";

        }
    }

    client ftitle description date date_1 date_2 date_3 product

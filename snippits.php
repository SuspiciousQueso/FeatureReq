<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->



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

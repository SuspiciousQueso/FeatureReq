<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-04-2016
-->
<?php
if($_SERVER['SERVER_NAME'] == '192.168.0.3') {
    // Define local dev configuration
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "!iG00gl311!");
    define("DB_NAME", "featurereq");
    define('BASE_URL', 'HTTP_TYPE' . "://" . 'HTTP_ROOT' . substr(__DIR__, strlen($_SERVER[ 'DOCUMENT_ROOT'])) . '/');

}elseif($_SERVER['SERVER_NAME'] == 'http://featurereq-env.us-west-2.elasticbeanstalk.com'){
    //Define AWS EB instance configuration
    define("DB_HOST", "aa19v9m8yhs4gc1.cjuto6cbmgfi.us-west-2.rds.amazonaws.com");
    define("DB_USER", "brbaldwin");
    define("DB_PASS", "!iG00gl311!");
    define("DB_NAME", "ebdb");
}
?>

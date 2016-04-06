<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   04-01-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-06-2016
-->
<?php
    // Define local dev configuration
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "!iG00gl311!");
    define("DB_NAME", "featurereq");
    define('BASE_URL', 'HTTP_TYPE' . "://" . 'HTTP_ROOT' . substr(__DIR__, strlen($_SERVER[ 'DOCUMENT_ROOT'])) . '/');

?>

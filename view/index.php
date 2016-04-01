<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 03-31-2016
-->
<?php
include("model/oop_forms.php");
$form = new Form("Register", "form.php");

$personal = new Block("Personal Information");

$name = new Text("name", "Your name");
$name->setDescription("this is my description");
$name->addValidator(new MaxLengthValidator("The name you have entered is too long", 30));


?>

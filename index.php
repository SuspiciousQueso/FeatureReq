<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-08-2016
-->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  include('app/class.main.php');
  $r = new DB();

echo $r->header();?>
<div class="container">
	<div class="jumbotron">
		<h1>Welcome to the FeatureReq System</h1>
		<p>This is the place you will request new features in our application streams. Like <a href="policies"</a> Policies</p>

	</div>
	<div class="row">
		<div class="col-xs-4">
			<h2>Client Login</h2>
			<p>If you are an existing customer, click here to login to view your active and past requests.</p>
			<p><a href="" target="_blank" class="btn btn-success">Client Login &raquo;</a></p>
		</div>
		<div class="col-xs-4">
			<h2>Administrator Login</h2>
			<p>Account Administrator Login.</p>
			<p><a href="http://www.tutorialrepublic.com/css-tutorial/" target="_blank" class="btn btn-success">Admin Login </a></p>
		</div>
		<div class="col-xs-4">
			<h2>Create Account</h2>
			<p>.</p>
			<p><a href="http://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank" class="btn btn-success">Learn More &raquo;</a></p>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<footer>
				<p>&copy; <?php echo date('Y');?> Infini-Loop Solutions</p>
			</footer>
		</div>
	</div>
</div>

	</body>
</html>

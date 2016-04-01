<!--
@Author: Billy R Baldwin <bbaldwin>
@Date:   03-31-2016
@Email:  billyraybaldwin@gmail.com
@Project: FeatureREQ
@Last modified by:   bbaldwin
@Last modified time: 04-01-2016
-->
<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>IWS Feature Request</title>
<link rel="stylesheet" type="text/css" href="style/view.css" media="all">
<script type="text/javascript" src="js/view.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
</head>
<body id="main_body" >

	<img id="top" src="images/top.png" alt="">
	<div id="form_container">

		<h1><a>IWS Feature Request</a></h1>
		<form id="form_1119565" class="request"  method="post" action="">
					<div class="form_description">
			<h2>IWS Feature Request</h2>
			<p>Welcom to the IWS Feature Request Form.</p>
		</div>
			<ul >

					<li id="li_4" >
		<label class="description" for="element_4">Select Your Customer Name </label>
		<div>
		<select class="element select medium" id="element_4" name="element_4">
			<option value="" selected="selected"></option>
<option value="1" >Client A</option>
<option value="2" >Client B</option>
<option value="3" >Client C</option>

		</select>
		</div><p class="guidelines" id="guide_4"><small>Please select the name that corresponds to your companies name</small></p>
		</li>		<li id="li_1" >
		<label class="description" for="element_1">Feature Title </label>
		<div>
			<input id="element_1" name="element_1" class="element text medium" type="text" maxlength="255" value=""/>
		</div><p class="guidelines" id="guide_1"><small>Please enter a general title for your feature request.</small></p>
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Feature Description </label>
		<div>
			<textarea id="element_2" name="element_2" class="element textarea medium"></textarea>
		</div><p class="guidelines" id="guide_2"><small>Please enter a longer description for your feature request</small></p>
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Expected Date </label>
		<span>
			<input id="element_3_1" name="element_3_1" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_1">MM</label>
		</span>
		<span>
			<input id="element_3_2" name="element_3_2" class="element text" size="2" maxlength="2" value="" type="text"> /
			<label for="element_3_2">DD</label>
		</span>
		<span>
	 		<input id="element_3_3" name="element_3_3" class="element text" size="4" maxlength="4" value="" type="text">
			<label for="element_3_3">YYYY</label>
		</span>

		<span id="calendar_3">
			<img id="cal_img_3" class="datepicker" src="calendar.gif" alt="Pick a date.">
		</span>
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_3_3",
			baseField    : "element_3",
			displayArea  : "calendar_3",
			button		 : "cal_img_3",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script>
		<p class="guidelines" id="guide_3"><small>Please enter a reasonable date you hope to have this feature implemented.</small></p>
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Product Selection </label>
		<div>
		<select class="element select medium" id="element_5" name="element_5">
			<option value="" selected="selected"></option>
<option value="1" >Policies</option>
<option value="2" >Billing</option>
<option value="3" >Claims</option>
<option value="4" >Reports</option>

		</select>
		</div><p class="guidelines" id="guide_5"><small>Please indicate what product this feature is intended for. </small></p>
		</li>

					<li class="buttons">
			    <input type="hidden" name="form_id" value="1119565" />

				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>

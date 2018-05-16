<?php 
//index.php

$foodTruckName = 'Go Food Truck Go!';
?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<title><?= $foodTruckName ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="css/ie7.css">	
	<![endif]-->
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="css/ie6.css">	
	<![endif]-->
</head>
<body>
	<div id="header"> <!-- start of header -->
		<span class="signboard"></span>
		<ul id="infos">
			<li class="home"> 
				<a href="index.html">HOME</a> 
			</li>

	       <li class="address">
				<a href="contact.html">buford@foodtruck.com</a> 
			</li>
		</ul>
		<a href="#" id="logo"></a>
		<ul id="navigation">
			<li><a href="#"><span>Home</span></a></li>
			<li class="main current"><a href="index.php"><span>Menu</span></a></li>
			<li><a href="#"><span>Booking</span></a></li>
			<li><a href="#"><span>Blog</span></a></li>
		</ul> <!-- /#navigation -->
	</div> <!-- end of header -->
	<div id="contents"> <!-- start of contents --> 
		        
        
    <div class="orderform">
        <?php include "includes/foodtruck_postback.php" ?>
    </div>
    
    </div>		
	<div id="footer"> <!-- start of footer -->
		<ul class="advertise">
			<li class="delivery">
				<h2>Hungry? We Deliver</h2>
				<a href="#">Download our Menu</a>
			</li>
			<li class="event">
				<h2>Party! Party!</h2>
				<p>Celebrate your</p>
				<p>Special Events with Us</p>
			</li>
			<li class="connect">
				<h2>Let's Keep in Touch</h2>
				<a href="http://facebook.com/freewebsitetemplates" target="_blank" class="fb" title="Facebook"></a> 
				<a href="http://twitter.com/fwtemplates" target="_blank" class="twitr" title="Twitter"></a>
			</li>
		</ul>
		<div>
			<ul class="navigation">
				<li><a href="#">Home</a></li>
				<li><a href="#">Book an event</a></li>
				<li><a href="#">Blog</a></li>
				<li><a href="#">About</a></li>
				<li class="last"><a href="#">Contact</a></li>
			</ul>
			<span>&copy; Copyright 2018. All Rights Reserved.</span>
		</div>
	</div> <!-- end of footer -->
</body>
</html>

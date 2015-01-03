<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php

		include("include.php"); 

		// TODO: Check session data to see if the user is trying to cheat
		// his/her way into the login screen
		// Probably use auth.php to verify session accuracy

		?>
</head>
<body>	

	<?php include('../common/header.php'); echo_header('Diver'); ?>

	<div class="container container-fluid">
		<div class="nav-offset"></div>
		<div class="row">
			<a href="./goals.php">
				<div class="adminHomeItem">
					<h3>My Goals</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>	
		<div class="row">
			<a href="./practices.php">
				<div class="adminHomeItem">
					<h3>Practices</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>
		
		<div class="ftr-offset"></div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li class="current"><span class="glyphicon glyphicon-home"></span><p>Home</p></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
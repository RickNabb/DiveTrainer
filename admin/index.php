<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>
</head>
<body>
	
	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="container container-fluid">
		<div class="nav-offset"></div>
		<div class="row">
			<a href="./practices.php?display=today">
				<div class="adminHomeItem current">
					<h3>Today's Practice</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>	
		<div class="row">
			<a href="./makePractice.php">
				<div class="adminHomeItem">
					<h3>Plan Next Practice</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>
		<div class="row">
			<a href="./divers.php">
				<div class="adminHomeItem">
					<h3>Your Divers</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>
		<div class="row">
			<a href='./skills.php'>
				<div class="adminHomeItem">
					<h3>View Skills</h3>
					<span class="glyphicon glyphicon-chevron-right"></span>
				</div>
			</a>
		</div>
		<div class="ftr-offset"></div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li class="current"><span class="glyphicon glyphicon-home"></span><p>Home</p></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
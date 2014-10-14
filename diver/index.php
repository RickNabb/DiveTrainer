<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>
</head>
<body>
	<div class="topNav">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h4 class="white ptsans">Welcome, <?php session_start(); echo $_SESSION['dive_trainer']['fname']; ?>!</h4>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<p class="navbar-title">Diver</p>
				</div>			
			</div>
		</nav>
	</div>


	<div class="container container-fluid">
		<div class="nav-offset"></div>
		<div class="row">
			<a href="./goals.php">
				<div class="adminHomeItem current">
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
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
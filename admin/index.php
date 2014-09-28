<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>
</head>
<body>
	<div class="row blue">
		<div class="col-sm-offset-1 col-xs-offset-1">
			<h4 class="white ptsans">Welcome, Cliff!</h4>
		</div>
	</div>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<!--<span class="glyphicon glyphicon-chevron-left back-arrow"></span>-->
				<p class="navbar-title">Coach</p>
			</div>			
		</div>
	</nav>


	<div class="container container-fluid">		
		<div class="row">
			<div class="adminHomeItem current">
				<h3>Today's Practice</h3>
				<span class="glyphicon glyphicon-chevron-right"></span>
			</div>
		</div>	
		<div class="row">
			<div class="adminHomeItem">
				<h3>Plan Next Practice</h3>
				<span class="glyphicon glyphicon-chevron-right"></span>
			</div>
		</div>
		<div class="row">
			<div class="adminHomeItem">
				<h3>Your Divers</h3>
				<span class="glyphicon glyphicon-chevron-right"></span>
			</div>
		</div>
		<div class="row">
			<div class="adminHomeItem">
				<h3>Make Note</h3>
				<span class="glyphicon glyphicon-chevron-right"></span>
			</div>
		</div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li class="current"><span class="glyphicon glyphicon-home"></span><p>Home</p></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
		include("include.php"); 
		require_once("./../bootstrap.php");
		require_once('../db.php'); // HACK : Since bootstrap.php looks in the wrong folder
	?>
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
			<div class="col-xs-offset-1">
				<h4>All Divers</h4>
			</div>
		</div>

		<?php
			$conn = getConnection();
			$query = sprintf("SELECT * FROM %s",
				DIVERS_TABLE);

			$result = mysql_query($query, $conn);
			if(!$result){
				$message = "Error finding divers";
				throw new Exception($message);
			}

			while($row = mysql_fetch_assoc($result)){
					echo '<div class="row">';
					echo '<div class="adminHomeItem">';
					echo "<h4>" . $row['fname'] . ' ' . $row['lname'] . "</h4></div></div>";
			}

		?>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Divers</p></li>
			<li><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
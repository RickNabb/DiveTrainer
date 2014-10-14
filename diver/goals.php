<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
		include("include.php"); 
		session_start(); 
	?>
</head>
<body>
	<div class="topNav">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h4 class="white ptsans">Welcome, <?php echo $_SESSION['dive_trainer']['fname']; ?>!</h4>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<!--<span class="glyphicon glyphicon-chevron-left back-arrow"></span>-->
					<p class="navbar-title">Diver</p>
				</div>			
			</div>
		</nav>
	</div>


	<div class="container container-fluid">

		<div class="nav-offset"></div>

		<div class="row">
			<div style="margin-left: 10px; color: #21aeff;" class="pull-left"><h4>Goals</h4></div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makeGoal.php';"></span>
			</div>
		</div>

		<?php
			$conn = getConnection();
			$query = sprintf("SELECT * FROM %s WHERE diverId = %s", 
			mysql_real_escape_string(GOALS_TABLE), 
			mysql_real_escape_string($_SESSION['dive_trainer']['userId']));

			$result = mysql_query($query, $conn);
			if(!$result){
				$message = "Error retrieving practices";
				throw new Exception($message);
			}

			while($row = mysql_fetch_assoc($result)){

				echo "<div class='row'>
						<div class='adminHomeItem'>
							<h3>".$row['name'].": </h3><h4>"
							.date("m/d/y", strtotime($row['startDate']))." - "
							.date("m/d/y", strtotime($row['endDate']))."</h4>
							<span class='glyphicon glyphicon-chevron-right'></span>
						</div>
					</div>";
			}
		?>

		<div class="ftr-offset"></div>
	</div>
	
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Goals</p></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
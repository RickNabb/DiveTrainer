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
	
	<?php include('header.php'); echo_header('Goals'); ?>

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
	
	<?php include('footer.php'); ?>
</body>
</html>
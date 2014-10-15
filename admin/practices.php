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
			<select style="margin-left: 10px; color: #21aeff; font-size: 20px; border:none;" 
				id="select_practice_filter" class="pull-left">
				<option>Past 10 Practices</option>
				<option>Past Week's Practices</option>
				<option>Past Month's Practices</option>
				<option>All Past Practices</option>
			</select>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makePractice.php';"></span>
			</div>
		</div>

		<?php

			$conn = getConnection();
			$query = sprintf("SELECT * FROM %s",
				PRACTICES_TABLE);

			$result = mysql_query($query, $conn);
			if(!$result){
				$message = "Error retrieving practices";
				throw new Exception($message);
			}

			if(mysql_num_rows($result) == 0){
				echo "<div class='row row-offset-md'>
						<div class='col-xs-offset-1 col-sm-offset-1'>
							<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>
							<h4 style='color: #ccc;'>Make some practices with the icon at the top.</h4>
						</div>
					   </div>";
			}
			else{
				while($row = mysql_fetch_assoc($result)){

					$date = new DateTime();
					$dateItems = split('[/.-]', $row['date']);
					$date->setDate(intval($dateItems[0]), intval($dateItems[1]), intval($dateItems[2]));

					echo "<div class='row'>
							<div class='adminHomeItem'>
								<h3>" . date_format($date, 'F jS, Y') . "</h3>
								<span class='glyphicon glyphicon-chevron-right'></span>
							</div>
						</div>";
				}
			}

		?>		

		<div class="ftr-offset"></div>
	</div>
		

	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php
		  include("include.php");
		  session_start(); 
	?>

	<script>

		function filterPractices(){
			
			var filter = $("#select_practice_filter").val();
			switch(filter){
				case "Past 10 Practices":
					var date_now = new Date();
					date_now = date_now.getDate();

					$("div[id*='practice_']").each(function(){
						var date = new Date($(this).val());
						if(date < date_now - 10){
							$(this).hide();
						}
					});
					break;
				case "Past Week's Practices":
					break;
				case "Past Month's Practices":
					break;
				case "All Past Practices":
					break;
			}
		}

	</script>
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
					<p class="navbar-title">Practices</p>
				</div>			
			</div>
		</nav>
	</div>


	<div class="container container-fluid">

		<div id="loaderDiv">
			<img src="./img/loader.gif" alt="Loading..."/>
			<h4>Please wait...</h4>
		</div>

		<div class="nav-offset"></div>

		<div class="row">
			<select style="margin-left: 10px; color: #21aeff; font-size: 20px; border:none;" 
				id="select_practice_filter" class="pull-left">
				<option>Past 10 Practices</option>
				<option>Past Week's Practices</option>
				<option>Past Month's Practices</option>
				<option>All Past Practices</option>
			</select>
		</div>

		<?php

			$conn = getConnection();
			$query = sprintf("SELECT * FROM %s",
				PRACTICES_TABLE);

			// TODO: Write SQL to first fetch divers->practice table results for diverId,
			// then join with practice and get practice data

			$result = mysql_query($query, $conn);
			if(!$result){
				$message = "Error retrieving practices";
				throw new Exception($message);
			}

			if(mysql_num_rows($result) == 0){
				echo "<div class='row row-offset-md'>
						<div class='col-xs-offset-1 col-sm-offset-1'>
							<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>
							<h4 style='color: #ccc;'>Ask your coach to add you to some practices!</h4>
						</div>
					   </div>";
			}
			else{
				while($row = mysql_fetch_assoc($result)){

					$date = new DateTime();
					$dateItems = split('[/.-]', $row['date']);
					$date->setDate(intval($dateItems[0]), intval($dateItems[1]), intval($dateItems[2]));

					echo "<div class='row'>
							<div class='goalItem' id='practice_" . $row['practiceId'] . "'>
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
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
		</ul>
	</div>
</body>
</html>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		$( document ).ready( load_goals );
		
		function load_goals() {
			var id = <?php echo $_SESSION["dive_trainer"]["userId"]; ?>;
			
			$.ajax({
				type: "GET",
				url: "../common/goal.php",
				data: { method: "get_goals_for_diver",
						diverId: id },
				dataType: "json"
				}).success(function( result ) {
					var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

					// No practices found
					if (result.length == 0) {
						$( "#goals" ).after(
						"<div class='row row-offset-md'>" +
							"<div class='col-xs-offset-1 col-sm-offset-1'>" +
								"<h4 style='color: #ccc;'>We didn't find any goals!<br/>Add some using the green button above.</h4><br/>" +
							"</div>" +
						"</div>");
					}
					
					// Make a row for each practice
					for (var i = 0; i < result.length; i++) {
						var d = new Date(result[i].startDate);
						var startDate = d.toLocaleDateString("en-US");
						
						d = new Date(result[i].endDate);
						var endDate = d.toLocaleDateString("en-US");
						
						$( "#goals" ).after(
						"<div class='row'>" +
							"<div class='adminHomeItem'>" +
								"<h4>" + (result[i].name == '' ? '(No name given)' : result[i].name) + "</h4><p>" + startDate + " - " + endDate + 
								"</p><span class='glyphicon glyphicon-chevron-right' onclick=\"loadGoal(" + result[i].goalId + ");\"></span>" +
							"</div>" +
						"</div>");
					}
			});
		}

		// Navigates to the view page for a specific goal
		function loadGoal(goalId) {
			window.location = "viewGoal.php?goalId=" + goalId;
		}
		
	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('Goals'); ?>

	<div class="container container-fluid">

		<div class="nav-offset"></div>

		<div id="filter" class="row">
			<div style="margin-left: 10px; color: #21aeff;" class="pull-left"><h4>Goals</h4></div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makeGoal.php?id=<?php echo $_SESSION["dive_trainer"]["userId"]; ?>';"></span>
			</div>
		</div>

		<?php if(isset($_GET['success']) && $_GET['success'] == 'false') { ?>
		<div class="row row">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-danger">
				<strong>Error:</strong>
				<span>There was an issue creating the goal. Please try again.</span>
			</div>
		</div>
		<?php } ?>

		<?php if(isset($_GET['success']) && $_GET['success'] == 'true') { ?>
		<div class="row row">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-success">
				<strong>Success!</strong>
				<span>Your goal has been created.</span>
			</div>
		</div>
		<?php } ?>

		<div id="goals"></div>

		<div class="ftr-offset"></div>
	</div>
	
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Goals</p></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
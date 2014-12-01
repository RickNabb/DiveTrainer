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

		$( document ).ready( load_goals );
		
		function load_goals() {
			var id = <?php echo $_SESSION["dive_trainer"]["userId"]?>;
			
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
						$( "#filter" ).after(
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
						
						$( "#filter" ).after(
						"<div class='row'>" +
							"<div class='adminHomeItem'>" +
								"<h3>" + result[i].name + ":</h3><h4>" + startDate + " - " + endDate + 
								"</h4><span class='glyphicon glyphicon-chevron-right' onclick=\"loadGoal(" + result[i].goalId + ");\"></span>" +
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
	<?php include('../common/header.php'); echo_header('Goals', true, 'index.php', '-sm'); ?>

	<div class="container container-fluid">

		<div class="nav-offset"></div>

		<div id="filter" class="row">
			<div style="margin-left: 10px; color: #21aeff;" class="pull-left"><h4>Goals</h4></div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makeGoal.php';"></span>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
	
	<?php include('footer.php'); ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>
	
	<script>
		$( document ).ready( loadPractices );
		
		// Gets the practice list for this coachId
		function loadPractices() {
			var id = <?php session_start(); echo $_SESSION["dive_trainer"]["userId"]?>;
			$.ajax({
				type: "GET",
				url: "../common/diver.php",
				data: { method: "get_diver_practices",
						diverId: id },
				dataType: "json"
				}).success(function( result ) {
					var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

					// No practices found
					if (result.length == 0) {
						$( "#filter" ).after(
						"<div class='row row-offset-md'>" +
							"<div class='col-xs-offset-1 col-sm-offset-1'>" +
								"<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>" +
							"</div>" +
						"</div>");
					}
					
					// Make a row for each practice
					for (var i = 0; i < result.length; i++) {
						var d = new Date(result[i].practice.date);
						var date = months[d.getUTCMonth()] + " " + d.getUTCDate() + ", " + d.getUTCFullYear();
						$( "#filter" ).after(
						"<div class='row'>" +
							"<div class='adminHomeItem'>" +
								"<h3>" + date + "</h3>" +
								"<span class='glyphicon glyphicon-chevron-right' onclick=\"loadPractice(" + result[i].practice.practiceId + ");\"></span>" +
							"</div>" +
						"</div>");
					}
			});
		}
		
		// Navigates to the view page for a specific practice
		function loadPractice(practiceId) {
			window.location = "viewPractice.php?practiceId=" + practiceId;
		}
	
	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Practices', true, 'index.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<div id="filter" class="row">
			<select style="margin-left: 10px; color: #21aeff; font-size: 20px; border:none;" 
				id="select_practice_filter" class="pull-left">
				<option>Past 10 Practices</option>
				<option>Past Week's Practices</option>
				<option>Past Month's Practices</option>
				<option>All Past Practices</option>
			</select>
		</div>

		<div class="ftr-offset"></div>
	</div>
	
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
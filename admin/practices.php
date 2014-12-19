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
			$.ajax({
				type: "GET",
				url: "../common/practice.php",
				data: { method: "get_practice_list" },
				dataType: "json"
				}).success(function( result ) {
					
					var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

					// No practices found
					if (result.length == 0) {
						$( "#practices").append(
							"<div class='col-xs-offset-1 col-sm-offset-1'>" +
								"<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>" +
								"<h4 style='color: #ccc;'>Make some practices with the icon at the top.</h4>" +
							"</div>");
					}
					
					// Make a row for each practice
					for (var i = 0; i < result.length; i++) {
						var d = new Date(result[i].date);
						var date = months[d.getUTCMonth()] + " " + d.getUTCDate() + ", " + d.getUTCFullYear();
						$( "#practices").append(
							"<div class='adminHomeItem'>" +
								"<h3>" + date + "</h3>" +
								"<span class='glyphicon glyphicon-chevron-right' onclick=\"loadPractice(" + result[i].practiceId + ");\"></span>" +
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

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<div id="filter" class="row">
			<div class="col-xs-4 col-sm-4">
				<select id="select_practice_filter" class="pull-left filter">
					<option>Past 10 Practices</option>
					<option>Past Week's Practices</option>
					<option>Past Month's Practices</option>
					<option>All Past Practices</option>
				</select>
			</div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makePractice.php';"></span>
			</div>
			<div class="col-xs-10 col-sm-10">
				<input type="text" placeholder="Search" id="search" class="form-control" />
			</div>
			<div class="col-xs-1 col-sm-1" style="padding: 0;">
				<button class="btn btn-default" onclick="search_divers();"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div id="practices"></div>
		</div>

		<div class="ftr-offset"></div>
	</div>
		

	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
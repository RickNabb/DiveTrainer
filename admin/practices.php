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
						$( "#practice_list").append(
							"<div class='col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10'>" +
								"<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>" +
								"<h4 style='color: #ccc;'>Make some practices with the icon at the top.</h4>" +
							"</div>");
					}
					
					// Make a row for each practice
					for (var i = 0; i < result.length; i++) {
						var d = new Date(result[i].date);
						var date = months[d.getUTCMonth()] + " " + d.getUTCDate() + ", " + d.getUTCFullYear();
						$( "#practice_list").append(
							"<a href='./viewPractice.php?practiceId=" + result[i].practiceId + "'><div class='adminHomeItem'>" +
								"<h4>" + result[i].title + "</h4>" +
								"<p>" + date + "</p>" +
								"<span class='glyphicon glyphicon-chevron-right'></span>" +
							"</a></div>");
					}
			});
		}

		function search_practices(){

			$("#practice_list > div").css("display", "none");

			if($("#search").val() == ''){

				filter_practices();
			}
			else{

				$("#ajax_loader").show();

				$("#practice_list > div > h3").each(function(){
					if($(this).text().toLowerCase().indexOf($("#search").val()) > -1){

						$(this).parent().css("display", "block");
					}
				});

				$("#ajax_loader").hide();
			}
		}

		function filter_practices(){

			$("#practice_list").empty();
			$("#ajax_loader").show();
			$("#search").val("");

			$.ajax({
					type: "GET",
					url: "../common/practice.php",
					data: { method : "get_practices_filtered", filter: $("#practice_filter option:selected").attr('value') },
					dataType: "json"
				}).success(function(data) {

					var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

					// No practices found
					if (data.length == 0) {
						$( "#practice_list").append(
							"<div class='col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10'>" +
								"<h4 style='color: #ccc;'>We didn't find any practices!</h4><br/>" +
								"<h4 style='color: #ccc;'>Make some practices with the icon at the top.</h4>" +
							"</div>");
					}

					for (var i = 0; i < data.length; i++) {
						
						var d = new Date(data[i].date);
						var date = months[d.getUTCMonth()] + " " + d.getUTCDate() + ", " + d.getUTCFullYear();
						$( "#practice_list").append(
							"<div class='adminHomeItem'>" +
								"<h3>" + date + "</h3>" +
								"<span class='glyphicon glyphicon-chevron-right' onclick=\"loadPractice(" + data[i].practiceId + ");\"></span>" +
							"</div>");
					}

					$("#ajax_loader").hide();
				}).error(function(data){
					$("#practice_list").append('<div class="row">');
					$("#practice_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1 col-xs-10 col-sm-10">');
					$("#practice_list > div > div").append('<h3>Sorry!</h3>');
					$("#practice_list > div > div").append('<h4>We couldn\'t load all of the skills.' + 
						' Please try again.</h4></div></div>');

					$("#ajax_loader").hide();
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
				<select id="practice_filter" class="pull-left filter" onchange="filter_practices();">
					<option value="last_created">Last Created</option>
					<option value="past10">Past 10 Practices</option>
					<option value="past_week">Past Week's Practices</option>
					<option value="past_month">Past Month's Practices</option>
					<option value="all">All Past Practices</option>
				</select>
			</div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="window.location='./makePractice.php';"></span>
			</div>
			<div class="col-xs-10 col-sm-10">
				<input type="text" placeholder="Search" id="search" class="form-control" />
			</div>
			<div class="col-xs-1 col-sm-1" style="padding: 0;">
				<button class="btn btn-default" onclick="search_practices();"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>

		<?php if(isset($_GET['success']) && $_GET['success'] == 'false') { ?>
		<div class="row row-offset-sm">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-danger">
				<strong>Error:</strong>
				<span>There was an issue creating the practice. Please try again.</span>
			</div>
		</div>
		<?php } ?>

		<?php if(isset($_GET['success']) && $_GET['success'] == 'true') { ?>
		<div class="row row-offset-sm">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-success">
				<strong>Success!</strong>
				<span>Your practice has been created.</span>
			</div>
		</div>
		<?php } ?>

		<div class="row row-offset-sm">
			<div id="practice_list"></div>
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
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width">

	<?php include("include.php"); ?>
	<?php //include("session_check.php"); ?>

	<script>

		$(document).ready(load_todays_practice);

		function load_todays_practice(){

			// Avoid loading unnecessary data if the device is not a tablet
			if($("#body_tablet").css("display") != "none"){
				var d = new Date();
				var date = d.getUTCFullYear() + "-" + (parseInt(d.getUTCMonth())+1) + "-" + d.getUTCDate();

				$.ajax({
					type: "GET",
					url: "../common/practice.php",
					data: {
						method: "get_practice_by_date",
						date: date
					},
					dataType: "json"
				}).success(function(data){
					// We found no rows!
					if(data.practice.length == 0){
						$("#today_practice").append("<br/><br/><h4>It looks like you don't have a practice planned for today.</h4>" + 
							"<h4>Why not <a href='./makePractice.php'>make one?</a></h4>");
					}
					else{
						$("#today_practice").append("<br/><h3>" + data.practice.title + "</h3>");
						$("#today_practice").append("<br/><h4 id='today_warmup'>Warm Ups</h3>");
						$("#today_practice").append("<br/><h4 id='today_skill'>Skills</h3>");
						$("#today_practice").append("<br/><h4 id='today_conditioning'>Conditioning</h3>");
						$("#today_practice").append("<br/><h4 id='today_flexibility'>Flexibility</h3>");
						for(var i = 0; i < data.exercises.length; i++){

							$("#today_" + data.exercises[i].type).after("<p>" + data.exercises[i].name 
								+ " level " + data.exercises[i].level + "</p>")
						}
					}

				}).error(function(data){

					$("#today_practice").append("<br/><br/><h4>Oops!</h4>" + 
						"<h4>We couldn't load today's practice.</h4>" + 
						"<h4>Please try again later, or contact (585) 943-9297 for assistance.</h4>");
				});
			}
		}


	</script>
</head>
<body>	

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">		

		<div id="body_mobile">
			<div class="row">
				<a href="./practices.php?display=today">
					<div class="adminHomeItem current">
						<h3>Today's Practice</h3>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>	
			<div class="row">
				<a href="./makePractice.php">
					<div class="adminHomeItem">
						<h3>Plan Next Practice</h3>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>
			<div class="row">
				<a href="./divers.php">
					<div class="adminHomeItem">
						<h3>Your Divers</h3>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>
			<div class="row">
				<a href='./skills.php'>
					<div class="adminHomeItem">
						<h3>View Skills</h3>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>
		</div>

		<div id="body_tablet">
			<div class="row">
				<div class="col-md-5" style="border-right: 1px solid #ddd;" id="today_practice">
					<h1>Today's Practice</h1>
				</div>
				<div class="col-md-6">
					<div class="alert alert-warning" style="margin-top:20px;">
						<h4><strong>Warning:</strong> There are <strong>4</strong> divers whose
							goals need to be updated.</h4>
					</div>
					<h3>Week <strong>10</strong></h3>
					<h3>Current Attendence Rate: <span class="fgGreen">74%</span></h3>
				</div>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li class="current"><span class="glyphicon glyphicon-home"></span><p>Home</p></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); 
		require_once("./bootstrap.php");
		session_start(); ?>

	<script>
		$( document ).ready( load_practice );
		
		var practice = 0;
	
		// Loads the contents of the practice from the database to the page
		function load_practice() {
			var practiceId = <?php echo $_GET['practiceId']; ?>;

			$.ajax({
				type: "GET",
				url: "../common/practice.php",
				data: { method: "get_practice", practiceId: practiceId },
				dataType: "json"
				}).success(function(data) {
					practice = data;
					practice.attended = [];
					// Practice
					//TODO: format date better
					var d = new Date(data.practice.date);
					$("#date").text(d.getUTCMonth()+1 + " - " + d.getUTCDate() + " - " + d.getUTCFullYear());
					$("#title").text(data.practice.title);
					
					// Exercises
					for (var i = 0; i < data.exercises.length; i++) {
						$("#insert_exercises").append("<label class=\"formLabel col-sm-offset-1 col-xs-offset-1\">" + data.exercises[i].name + "</label><br>");
					}
				});
		}
		
	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('View Practice', true, 'practices.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		<div class="row row-offset-sm">
			<h3 id="title" class="col-sm-offset-1 col-xs-offset-1"></h3>
		</div>
		
		<div class="row">
			<h4 id="date" class="formLabel col-sm-offset-1 col-xs-offset-1"></h4>
		</div>
		
		<div class="row row-offset-sm" id="insert_exercises">
		</div>
		
		<div class="ftr-offset"></div>
	</div>
		
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
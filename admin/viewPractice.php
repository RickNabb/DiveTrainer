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
		
		function load_practice(){
			//TODO: perhaps use session instead of query string?
			var practiceId = <?php echo $_GET['practiceId']; ?>;
			
			$.ajax({
				type: "GET",
				url: "../common/practice.php",
				data: { method: "get_practice", practiceId: practiceId },
				dataType: "json"
				}).success(function(data) {
					practice = data;
					
					// Practice
					//TODO: format date better
					var d = new Date(data.practice.date);
					$("#date").text(d.getUTCMonth() + " - " + d.getUTCDate() + " - " + d.getUTCFullYear());
					$("#title").text(data.practice.title);
					
					// Exercises
					for (var i = 0; i < data.exercises.length; i++) {
						$("#insertExercises").after("<label class=\"formLabel col-sm-offset-1 col-xs-offset-1\">" + data.exercises[i].name + "</label><br>");
					}
				});
		}
		
		function clone_practice(){
			if (practice == 0)
				return;

			$.ajax({
				type: "POST",
				url: "../common/practice.php",
				data: { method : "create_practice",
						coachId : practice.practice.coachId,
						title : practice.practice.title,
						date :  practice.practice.date, 
						exercises : practice.exercises },
				dataType: "text"
				}).success(function(data) {
					if(data > 0){
						window.location = "./practices.php?success=true";
					}
				});
		}

		// Navigates to the view page for a specific practice
		function edit_practice() {
			window.location = "editPractice.php?practiceId=" + practice.practice.practiceId;
		}

	</script>
</head>
<body>
	
	<?php include('../common/header.php'); echo_header('View Practice', true, '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<div class="row">
			<div class="pull-right">
				<span class="glyphicon glyphicon-file addButton fgBlue" onclick="clone_practice();"></span>
				<span class="glyphicon glyphicon-edit addButton fgOrange" onclick="edit_practice();"></span>
			</div>
		</div>

		<div class="row row-offset-sm">
			<h3 id="title" class="col-sm-offset-1 col-xs-offset-1"></h3>
		</div>
		
		<div class="row">
			<h4 id="date" class="formLabel col-sm-offset-1 col-xs-offset-1"></h4>
		</div>
		
		<div class="row row-offset-sm">
		</div>

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
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
					
					// Practice
					//TODO: format date better
					$("#date").text(data.practice.date);
					$("#title").text(data.practice.title);
					
					// Exercises
					for (var i = 0; i < data.exercises.length; i++) {
						$("#insertExercises").after("<label class=\"formLabel col-sm-offset-1 col-xs-offset-1\">" + data.exercises[i].name + "</label><br>");
					}
				});
		}
		
		// Creates a new practice with the same content as this one and returns to practices screen
		function clone_practice(){
			if (practice == 0)
				return;

			exerciseIds = [];
			for (var i = 0; i < practice.exercises.length; i++) {
				exerciseIds[i] = practice.exercises[i].exerciseId;
			}
				
			$.ajax({
				type: "POST",
				url: "../common/practice.php",
				data: { method : "create_practice",
						coachId : practice.practice.coachId,
						title : practice.practice.title,
						date :  practice.practice.date, 
						exercises : exerciseIds },
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
	<div class="topNav">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h4 class="white ptsans">Welcome, <?php echo $_SESSION["dive_trainer"]["fname"] ?>!</h4>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="./practices.php"><span class="glyphicon glyphicon-chevron-left back-arrow"></span></a>
					<p class="navbar-title-sm">View Practice</p>
				</div>			
			</div>
			<div class="pull-right">
				<span class="glyphicon glyphicon-plus-sign addButton fgGreen" onclick="clone_practice();"></span>
			</div>
			<div class="pull-left">
				<button class="btn btn-default" onclick="edit_practice();">Edit</button>
			</div>
		</nav>
	</div>	

	<div class="container container-fluid">
		<div class="nav-offset"></div>

		<div class="row row-offset-sm">
			<label for="title" class="formLabel col-sm-offset-1 col-xs-offset-1">Title:</label>
			<label id="title" class="formLabel col-sm-offset-1 col-xs-offset-1" />
		</div>
		
		<div class="row row-offset-sm">
			<label for="date" class="formLabel col-sm-offset-1 col-xs-offset-1">Date:</label>
			<label id="date" class="formLabel col-sm-offset-1 col-xs-offset-1" />
		</div>
		
		<div class="row row-offset-sm">
			<label id="exerciseLabel" class="formLabel col-sm-offset-1 col-xs-offset-1">Exercises:</label><br id="insertExercises">
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
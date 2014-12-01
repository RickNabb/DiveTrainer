<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); 
		require_once("./bootstrap.php");
		session_start(); ?>

	<script>
		$( document ).ready( load_goal );
		
		var goal = 0;
		
		// Loads the contents of the goal from the database to the page
		function load_goal() {
			var goalId = <?php echo $_GET['goalId']; ?>;

			$.ajax({
				type: "GET",
				url: "../common/goal.php",
				data: { method: "get_goal", goalId: goalId },
				dataType: "json"
				}).success(function(data) {
					goal = data;
					// Goal
					//TODO: format date better http://msdn.microsoft.com/en-us/library/ie/ff743760(v=vs.94).aspx
					var d1 = new Date(data.goal.startDate).toLocaleDateString("en-US");
					var d2 = new Date(data.goal.endDate).toLocaleDateString("en-US");
					
					$("#date").text(d1 + " - " + d2);
					$("#title").text(data.goal.name);
					
					// Skills
					for (var i = 0; i < data.skills.length; i++) {
						$("#insert_skills").append("<label class=\"formLabel col-sm-offset-1 col-xs-offset-1\">" + data.skills[i].name + "<br>&nbsp&nbsp&nbsp&nbspRating: " + data.skills[i].rating + "</label><br>");
					}
				});
		}

		// Navigates to the view page for a specific goal
		function edit_goal() {
			window.location = "editGoal.php?goalId=" + goal.goal.goalId;
		}
		
	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('View Goal', true, 'goals.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		
		<div class="row">
			<div class="pull-right">
				<span class="glyphicon glyphicon-edit addButton fgOrange" onclick="edit_practice();"></span>
			</div>
		</div>

		<div class="row row-offset-sm">
			<h3 id="title" class="col-sm-offset-1 col-xs-offset-1"></h3>
		</div>
		
		<div class="row">
			<h4 id="date" class="formLabel col-sm-offset-1 col-xs-offset-1"></h4>
		</div>
		
		<div class="row row-offset-sm" id="insert_skills">
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
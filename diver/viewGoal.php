<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>
		$( document ).ready( load_goal );
		
		var goal = 0;
		
		// Loads the contents of the goal from the database to the page
		function load_goal() {

			$("#loader").fadeIn();

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
					data.goal.name != "" ? $("#title").text(data.goal.name) : $("#title").text("(No title given)");
					
					if(data.skills.length > 0){
						// Skills
						for (var i = 0; i < data.skills.length; i++) {
							$("#insert_skills").append("<div class=\"col-sm-offset-1 col-xs-offset-1\"><p><a href='./skill.php?id=" + 
								data.skills[i].exerciseId + "&retURL=./viewGoal.php?goalId=" + <?php echo $_GET['goalId']; ?> + "'><strong>" + data.skills[i].name + " level " + 
								data.skills[i].level + "</strong></a><br/>Desired Rating: " + data.skills[i].desiredRating + 
								"<span style='margin-left: 40px;'>Rating: " + data.skills[i].rating + "</p></div><br/>");
						}
					}
					else{
						$("#insert_skills").append("<div class=\"col-sm-offset-1 col-xs-offset-1 col-xs-10 col-sm-10 alert alert-danger\"><p>There are no skills in this goal. Perhaps you should add some.</p></div>");
					}

					$("#loader").hide();
				}).error(function(data){

					$("#error").fadeIn();
					$("#edit_practice").hide();
					$("#loader").hide();
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
				<span id="edit_practice" class="glyphicon glyphicon-edit addButton fgOrange" onclick="edit_practice();"></span>
			</div>
		</div>

		<div class="row">
			<h3 id="title" class="col-sm-offset-1 col-xs-offset-1" style="margin-top: 0;"></h3>
		</div>
		
		<div class="row">
			<h4 id="date" class="formLabel col-sm-offset-1 col-xs-offset-1"></h4>
		</div>
		
		<div class="row row-offset-sm" id="insert_skills">
			<div id="loader" class="ajax-loader loader-lg center" style="display: none;">
			</div>

			<div id="error" class='col-xs-10 col-sm-10 col-xs-offset-1 col-sm-offset-1 alert alert-danger' style="display: none;">
				<strong>Error: </strong><span>There was an issue loading this goal. Please try again.</span>
			</div>
		</div>
		
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
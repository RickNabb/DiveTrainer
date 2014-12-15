<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		window.onload = function(){

			loadSkills();
		}

		function loadSkills(){

			$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_skill" },
					dataType: "json"
				}).success(function(data) {
					for (var i = 0; i < data.exercises.length; i++) {
						$("#skill_list").append("<div class='row'><div class='adminHomeItem'><a href='./skill.php?id="
							+ data.exercises[i].exerciseId + "'><h4>" + data.exercises[i].name + " level " + data.exercises[i].level + "</h4></a></div></div>");
					}
				}).error(function(data){
					$("#skill_list").append('<div class="row">');
					$("#skill_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
					$("#skill_list > div > div").append('<h3>Sorry!</h3>');
					$("#skill_list > div > div").append('<h4>We couldn\'t load all of the skills.' + 
						' Please try again.</h4></div></div>');
				});
		}

		function search_skills(){

			$("#skill_list").empty();

			if($("#search").val() == ''){

				loadSkills();
			}
			else{ // TODO: Write PHP to get skills by name

				$.ajax({
					type: "GET",
					url: "../common/skill.php",
					data: {
						method: "get_divers_by_name",
						name: $("#search").val()
					},
					dataType: "json"
				}).success(function(data){

					for(var i = 0; i < data.length; i++){
						$("#skill_list").append("<div class='row'><div class='adminHomeItem'><a href='./skill.php?id="
							+ data[i].skill + "'><h4>" + data[i].fname + " " + data[i].lname + "</h4></a></div></div>");
					}

				}).error(function(data){

					$("#diver_list").append('<div class="row">');
					$("#diver_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
					$("#diver_list > div > div").append('<h3>Sorry!</h3>');
					$("#diver_list > div > div").append('<h4>We couldn\'t load all of the divers.' + 
						' Please try again.</h4></div></div>');
				});
			}
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		<div class="row" style="padding-bottom: 20px;"> <!-- TODO: Remove styling and fix this shit -->
			<div class="col-xs-4 col-sm-4">
				<h4>All Skills</h4>
			</div>
			<div class="col-xs-10 col-sm-10">
				<input type="text" placeholder="Search" id="search" class="form-control" />
			</div>
			<div class="col-xs-1 col-sm-1" style="padding: 0;">
				<button class="btn btn-default" onclick="search_skills();"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>

		<div id="skill_list"></div>

		<div class="ftr-offset"></div>
	</div>
		
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
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

			$("#ajax_loader").show();

			$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_skills" },
					dataType: "json"
				}).success(function(data) {
					for (var i = 0; i < data.length; i++) {
						if(data[i].name == '' && data[i].diveNum != ''){
							$("#skill_list").append("<div class='row' type='" + data[i].type + "'><div class='adminHomeItem'><a href='./`skill.php?id="
							+ data[i].exerciseId + "'><h4>(No name - Dive #" + data[i].diveNum + ")</h4></a></div></div>");
						}
						else if(data[i].name == ''){
							$("#skill_list").append("<div class='row' type='" + data[i].type + "'><div class='adminHomeItem'><a href='./skill.php?id="
							+ data[i].exerciseId + "'><h4>(No name)</h4></a></div></div>");
						}
						else{
							$("#skill_list").append("<div class='row' type='" + data[i].type + "'><div class='adminHomeItem'><a href='./skill.php?id="
								+ data[i].exerciseId + "'><h4>" + data[i].name + " (Level " + data[i].level + ")</h4></a></div></div>");
						}
					}

					$("#ajax_loader").hide();
				}).error(function(data){
					$("#skill_list").append('<div class="row">');
					$("#skill_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
					$("#skill_list > div > div").append('<h3>Sorry!</h3>');
					$("#skill_list > div > div").append('<h4>We couldn\'t load all of the skills.' + 
						' Please try again.</h4></div></div>');

					$("#ajax_loader").hide();
				});
		}

		function search_skills(){

			$("#skill_list > div").css("display", "none");

			if($("#search").val() == ''){

				filter_skills();
			}
			else{

				$("#ajax_loader").show();

				$("#skill_list > div > div > a > h4").each(function(){
					if($(this).text().toLowerCase().indexOf($("#search").val()) > -1){

						$(this).parent().parent().parent().css("display", "block");
					}
				});

				$("#ajax_loader").hide();
			}
		}

		function filter_skills(){

			$("#skill_list").empty();
			$("#ajax_loader").show();
			$("#search").val("");

			$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_exercise_type", type: $("#type_filter option:selected").attr('value') },
					dataType: "json"
				}).success(function(data) {
					for (var i = 0; i < data.length; i++) {
						
						$("#skill_list").append("<div class='row' type='" + data[i].type + "'><div class='adminHomeItem'><a href='./skill.php?id="
							+ data[i].exerciseId + "'><h4>" + data[i].name + " (Level " + data[i].level + ")</h4></a></div></div>");
					}

					$("#ajax_loader").hide();
				}).error(function(data){
					$("#skill_list").append('<div class="row">');
					$("#skill_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
					$("#skill_list > div > div").append('<h3>Sorry!</h3>');
					$("#skill_list > div > div").append('<h4>We couldn\'t load all of the skills.' + 
						' Please try again.</h4></div></div>');

					$("#ajax_loader").hide();
				});
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		<div class="row" style="padding-bottom: 20px;"> <!-- TODO: Remove styling and fix this shit -->
			<div class="col-xs-4 col-sm-4">
				<select id="type_filter" class="pull-left filter" onchange="filter_skills();">
					<option value="all_skills">All Skills</option>
					<option value="trampoline">Trampoline</option>
					<option value="dryboard">Dryboard</option>
					<option value="platform">Platform</option>
					<option value="deck-mat-bulkhead">Deck/Mat</option>
					<option value="1m">1m Dives</option>
					<option value="3m">3m Dives</option>
				</select>
			</div>
			<div class="col-xs-10 col-sm-10">
				<input type="text" placeholder="Search" id="search" class="form-control" />
			</div>
			<div class="col-xs-1 col-sm-1" style="padding: 0;">
				<button class="btn btn-default" onclick="search_skills();"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>

		<div id="skill_list"></div>
		<div id="ajax_loader" class="ajax-loader loader-lg center"></div>

		<div class="ftr-offset"></div>
	</div>
		
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
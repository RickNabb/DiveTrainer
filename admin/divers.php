<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		window.onload = function(){

			loadDivers();
			load_filters();
		}

		function loadDivers(){

			$("#ajax_loader").show();

			$.ajax({
				type: "GET",
				url: "../common/diver.php",
				data: {
					method: "get_all_divers"
				},
				dataType: "json"
			}).success(function(data){

				for(var i = 0; i < data.length; i++){
					$("#diver_list").append("<div class='row'><div class='adminHomeItem'><a href='./diver.php?id="
						+ data[i].diverId + "'><h4>" + data[i].fname + " " + data[i].lname + "</h4></a></div></div>");
				}

				$("#ajax_loader").hide();

			}).error(function(data){

				$("#diver_list").append('<div class="row">');
				$("#diver_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10 alert alert-danger">');
				$("#diver_list > div > div").append('<strong>Sorry!</strong>');
				$("#diver_list > div > div").append('<p>We couldn\'t load all of the divers.' + 
					' Please try again.</p></div></div>');

				$("#ajax_loader").hide();
			});
		}

		function load_filters(){

			$.ajax({
				type: "GET",
				url: "../common/class.php",
				data: {
					method: "get_classes"
				},
				dataType: "json"
			}).success(function(data){

				for(var i = 0; i < data.length; i++){
					$("#class_filter").append("<option level='" + data[i].level + "'>" + data[i].title + "</option>");
				}

			}).error(function(data){

				$("#diver_list").append('<div class="row">');
				$("#diver_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
				$("#diver_list > div > div").append('<h3>Sorry!</h3>');
				$("#diver_list > div > div").append('<h4>We couldn\'t load all of the divers.' + 
					' Please try again.</h4></div></div>');
			});
		}

		function search_divers(){

			$("#diver_list > div").css("display", "none");

			if($("#search").val() == ''){

				filter_divers();
			}
			else{

				$("#ajax_loader").show();

				$("#diver_list > div > div > a > h4").each(function(){
					if($(this).text().toLowerCase().indexOf($("#search").val()) > -1){

						$(this).parent().parent().parent().css("display", "block");
					}
				});

				$("#ajax_loader").hide();
			}
		}

		function filter_divers(){

			$("#diver_list").empty();

			if($("#class_filter").val() == 'All Divers'){

				loadDivers();
			}
			else{
				$("#ajax_loader").show();

				$.ajax({
					type: "GET",
					url: "../common/diver.php",
					data: {
						method: "get_divers_by_level",
						level: $("#class_filter").find("option:contains(" + $("#class_filter").val() + ")").attr('level')
					},
					dataType: "json"
				}).success(function(data){

					for(var i = 0; i < data.length; i++){
						$("#diver_list").append("<div class='row'><div class='adminHomeItem'><a href='./diver.php?id="
							+ data[i].diverId + "'><h4>" + data[i].fname + " " + data[i].lname + "</h4></a></div></div>");
					}
					$("#ajax_loader").hide();

				}).error(function(data){

					$("#diver_list").append('<div class="row">');
					$("#diver_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10 alert alert-danger">');
					$("#diver_list > div > div").append('<strong>Sorry!</strong>');
					$("#diver_list > div > div").append('<p>We couldn\'t load all of the divers.' + 
						' Please try again.</p></div></div>');

					$("#ajax_loader").hide();
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
				<select id="class_filter" class="pull-left filter" onchange="filter_divers();">
					<option>All Divers</option>
				</select>
			</div>
			<div class="col-xs-10 col-sm-10">
				<input type="text" placeholder="Search" id="search" class="form-control" />
			</div>
			<div class="col-xs-1 col-sm-1" style="padding: 0;">
				<button class="btn btn-default" onclick="search_divers();"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>

		<div id="diver_list"></div>
		<div id="ajax_loader" class="ajax-loader loader-lg center"></div>

		<div class="ftr-offset"></div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Divers</p></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
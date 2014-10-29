<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		$( document ).ready(loadDivers);

		function loadDivers(){

			$.ajax({
				type: "GET",
				url: "../common/diver.php",
				data: {
					method: "get_all_divers"
				},
				dataType: "json"
			}).success(function(data){

				for(var i = 0; i < data.length; i++){
					$("#diver_list").append("<div class='row'><div class='adminHomeItem'><h4>" + data[i].fname + " " + data[i].lname +
						"</h4></div></div>");
				}

			}).error(function(data){

				$("#diver_list").append('<div class="row">');
				$("#diver_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
				$("#diver_list > div > div").append('<h3>Sorry!</h3>');
				$("#diver_list > div > div").append('<h4>We couldn\'t load all of the divers.' + 
					' Please try again.</h4></div></div>');
			});
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">	
		<div class="row">
			<div class="col-xs-offset-1">
				<h4>All Divers</h4>
			</div>
		</div>

		<div id="diver_list">
		</div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Divers</p></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
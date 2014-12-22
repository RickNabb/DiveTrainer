<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		window.onload = function(){

			loadSkill();
		}

		function loadSkill(){

			$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_exercise", exerciseId: <?php echo $_GET['id']; ?>},
					dataType: "json"
				}).success(function(data) {
					
					if(data.name == ''){
						$("#name").text("(No name given)");
					} else {
						$("#name").text(data.name);
					}
					$("#level").text("Level " + data.level);
					if(data.description == ''){
						$("#description").text("(No description given)");
					}
					else{
						$("#description").text(data.description);
					}
					$("#video_link").attr("href", data.videoURL);
					if(data.videoURL == '')
						$("#video_link").text("http://youtube.com/upstatenydiving/");
					else
						$("#video_link").text(data.videoURL);
					
				}).error(function(data){
					$("#skill_list").append('<div class="row">');
					$("#skill_list > div").append('<div class="col-sm-offset-1 col-xs-offset-1">');
					$("#skill_list > div > div").append('<h3>Sorry!</h3>');
					$("#skill_list > div > div").append('<h4>We couldn\'t load all of the skills.' + 
						' Please try again.</h4></div></div>');
				});
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('View Skill', true, 
	 isset($_GET['retURL']) ? $_GET['retURL'] : './skills.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		
		<div class="row">
			<div class="col-xs-offset-1 col-sm-offset-1">
				<h3 id="name"></h3>
				<h4 id="level" class="fgOrange"></h4>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-1 col-sm-offset-1">
				<a id="video_link"></a>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10 well">
				<p id="description"></p>
			</div>
		</div>

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
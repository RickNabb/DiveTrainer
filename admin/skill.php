<?php session_start(); ?>

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
					$("#description").parent().removeClass("well");
					$("#description").parent().addClass("alert");
					$("#description").parent().addClass("alert-warning");
					$("#description").parent().append("<strong>Oops!</strong><p>There was an issue loading this skill. Please try again later.</p>");
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
			<div class="pull-right">
				<a href="./editSkill.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-edit addButton fgOrange"></span></a>
			</div>
		</div>

		<!-- Edit success check -->
		<?php if(isset($_GET['success']) && $_GET['success'] == 'success') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-success">
					<p>This skill has been successfully edited!</p>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- Edit failure check -->
		<?php if(isset($_GET['success']) && $_GET['success'] == 'failure') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-danger">
					<p>Something went wrong with editing! Please try again later.</p>
				</div>
			</div>
		</div>
		<?php } ?>
		
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
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li><a href="./practices.php"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
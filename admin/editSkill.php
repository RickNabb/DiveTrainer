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
						$("#name").val("(No name given)");
					} else {
						$("#name").val(data.name);
					}
					$("#level option:contains(" + data.level + ")").attr("selected", "");
					if(data.description == ''){
						$("#description").val("(No description given)");
					}
					else{
						$("#description").val(data.description);
					}
					$("#video_link").attr("href", data.videoURL);
					if(data.videoURL == '')
						$("#video_link").val("http://youtube.com/upstatenydiving/");
					else
						$("#video_link").val(data.videoURL);
					
				}).error(function(data){
					$("#description").parent().removeClass("well");
					$("#description").parent().addClass("alert");
					$("#description").parent().addClass("alert-warning");
					$("#description").parent().append("<strong>Oops!</strong><p>There was an issue loading this skill. Please try again later.</p>");
				});
		}

		function edit_skill(){

			var name = $("#name").val();
			var level = $("#level").val();
			var video_link = $("#video_link").val();
			var description = $("#description").val();

			$.ajax({
					type: "POST",
					url: "../common/exercise.php",
					data: { method : "edit_exercise", exerciseId: <?php echo $_GET['id']; ?>, name: name,
						level: level, videoURL: video_link, description: description},
					dataType: "json"
				}).success(function(data) {
					
					if(data == '1'){
						window.location = "./skill.php?id=" + <?php echo $_GET['id']; ?> + "&success=success";
					}
					else{
						window.location = "./skill.php?id=" + <?php echo $_GET['id']; ?> + "&success=failure";
					}
					
				}).error(function(data){
					window.location = "./skill.php?id=" + <?php echo $_GET['id']; ?> + "&success=failure";
				});
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Edit Skill', true, 
	 isset($_GET['retURL']) ? $_GET['retURL'] : './skill.php?id=' . $_GET['id'], '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<div class="row">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				
				<label for="name">Name</label><br />
				<input class="form-control" type="text" id="name" />

				<label for="level">Difficulty Level</label>
				<select class="form-control" id="level" class="fgOrange">
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<label for="video_link">Video URL</label>
				<input class="form-control" type="text" id="video_link" />
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<label for="description">Description</label>
				<textarea class="form-control" type="text" id="description"></textarea>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-8 col-sm-offset-8">
				<button class="btn btn-default" onclick="edit_skill();">Save</button>
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
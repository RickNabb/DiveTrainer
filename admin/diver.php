<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
		include("include.php");
	?>

	<script>

		window.onload = function(){

			load_diver();
			load_goals();
		}

		function load_diver(){

			$.ajax({
				type: "GET",
				url: "../common/diver.php",
				data: {
					method: "get_diver",
					diverId: <?php echo $_GET['id']; ?>
				},
				dataType: "json"
			}).success(function(data){
				
				$("#name").text(data.fname + " " + data.lname);

				if(data.email != ''){
					$("#email").text(data.email);
				} else{
					$("#email").text("No email registered for this user");
					$("#email").attr("data-toggle", "");
				}

			}).error(function(data){

				alert(data);
			});
		}

		function load_goals(){

			$.ajax({
				type: "GET",
				url: "../common/goal.php",
				data: {
					method: "get_goals_for_diver",
					diverId: <?php echo $_GET['id']; ?>
				},
				dataType: "json"
			}).success(function(data){

				if(data.length == 0){
					$("#goals").append("<div class='row'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10'>" + 
						"<h4>This diver has no goals! Perhaps you should make one for them.</h4><br/>"
						+ "</div></div>");
				}
	
				for(var i = 0; i < data.length; i++){

					// Append goal well with goal name, and ajax loader

					$("#goals").append("<a href='./viewGoal.php?id=" + data[i].goalId + "&diverId=" + <?php echo $_GET['id']; ?> + "'><div class='row'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10 well'>" +
							"<strong style='color: #000;'>" + (data[i].name != "" ? data[i].name : '(No title given)') + "</strong><br/>" +
							"<div id='goal_" + i + "'><div id='goal_loader_" + i + "' class='ajax-loader loader-md center'></div></div></div></div></a>");

					// Show ajax loader
					$("#goal_loader_" + i).show();

					// ajax query for exercises related to this goal
					$.ajax({
						type: "GET",
						url: "../common/goal.php",
						data: {
							method: "get_exercises_for_goal",
							goalId: data[i].goalId,
							count: i
						},
						dataType: "json"
					}).success(function(data){

						var i = data[data.length-1].count;
						var completed_goals = 0;

						$("#goal_" + i).append("<span class='glyphicon glyphicon-chevron-right fgOrange font-30 pull-right'></span>");

						if(data.length > 1){ // If there are entries besides the count
							for(var j = 0; j < data.length-1; j++){

								if(data[j].rating >= data[j].desiredRating){
									completed_goals++;
								}
							}
							$("#goal_" + i).append("<span>" + completed_goals.toString() + " of " + (data.length-1).toString() + " skills completed</span>");
						}
						else{
							$("#goal_" + i).append("<p>There are no skills for this goal. Perhaps you should add some.</p>");
						}

						// Hide the ajax loader
						$("#goal_loader_" + i).hide();
						
					}).error(function(data){

						var i = data[data.length-1].count;
						$("#goal_loader_" + i).hide();
						$("#goal_" + i).removeClass("well");
						$("#goal_" + i).addClass("alert");
						$("#goal_" + i).addClass("alert-danger");
						$("#goal_" + i).append("<p>Error loading skills for goal</p>");
					});
				}

			}).error(function(data){

				alert(data);
			});
		}

	</script>
</head>
<body>

	<?php include('../common/header.php'); echo_header('Diver', true, './divers.php'); ?>

	<div class="modal fade" id="emailModal" data-toggle="modal" role="dialog" arialabelledby="emailModalLabel" aria-hidden="true" style="max-height: 90%;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="emailModalLabel">Send a Message</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="email_subject" placeholder="Subject"/>
						</div>
					</div>
					<div class="row row-offset-sm">
						<div class="col-sm-12 col-xs-12">
							<textarea id="email_body" class="form-control" placeholder="Type your message here..." cols="10" style="height: 100px;"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="" data-dismiss="modal">Send</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="nav-offset"></div>

	<div class="container container-fluid">	

		<?php if(isset($_GET['success']) && $_GET['success'] == 'false') { ?>
		<div class="row row">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-danger">
				<strong>Error:</strong>
				<span>There was an issue creating the goal. Please try again.</span>
			</div>
		</div>
		<?php } ?>

		<?php if(isset($_GET['success']) && $_GET['success'] == 'true') { ?>
		<div class="row row">
			<div class="col-sm-10 col-xs-10 col-xs-offset-1 col-sm-offset-1 alert alert-success">
				<strong>Success!</strong>
				<span>Your goal has been created.</span>
			</div>
		</div>
		<?php } ?>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1">
				<h3 id="name"></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1">
				<h4 id="email" class="fgOrange" data-toggle="modal" data-target="#emailModal"></h4>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-sm-4 col-xs-4">
				<h4>Goals</h4>
			</div>
			<div class="col-sm-offset-9 col-xs-offset-9">
				<a href="./makeGoal.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-plus-sign addButtonSm fgGreen" style="padding-top: 10px;"></span></a>
			</div>
			<div class="col-sm-offset-1 col-xs-offset-1">
				<hr />
			</div>
		</div>
		<div id="goals" class="row"></div>

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
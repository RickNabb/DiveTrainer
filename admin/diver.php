<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
		include("include.php");
		session_start();
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
				$("#email").text(data.email);

			}).error(function(data){

				//alert(data);
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
	
				for(var i = 0; i < data.length; i++){

					$("#goals").append("<div class='row'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10 well'>" + 
						"<strong>" + data[i].name + "</strong><br/>"
						+ "<p>Progress: 1/3 Skills Complete</p></div></div>"); // TODO: Actually quantify progress of goal
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

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1">
				<h3 id="name">Nick Rabb</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1">
				<h4 id="email" class="fgOrange" data-toggle="modal" data-target="#emailModal">nrabb@outlook.com</h4>
			</div>
		</div>

		<div id="goals" class="row row-offset-md"></div>
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
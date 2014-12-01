<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); 
		require_once("./bootstrap.php");
		session_start(); ?>

	<script>
		$( document ).ready( load_divers );
		
		var practice = 0;

		// Function to load all the exercise types from the database as options
		function load_divers() {
			$.ajax({
				type: "GET",
				async: false,
				url: "../common/diver.php",
				data: { method : "get_all_divers" },
				dataType: "json"
			}).done(function(data) {
				for (var i = 0; i < data.length; i++) {
					$("#diver_form").append(
						'<div class="row">' +
							'<div class="col-sm-offset-1 col-xs-offset-1">' +
								'<input type="checkbox" id="d' + data[i].diverId + '" value="' + data[i].fname + ' ' + data[i].lname + '">&nbsp;' + data[i].fname + ' ' + data[i].lname + '</input>' +
							'</div>' +
						'</div>');
				}
			});
			
			load_practice();
		}
	
		// Loads the contents of the practice from the database to the page
		function load_practice() {
			var practiceId = <?php echo $_GET['practiceId']; ?>;

			$.ajax({
				type: "GET",
				url: "../common/practice.php",
				data: { method: "get_practice", practiceId: practiceId },
				dataType: "json"
				}).success(function(data) {
					practice = data;
					practice.attended = [];
					// Practice
					//TODO: format date better
					var d = new Date(data.practice.date);
					$("#date").text(d.getUTCMonth()+1 + " - " + d.getUTCDate() + " - " + d.getUTCFullYear());
					$("#title").text(data.practice.title);
					
					// Exercises
					for (var i = 0; i < data.exercises.length; i++) {
						$("#insert_exercises").append("<label class=\"formLabel col-sm-offset-1 col-xs-offset-1\">" + data.exercises[i].name + "</label><br>");
					}
					
					// Divers
					for (var i = 0; i < data.divers.length; i++) {
						var checkbox = $("#d" + data.divers[i].diverId);
						checkbox.attr('checked', true);
						practice.attended[data.divers[i].diverId] = data.divers[i].attended;
					}
					add_divers();
				});
		}
		
		// Creates a new practice with the same content as this one and returns to practices screen
		function clone_practice(){
			if (practice == 0)
				return;

			exerciseIds = [];
			for (var i = 0; i < practice.exercises.length; i++) {
				exerciseIds[i] = practice.exercises[i].exerciseId;
			}
				
			$.ajax({
				type: "POST",
				url: "../common/practice.php",
				data: { method : "create_practice",
						coachId : practice.practice.coachId,
						title : practice.practice.title,
						date :  practice.practice.date, 
						exercises : exerciseIds },
				dataType: "text"
				}).success(function(data) {
					if(data > 0){
						window.location = "./practices.php?success=true";
					}
				});
		}

		// Navigates to the view page for a specific practice
		function edit_practice() {
			window.location = "editPractice.php?practiceId=" + practice.practice.practiceId;
		}

		// Opens modal to add divers
		function add_divers() {
			$("#divers_list > div").empty();

			$("#diver_form :input").each(function(){
				if(this.checked){
					var ele = "<button id='diver" + this.id.substring(1) + "' class='btn btn-default'>" + this.value + 
						"<span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;' onclick='remove_diver(\"" + this.value + "\");'></span>" +
					"</button>";
					
					// Add attendance option for current/past practices
					var date = new Date(practice.practice.date)
					var notFuture = date.setHours(0,0,0,0) <= new Date().setHours(0,0,0,0);
					if(notFuture) {
						var checked = "";
						// Check if attended
						if (this.id.substring(1) in practice.attended && 
							practice.attended[this.id.substring(1)] == 1) {
							checked = " checked";
						}
						
						ele = "<input type='checkbox' id='attended" + this.id.substring(1) + "'" + checked + ">" + ele + "</input>";
					}
				
					$("#divers_list > div").append("<div class='row'>" + ele + "</div>");
					
				}
			});

			if($("#divers_list > div").children().size() == 0)
				$("#divers_list > div").append("<p>No divers are currently scheduled to attend.</p>");
		}
		
		// Function to save the practice to the database
		function update_practice() {
			
			// Get divers
			var divers = [];
			var id, attended;
			inputs = $("button[id^='diver']")
			for (var i = 0; i < inputs.length; i++) {
				id = inputs[i].id.replace("diver", "");
				checkbox = $("#attended" + id)[0];
				
				attended = 0;
				if (checkbox && checkbox.checked)
					attended = 1;
					
				divers[i] = {diverId: id, attended: attended};
			}
			
			$.ajax({
				type: "POST",
				url: "../common/practice.php",
				data: { method : "update_attendance",
						practiceId : practice.practice.practiceId,
						divers : divers},
				dataType: "text"
				}).success(function(data) {
					// TODO: better way of informing success
					if (data > 0)
						alert("Attendance saved");
					else
						alert(data);
				});
		}
		
		// Remove a diver
		function remove_diver(value) {
			var button = $("#divers_list button:contains('" + value + "')");
			$("#diver_form input[id*='d" + button[0].id.substring(5) + "']")[0].checked = false;
			
			checkbox = $("#attended" + button[0].id.substring(5))[0];
			if (checkbox)
				checkbox.remove();
			button.remove();

			if($("#divers_list > div").children().size() == 0){
				$("#divers_list > div").append("<p>No divers are currently scheduled to attend.</p>");
			}
		}
		
	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('View Practice', true, 'practices.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		<div class="modal fade" id="diversModal" data-toggle="modal" role="dialog" arialabelledby="diversModalLabel" aria-hidden="true" style="max-height: 90%;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="diversModalLabel">Select Divers</h4>
					</div>
					<div class="modal-body">
						<form id="diver_form" name="diver_form">
						</form>
					</div>
					<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" onclick="add_divers();" data-dismiss="modal">Add Divers</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="row">
			<div class="pull-right">
				<span class="glyphicon glyphicon-file addButton fgBlue" onclick="clone_practice();"></span>
				<span class="glyphicon glyphicon-edit addButton fgOrange" onclick="edit_practice();"></span>
			</div>
		</div>

		<div class="row row-offset-sm">
			<h3 id="title" class="col-sm-offset-1 col-xs-offset-1"></h3>
		</div>
		
		<div class="row">
			<h4 id="date" class="formLabel col-sm-offset-1 col-xs-offset-1"></h4>
		</div>
		
		<div class="row row-offset-sm" id="insert_exercises">
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-sm-4 col-xs-4">
				<h4>Attendance</h4>
			</div>
			<div class="col-sm-offset-9 col-xs-offset-9">
				<span class="glyphicon glyphicon-plus-sign addButtonSm fgGreen" style="padding-top: 10px;" data-toggle="modal" data-target="#diversModal"/>
			</div>
		</div>
		
		<div id="divers_list" class="row">
			<div class="col-sm-offset-1 col-xs-offset-2">
				<p>No divers are currently scheduled to attend.</p>
			</div>
		</div>
		
		<div class="row row-offset-md">
			<div class="col-sm-offset-6 col-xs-offset-6">
				<button class="btn btn-default" onclick="update_practice();">Save Attendance</button>
			</div>
		</div>
		
		<div class="ftr-offset"></div>
	</div>
		
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./divers.php"><span class="glyphicon glyphicon-user"></span><p>Divers</p></a></li>
			<li class="current"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
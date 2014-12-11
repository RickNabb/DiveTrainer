<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>
	
		$(document).ready(load_exercises);
	
		function load_exercises() {
			$.ajax({
				type: "GET",
				url: "../common/exercise.php",
				data: { method : "get_skill" },
				dataType: "json"
			}).success(function(data) {
				for(var i = 0; i < data.exercises.length; i++){
					$("#skill_form").append(
						'<div class="row">' +
							'<div class="col-sm-offset-2 col-xs-offset-2">' +
								'<input type="checkbox" id="' + data.exercises[i].exerciseId + '" value="' + data.exercises[i].name + ' ' + data.exercises[i].level + '">' + data.exercises[i].name + " level " + data.exercises[i].level + '</input>' +
							'</div>' +
						'</div>');
				}
			}).error(function(data){
				console.log(data);
			});
		}
	
		function create_goal() {
			var diverId = <?php	echo $_GET['id']; ?>; 
			
			var date_month = $("#date_month").val();
			var months = {"Jan":"01", "Feb":"02", "Mar":"03", "Apr":"04", "May": "05", "Jun":"06", "Jul":"07", "Aug":"08", "Sep":"09", "Oct":"10", "Nov":"11", "Dec":"12"};
			var date_month_num = months[date_month];
			var date_full = date_month_num + "-" + $("#date_day").val() + "-" + $("#date_year").val();
			
			$.ajax({
				type: "POST",
				url: "../common/goal.php",
				data: { method : "create_goal",
						diverId : diverId,
						title : $("#input_title").val(),
						endDate : date_full },
				dataType: "text"
				}).success(function(data) {

					if(data > -1){
						// goalId returned
						var goals = $("div.well");
						var skills = new Array(); // TODO: Send over associative list of goals
						for(var i = 0; i < goals.length; i++){

							var id = goals[i].id.substring(8);
							var desired_rating = $(goals[i].children[4]).val();
							skills[id] = desired_rating;
						}

						$.ajax({
							type: "POST",
							url: "../common/goal.php",
							data: { method : "create_exercise_to_goal",
									goalId : data,
									skills : skills },
							dataType: "text"
							}).success(function(data) {
								
								if(data == 'success'){
									window.location = "./diver.php?id=" + <?php echo $_GET['id'] ?> + "&success=true";
								}
							});
					}
					else{
						window.location = "./diver.php?id=" + <?php echo $_GET['id'] ?> + "&success=false";
					}
				}
			);
		}

		function add_skills() {

			$("#skill_list").empty();

			$("#skill_form :input").each(function(){
				if(this.checked){
					$("#skill_list").append("<div class='row row-offset-xs'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-8 col-xs-10'>"+
						"<div id='exercise" + this.id + "' class='well'><strong>" + this.value + 
						"</strong><span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;' onclick=\"remove_skill('" + this.value + "');\"></span>" + 
						"<br/><span>Desired Rating:</span><select id='desired_rating' class='form-control' style='width: 50px;'>" +
						"<option>1</option><option>2</option><option>3</option>" + 
						"<option>4</option><option>5</option></select></div></div></div>");
				}
			});
		}

		function remove_skill(value){

			var button = $("#skill_list div.well:contains('" + value + "')");
			$("#skill_form input[id*='" + button[0].id.substring(8) + "']")[0].checked = false;
			button.remove();

			if($("#skill_list > div > div").children().size() == 0){

				$("#skill_list > div > div").append("<p>There is nothing here. Add an exercise!</p>");
			}
		}

	</script>
</head>
<body>
	
	<?php include('../common/header.php'); echo_header('Create Goal', true, './diver.php?id=' . $_GET["id"], '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<!-- Exercises Modals -->
		
		<div class="modal fade" id="skillModal" data-toggle="modal" role="dialog" arialabelledby="skillsModalLabel" aria-hidden="true" style="max-height: 90%;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="skillsModalLabel">Select Skills</h4>
					</div>
					<div class="modal-body">
						<form id="skill_form" name="skill_form">
						</form>
					</div>
					<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" onclick="add_skills();" data-dismiss="modal">Add Exercises</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">Title</label><br />
				<input type="text" class="form-control" placeholder="Title..." style="width:80%;" id="input_title"/>
			</div>
		</div>

		<div class="row row-offset-sm">
			<label for="date_month" class="formLabel col-sm-offset-1 col-xs-offset-1">End Date</label><br />
			<select id="date_month" class="col-sm-offset-1 col-xs-offset-1 form-control"
				style="width: 70px; display: inline-block;">
			<?php
				$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
				foreach($months as $month){
					echo "<option>$month</option>";
				}
			?>
			</select>
			<select id="date_day" class="form-control"
				style="width: 60px; display: inline-block; margin-left: 10px;">
				<?php for($i = 1; $i < 31; $i++){ echo "<option>$i</option>"; } ?>
			</select>
			<select id="date_year" class="form-control"
				style="width: 80px; display: inline-block; margin-left: 10px;">
				<?php for($i = 2014; $i <= 2020; $i++){ echo "<option>$i</option>"; } ?>
			</select>
		</div>

		<!-- Skills Section -->
		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-sm-4 col-xs-4">
				<h4>Skills</h4>
			</div>
			<div class="col-sm-offset-9 col-xs-offset-9">
				<span class="glyphicon glyphicon-plus-sign addButtonSm fgGreen" style="padding-top: 10px;"
					data-toggle="modal" data-target="#skillModal"></span>
			</div>
			<div class="col-sm-offset-1 col-xs-offset-1">
				<hr />
			</div>
		</div>
		<div id="skill_list" class="row">
			<div class="col-sm-offset-1 col-xs-offset-2">
				<p>There is nothing here. Add a skill!</p>
			</div>
		</div>
		<!-- End Skills Section -->

		<div class="row row-offset-md">
			<div class="col-sm-offset-9 col-xs-offset-9">
				<button class="btn btn-default" onclick="create_goal();">Finish</button>
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
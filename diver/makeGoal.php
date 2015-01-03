<?php session_start(); ?>

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
				data: { method : "get_skills" },
				dataType: "json"
			}).success(function(data) {
				for(var i = 0; i < data.length; i++){
					$("#skill_form").append(
						'<div class="row">' +
							'<div class="col-sm-offset-1 col-xs-offset-1">' +
								'<input type="checkbox" ex_type="' + data[i].type + '" id="' + data[i].exerciseId + '" value="' + data[i].name + ' ' 
								+ data[i].level + '">' + data[i].name + " level " + data[i].level + '</input>' +
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
						var skill_ids = new Array();
						var desired_ratings = new Array();
						for(var i = 0; i < goals.length; i++){

							var id = goals[i].id.substring(8);
							var desired_rating = $(goals[i].children[4]).val();
							skill_ids[i] = id;
							desired_ratings[i] = desired_rating;
						}

						$.ajax({
							type: "POST",
							url: "../common/goal.php",
							data: { method : "create_exercise_to_goal",
									goalId : data,
									skill_ids : skill_ids,
									desired_ratings : desired_ratings },
							dataType: "text"
							}).success(function(data) {
								
								if(data == 'success'){
									window.location = "./goals.php?success=true";
								}
								else{
									window.location = "./goals.php?success=false";
								}
							});
					}
					else{
						window.location = "./goals.php?success=false";
					}
				}
			);
		}

		function add_skills() {

			$("#skill_list").empty();

			$("#skill_form :input").each(function(){
				if(this.checked){
					$("#skill_list").append("<div class='row row-offset-xs'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-8 col-xs-10'>"+
						"<div id='exercise" + this.id + "' class='well'><strong>" + this.value.substring(0, this.value.length - 2) + 
						"</strong><span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;' onclick=\"remove_skill('" + this.value + "');\"></span>" + 
						"<br/><span>Desired Rating:</span><select id='desired_rating' class='form-control' style='width: 50px;'>" +
						"<option>1</option><option>2</option><option>3</option>" + 
						"<option>4</option><option>5</option></select></div></div></div>");
				}
			});
		}

		function remove_skill(value){

			var button = $("#skill_list div.well:contains('" + value.substring(0, value.length-2) + "')");
			$("#skill_form input[id*='" + button[0].id.substring(8) + "']")[0].checked = false;
			button.remove();

			if($("#skill_list > div > div").children().size() == 0){

				$("#skill_list > div > div").append("<p>There is nothing here. Add an exercise!</p>");
			}
		}

		function search_modal(section){

			$("#" + section + "_form > div").css("display", "none");

			if($("#" + section + "_search").val() == ''){
				filter_modal();
			}
			else{

				$("#ajax_loader").show();

				$("#" + section + "_form > div > div > input").each(function(){
					if($(this).val().toLowerCase().indexOf($("#" + section + "_search").val()) > -1){

						$(this).parent().parent().css("display", "block");
					}
				});

				$("#ajax_loader").hide();
			}
		}

		function filter_modal(section){

			$("#ajax_loader").show();

			if($("#" + section + "_filter option:selected").attr("value") == "all"){
				$("#" + section + "_form > div").each(function(){
					$(this).show();
				});
			}
			else{
				$("#" + section + "_form > div").css("display", "none");

				$("#" + section + "_form > div > div > input").each(function(){
					if($(this).attr("ex_type") == $("#" + section + "_filter option:selected").attr("value")){

						$(this).parent().parent().css("display", "block");
					}
				});
			}

			$("#ajax_loader").hide();
		}

	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('Make Goal', true, 'goals.php', '-sm'); ?>

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
						<div class="row" style="padding-bottom: 20px;">
							<div class="col-xs-4 col-sm-4">
								<select id="skill_filter" class="pull-left filter" onchange="filter_modal('skill');">
									<option value='all'>All Skills</option>
									<option value='trampoline'>Trampoline</option>
									<option value='dryboard'>Dryboard</option>
									<option value='platform'>Platform</option>
									<option value='deck-mat-bulkhead'>Deck/Mat</option>
									<option value='1m'>1m Dive</option>
									<option value='3m'>3m Dives</option>
								</select>
							</div>
							<div class="col-xs-10 col-sm-10">
								<input type="text" placeholder="Search" id="skill_search" class="form-control" />
							</div>
							<div class="col-xs-1 col-sm-1" style="padding: 0;">
								<button class="btn btn-default" onclick="search_modal('skill');"><span class="glyphicon glyphicon-search"></span></button>
							</div>
						</div>
						<div id="ajax_loader" class="ajax-loader loader-lg center"></div>
						<form id="skill_form" name="skill_form"></form>
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
			<li class="current"><span class="glyphicon glyphicon-user"></span><p>Goals</p></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
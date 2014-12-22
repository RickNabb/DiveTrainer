<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>
	
		window.onload = function(){

			load_exercises();
			load_filters();
		}
	
		function load_exercises() {
			var types = ["safetyeducation", "trampoline", "dryboard", "platform", "deck-mat-bulkhead", "1m", "3m", 
				"warmup", "skills", "conditioning", "flexibility"];
			
			for (var j = 0; j < types.length; j++) {

				$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_exercise_type",
							type : types[j] },
					dataType: "json"
				}).success(function(data) {

					if(data.length > 0){
						var type = data[0].type;

						if(type == "safetyeducation")
							type = "warmup";

						else if(type == "trampoline" || type == "dryboard" || type=="platform"
							|| type == "deck-mat-bulkhead" || type == "1m" || type == "3m"){
							type = "skills";
						}

						for (var i = 0; i < data.length; i++) {
							$("#" + type + "_form").append(
								'<div class="row">' +
									'<div class="col-sm-offset-1 col-xs-offset-1">' +
										'<input type="checkbox" ex_type="' + data[i].type + '" id="' + data[i].exerciseId + '" value="' + data[i].name 
										+ ' ' + data[i].level + '">&nbsp;' + data[i].name +'</input>' +
									'</div>' +
								'</div>');
						}
					}
					else{
						// Nothing
					}
				}).error(function(data){
					console.log(data);
				});
			}
		}

		function load_filters(){

			var types = ["warmup", "skills", "conditioning", "flexibility"];
			for(var i = 0; i < types.length; i++){

				if(types[i] == "warmup"){
					$("#warmup_filter").append("<option value='all'>All Warmups</option>");
					$("#warmup_filter").append("<option value='safetyeducation'>Safety Education</option>");
					$("#warmup_filter").append("<option value='warmup'>Warm Ups</option>");
				}
				else if(types[i] == "skills"){
					$("#skills_filter").append("<option value='all'>All Skills</option>");
					$("#skills_filter").append("<option value='trampoline'>Trampoline</option>");
					$("#skills_filter").append("<option value='dryboard'>Dryboard</option>");
					$("#skills_filter").append("<option value='platform'>Platform</option>");
					$("#skills_filter").append("<option value='deck-mat-bulkhead'>Deck/Mat</option>");
					$("#skills_filter").append("<option value='1m'>1m Dive</option>");
					$("#skills_filter").append("<option value='3m'>3m Dives</option>");
				}
				else{
					$("#" + types + "_filter").hide();
				}
			}
		}
	
		function create_practice() {
			var coach_id = <?php if(session_id() == null) { session_start(); }
								echo $_SESSION['dive_trainer']['userId']; ?>; 
			
			var date_month = $("#date_month").val();
			var months = {"Jan":"01", "Feb":"02", "Mar":"03", "Apr":"04", "May": "05", "Jun":"06", "Jul":"07", "Aug":"08", "Sep":"09", "Oct":"10", "Nov":"11", "Dec":"12"};
			var date_month_num = months[date_month];
			var date_full = $("#date_year").val() + '-' + date_month_num + "-" + $("#date_day").val();
			
			// Get exercises
			var exercises = [];
			var inputs = $("button[id^='exercise']")
			for (var i = 0; i < inputs.length; i++) {
				exercises[i] = inputs[i].id.replace("exercise", "");
			}
			
			$.ajax({
				type: "POST",
				url: "../common/practice.php",
				data: { method : "create_practice",
						coachId : coach_id,
						title : $("#input_title").val(),
						date : date_full,
						exercises : exercises },
				dataType: "text"
				}).success(function(data) {
					if(data > 0){
						window.location = "./practices.php?success=true";
					}
				}
			);
		}

		function add_skills(section) {

			$("#" + section + "_exercises_list").empty();

			$("#" + section + "_form :input").each(function(){
				if(this.checked){
					$("#" + section + "_exercises_list").append("<div class='row row-offset-xs'><div class='col-sm-offset-1 col-xs-offset-2'>"+
						"<button id='exercise" + this.id + "' class='btn btn-default col-xs-10 col-sm-10' style='white-space: normal;' onclick='remove_skill(" + '"' + section + '"' + ", " + '"'
						 + this.value + '"' + ");'>" + this.value.substring(0, this.value.length - 2) + 
						"<span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;'></span></button></div></div>");
				}
			});
		}

		function remove_skill(section, value){
			var button = $("#" + section + "_exercises_list button:contains('" + value.substring(0, value.length - 2) + "')");
			$("#" + section + "_form input[id*='" + button[0].id.substring(8) + "']")[0].checked = false;
			button.remove();

			if($("#" + section + "_exercises_list > div > div").children().size() == 0){
				$("#" + section + "_exercises_list > div > div").append("<p>There is nothing here. Add an exercise!</p>");
			}
		}

		function search_modal(section){

			$("#" + section + "_form > div").css("display", "none");

			if($("#" + section + "_search").val() == ''){
				filter_divers();
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
	
	<?php include('../common/header.php'); echo_header('Create Practice', true, './practices.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<!-- Exercises Modals --> <!-- TODO: Use one modal and dynamically switch content (?) -->
		
		<?php
			$types = array("warmup", "skills", "conditioning", "flexibility");
		
			foreach ($types as $type) {
				echo '<div class="modal fade" id="' . $type . 'Modal" data-toggle="modal" role="dialog" arialabelledby="skillsModalLabel" aria-hidden="true" style="max-height: 90%;">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="modal-title" id="skillsModalLabel">Select Exercises</h4>
							</div>
							<div class="modal-body">
								<div class="row" style="padding-bottom: 20px;">
									<div class="col-xs-4 col-sm-4">
										<select id="' . $type . '_filter" class="pull-left filter" onchange="filter_modal(\'' . $type . '\');"></select>
									</div>
									<div class="col-xs-10 col-sm-10">
										<input type="text" placeholder="Search" id="' . $type . '_search" class="form-control" />
									</div>
									<div class="col-xs-1 col-sm-1" style="padding: 0;">
										<button class="btn btn-default" onclick="search_modal(\'' . $type . '\');"><span class="glyphicon glyphicon-search"></span></button>
									</div>
								</div>
								<div id="ajax_loader" class="ajax-loader loader-lg center"></div>
								<form id="' . $type . '_form" name="' . $type . '_form">
								</form>
							</div>
							<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" onclick="add_skills(\'' . $type . '\');" data-dismiss="modal">Add Exercises</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->';
			}
		?>

		<div class="row row-offset-sm">
			<label for="date_month" class="formLabel col-sm-offset-1 col-xs-offset-1">Select a Date</label><br />
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

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">Title</label><br />
				<input type="text" class="form-control" placeholder="Title..." style="width:80%;" id="input_title"/>
			</div>
		</div>

		<?php
			$titles = array("Warm Up", "Skills", "Conditioning", "Flexibility");
			
			$types = array("warmup", "skills", "conditioning", "flexibility");
			
			for ($i = 0; $i < count($titles); $i++) {
				echo '<!-- ' . $titles[$i] . ' Section -->
						<div class="row row-offset-sm">
							<div class="col-sm-offset-1 col-xs-offset-1 col-sm-4 col-xs-4">
								<h4>' . $titles[$i] . '</h4>
							</div>
							<div class="col-sm-offset-9 col-xs-offset-9">
								<span class="glyphicon glyphicon-plus-sign addButtonSm fgGreen" style="padding-top: 10px;"
									data-toggle="modal" data-target="#' . $types[$i] . 'Modal"></span>
							</div>
							<div class="col-sm-offset-1 col-xs-offset-1">
								<hr />
							</div>
						</div>
						<div id="' . $types[$i] . '_exercises_list" class="row">
							<div class="col-sm-offset-1 col-xs-offset-2">
								<p>There is nothing here. Add an exercise!</p>
							</div>
						</div>
						<!-- End ' . $titles[$i] . ' Section -->';
			}

		?>

		<div class="row row-offset-md">
			<div class="col-sm-offset-9 col-xs-offset-9">
				<button class="btn btn-default" onclick="create_practice();">Finish</button>
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
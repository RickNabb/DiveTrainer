<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>
	
		$(document).ready(load_exercises);
	
		function load_exercises() {
			var types = ["safetyeducation", "warmup", "conditioning", "flexibility", "trampoline", "dryboard", "platform", "deck-mat-bulkhead", "1m", "3m"];
			
			for (var j = 0; j < types.length; j++) {
				$.ajax({
					type: "GET",
					url: "../common/exercise.php",
					data: { method : "get_exercise_type",
							type : types[j] },
					dataType: "json"
				}).success(function(data) {
					for (var i = 0; i < data.exercises.length; i++) {
						$("#" + data.type + "_form").append(
							'<div class="row">' +
								'<div class="col-sm-offset-2 col-xs-offset-2">' +
									'<input type="checkbox" id="' + data.exercises[i].exerciseId + '" value="' + data.exercises[i].name + ' ' + data.exercises[i].level + '">&nbsp;' + data.exercises[i].name +'</input>' +
								'</div>' +
							'</div>');
					}
				}).error(function(data){
					console.log(data);
				});
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
						"<button id='exercise" + this.id + "' class='btn btn-default' onclick='remove_skill(" + '"' + section + '"' + ", " + '"'
						 + this.value + '"' + ");'>" + this.value + 
						"<span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;'></span></button></div></div>");
				}
			});
		}

		function remove_skill(section, value){
			alert("remove_skill");
			var button = $("#" + section + "_exercises_list button:contains('" + value + "')");
			$("#" + section + "_form input[id*='" + button[0].id.substring(8) + "']")[0].checked = false;
			button.remove();

			if($("#" + section + "_exercises_list > div > div").children().size() == 0){
				alert("empty");
				$("#" + section + "_exercises_list > div > div").append("<p>There is nothing here. Add an exercise!</p>");
			}
		}

	</script>
</head>
<body>
	
	<?php include('../common/header.php'); echo_header('Create Practice', true, './practices.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<!-- Exercises Modals --> <!-- TODO: Use one modal and dynamically switch content (?) -->
		
		<?php
		$types = array("safetyeducation", "warmup", "conditioning", "flexibility", "trampoline", "dryboard", "platform", "deck-mat-bulkhead", "1m", "3m");
		
		foreach ($types as $type) {
			echo '<div class="modal fade" id="' . $type . 'Modal" data-toggle="modal" role="dialog" arialabelledby="skillsModalLabel" aria-hidden="true" style="max-height: 90%;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="skillsModalLabel">Select Exercises</h4>
						</div>
						<div class="modal-body">
							<form id="' . $type . '_form" name="' . $type . '_form">
							</form>
						</div>
						<div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" onclick="add_skills(\'' . $type . '\');" data-dismiss="modal">Add Exercises</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			
			';
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
			$titles = array("Safety Education", "Warm Up","Conditioning", "Flexibility", "Trampoline", "Dryboard", "Platform", "Deck/Mat/Bulkhead", "1m", "3m");
			
			$types = array("safetyeducation", "warmup", "conditioning", "flexibility", "trampoline", "dryboard", "platform", "deck-mat-bulkhead", "1m", "3m");
			
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
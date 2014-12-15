<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		$(document).ready(load_modal_skills);

		function load_modal_skills(){

			var input_data = {
				method: "get_skill"
			};

			$.ajax({
				type: "GET",
				url: "../common/exercise.php",
				data: input_data,
				dataType: 'json'
			}).success(function(data){
					
					if(data != ''){
						for(var i = 0; i < data.exercises.length; i++){
							$("#skills_form").append("<div class='row'><div class='col-sm-offset-1 col-xs-offset-1'>" +
								"<input type='checkbox' id='" + data.exercises[i].exerciseId + "' value='" + data.exercises[i].name + " " + data.exercises[i].level + "'>&nbsp;" +
								data.exercises[i].name + " level " + data.exercises[i].level + "</input>");
						}
					}
			}).error(function(data){

				var test = "test";
			});
		}

		function add_goal() {
			// Combine date fields
			var months = {"Jan": '01', "Feb": "02", "Mar": "03", "Apr":"04", "May": "05",
				"Jun":"06", "Jul":"07", "Aug":"08", "Sep":"09", "Oct":"10", "Nov":"11", "Dec":"12"};
				
			var date_month = $("#date_month").val();
			var date_month_num = months.date_month;
			var date_full = date_month_num + "/" + $("#date_day").val() + "/" + $("#date_year").val();

			var date_now = new Date();
			
			// Get skills
			var skills = [];
			var inputs = $("div[id^='exercise']")
			for (var i = 0; i < inputs.length; i++) {
				var id = inputs[i].id.replace("exercise", "");
				skills[id] = $("#rating" + id).val();
			}

			// Perform post
			$.post("../common/goal.php", 
				{
					diverId:<?php echo $_SESSION['dive_trainer']['userId']; ?>,
					name:$("#input_title").val(),
					startDate: (date_now.getMonth()+1) + "/" + date_now.getDate() + "/" + (date_now.getYear() + 1900),
					endDate:date_full,
					skills: skills, // key = skillId, value = desired rating
					method:"create_goal"
				},
			function(result) {
				if (result != '') {
					alert(result);
					window.location = './goals.php?error=true';
				}
				else {
					window.location="./goals.php";
				}
			}).always(function(result) {
				//alert(result);
			});
		}
	
		function add_skills(){

			$("#skill_list").empty();

			$("#skills_form :input").each(function(){
				if(this.checked){
					$("#skill_list").append("<div class='row row-offset-xs'><div class='col-sm-offset-1 col-xs-offset-1 col-sm-10 col-xs-10 well'>"+
						"<div id='exercise" + this.id + "'>" + this.value + 
						"<span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px; " + 
						"' onclick='remove_skill(\"" + this.value + "\");'></span></div>" + 
						"<label for=''>Complete Rating: </label><input id='rating" + this.id + "' type='number' min='1' max='5' class='form-control' " + 
						"value='1' style='width: 50px;'/></div></div></div>");
				}
			});
		}

		function remove_skill(value){

			var button = $("#skill_list div:contains('" + value + "')");
			$("#skills_form input[id*='" + button[2].id.substring(8) + "']")[0].checked = false;
			button.remove();

			if($("#skill_list > div > div").children().size() == 0){

				$("#skill_list > div > div").append("<p>There is nothing here. Add a skill!</p>");
			}
		}

	</script>
</head>
<body>
	<?php include('../common/header.php'); echo_header('Make Goal', true, 'goals.php', '-sm'); ?>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<!-- Skills Modal -->
		<div class="modal fade" id="skillsModal" data-toggle="modal" role="dialog" arialabelledby="skillsModalLabel" aria-hidden="true" style="max-height: 90%;">
		    <div class="modal-dialog">
		        <div class="modal-content">
		        	<div class="modal-header">
			          	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			            <h4 class="modal-title" id="skillsModalLabel">Select Skills</h4>
		        	</div>
		        	<div class="modal-body">
		        		<form id="skills_form"></form>
		        	</div>
		        	<div class="modal-footer">
		        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	    	<button type="button" class="btn btn-primary" onclick="add_skills();" data-dismiss="modal">Add Skills</button>
		        	</div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="row row-offset-sm">
			<label for="date_month" class="formLabel col-sm-offset-1 col-xs-offset-1">Select End Date</label><br />
			<select id="date_month" class="col-sm-offset-1 col-xs-offset-1 form-control"
				style="width: 70px; display: inline-block;">
			<?php
				$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
				foreach($months as $month){
					echo "<option>$month</option>";
				}
			?>
			</select>
			<!--TODO: have correct days for month-->
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

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1 col-sm-2 col-xs-2">
				<label for="date_month" class="formLabel">Skills</label><br />
			</div>
			<div class="col-sm-offset-9 col-xs-offset-9">
				<span class="glyphicon glyphicon-plus-sign addButtonSm fgGreen" style="padding-top: 10px;"
					data-toggle="modal" data-target="#skillsModal"></span>
			</div>
		</div>

		<div class="row row-offset-sm" id="skill_list">
			<div class="col-sm-offset-1 col-xs-offset-2">
				<p>There is nothing here. Add a skill!</p>
			</div>
		</div>

		<div class="row row-offset-md">
			<div class="col-sm-offset-9 col-xs-offset-9">
				<button class="btn btn-default" id="finishBtn" onclick="add_goal();">Finish</button>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
		
	<div class="admin-bottom-nav">
		<ul>
			<li><a href="./index.php"><span class="glyphicon glyphicon-home"></span><p>Home</p></a></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
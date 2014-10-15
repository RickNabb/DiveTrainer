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

		function add_goal() {
			alert("Start function");
			// Combine date fields
			var months = {"Jan": '01', "Feb": "02", "Mar": "03", "Apr":"04", "May": "05",
				"Jun":"06", "Jul":"07", "Aug":"08", "Sep":"09", "Oct":"10", "Nov":"11", "Dec":"12"};
				
			var date_month = $("#date_month").val();
			var date_month_num = months.date_month;
			var date_full = date_month_num + "/" + $("#date_day").val() + "/" + $("#date_year").val();

			var date_now = new Date();

			// Perform post
			$.post("../common/goal.php", 
				{
					diverId:<?php echo $_SESSION['dive_trainer']['userId']; ?>,
					name:$("#input_title").val(),
					startDate: (date_now.getMonth()+1) + "/" + date_now.getDate() + "/" + (date_now.getYear() + 1900),
					endDate:date_full,
					method:"create_goal"
				},
			function(result) {
				if (result != '') {
					//alert(result);
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

			$("div.modal-body input").each(function(){
				if(this.checked){
					$("#skill_list").append("<div class='row row-offset-xs'><div class='col-sm-offset-1 col-xs-offset-1'>"+
						"<button class='btn btn-default'>" + this.value + "<span class='glyphicon glyphicon-minus-sign' style='color: red; margin-left: 10px;'></span></div></div></div>");
				}
			});
		}

	</script>
</head>
<body>
	<div class="topNav">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h4 class="white ptsans">Welcome, <?php echo $_SESSION['dive_trainer']['fname']; ?>!</h4>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="./goals.php"><span class="glyphicon glyphicon-chevron-left back-arrow"></span></a>
					<!--<p class="navbar-title">Coach</p>-->
				</div>			
			</div>
		</nav>
	</div>	

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
		        		<form>
		        		<?php
		        			// TEMPORARY IMPLEMENTATION : USE SKILLS.PHP FOR THIS

		        			$conn = getConnection();
		        			$query = "SELECT * FROM " . SKILLS_TABLE;
		        			$result = mysql_query($query, $conn);

		        			while($row = mysql_fetch_assoc($result)){

		        				echo '<div class="row">';
		        				echo '<div class="col-sm-offset-1 col-xs-offset-1">';
		        				echo '<input type="checkbox" value="'
		        					. $row['name'] . ' ' . $row['level'] . '">&nbsp;' 
		        					. $row['name'] . " level " . $row['level'] . '</input>';
		        				echo '</div></div>';
		        			}
		        		?>
		        		</form>
		        	</div>
		        	<div class="modal-footer">
		        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	    	<button type="button" class="btn btn-primary" onclick="add_skills();" data-dismiss="modal">Add Skills</button>
		        	</div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="nav-offset"></div>

		<div class="row">
			<div style="color: #21aeff;" class="pull-left col-sm-offset-1 col-xs-offset-1"><h4>Create Goal</h4></div>
		</div>

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
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">Skills</label><br />
				<button class="btn btn-success" data-toggle="modal" data-target="#skillsModal">Add Skills
				<span class="glyphicon glyphicon-plus-sign addButtonSm fgWhite" style="margin-left: 10px;"></span></button>
			</div>
		</div>

		<div id="skill_list"></div>

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
			<li class="./practices"><span class="glyphicon glyphicon-pencil"></span><p>Practices</p></li>
			<li><span class="glyphicon glyphicon-th-list"></span><p>Skills</p></li>
		</ul>
	</div>
</body>
</html>
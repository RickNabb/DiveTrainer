<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require("include.php"); ?>
	
	<script>

		function create_diver(){
			var fname = $("#input_fname").val();
			var lname = $("#input_lname").val();
			var coachId = $("#input_coachID").val();
			
			$.post("./common/diver.php", {fname:fname, lname:lname, coachId:coachId, method:"create_diver"},
			function(result) {
				if (result != '') {
					alert(result);
				}
				else {
					window.location="./index.php";
				}
			});
		}
		
	</script>
</head>
<body>
	<div class="topNav">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h4 class="white ptsans">Registration</h4>
			</div>
		</div>
		
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<a href="./index.php">
					<span class="glyphicon glyphicon-chevron-left back-arrow" />
				</a>
			</div>
		</nav>
	</div>	

	<div class="container container-fluid">
		<div class="nav-offset"></div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">First Name</label><br />
				<input type="text" class="form-control" placeholder="Enter Name..." style="width:80%;" id="input_fname"/>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">Last Name</label><br />
				<input type="text" class="form-control" placeholder="Enter Name..." style="width:80%;" id="input_lname"/>
			</div>
		</div>
		
		<div class="row row-offset-sm">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<label for="date_month" class="formLabel">Coach ID</label><br />
				<input type="text" class="form-control" placeholder="Enter Your Coach's ID..." style="width:80%;" id="input_coachID"/>
			</div>
		</div>
		
		<div class="row row-offset-sm">
			<div class="col-sm-offset-9 col-xs-offset-9">
				<button class="btn btn-default" onclick="create_diver();">Finish</button>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
</body>
</html>
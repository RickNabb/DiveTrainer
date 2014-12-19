<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require("include.php"); ?>
	
	<script>

		window.onload = function(){

			$("#step_2").hide();
			$("small[id*='_error']").each(function(){
				$(this).hide();
			});
		}

		function create_diver(){
			var fname = $("#input_fname").val();
			var lname = $("#input_lname").val();
			var coachId = $("#input_coachID").val();
			var email = $("#input_email").val();
			var password = $("#input_pass").val();

			$.post("./common/diver.php", 
				{fname:fname, lname:lname, coachId:coachId, method:"create_diver", email:email},
				function(result) {
					if (result != '') {
						
						$.post("./common/auth.php", 
							{type:"diver", id:result, email:email, password:password, method:"register",
								fname:fname, lname:lname},
							function(result) {
								if (result == 'success') {
									window.location="./index.php?register=success&email=" + email;
								}
								else if(result == 'existing'){
									window.location="./index.php?register=existing";	
								}
								else {
									window.location="./index.php?register=failure";
								}
							});
					}
					else {
						window.location="./index.php?register=failure";
					}
				});
		}

		function validate_coach_id(){

			var coach_id = $("#input_coachID").val();

			$(".loader-btn").parent().attr("disabled", "");
			$(".loader-btn").parent().attr("onclick", "");
			$(".loader-btn").show();

			$.get("./common/coach.php", 
				{ method: "get_coach", coachId:coach_id },
				function(result) {

					$(".loader-btn").hide();
					$(".loader-btn").parent().removeAttr("disabled");
					$(".loader-btn").parent().attr("onclick", "validate_coach_id();");

					if (result != '') {
						step_2();
					}
					else {
						coach_id_error();
					}
				});
		}

		function coach_id_error(){

			$("#coach_error").show();
		}

		function step_2(){

			$("#step_1").hide();
			$("#step_2").show();
		}
		
	</script>
</head>
<body>

	<div id="topNav_mobile">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1 col-lg-offset-1">
				<h2 class="white ptsans">&nbsp;</h2>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="./practices.php"><span class="glyphicon glyphicon-chevron-left back-arrow"></span></a>
					<p class="navbar-title">Register</p>
				</div>			
			</div>
		</nav>
	</div>
	<div id="topNav_tablet">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1 col-lg-offset-1">
				<h1 class="white ptsans">Dive Trainer</h1>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<p class="navbar-title">Register</p>
				</div>			
			</div>
		</nav>
	</div>

	<div class="nav-offset"></div>

	<div class="container container-fluid">
		
		<div id="step_1">
			<div class="row row-offset-lg">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<label for="input_coachID" class="formLabel">Coach ID</label><br />
					<input type="number" class="form-control" placeholder="Enter Your Coach's ID..." style="width:80%;" id="input_coachID"/>
				</div>
			</div>

			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<small id="coach_error" class="error">&nbsp;Coach ID not found. Please try again.</small>
				</div>
			</div>
			
			<div class="row row-offset-md">
				<div class="col-sm-offset-8 col-xs-offset-8">
					<button class="btn btn-default" onclick="validate_coach_id();">Next
						<img src="./img/loader_white.gif" class="loader-btn"></button>
				</div>
			</div>
		</div>

		<div id="step_2">
			<div class="row row-offset-lg">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<label for="input_fname" class="formLabel">First Name</label><br />
					<input type="text" class="form-control" placeholder="Enter Your First Name..." style="width:80%;" id="input_fname"/>
				</div>
			</div>
			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<small id="fname_error" class="error">&nbsp;Please enter a valid first name.</small>
				</div>
			</div>

			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<label for="input_lname" class="formLabel">Last Name</label><br />
					<input type="text" class="form-control" placeholder="Enter Your Last Name..." style="width:80%;" id="input_lname"/>
				</div>
			</div>
			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<small id="lname_error" class="error">&nbsp;Please enter a valid last name.</small>
				</div>
			</div>

			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<label for="input_email" class="formLabel">Email</label><br />
					<input type="text" class="form-control" placeholder="someone@example.com" style="width:80%;" id="input_email"/>
				</div>
			</div>
			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<small id="address_error" class="error">&nbsp;Please enter a valid email address.</small>
				</div>
			</div>

			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<label for="input_email" class="formLabel">Password</label><br />
					<input type="password" class="form-control" placeholder="Enter A Password..." style="width:80%;" id="input_pass"/>
				</div>
			</div>
			<div class="row row-offset-sm">
				<div class="col-sm-offset-1 col-xs-offset-1">
					<small id="pass_error" class="error">&nbsp;Please enter a valid password.</small>
				</div>
			</div>
			
			<div class="row row-offset-md">
				<div class="col-sm-offset-8 col-xs-offset-8">
					<button class="btn btn-default" onclick="create_diver();">Finish</button>
				</div>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
</body>
</html>
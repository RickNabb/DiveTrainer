<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); 
		require_once("./bootstrap.php"); ?>

	<script>

		function create_diver(){
			var fname = $("#fname").val();
			var lname = $("#lname").val();
			var coach_id = $("#coach_id").val();

			
			
			var input_data = {
				fname : $("#input_title").val(),
				lname : date_full,
				coachId : coach_id
			};

			$.post({
				url: "./common/diver.php",
				data: input_data,
				success: function(data){
					if(data > 0){
						window.location = "./index.php?success=true";
					}
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

		<!--<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-offset-2 col-xs-3 col-sm-6">
						<a href="./index.php"><span class="glyphicon glyphicon-chevron-left back-arrow"></span></a>
					</div>
					<div class="col-sm-offset-2 col-sm-2 row-offset-15">
						Return to Login
					</div>
				</div>
			</div>
		</nav>-->
		
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

		<!--<div class="row row-offset-sm">
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
	</div>-->
	
	<form role="form" method="post" action="./common/diver.php">
		<div class="form-group">
			<label for="date_month" class="formLabel">First Name</label><br />
			<input type="text" class="form-control" placeholder="Enter Name..." style="width:80%;" name="fname" id="input_fname"/>
		</div>

		<div class="form-group">
			<label for="date_month" class="formLabel">Last Name</label><br />
			<input type="text" class="form-control" placeholder="Enter Name..." style="width:80%;" name="lname" id="input_lname"/>
		</div>
	
		<div class="form-group">
			<label for="date_month" class="formLabel">Coach ID</label><br />
			<input type="text" class="form-control" placeholder="Enter Your Coach's ID..." style="width:80%;" name="coachId" id="input_coachID"/>
		</div>
	
		<div class="col">
			<button class="btn btn-default" type="submit">Finish</button>
		</div>
	</form>
</body>
</html>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require("include.php"); ?>
	
	<script>
		
		window.onload = function(){
			activate_account();
		}

		function activate_account(){

			var GUID = "<?php echo $_GET['guid']; ?>";
			var id = <?php echo $_GET['userId']; ?>;

			$.ajax({
				type: "POST",
				url: "./common/auth.php",
				data: {
					method: "activate_account",
					id: id,
					guid: GUID
				}
			}).success(function(data){

				if(data == "success"){
					send_login_info_email();
				} 
				else if(data == "already"){
					$("#already").show();
				}
				else if(data == "none"){
					$("#none").show();
				}
				else if(data == "failure"){
					$("#error").show();
				}

			}).error(function(data){

				$("#error").show();
			});
		}

		function send_login_info_email(){

			var id = <?php echo $_GET['userId']; ?>;

			$.ajax({
				type: "POST",
				url: "./common/auth.php",
				data: {
					method: "send_username_email",
					type: "<?php echo $_GET['type']; ?>",
					authId: id,
				}
			}).success(function(data){

				if(data == "success"){
					$("#success").show();
				} 
				else if(data == "failure"){
					$("#error").show();	
				}

			}).error(function(data){

				$("#error").show();
			});
		}

	</script>
</head>
<body>

	<div id="topNav_mobile">
		<div class="row blue">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1 col-lg-offset-1">
				<h4 class="white ptsans">&nbsp;</h4>
			</div>
		</div>

		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<p class="navbar-title">Confirm</p>
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
					<p class="navbar-title">Confirm</p>
				</div>			
			</div>
		</nav>
	</div>

	<div class="nav-offset"></div>

	<div class="container container-fluid">

		<div id="success" style="display: none;">
			<div class="row row-offset-sm">
				<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10 alert alert-success">
					<strong>Thank you!</strong>
					<p>Your account has been confirmed. You can now successfully log in and begin training!</p> <!-- TODO: Maybe make this sound less stupid... -->
				</div>
			</div>
		</div>

		<div id="already" style="display: none;">
			<div class="row row-offset-sm">
				<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10 alert alert-warning">
					<strong>Oops!</strong>
					<p>It seems your account has already been confirmed.</p>
				</div>
			</div>
		</div>

		<div id="none" style="display: none;">
			<div class="row row-offset-sm">
				<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10 alert alert-danger">
					<strong>Oops!</strong>
					<p>It seems we couldn't find your account. Perhaps you need to register again.</p>
				</div>
			</div>
		</div>

		<div id="error" style="display: none;">
			<div class="row row-offset-sm">
				<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10 alert alert-danger">
					<strong>Oops!</strong>
					<p>It seems something went wrong. Please contact upstatediving@gmail.com for more information.</p>
				</div>
			</div>
		</div>

		<div class="row row-offset-lg">
			<div class="center">
				<button class="btn btn-default" onclick="window.location='./index.php'">Back to Login</button>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
</body>
</html>
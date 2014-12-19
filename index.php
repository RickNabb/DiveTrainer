<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		function logIn(){
			var userId = $("#inputID").val();
			var password = $("#password").val();
			var first_char = $("#inputID").val().substr(0, 1);
			var input_data = {
				method : "log_in",
				ident : first_char,
				authId : userId.substr(1),
				pass : password
			};

			$.get('./common/auth.php',
				input_data,
				function(data, success){
					if(parseInt(data) > 0){

						if(first_char == 'c')
							window.location = './admin/index.php';
						else if(first_char == 'd')
							window.location = './diver/index.php';
					}
					else{
						if (parseInt(data) == 0) {
							// TODO: Form validation
							alert("Username not found")
						}
					}
				});			
		}

		function register(){
			window.location="./register.php";
		}
		
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row row-lg blue">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1 col-lg-offset-1">
				<h1 class="white ptsans">Dive Trainer</h1>
			</div>
		</div>

		<!-- Register success check -->
		<?php if(isset($_GET['register']) && $_GET['register'] == 'success') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-success">
					<?php echo '<p>You have successfully been registered! A confirmation email has been sent to 
							<strong>' . $_GET['email'] . '</strong></p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- Register existing check -->
		<?php if(isset($_GET['register']) && $_GET['register'] == 'existing') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-warning">
					<?php echo '<p>This email has already been registered.</p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- Register failure check -->
		<?php if(isset($_GET['register']) && $_GET['register'] == 'failure') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-danger">
					<?php echo '<p>Something went wrong with registration! Please try again later.</p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="row row-offset-md">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-offset-2 
				col-xs-8 col-sm-8 col-md-8 col-lg-8">
				<input type="text" class="form-control" placeholder="User ID" id="inputID"/>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-offset-2 
				col-xs-8 col-sm-8 col-md-8 col-lg-8">
				<input type="password" class="form-control" placeholder="password"  id="password" />
			</div>
		</div>

		<div class="row row-offset-lg">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-2 col-sm-2 col-md-offset-3">
				<input type="button" class="btn btn-default" value="Log In"
					onclick="logIn();"/>
			</div>
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-2 col-sm-2">
				<input type="button" class="btn btn-default" value="Register" 
					onclick="register();"/>
			</div>
		</div>
	</div>
</body>
</html>
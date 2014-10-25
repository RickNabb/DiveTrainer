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
						window.location = './admin/index.php';
					}
					else{
						if (parseInt(data) == 0) {
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
	<div class="container container-fluid">
		<div class="row row-lg blue">
			<div class="col-sm-offset-1 col-xs-offset-1">
				<h1 class="white ptsans">Dive Trainer</h1>
			</div>
		</div>

		<div class="row row-offset-md">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-8 col-sm-8">
				<input type="text" class="form-control" placeholder="User ID" id="inputID"/>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-8 col-sm-8">
				<input type="password" class="form-control" placeholder="password"  id="password" />
			</div>
		</div>

		<div class="row row-offset-lg">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-2 col-sm-2">
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
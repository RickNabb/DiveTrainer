<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>

	<script>

		function logIn(){
			var userId = $("#inputDiverID").val();
			var password = $("#password").val();

			if(userId === "d123456789" && password === "password"){
				window.location="./diver/index.php";
			}
			else if(userId === "a123456789" && password === "password"){
				window.location="./admin/index.php";
			}
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
				<input type="text" class="form-control" placeholder="Diver ID" id="inputDiverID"/>
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-8 col-sm-8">
				<input type="password" class="form-control"  id="password" />
			</div>
		</div>

		<div class="row row-offset-lg">
			<div class="col-sm-offset-4 col-xs-offset-4 col-xs-4 col-sm-4">
				<input type="button" class="btn btn-default" value="Log In"
					onclick="logIn();"/>
			</div>
		</div>
	</div>
</body>
</html>
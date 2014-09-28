<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include("include.php"); ?>
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
				<input type="text" class="form-control" placeholder="Email Address" />
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-sm-offset-2 col-xs-offset-2 col-xs-8 col-sm-8">
				<input type="password" class="form-control"  />
			</div>
		</div>

		<div class="row row-offset-lg">
			<div class="col-sm-offset-4 col-xs-offset-4 col-xs-4 col-sm-4">
				<input type="button" class="btn btn-default" value="Log In"
					onclick="window.location = './admin/admin'"/>
			</div>
		</div>
	</div>
</body>
</html>
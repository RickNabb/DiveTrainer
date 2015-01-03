<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width">

	<?php include("include.php"); ?>
	<?php //include("session_check.php"); ?>

	<script>

	</script>
</head>
<body>	

	<?php include('../common/header.php'); echo_header('Coach'); ?>

	<div class="nav-offset" style="padding: 0; height: 90px;"></div>

	<div class="container container-fluid">

		<div id="body_mobile">

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


			<div class="row">
				<a href="./makeCoach.php">
					<div class="adminHomeItem">
						<h3>Make a Coach</h3>
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>
</body>
</html>
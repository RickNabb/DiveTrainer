<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width">

	<?php include("include.php"); ?>
	<?php if($_SESSION['dive_trainer']['userId'] != $_GET['id']){
		header("Location: ../auth_error.php");
	} ?>

	<script>

		function changePwd(){

			$("#pwd_match_validate").hide();

			// Check for the new passwords matching
			if($("#new_pwd").val() == $("#new_confirm").val()){

				// If they do, then check if the old pwd and the pwd in the database match
				$.ajax({
					type: "GET",
					url: "../common/auth.php",
					data: {
						method: "pwd_match",
						id: <?php echo $_GET['id']; ?>,
						type: 'diver',
						pass: $("#old_pwd").val()
					},
					dataType: "json"
				}).success(function(data){
					
					// If they do, then change the password to the new one
					if(data == 1){

						$.ajax({
							type: "POST",
							url: "../common/auth.php",
							data: {
								method: "change_pwd",
								id: <?php echo $_GET['id']; ?>,
								type: 'diver',
								pass: $("#new_pwd").val()
							},
							dataType: "json"
						}).success(function(data){
							
							if(data == 1){
								window.location = "./account.php?id=" + <?php echo $_GET['id']; ?> + "&changePwd=success";
							}
							else{
								window.location = "./account.php?id=" + <?php echo $_GET['id']; ?> + "&changePwd=failure";
							}

						}).error(function(data){

							window.location = "./account.php?id=" + <?php echo $_GET['id']; ?> + "&changePwd=failure";
						});
					}
					// If they don't match, let the user know
					else{
						window.location = "./account.php?id=" + <?php echo $_GET['id']; ?> + "&changePwd=nomatch";
					}

				}).error(function(data){

					window.location = "./account.php?id=" + <?php echo $_GET['id']; ?> + "&changePwd=nomatch";
				});
			}
			else{

				$("#pwd_match_validate").show();
			}
		}

	</script>
</head>
<body>	

	<?php include('../common/header.php'); echo_header('My Account', true, './index.php', '-sm'); ?>

	<div class="nav-offset" style="padding: 0; height: 90px;"></div>

	<div class="container container-fluid">	

		<!-- Register success check -->
		<?php if(isset($_GET['changePwd']) && $_GET['changePwd'] == 'success') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-success">
					<?php echo '<p>Your password has been changed!</p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- Register existing check -->
		<?php if(isset($_GET['changePwd']) && $_GET['changePwd'] == 'nomatch') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-warning">
					<?php echo '<p>The password you entered did not match your password. Please try again.</p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<!-- Register failure check -->
		<?php if(isset($_GET['changePwd']) && $_GET['changePwd'] == 'failure') { ?>
		<div class="row row-offset-sm">
			<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
				<div class="alert alert-danger">
					<?php echo '<p>Something went wrong with changing your password! Please try again later.</p>'; ?>
				</div>
			</div>
		</div>
		<?php } ?>	

		<div class="row row-offset-sm">
			<div class="col-xs-11 col-sm-11">
				<h4>Change Password?</h4>
				<hr />
			</div>
		</div>

		<div class="row row-offset-xs">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<input type="password" id="old_pwd" class="form-control" placeholder="Enter Password..." />
			</div>
		</div>

		<div id="pwd_match_validate" class="row row-offset-xs" style="display: none;">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<p class="error">Passwords do not match</p>
			</div>
		</div>

		<div class="row row-offset-xs">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<input type="password" id="new_pwd" class="form-control" placeholder="Enter New Password..." />
			</div>
		</div>

		<div class="row row-offset-xs">
			<div class="col-xs-offset-1 col-sm-offset-1 col-xs-10 col-sm-10">
				<input type="password" id="new_confirm" class="form-control" placeholder="Confirm New Password..." />
			</div>
		</div>

		<div class="row row-offset-sm">
			<div class="col-xs-offset-7 col-sm-offset-7 col-xs-1 col-sm-1">
				<button class="btn btn-default" onclick="changePwd();">Change</button>
			</div>
		</div>

		<div class="ftr-offset"></div>
	</div>

	<div class="admin-bottom-nav">
		<ul>
			<li class="current"><span class="glyphicon glyphicon-home"></span><p>Home</p></li>
			<li><a href="./goals.php"><span class="glyphicon glyphicon-user"></span><p>Goals</p></a></li>
			<li><a href="./skills.php"><span class="glyphicon glyphicon-list"></span><p>Skills</p></a></li>
		</ul>
	</div>
</body>
</html>
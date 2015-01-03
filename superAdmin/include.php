<?php require("bootstrap.php");
	if(!isset($_SESSION['dive_trainer']['userId']) || $_SESSION['dive_trainer']['userId'] == NULL || !$_SESSION['dive_trainer']['isSuperAdmin']){
		
		header('Location: ../auth_error.php');
	}
?>

<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/admin_site.css" rel="stylesheet" type="text/css" />
<link href="../css/shared_site.css" rel="stylesheet" type="text/css" />
<!--<link href='http://fonts.googleapis.com/css?family=PT+Sans:700,400' rel='stylesheet' type='text/css'>-->
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/site.js"></script>
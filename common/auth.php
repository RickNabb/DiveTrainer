<?php

/**
* auth.php
*
* Handles authentication transactions between client and server/db.
* Contains both data methods and HTTP methods.
*
* (C) Nick Rabb 2014
*/


///////////////////////////////////////////////////////////////////////////////
// INCLUDES & REQUIRES
///////////////////////////////////////////////////////////////////////////////

require_once('bootstrap.php');


///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	session_start();

	if($_POST['method'] == "log_out"){
		echo log_out();
	}
}

else if($_SERVER['REQUEST_METHOD'] == 'GET'){

	session_start();

	if($_GET['method'] == 'log_in'){

		$authId = $_GET['authId'];
		$pass = $_GET['pass'];
		$ident = $_GET['ident'];

		echo log_in($authId, $ident, $pass);
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* logIn
*
* Function to verify log in information.
*
* @param int $authId : Integer representation of authId value (part of login name).
* @param char $ident : Character signifying log in type.
*	'c' = coach
*	'd' = diver
* @param string $pass : String representation of the user's password.
*/
function log_in($authId, $ident, $pass){

	// TODO: Make logging in go through the actual auth table
	// with hashing checks, etc.

	$conn = getConnection();

	if($ident == 'c'){		
	
		// Check if coach exists
		$query = sprintf('SELECT COUNT(*) FROM %s WHERE coachId = %s',
			mysql_real_escape_string(COACHES_TABLE),
			mysql_real_escape_string($authId));
			
		$result = mysql_query($query, $conn);
		
		// If no coach exists, return 0
		if (mysql_fetch_row($result)[0] == '0') {
			return 0;
		}		
		$_SESSION['dive_trainer']['userId'] = $authId;
		coach_load_info();
		return 1;
	}
	else if($ident == 'd'){
		// Check if diver exists
		$query = sprintf('SELECT COUNT(*) FROM %s WHERE diverId = %s',
			mysql_real_escape_string(DIVERS_TABLE),
			mysql_real_escape_string($authId));
			
		$result = mysql_query($query, $conn);
		
		// If no diver exists, return 0
		if (mysql_fetch_row($result)[0] == '0') {
			return 0;
		}
		$_SESSION['dive_trainer']['userId'] = $authId;
		diver_load_info();
		return 1;
	}
	else{
		// Error
	}
}

/**
* diver_load_info
*
* Function to load diver information into the Server variables
*
* Note: $_SESSION['userId'] must be set
**/
function diver_load_info() {
	if ($_SESSION['dive_trainer']['userId'] == NULL || $_SESSION['dive_trainer']['userId'] == '') {
		return;
	}
	
	$_SESSION['dive_trainer']['userType'] = 'diver';
		
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT fname, lname FROM %s WHERE diverId = %s',
		mysql_real_escape_string(DIVERS_TABLE),
		mysql_real_escape_string($_SESSION['dive_trainer']['userId']));
		
	$row = mysql_fetch_assoc($result);
	
	$_SESSION['dive_trainer']['fname'] = $row['fname'];
	$_SESSION['dive_trainer']['lname'] = $row['lname'];
	//$_SESSION['dive_trainer']['diverId'] = $result['diverId'];
}

/**
* coach_load_info
*
* Function to load diver information into the Server variables
*
* Note: $_SESSION['userId'] must be set
**/
function coach_load_info() {
	if ($_SESSION['dive_trainer']['userId'] == NULL || $_SESSION['dive_trainer']['userId'] == '') {
		return;
	}
	
	$_SESSION['dive_trainer']['userType'] = 'coach';
	
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT fname, lname FROM %s WHERE coachId = %s',
		mysql_real_escape_string(COACHES_TABLE),
		mysql_real_escape_string($_SESSION['dive_trainer']['userId']));
		
	$result = mysql_query($query, $conn);
	$row = mysql_fetch_assoc($result);
	
	$_SESSION['dive_trainer']['fname'] = $row['fname'];
	$_SESSION['dive_trainer']['lname'] = $row['lname'];
	//$_SESSION['dive_trainer']['coachId'] = $result['coachId'];
}

/**
* log_out
*
* Function to log the user out of the app, and clear the session
* data.
**/
function log_out(){

	session_unset();
	return 1; // TODO: Check for actual session destruction
}


?>
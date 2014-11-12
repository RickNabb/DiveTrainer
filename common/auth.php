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
require_once('../phpmailer/class.phpmailer.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	session_start();

	if($_POST['method'] == "log_out"){
		echo log_out();
	}

	if($_POST['method'] == "register") {

		$email = $_POST['email'];
		$password = $_POST['password'];
		$type = $_POST['type'];
		$id = $_POST['id'];

		echo register($type, $id, $email, $password);
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
		$query = sprintf("SELECT COUNT(*) FROM %s where coachId='%s' AND password='%s'",
			AUTH_TABLE,
			mysql_real_escape_string($authId),
			encrypt($pass));

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
		$query = sprintf("SELECT COUNT(*) FROM %s where diverId='%s' AND password='%s'",
			AUTH_TABLE,
			mysql_real_escape_string($authId),
			encrypt($pass));
			
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
	$result = mysql_query($query, $conn);

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

/**
* register
*
* @param string $type : 'coach' or 'diver'
* @param int $id : id of individual to register
* @param string $email : email address of the individual to register
* @param string $password : password for the account
*
*/
function register($type, $id, $email, $password){

	$conn = getConnection();
	$guid = GUID();

	$result = '';

	$diverId = $coachId = -1;

	if($type == 'diver'){
		$diverId = $id;
		$query = sprintf("SELECT * FROM %s WHERE email='%s'",
			DIVERS_TABLE,
			mysql_real_escape_string($email));
		$result = mysql_query($query, $conn);

		if(!$result){
			$errMsg = "Error fetching diver entry: " . mysql_error($conn);
			mysql_close($conn);
			throw new Exception($errMsg);
		}
	} else if($type == 'coach'){
		$coachId = $id;
	}

	// No duplicate entries for auth
	if(mysql_fetch_assoc($result) == ""){
		$query = sprintf("INSERT INTO %s(diverId, coachId, password, GUID, active)
			VALUES('%s', '%s', '%s', '%s', '%d')",
			AUTH_TABLE,
			mysql_real_escape_string($diverId),
			mysql_real_escape_string($coachId),
			mysql_real_escape_string(encrypt($password)),
			GUID(),
			0);

		$result = mysql_query($query, $conn);
		if(!$result){
			$errMsg = "Error creating new user: " . mysql_error($conn);
			mysql_close($conn);
			throw new Exception($errMsg);
		}
		$userId = mysql_insert_id($conn);
		mysql_close($conn);

		$success = 'success';//sendConfirmEmail($userId, $email, $guid, $fname, $lname);

		return $success;
	}
	else{
		return "existing";
	}
}

/*
* CREDIT TO The phunction PHP framework (http://sourceforge.net/projects/phunction/)
*/
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

/**
* sendConfirmEmail
*
* Function to send a registration confirmation email to a user including a link to a
* the confirmation page.
*
* @param int $userId : The userId to stick in the confirmation link
* @param string $email : The email address to send the message to
* @param string $guid : A unique identifier for user confirmation
* @param string $fname : The first name of the user
* @param string $lname : The last name of the user
*
* @return string : 'success' if the confirmation email was sent successfully
*				   'failure' if the confirmation email was not sent successfully
*
*/
function sendConfirmEmail($userId, $email, $guid, $fname, $lname){
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Username="";
	$mail->Password="";
	$webmaster_email = "";
	
	$mail->From = $webmaster_email;
	$mail->FromName = "The Sandbox Playground";
	$mail->AddAddress($email);
	$mail->AddReplyTo($webmaster_email, "The Sandbox Playground");
	$mail->WordWrap = 50;
	$mail->IsHTML(true);		

	$subject = "The Sandbox Playground Account - Confirmation";
	$body = "<p>Dear $fname $lname,</p>
			<br /><p>Thank you for registering as a user of The Sandbox Playground!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: <a href='http://localhost/Sandbox/confirmAccount.php?userId=$userId&&guid=$guid'>
			http://localhost/Sandbox/confirmAccount?userId=$userId&&guid=$guid</a>
			</p><br /><br />
			<p>Sincerely,</p>
			<p>The Sandbox Playground</p>";
	$altBody = "Dear Sandbox User,\n
			Thank you for registering as a user of The Sandbox Playground!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: http://localhost/Sandbox/confirmAccount.php?userId=$userId&&guid=$guid\n\n\n
			Sincerely,\n
			The Sandbox Playground";

	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody = $altBody;

	if($mail->Send()){
		echo "success";
	}
	else{
		echo "failure";
	}
}

/**
* encrypt
*
* Simply encrypts a password
* TODO : enhance encryption algorithm
*
* @param string $pass : Password for encryption
*
* @return string $newPass : The encrypted password
*/
function encrypt($pass){
	$newPass = '';
	for($i = 0; $i < strlen($pass); $i++){
		$newPass .= chr((ord($pass[$i])*13) % 48 + 48);
	}

	return $newPass;
}

?>
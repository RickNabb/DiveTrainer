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
require_once('../phpmailer/class.smtp.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	session_start();

	if($_POST['method'] == "log_out"){
		echo log_out();
	}

	else if($_POST['method'] == "register") {

		$email = $_POST['email'];
		$password = $_POST['password'];
		$type = $_POST['type'];
		$id = $_POST['id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		echo register($type, $id, $email, $password, $fname, $lname);
	}

	else if($_POST['method'] == "activate_account"){

		$authId = $_POST['id'];
		$GUID = $_POST['guid'];

		echo activate_account($authId, $GUID);
	}

	else if($_POST['method'] == "send_username_email"){

		$authId = $_POST['authId'];

		echo send_username_email($authId);
	}

	else if($_POST['method'] == "change_pwd"){

		$type = $_POST['type'];
		$id = $_POST['id'];
		$pass = $_POST['pass'];

		echo change_pwd($type, $id, $pass);
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
	else if($_GET['method'] == 'pwd_match'){

		$type = $_GET['type'];
		$id = $_GET['id'];
		$pass = $_GET['pass'];

		echo pwd_match($type, $id, $pass);
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

	$conn = getConnection();

	if($ident == 'c'){		
	
		// Check if coach exists
		$query = sprintf("SELECT * FROM %s where coachId='%s' AND password='%s' AND active=1",
			AUTH_TABLE,
			mysql_real_escape_string($authId),
			encrypt($pass));

		$result = mysql_query($query, $conn);
		$row = mysql_fetch_assoc($result);
		
		// If no coach exists, return 0
		if ($row == '' || $row == null) {
			return 0;
		}

		$_SESSION['dive_trainer']['userId'] = $authId;
		$_SESSION['dive_trainer']['isAdmin'] = True;
		coach_load_info();

		return 1;
	}
	else if($ident == 'd'){
		// Check if diver exists
		$query = sprintf("SELECT * FROM %s where diverId='%s' AND password='%s' AND active=1",
			AUTH_TABLE,
			mysql_real_escape_string($authId),
			encrypt($pass));
			
		$result = mysql_query($query, $conn);
		
		$row = mysql_fetch_assoc($result);
		
		// If no diver exists, return 0
		if ($row == '' || $row == null) {
			return 0;
		}
		$_SESSION['dive_trainer']['userId'] = $authId;
		$_SESSION['dive_trainer']['isAdmin'] = False;
		diver_load_info();
		return 1;
	}
	else if($ident == 's'){

		$query = sprintf("SELECT * FROM %s where coachId='%s' AND password='%s' AND active=1 AND isSuperAdmin=1",
			AUTH_TABLE,
			mysql_real_escape_string($authId),
			encrypt($pass));
			
		$result = mysql_query($query, $conn);
		
		$row = mysql_fetch_assoc($result);
		
		// If no super admin exists, return 0
		if ($row == '' || $row == null) {
			return 0;
		}
		$_SESSION['dive_trainer']['userId'] = $authId;
		$_SESSION['dive_trainer']['isSuperAdmin'] = True;
		coach_load_info();

		return 1;
	}
	else{
		// Error
	}
}

/**
* pwd_match
*
* This function will determine if a given password matches a user's password
*
* @param string $type : 'coach' or 'diver'
* @param int $id : id of the user to check against
* @param string $pass : password to check for match
*
* @return bool $match : Does the password match?
*/
function pwd_match($type, $id, $pass){

	$conn = getConnection();

	$query = sprintf("SELECT * FROM %s WHERE " . $type . "Id=%s AND password='%s'",
		AUTH_TABLE,
		mysql_real_escape_string($id),
		encrypt($pass));

	$result = mysql_query($query, $conn);
	if(!$result){
		$errMsg = "Error finding matching password: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}

	$row = mysql_fetch_assoc($result);
	$match = ($row != '' || $row != null);

	return $match;
}

/**
* change_pwd
*
* This function change a user's password
*
* @param string $type : 'coach' or 'diver'
* @param int $id : id of the user to check against
* @param string $pass : password to change to
*
* @return int $rows_affected : Number of SQL rows affected by the update query
*/
function change_pwd($type, $id, $pass){

	$conn = getConnection();

	$query = sprintf("UPDATE %s SET password='%s' WHERE " . $type . "Id=%s",
		AUTH_TABLE,
		encrypt($pass),
		mysql_real_escape_string($id));

	$result = mysql_query($query, $conn);
	if(!$result){
		$errMsg = "Error finding matching password: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}

	$rows_affected = mysql_affected_rows($conn);

	return $rows_affected;
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
* @param string $fname : first name of the registrant
* @param string $lname : last name of the registrant
*
*/
function register($type, $id, $email, $password, $fname, $lname){

	$conn = getConnection();
	$guid = GUID();

	$result = '';

	$diverId = $coachId = -1;

	if($type == 'diver'){
		$diverId = $id;
	} else if($type == 'coach'){
		$coachId = $id;
	}

	// No duplicate entries for auth
	//if(mysql_fetch_assoc($result) == ""){
		$query = sprintf("INSERT INTO %s(diverId, coachId, password, GUID, active)
			VALUES('%s', '%s', '%s', '%s', %s)",
			AUTH_TABLE,
			mysql_real_escape_string($diverId),
			mysql_real_escape_string($coachId),
			mysql_real_escape_string(encrypt($password)),
			$guid,
			'0');

		$result = mysql_query($query, $conn);
		if(!$result){
			$errMsg = "Error creating new user: " . mysql_error($conn);
			mysql_close($conn);
			throw new Exception($errMsg);
		}
		$userId = mysql_insert_id($conn);
		mysql_close($conn);

		$success = sendConfirmEmail($userId, $email, $guid, $fname, $lname);

		return $success;
	/*}
	else{
		return "existing";
	}*/
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

	$subject = "Dive Trainer - Account Confirmation";
	$body = "<p>Dear $fname $lname,</p>
			<br /><p>Thank you for registering as a user of Dive Trainer!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: <a href='http://upstatediving.com/DiveTrainer/confirmAccount.php?userId=$userId&guid=$guid'>
			http://upstatediving.com/DiveTrainer/confirmAccount?userId=$userId&&guid=$guid</a>
			</p><br /><br />
			<p>Sincerely,</p>
			<p>Upstate Diving</p>";
	$altBody = "Dear Upstate Diving User,\n
			Thank you for registering as a user of Dive Trainer!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: http://upstatediving.com/DiveTrainer/confirmAccount.php?userId=$userId&guid=$guid\n\n\n
			Sincerely,\n
			Upstate Diving";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	//$headers .= 'To: $fname $lname <$email>' . "\r\n";
	$headers .= 'From: Upstate Diving <upstatediving@gmail.com>' . "\r\n";

	if(mail($email, $subject, $body, $headers)){
		echo "success";
	} else {
		echo "failure";
	}
	
	/*$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Username="upstatediving@gmail.com";
	$mail->Password="Jongos01";
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;  
	$webmaster_email = "upstatediving@gmail.com";
	
	$mail->From = $webmaster_email;
	$mail->FromName = "Upstate Diving";
	$mail->AddAddress($email);
	$mail->AddReplyTo($webmaster_email, "Upstate Diving");
	$mail->WordWrap = 50;
	$mail->IsHTML(true);		

	$subject = "Upstate Diving - Account Confirmation"; // TODO: Change account confirmation link to the real URL
	$body = "<p>Dear $fname $lname,</p>
			<br /><p>Thank you for registering as a user of Dive Trainer!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: <a href='http://upstatediving.com/DiveTrainer/confirmAccount.php?userId=$userId&guid=$guid'>
			http://upstatediving.com/DiveTrainer/confirmAccount?userId=$userId&&guid=$guid</a>
			</p><br /><br />
			<p>Sincerely,</p>
			<p>Upstate Diving</p>";
	$altBody = "Dear Upstate Diving User,\n
			Thank you for registering as a user of Dive Trainer!\n\n
			Please follow this confirmation address to finalize your account creation,
			and have full access to our web services: http://upstatediving.com/DiveTrainer/confirmAccount.php?userId=$userId&guid=$guid\n\n\n
			Sincerely,\n
			Upstate Diving";

	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody = $altBody;

	if($mail->Send()){
		echo "success";
	}
	else{
		echo "failure";
	}*/


}

/**
* sendUsernameEmail
*
* Function to send a username info email to a user including a link to a
* the login page.
*
* @param string $type : Type of the user to email
* @param int $authId : The id to retrieve information with
*
* @return string : 'success' if the confirmation email was sent successfully
*				   'failure' if the confirmation email was not sent successfully
*
*/
function send_username_email($type, $authId){

	$conn = getConnection();
	// Get the coachId or diverId of the auth row
	$query = sprintf("SELECT * FROM %s WHERE authId=%s",
		AUTH_TABLE,
		$authId);

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error fetching auth information";
		throw new Exception($message);
	}

	$row = mysql_fetch_assoc($result);

	if($row != null || $row != ''){

		// Get the diver info from the diver row
		$query = sprintf("SELECT * FROM %s WHERE diverId=%s",
			DIVERS_TABLE,
			$row['diverId']);
		$result = mysql_query($query, $conn);
		$row = mysql_fetch_assoc($result);

		$fname = $row['fname'];
		$lname = $row['lname'];
		$email = $row['email'];

		// Get coach or diver id based on type
		$diverId = $coachId = -1;
		if($type == 'coach')
			$coachId = $row['coachId'];
		else if($type == 'diver')
			$diverId = $row['diverId'];

		$subject = "Dive Trainer - Login Info";
		$body = "<p>Dear $fname $lname,</p>
				<br /><p>Your Dive Trainer account has been activated!\n\n
				Your username for logging in is: " . ($type == 'coach' ? "c$coachId" : "d$diverId") . "\n
				You can now log in to start using the application!\n
				<a href='http://new.upstatediving.com/DiveTrainer/index.php'>
				http://new.upstatediving.com/DiveTrainer/index.php</a>
				</p><br /><br />
				<p>Sincerely,</p>
				<p>Upstate Diving</p>";
		$altBody = "Dear $fname $lname,\n
				Your Dive Trainer account has been activated!\n\n
				Your username for logging in is: " . ($type == 'coach' ? "c$coachId" : "d$diverId") . "\n
				You can now log in to start using the application!\n
				http://new.upstatediving.com/DiveTrainer/index.php\n\n\n
				Sincerely,\n
				Upstate Diving";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		//$headers .= 'To: $fname $lname <$email>' . "\r\n";
		$headers .= 'From: Upstate Diving <upstatediving@gmail.com>' . "\r\n";

		if(mail($email, $subject, $body, $headers)){
			echo "success";
		} else {
			echo "failure";
		}
	}
}

/**
* activate_account
*
* Set a user account to active.
* If the user doesn't exist, or the account is already active,
* return a friendly error.
*
* @param int $authId : auth row id
* @param string $GUID : unique identifier for user verification
*/
function activate_account($authId, $GUID){

	$conn = getConnection();

	// Check for existing, activated accounts, or none
	$query = sprintf("SELECT * FROM %s WHERE authId=%s AND GUID='%s'",
		AUTH_TABLE,
		mysql_real_escape_string($authId),
		$GUID);

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error checking existing accounts:$type, userId:$userId, guid:$GUID";
		throw new Exception($message);
	}

	$row = mysql_fetch_assoc($result);
	// If there is no result, return an error
	if($row == null || $row == '')
		return 'none';
	// If the user is already set to active, return an error
	else if($row['active'] == '1')
		return 'already';

	// If all is clear, update the user to active
	$query = sprintf("UPDATE %s SET active='1' WHERE authId=%s AND GUID='%s'",
		AUTH_TABLE,
		mysql_real_escape_string($authId),
		$GUID);

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error activating account authId:$authId, guid:$GUID";
		throw new Exception($message);
	}

	// Return success if 1 row was changed
	return mysql_affected_rows($conn) == 1 ? 'success' : 'failure';
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
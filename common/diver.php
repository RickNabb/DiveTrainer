<?php
/**
* diver.php
*
* Object representation of a diver entity.
* Contains methods to create, retrieve, update, and destroy
* from the divers table.
* Contains backend HTTP methods to get/put for ajax interactions
*
* (C) Michael Pruitt 2014
*/

//TODO: update mysql functions (deprecated)

///////////////////////////////////////////////////////////////////////////////
// Includes & requires
///////////////////////////////////////////////////////////////////////////////

require("bootstrap.php");

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$result = '';
	session_start();
	
	/**
	* Create diver method
	**/
	if($_POST['method'] == 'create_diver' && isset($_POST['fname']) && 
		isset($_POST['lname']) && isset($_POST['coachId'])) {
		
		$value = create_diver($_POST['fname'], $_POST['lname'], $_POST['coachId']);
		
		// If the insertion failed record error message in result
		if ($value == '0') {
			$result = 'Registration failed, ensure all fields have proper values and coach ID is correct';
		}
		else {
			$result = '';
		}
	}
	/**
	* Diver exists method
	**/
	else if($_POST['method'] == 'log_in' && isset($_POST['diverId'])) {
		
		$value = diver_exists($_POST['diverId']);
		
		// If the diver does not exist, store failure message in result
		if ($value == '0') {
			$result = 'Login failed: invalid ID/password combination.';
		}
		else {
			$result = ''; 
			// Save id as current user
			$_SESSION['dive_trainer']['userId'] = $_POST['diverId'];
		}
	}
	/**
	* Load information method
	**/
	else if($_POST['method'] == 'load_info') {
		
		$value = diver_exists($_SESSION['dive_trainer']['userId']);
		
		// If the diver does not exist, store failure message in result
		if ($value == '0') {
			$result = 'Error: diver not found';
		}
		else {
			load_info();
			$result = '';
		}
	}
	else {
		$result = 'Invalid function call';
	}
	
	// Print out result
	echo $result;
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* create_diver
*
* Function to create a diver and insert into the database
* @param string $fname : First name of the diver
* @param Date $lname : Last name of the diver
* @param int $coachId : ID of this diver's coach
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_diver($fname, $lname, $coachId){
	$conn = getConnection();
	
	// Check if coach exists
	$query = sprintf('SELECT COUNT(*) FROM %s WHERE coachId = %s',
		mysql_real_escape_string(COACHES_TABLE),
		mysql_real_escape_string($coachId));
		
	$result = mysql_query($query, $conn);
	
	// If no coach exists, return 0
	if (mysql_fetch_row($result)[0] == '0') {
		return 0;
	}
	else {
		// Attempt to add diver
		$query = sprintf('INSERT INTO %s (fname, lname, coachId)
			VALUES ("%s", "%s", "%s")',
			mysql_real_escape_string(DIVERS_TABLE),
			mysql_real_escape_string($fname),
			mysql_real_escape_string($lname),
			mysql_real_escape_string($coachId));

		$result = mysql_query($query, $conn);
		
		// Insertion failed
		if(!$result){
			$message = "Error inserting practice into database";
			throw new Exception($message);
		}

		return mysql_affected_rows($conn);
	}
}

/**
* diver_exists
*
* Function to check if a diver exists
* @param int $diverId : ID of this diver
*
* @return int n : Whether or not the diver with the given ID exists
* 	n = 1 -> Diver found
*	n = 0 -> Diver does not exist
**/
function diver_exists($diverId) {
	if ($diverId == NULL || $diverId == '') {
		return 0;
	}
		
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT COUNT(*) FROM %s WHERE diverId = %s',
		mysql_real_escape_string(DIVERS_TABLE),
		mysql_real_escape_string($diverId));
		
	$result = mysql_query($query, $conn);
	
	// If no diver exists, return 0
	if (mysql_fetch_row($result)[0] == '0') {
		return 0;
	}
	return 1;
}

/**
* load_info
*
* Function to load diver information into the Server variables
*
* Note: SERVER['userId'] must be set
**/
function load_info() {
	if ($_SESSION['dive_trainer']['userId'] == NULL || $_SESSION['dive_trainer']['userId'] == '') {
		return;
	}
		
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT fname, lname, coachId FROM %s WHERE diverId = %s',
		mysql_real_escape_string(DIVERS_TABLE),
		mysql_real_escape_string($_SESSION['dive_trainer']['userId']));
		
	$result = mysql_fetch_array(mysql_query($query, $conn));
	
	$_SESSION['dive_trainer']['fname'] = $result['fname'];
	$_SESSION['dive_trainer']['lname'] = $result['lname'];
	$_SESSION['dive_trainer']['coachId'] = $result['coachId'];
}
?>
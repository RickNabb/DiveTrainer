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

require_once('bootstrap.php');
require_once('practice.php');

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
		isset($_POST['lname']) && isset($_POST['coachId']) && isset($_POST['email'])) {
		
		$value = create_diver($_POST['coachId'], $_POST['fname'], $_POST['lname'], $_POST['email']);
		
		// If the insertion failed echo empty message for error
		if ($value == '') {
			$result = '';
		}
		else {
			$result = $value;
		}
	}
	/**
	* Diver exists method
	**/
	else if($_POST['method'] == 'log_in' && isset($_POST['diverId'])) {
		
		// TODO: Create auth table so logging in has no dependence on diver
		// Instead, the method will query the auth table, and the auth table
		// is linked to diver by diver_id

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
	
	
	// Print out result
	echo $result;
}
else if($_SERVER['REQUEST_METHOD'] == "GET"){

	$method = '';
	if(isset($_GET['method'])){
		$method = $_GET['method'];
	}

	if($method == 'get_all_divers') {
		$result = get_all_divers();
		echo json_encode($result);
	}
	else if($method == 'get_divers_by_name'){
		$name = $_GET['name'];
		$result = get_divers_by_name($name);

		echo json_encode($result);
	}
	else if($method == 'get_diver') {

		$id = $_GET['diverId'];
		$result = get_diver($id);

		echo json_encode($result);
	}
	else if($method == 'get_divers_by_level') {

		$level = $_GET['level'];
		$result = get_divers_by_level($level);

		echo json_encode($result);
	}
	else if($method == 'get_diver_practices') {
		if (isset($_GET['diverId'])) {
			$id = $_GET['diverId'];
			echo json_encode(get_diver_practices($id));
		}
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* create_diver
*
* Function to create a diver and insert into the database
* @param int $coachId : ID of this diver's coach
* @param string $fname : First name of the diver
* @param Date $lname : Last name of the diver
* @param string $email : Email address of the diver
*
* @return int id : id associated with the newly entered row
**/
function create_diver($coachId, $fname, $lname, $email){
	$conn = getConnection();
	
	// Check if coach exists
	$query = sprintf('SELECT * FROM %s WHERE coachId = %s',
		mysql_real_escape_string(COACHES_TABLE),
		mysql_real_escape_string($coachId));
		
	$result = mysql_query($query, $conn);
	if(!$result){
		$errMsg = "Error creating new diver: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}

	// If no coach exists, return 0
	if (mysql_fetch_assoc($result) == '') {
		return 0;
	}
	else {
		// Attempt to add diver
		$query = sprintf('INSERT INTO %s (fname, lname, coachId, email)
			VALUES ("%s", "%s", "%s", "%s")',
			mysql_real_escape_string(DIVERS_TABLE),
			mysql_real_escape_string($fname),
			mysql_real_escape_string($lname),
			mysql_real_escape_string($coachId),
			mysql_real_escape_string($email));

		$result = mysql_query($query, $conn);
		
		// Insertion failed
		if(!$result){
			$message = "Error inserting practice into database";
			throw new Exception($message);
		}

		return mysql_insert_id($conn);
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

/**
* get_diver
*
* Function to get a diver from the database
* @param int $diverId : ID of the diver
*
* @return result - the diver object
**/
function get_diver($diverId) {		
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT * FROM %s WHERE diverId = %s',
		DIVERS_TABLE,
		mysql_real_escape_string($diverId));
		
	$result = mysql_query($query, $conn);

	$row = mysql_fetch_assoc($result);
	if(!$result){
		$message = "Error getting diver";
		throw new Exception($message);
	}
	
	return $row;
}

/**
* get_all_divers
*
* Function to retrieve all diver information from the database
*
* @return array rows : An array of associative arrays containing relations
* 					   of database columns to array entries.
**/
function get_all_divers(){

	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s",
		DIVERS_TABLE);

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error getting divers";
		throw new Exception($message);
	}

	$rows = array();
	while($row = mysql_fetch_assoc($result)){
		$rows[] = $row;
	}

	return $rows;
}

function get_divers_by_name($name){

	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE fname LIKE '%s' OR lname LIKE '%s'",
		DIVERS_TABLE,
		mysql_real_escape_string($name),
		mysql_real_escape_string($name));

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error getting divers";
		throw new Exception($message);
	}

	$rows = array();
	while($row = mysql_fetch_assoc($result)){
		$rows[] = $row;
	}

	return $rows;
}

function get_divers_by_level($level){

	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE level=%s",
		DIVERS_TABLE,
		mysql_real_escape_string($level));

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error getting divers";
		throw new Exception($message);
	}

	$rows = array();
	while($row = mysql_fetch_assoc($result)){
		$rows[] = $row;
	}

	return $rows;
}

/**
* get_diver_practices
*
* Function to get a diver's list of practices
* @param int $diverId : ID of the diver
*
* @return practices - the list of practice objects
**/
function get_diver_practices($diverId) {		
	$conn = getConnection();
	
	// Check if diver exists
	$query = sprintf('SELECT * FROM %s WHERE diverId = "%s"',
		DIVER_TO_PRACTICE_TABLE,
		mysql_real_escape_string($diverId));
		
	$result = mysql_query($query, $conn);

	if(!$result){
		$message = "Error getting diver";
		throw new Exception($message);
	}
	
	$practices = array();
	while ($row = mysql_fetch_assoc($result)) {
		$practices[] = get_practice($row['practiceId']);
	}
	
	return $practices;
}

?>
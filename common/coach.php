<?php
/**
* coach.php
*
* Object representation of a coach entity.
* Contains methods to create, retrieve, update, and destroy
* from the coachs table.
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
	
	/**
	* Create coach method
	**/
	if($_POST['method'] == 'create_coach' && isset($_POST['coach'])) {
		$result = create_coach($_POST['coach']);
		
		// Print out result
		echo $result;
	}
}
else if($_SERVER['REQUEST_METHOD'] == 'GET') {
	/**
	* Load information method
	**/
	if($_GET['method'] == 'get_coach' && isset($_GET['coachId'])) {
		$result = get_coach($_GET['coachId']);
				
		// Print out result
		echo json_encode($result);
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* create_coach
*
* Function to create a coach and insert into the database
* @param array $coach : A coach object with the following fields
*			int coachId : ID number
* 			string fname : First name
* 			string lname : Last name
* 			string level : Coach skill level
* 			string address1 : Address line 1
* 			string address2 : Address line 2
* 			string zip : Zip-code
* 			string phone : Phone number
* 			string email : Email address
* 			Date dob : Date of birth
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_coach($coach){
	$conn = getConnection();
	
	// Attempt to add coach
	$query = sprintf('INSERT INTO %s (fname, lname, level, address1, address2, zip, phone, email, dob)
		VALUES ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s")',
		mysql_real_escape_string(COACHS_TABLE),
		mysql_real_escape_string($coach['fname']),
		mysql_real_escape_string($coach['lname']),
		mysql_real_escape_string($coach['level']),
		mysql_real_escape_string($coach['address1']),
		mysql_real_escape_string($coach['address2']),
		mysql_real_escape_string($coach['zip']),
		mysql_real_escape_string($coach['phone']),
		mysql_real_escape_string($coach['email']),
		mysql_real_escape_string($coach['dob']));

	$result = mysql_query($query, $conn);
	
	// Insertion failed
	if(!$result){
		$message = "Error inserting practice into database";
		throw new Exception($message);
	}

	return mysql_affected_rows($conn);
}

/**
* get_coach
*
* Function to get an exercise from the database
* @param int $coachId : ID of the coach
*
* @return coach - the coach object
**/
function get_coach($coachId) {
	$conn = getConnection();
	
	// Get exercise info
	$query = sprintf('SELECT * FROM %s WHERE coachId = %s',
		mysql_real_escape_string(COACHES_TABLE),
		mysql_real_escape_string($coachId));
		
	$coach = mysql_query($query,$conn);
	
	if(!$coach){
		$message = "Error retrieving exercise";
		throw new Exception($message);
	}

	return mysql_fetch_assoc($coach);
}
?>
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

///////////////////////////////////////////////////////////////////////////////
// Includes & requires
///////////////////////////////////////////////////////////////////////////////

include("include.php");

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	// Check that all variables have values
	if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['coachId'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$coachId = $_POST['coachId'];

		$result = create_diver($fname, $lname, $coachId);

		//TODO: redirect better
		echo $result;
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* create_diver
*
* Function to create a practice and insert into the database
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

?>
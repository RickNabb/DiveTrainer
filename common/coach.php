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

	if(isset($_POST['method'])){

		$method = $_POST['method'];
		
		/**
		* Create coach method
		**/
		if($method == 'create_coach') {

			$coachId = $_POST['coachId'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$level = $_POST['level'];

			$result = create_coach($coachId, $fname, $lname, $email, $level);
			
			// Print out result
			echo $result;
		}
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
* @param int $coachId : ID to assign to this coach
* @param string $fname : First name of the coach
* @param string $lname : Last name of the coach
* @param string $email : Email address of the coach
* @param int $level : The level that the coach teaches
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_coach($coachId, $fname, $lname, $email, $level){
	$conn = getConnection();
	
	// Attempt to add coach
	$query = sprintf('INSERT INTO %s (coachId, fname, lname, level, email)
		VALUES ("%s", "%s", "%s", "%s", "%s")',
		mysql_real_escape_string(COACHES_TABLE),
		mysql_real_escape_string($coachId),
		mysql_real_escape_string($fname),
		mysql_real_escape_string($lname),
		mysql_real_escape_string($level),
		mysql_real_escape_string($email));

	$result = mysql_query($query, $conn);
	
	// Insertion failed
	if(!$result){
		$message = "Error inserting coach into database";
		throw new Exception($message);
	}

	return mysql_affected_rows($conn);
}

/**
* get_coach
*
* Function to get a coach from the database
* @param int $coachId : ID of the coach
*
* @return row - the mysql row
**/
function get_coach($coachId) {

	$conn = getConnection();
	
	// Get exercise info
	$query = sprintf('SELECT * FROM %s WHERE coachId = %s',
		COACHES_TABLE,
		mysql_real_escape_string($coachId));
		
	$result = mysql_query($query, $conn);
	
	if(!$result){
		$message = "Error retrieving coach";
		throw new Exception($message);
	}

	$row = mysql_fetch_assoc($result);

	return $row;
}
?>
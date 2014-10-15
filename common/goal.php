<?php
/**
* goal.php
*
* Object representation of a goal entity.
* Contains methods to create, retrieve, update, and destroy
* from the goals table.
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
	* Create goal method
	**/
	if($_POST['method'] == 'create_goal' && isset($_POST['diverId']) && 
		isset($_POST['name']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
		
		$value = create_goal($_POST['diverId'], $_POST['name'], $_POST['startDate'], $_POST['endDate']);
		
		// If the insertion failed record error message in result
		if ($value == '0') {
			$result = 'Creation failed, ensure all fields have proper values.';
		}
		else {
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
* create_goal
*
* Function to create a goal and insert into the database
* @param string $diverId : The diver that made the goal
* @param Date $name : Name for the goal
* @param int $startDate : The date the goal was set (format: m/d/Y)
* @param int $endDate : The end date for the goal (format: m/d/Y)
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_goal($diverId, $name, $startDate_str, $endDate_str){
	$conn = getConnection();

	$startDate = new DateTime();
	$endDate = new DateTime();

	$startDateNums = split('[/.-]', $startDate_str);
	$endDateNums = split('[/.-]', $endDate_str);

	// setDate(year, month, day)
	$startDate->setDate(intval($startDateNums[2]), intval($startDateNums[0]), intval($startDateNums[1]));
	$endDate->setDate(intval($endDateNums[2]), intval($endDateNums[0]), intval($endDateNums[1]));
	
	// Attempt to add goal
	$query = sprintf('INSERT INTO %s (diverId, name, startDate, endDate)
		VALUES ("%s", "%s", "%s", "%s")',
		mysql_real_escape_string(GOALS_TABLE),
		mysql_real_escape_string($diverId),
		mysql_real_escape_string($name),
		mysql_real_escape_string($startDate->format('Y:m:d H:i:s')),
		mysql_real_escape_string($endDate->format('Y:m:d H:i:s')));

	$result = mysql_query($query, $conn);
	
	// Insertion failed
	if(!$result){
		$message = "Error inserting practice into database";
		throw new Exception($message);
	}

	return mysql_affected_rows($conn);
}
?>
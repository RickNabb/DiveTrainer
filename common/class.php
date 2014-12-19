<?php
/**
* class.php
*
* Object representation of a class entity.
* Contains methods for class retrieval
* Contains backend HTTP methods to get/put for ajax interactions
*
* (C) Nick Rabb & Michael Pruitt 2014
*/

//TODO: update mysql functions (deprecated)

///////////////////////////////////////////////////////////////////////////////
// Includes & requires
///////////////////////////////////////////////////////////////////////////////

require_once('bootstrap.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == "GET"){

	$method = '';
	if(isset($_GET['method'])){
		$method = $_GET['method'];
	}

	if($method == 'get_classes') {
		$result = get_classes();
		
		echo json_encode($result);
	}
	else if($method == 'get_class_by_level'){
		$level = $_GET['level'];
		$result = get_class_by_level($level);

		echo json_encode($result);
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* get_classes
*
* This method retrieves every class entry in the database
* 
* @return array() $rows - array of associative arrays of mysql entry rows
**/
function get_classes(){

	// Get a mySQL connection
	$conn = getConnection();

	$query = sprintf("SELECT * FROM %s",
		CLASSES_TABLE);
	$result = mysql_query($query, $conn);

	// If the query fails
	if(!$result){
		$message = "Error retrieving classes";
		throw new Exception($message);
	}

	// Aggregate all rows fetched
	$rows = array();
	while($row = mysql_fetch_assoc($result)){
		$rows[] = $row;
	}

	return $rows;
}

/**
* get_class_by_level
*
* This method gets an entry from the class table based on
* the $level parameter
*
* @return array() $row - the mysql row with level = $level
**/
function get_class_by_level($level){

	// Get a mySQL connection
	$conn = getConnection();

	$query = sprintf("SELECT * FROM %s WHERE level=%s",
		CLASSES_TABLE,
		mysql_real_escape_string($level));
	$result = mysql_query($query, $conn);

	// If the query fails
	if(!$result){
		$message = "Error retrieving class by level";
		throw new Exception($message);
	}

	$row = mysql_fetch_assoc($result);

	return $row;
}

?>
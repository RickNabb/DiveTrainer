<?php
/**
* Practice.php
*
* Object representation of a practice entity.
* Contains methods to create, retrieve, update, and destroy
* from the practices table.
* Contains backend HTTP methods to get/put for ajax interactions
*
* (C) Nick Rabb 2014
*/

// Includes & requires

require_once('bootstrap.php');

// HTTP METHODS

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	// Get the deisred method from the HTTP call
	$method = $_PUT['method'];

	if($method == 'create_practice'){

		$coachId = $_PUT['coachId'];
		$title = $_PUT['title'];
		$date = $_PUT['date'];

		$result = create_practice($coachId, $title, $date);

		echo $result;
	}
}

// DATA METHODS

/**
* create_practice
*
* Function to create a practice and insert into the database
* @param int $coachId : ID of owning coach
* @param string $title : Title of the practice
* @param Date $date : Date object representing when the practice happens
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_practice($coachId, $title, $date){

	$conn = getConnection();
	$query = sprintf('INSERT INTO %s (coachId, title, "date")
		VALUES ("%s", "%s", "%s")',
		mysql_real_escape_string($coachId),
		mysql_real_escape_string($title),
		mysql_real_escape_string($date));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error inserting practice into database";
		throw new Exception($message);
	}

	return mysql_affected_rows($conn);
}

?>
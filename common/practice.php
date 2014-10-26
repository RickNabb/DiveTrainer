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

///////////////////////////////////////////////////////////////////////////////
// Includes & requires
///////////////////////////////////////////////////////////////////////////////

require_once('bootstrap.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	// Get the deisred method from the HTTP call
	$method = '';
	if (isset($_PUT['method'])) {
		$method = $_PUT['method'];
	}
	else if (isset($_POST['method'])) {
		$method = $_POST['method'];
	}
	else if (isset($_GET['method'])) {
		$method = $_GET['method'];
	}

	/**
	* Create practice method
	**/
	if($method == 'create_practice'){

		$coachId = $_PUT['coachId'];
		$title = $_PUT['title'];
		$date = $_PUT['date'];

		$result = create_practice($coachId, $title, $date);

		echo $result;
	}
	/**
	* Get practice list method
	**/
	if($method == 'get_practice_list') {
		$result = '';
		session_start();
		if ($_SESSION['dive_trainer']['userType'] == 'coach') {
			$result = get_coach_practices($_SESSION['dive_trainer']['userId']);
		}
		
		echo json_encode($result);
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

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

	// TODO: save exercises
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

/**
* get_practice_list
*
* Function to create a practice and insert into the database
* @param int $coachId : ID of owning coach
*
* @return practiceArray - an array of practice rows
**/
function get_coach_practices($coachId){

	$conn = getConnection();
	$query = sprintf('SELECT practiceId, title, date FROM %s WHERE coachId = %s',
		mysql_real_escape_string(PRACTICES_TABLE),
		mysql_real_escape_string($coachId));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error retrieving practices";
		throw new Exception($message);
	}
	
	$rows = array();
	while(($row =  mysql_fetch_assoc($result))) {
		$rows[] = $row;
	}

	return $rows;
}
?>
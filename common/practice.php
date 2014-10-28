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
require_once('exercise.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

$method = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	// Get the deisred method from the HTTP call
	if (isset($_POST['method'])) {
		$method = $_POST['method'];
	}

	/**
	* Create practice method
	**/
	if($method == 'create_practice'){
		$result = 0;
		
		if (isset($_POST['coachId']) && isset($_POST['title']) && isset($_POST['date'])) {
			$exercises = array();
			if (isset($_POST['exercises'])) {
				$exercises = $_POST['exercises'];
			}
			$result = create_practice($_POST['coachId'], $_POST['title'], $_POST['date'], $exercises);
		}

		echo $result;
	}
	/**
	* Update practice method
	**/
	else if($method == 'update_practice'){
		$result = 0;
		
		if (isset($_POST['practiceId']) && isset($_POST['coachId']) && isset($_POST['title']) && isset($_POST['date'])) {
			$exercises = array();
			if (isset($_POST['exercises'])) {
				$exercises = $_POST['exercises'];
			}
			$result = update_practice($_POST['practiceId'], $_POST['coachId'], $_POST['title'], $_POST['date'], $exercises);
		}

		echo $result;
	}
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	// Get the deisred method from the HTTP call
	if (isset($_GET['method'])) {
		$method = $_GET['method'];
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
		//TODO: get diver practices
		else if ($_SESSION['dive_trainer']['userType'] == 'diver') {
			$result = "";
		}
		
		echo json_encode($result);
	}
	/**
	* Get practice method
	**/
	else if($method == 'get_practice') {
		$result = '';
		if (isset($_GET['practiceId'])) {
			$result = get_practice($_GET['practiceId']);
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
* @param array $exercises : array of ids of the exercises in this practice
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_practice($coachId, $title, $date, $exercises) {

	$conn = getConnection();
	$query = sprintf('INSERT INTO %s (coachId, title, date)
		VALUES ("%s", "%s", "%s")',
		mysql_real_escape_string(PRACTICES_TABLE),
		mysql_real_escape_string($coachId),
		mysql_real_escape_string($title),
		mysql_real_escape_string($date));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error inserting practice into database";
		throw new Exception($message);
	}
	
	// Save exercises
	$practiceId = mysql_insert_id();
	foreach ($exercises as $exercise) {
		$query = sprintf('INSERT INTO %s (exerciseId, practiceId)
			VALUES ("%s", "%s")',
			mysql_real_escape_string(EXERCISE_TO_PRACTICE_TABLE),
			mysql_real_escape_string($exercise),
			mysql_real_escape_string($practiceId));
			
		$result = mysql_query($query,$conn);
		if(!$result){
			$message = "Error inserting exercise into database";
			throw new Exception($message);
		}
	}

	return mysql_affected_rows($conn);
}

/**
* update_practice
*
* Function to update an existing practice in the database
* @param int $practiceId : ID of the practice
* @param int $coachId : ID of owning coach
* @param string $title : Title of the practice
* @param Date $date : Date object representing when the practice happens
* @param array $exercises : array of ids of the exercises in this practice
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function update_practice($practiceId, $coachId, $title, $date, $exercises) {

	// Save practice fields
	$conn = getConnection();
	$query = sprintf('UPDATE %s SET coachId=%s, title="%s", date="%s" WHERE practiceId=%s',
		mysql_real_escape_string(PRACTICES_TABLE),
		mysql_real_escape_string($coachId),
		mysql_real_escape_string($title),
		mysql_real_escape_string($date),
		mysql_real_escape_string($practiceId));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error inserting practice into database";
		throw new Exception($message);
	}
	
	// Remove old exercises
	$query = sprintf('DELETE FROM %s WHERE practiceId = %s',
		mysql_real_escape_string(EXERCISE_TO_PRACTICE_TABLE),
		mysql_real_escape_string($practiceId));
	
	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error removing practice-exercises into database";
		throw new Exception($message);
	}
	
	// Save exercises
	foreach ($exercises as $exercise) {
		$query = sprintf('INSERT INTO %s (exerciseId, practiceId)
			VALUES ("%s", "%s")',
			mysql_real_escape_string(EXERCISE_TO_PRACTICE_TABLE),
			mysql_real_escape_string($exercise),
			mysql_real_escape_string($practiceId));
			
		$result = mysql_query($query,$conn);
		if(!$result){
			$message = "Error inserting practice-exercise into database";
			throw new Exception($message);
		}
	}

	return mysql_affected_rows($conn);
}

/**
* get_practice_list
*
* Function to get a list of practices based on the coach
* @param int $coachId : ID of owning coach
*
* @return practiceArray - an array of practice rows
**/
function get_coach_practices($coachId) {

	$conn = getConnection();
	$query = sprintf('SELECT practiceId, title, date FROM %s WHERE coachId = %s ORDER BY date ASC',
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

/**
* get_practice
*
* Function to get a practice from the database
* @param int $practiceId : ID of the practice
*
* @return practice - the practice and its exercises 
*						(i.e. {"practice":practice, "exercises":exercises} )
**/
function get_practice($practiceId) {
	$conn = getConnection();
	
	// Get practice info
	$query = sprintf('SELECT * FROM %s WHERE practiceId = %s',
		mysql_real_escape_string(PRACTICES_TABLE),
		mysql_real_escape_string($practiceId));

	$practice = mysql_query($query,$conn);
	if(!$practice){
		$message = "Error retrieving practice";
		throw new Exception($message);
	}
	
	// Get practice to exercise relations
	$query = sprintf('SELECT * FROM %s WHERE practiceId = %s',
		mysql_real_escape_string(EXERCISE_TO_PRACTICE_TABLE),
		mysql_real_escape_string($practiceId));

	$relation = mysql_query($query,$conn);
	
	// Get each exercise info
	$exercises = array();
	while(($row =  mysql_fetch_assoc($relation))) {
		$exercises[] = get_exercise($row['exerciseId']);
	}
	
	// Return a nonsequential with the practice row and exercises array
	$result = array('practice' => mysql_fetch_assoc($practice),
					'exercises' => $exercises);

	return $result;
}
?>
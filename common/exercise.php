<?php
/**
* exercise.php
*
* Object representation of a exercise entity.
* Contains methods to create, retrieve, update, and destroy
* from the exercises table.
* Contains backend HTTP methods to get/put for ajax interactions
*
* (C) Michael Pruitt 2014
*/

///////////////////////////////////////////////////////////////////////////////
// Includes & requires
///////////////////////////////////////////////////////////////////////////////

require_once('bootstrap.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

$method = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Get the deisred method from the HTTP call
	if (isset($_POST['method'])) {
		$method = $_POST['method'];
	}

	/**
	* Create exercise method
	**/
	if($method == 'create_exercise'){
		$result = 0;
		
		if (isset($_POST['name']) && isset($_POST['level']) && isset($_POST['type']) && isset($_POST['description'])) {
		
			$result = create_practice($_POST['name'], $_POST['level'], $_POST['type'], $_POST['description']);
		}

		echo $result;
	}
}
else if($_SERVER['REQUEST_METHOD'] == 'GET') {

	// Get the deisred method from the HTTP call
	if (isset($_GET['method'])) {
		$method = $_GET['method'];
	}
	
	/**
	* Get exercise method
	**/
	if($method == 'get_exercise') {
		$result = '';
		if (isset($_GET['exerciseId'])) {
			$result = get_exercise($_GET['exerciseId']);
		}
		
		echo json_encode($result);
	}
	/**
	* Get exercise list by type method
	**/
	else if($method == 'get_exercise_type') {
		$result = '';
		if (isset($_GET['type'])) {
			$result = get_exercise_type($_GET['type']);
		}
		
		echo json_encode($result);
	}

	else if($method == "get_skills"){
		$skill_types = array("trampoline", "dryboard", "platform", "deck-mat-bulkhead", "1m", "3m");
		$result = array();
		foreach($skill_types as $type){
			$temp = get_exercise_type($type);

			foreach($temp as $row){
				$result[] = $row;
			}
		}

		echo json_encode($result);
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATA METHODS
///////////////////////////////////////////////////////////////////////////////

/**
* create_exercise_with_id
*
* Function to create a exercise and insert into the database
* @param int $id : ID number of the exercise
* @param string $name : Name of the exercise
* @param string $diveNum : The dive number
* @param int $level : Skill level of the exercise
* @param string $type : Type of exercise (skill, warm-up, conditioning...)
* @param string $description : A description of the exercise
* @param string $videoURL : The location of the video for the skill
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_exercise_with_id($id, $name, $diveNum, $level, $type, $description, $videoURL) {
	$conn = getConnection();
	$query = sprintf('INSERT INTO %s (exerciseId, name, diveNum, level, type, description, videoURL)
		VALUES ("%s", "%s", "%s", "%s", "%s", "%s", "%s")',
		mysql_real_escape_string(EXERCISES_TABLE),
		mysql_real_escape_string($id),
		mysql_real_escape_string($name),
		mysql_real_escape_string($diveNum),
		mysql_real_escape_string($level),
		mysql_real_escape_string($type),
		mysql_real_escape_string($description),
		mysql_real_escape_string($videoURL));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error inserting exercise into database";
		throw new Exception($message);
	}
	
	$val = mysql_affected_rows($conn);
	mysql_close($conn);
	return $val;
}

/**
* create_exercise
*
* Function to create a exercise and insert into the database
* @param string $name : Name of the exercise
* @param string $diveNum : The dive number
* @param int $level : Skill level of the exercise
* @param string $type : Type of exercise (skill, warm-up, conditioning...)
* @param string $description : A description of the exercise
* @param string $videoURL : The location of the video for the skill
*
* @return int n : Number of affected rows in the sql query
* 	n >= 1 -> Insert worked, multiple rows affected
*	n = 0 -> Insert failed, no rows affected
**/
function create_exercise($name, $diveNum, $level, $type, $description, $videoURL) {
	$conn = getConnection();
	$query = sprintf('INSERT INTO %s (name, diveNum, level, type, description, videoURL)
		VALUES ("%s", "%s", "%s", "%s", "%s", "%s")',
		mysql_real_escape_string(EXERCISES_TABLE),
		mysql_real_escape_string($name),
		mysql_real_escape_string($diveNum),
		mysql_real_escape_string($level),
		mysql_real_escape_string($type),
		mysql_real_escape_string($description),
		mysql_real_escape_string($videoURL));

	$result = mysql_query($query,$conn);
	if(!$result){
		$message = "Error inserting exercise into database";
		throw new Exception($message);
	}
	
	$val = mysql_affected_rows($conn);
	mysql_close($conn);
	return $val;
}

/**
* get_exercise
*
* Function to get an exercise from the database
* @param int $exerciseId : ID of the exercise
*
* @return exercise - the exercise object
**/
function get_exercise($exerciseId) {
	$conn = getConnection();
	
	// Get exercise info
	$query = sprintf('SELECT * FROM %s WHERE exerciseId = %s',
		mysql_real_escape_string(EXERCISES_TABLE),
		mysql_real_escape_string($exerciseId));
		
	$exercise = mysql_query($query,$conn);
	
	if(!$exercise){
		$message = "Error retrieving exercise";
		throw new Exception($message);
	}

	return mysql_fetch_assoc($exercise);
}

/**
* get_exercise_type
*
* Function to get a list of exercises from the database based on type
* @param string $type : the type of exercise
*
* @return result - the list of exercises with the given type
**/
function get_exercise_type($type) {
	$conn = getConnection();
	
	// Get exercise info
	$query = sprintf("SELECT * FROM %s WHERE type = '%s'",
		mysql_real_escape_string(EXERCISES_TABLE),
		mysql_real_escape_string($type));
		
	$exercises = mysql_query($query,$conn);
	
	if(!$exercises){
		$message = "Error retrieving exercise";
		throw new Exception($message);
	}
	
	$result = array();
	
	while ($e = mysql_fetch_assoc($exercises)) {
		$result[] = $e;
	}
	
	return $result; //array('exercises' => $result, 'type' => $type);
}

?>
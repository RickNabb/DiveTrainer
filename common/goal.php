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
// REQUIRES AND INCLUDES
///////////////////////////////////////////////////////////////////////////////

require_once('bootstrap.php');
require_once('exercise.php');

///////////////////////////////////////////////////////////////////////////////
// HTTP METHODS
///////////////////////////////////////////////////////////////////////////////

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$result = '';
	session_start();
	
	// Get the deisred method from the HTTP call
	if (isset($_POST['method'])) {
		$method = $_POST['method'];
	}
	
	/**
	* Create goal method
	**/
	if($method == 'create_goal' && isset($_POST['diverId']) && 
		isset($_POST['title']) && isset($_POST['endDate'])) {

		$startDate = new DateTime();

		$goalId = create_goal($_POST['diverId'], $_POST['title'], date_format($startDate, 'm-d-Y'), $_POST['endDate']);
		
		// If the insertion failed record error message in result
		if ($goalId == '') {
			$result = 'Creation failed, ensure all fields have proper values.';
		}
		else {
			echo $goalId;
		}
	}
	else if($method == 'create_exercise_to_goal' && isset($_POST['goalId']) && isset($_POST['skill_ids'])
		&& isset($_POST['desired_ratings'])) {

		$result = create_exercise_to_goal($_POST['goalId'], $_POST['skill_ids'], $_POST['desired_ratings']);
		echo ($result == 1 ? 'success' : 'failure');
	}
	else {
		$result = 'Invalid function call';
	}
}

else if($_SERVER['REQUEST_METHOD'] == "GET"){

	// Get the deisred method from the HTTP call
	if (isset($_GET['method'])) {
		$method = $_GET['method'];
	}
	
	if($method == 'get_goals_for_diver'){
		$diverId = $_GET['diverId'];
		echo json_encode(get_goals_for_diver($diverId));
	}
	else if($method == 'get_goal'){
		$goalId = $_GET['goalId'];
		echo json_encode(get_goal($goalId));
	}
	else if($method == 'get_exercises_for_goal'){
		$goalId = $_GET['goalId'];
		$result = get_exercises_for_goal($goalId);
		$result[] = array('count' => $_GET['count']);
		echo json_encode($result);
	}
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
		$message = "Error inserting goal into database";
		throw new Exception($message);
	}

	return mysql_insert_id($conn);
}

function create_exercise_to_goal($goalId, $skill_ids, $desired_ratings){

	$conn = getConnection();

	for($i = 0; $i < sizeof($skill_ids); $i++){

		$query = sprintf("INSERT INTO %s (exerciseId, goalId, desiredRating, rating)
			VALUES ('%s', '%s', '%s', '%s')",
				EXERCISE_TO_GOAL_TABLE,
				mysql_real_escape_string($skill_ids[$i]),
				mysql_real_escape_string($goalId),
				mysql_real_escape_string($desired_ratings[$i]),
				'1');
		$result = mysql_query($query, $conn);

		if(!$result){
			$message = "Error inserting exercise to goal relation.";
			throw new Exception($message);
		}
	}

	return 1;
}

function get_goals_for_diver($diverId){

	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE diverId = '%s'",
		GOALS_TABLE,
		mysql_real_escape_string($diverId));

	$result = mysql_query($query, $conn);
	if(!$result){
		$message = "Error getting goals for diver.";
		throw new Exception($message);
	}

	$rows = array();

	while($row = mysql_fetch_assoc($result)){
		$rows[] = $row;
	}

	return $rows;
}

function get_goal($goalId){

	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE goalId = '%s'",
		GOALS_TABLE,
		mysql_real_escape_string($goalId));

	$result = mysql_query($query, $conn);
	
	if(!$result){
		$message = "Error getting goal.";
		throw new Exception($message);
	}
	
	$goal = mysql_fetch_assoc($result);
	$skills = get_exercises_for_goal($goalId);
	
	return array('goal' => $goal, 'skills' => $skills);
}

/**
* get_skills
*
* Function to get a skills related to a goal
* @param int goalId : the id of the related goal
*
* @return skills - the list of skills
**/
function get_exercises_for_goal($goalId) {

	$conn = getConnection();

	// Get practice to exercise relations
	$query = sprintf('SELECT * FROM %s as e1 JOIN %s as e2 on e1.exerciseId=e2.exerciseId WHERE e1.goalId = %s',
		EXERCISE_TO_GOAL_TABLE,
		EXERCISES_TABLE,
		mysql_real_escape_string($goalId));

	$result = mysql_query($query, $conn);

	if(!$result){
		$message = 'Error retrieving skills for goal id: ' . $goalId;
		throw new Exception($message);
	}
	
	// Get each exercise info
	$rows = array();
	while($row =  mysql_fetch_assoc($result)) {
		$rows[] = $row;
	}
	
	return $rows;
}

?>
<?php

// Entity tables
define('DIVERS_TABLE', 'divers');
define('COACHES_TABLE', 'coaches');
define('PRACTICES_TABLE', 'practices');
define('EXERCISES_TABLE', 'exercises');
define('GOALS_TABLE', 'goals');

// Relation tables
define('EXERCISE_TO_PRACTICE_TABLE', 'exercisetopractice');

function getConnection(){

	$link = @mysql_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD);
	if(!$link) {
		throw new Exception('Could not connect to mysql ' . mysql_error() . PHP_EOL . 
				'. Please check connection parameters in app/bootstrap.php');
	}
	if(!mysql_select_db(MYSQL_DB, $link)) {
		throw new Exception('Could not select database ' . mysql_error() . PHP_EOL . 
				'. Please check connection parameters in app/bootstrap.php');
	}
	
	//mysql_query($usersTableCreateQuery, $link);
	//mysql_query($ordersTableCreateQuery, $link);
	return $link;
}
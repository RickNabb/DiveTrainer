<?php

	require_once('bootstrap.php');

	$conn = getConnection();

	$fnames = array('Aaron', 'Apple', 'Abby', 'Alicia', 'Amy', 'Anthony', 'Amelia', 'Allie',
		'Bob');
	$lnames = array('Aardvark', 'Pie', 'Wambach', 'Keys', 'Poehler', 'Gabrielle', 'Badelia',
		'Smith', 'Johnson', 'Johns', 'Mans', 'Rabb', 'Bynoe', 'Alquhist', 'McMahon', 'MacDonald',
		'Meat', 'Mere', 'Mixalot');

	// Diver table population
	/*
	foreach($fnames as $fname){
		foreach($lnames as $lname){
		
			$query = sprintf("INSERT INTO %s (fname, lname, coachId) VALUES ('%s', '%s', '%s')",
				DIVERS_TABLE,
				mysql_real_escape_string($fname),
				mysql_real_escape_string($lname),
				'1000');

			$result = mysql_query($query, $conn);

			if(!$result){
				echo 'Error!';
				break;
			}
		}
	}*/

	// Skills table population

	/*$skill_titles = array('Jumprope', 'Armcircles', 'Pike jumps on Dryboard', 'Standing 1/2 twist Drills', 
		'Lunges');
	$levels = array('1', '2', '3');

	foreach ($skill_titles as $skill) {
		foreach($levels as $level){

			$query = sprintf("INSERT INTO %s (name, level, description)
				VALUES ('%s', '%s', '%s')",
				SKILLS_TABLE,
				$skill,
				$level,
				"This is the description for " . $skill . " at level " . $level);
			$result = mysql_query($query, $conn);
			if(!$result){
				echo 'ERROR!';
				break;
			}
		}
	}*/

?>
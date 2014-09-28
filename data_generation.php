<?php

	require_once('bootstrap.php');

	$conn = getConnection();

	$fnames = array('Aaron', 'Apple', 'Abby', 'Alicia', 'Amy', 'Anthony', 'Amelia', 'Allie',
		'Bob');
	$lnames = array('Aardvark', 'Pie', 'Wambach', 'Keys', 'Poehler', 'Gabrielle', 'Badelia',
		'Smith', 'Johnson', 'Johns', 'Mans', 'Rabb', 'Bynoe', 'Alquhist', 'McMahon', 'MacDonald',
		'Meat', 'Mere', 'Mixalot');

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
	}


?>
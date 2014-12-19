<html>
<head>
</head>
	<body>

	<?php

		require_once('bootstrap.php');

		$conn = getConnection();

		// Diver table population

		$fnames = array('Aaron', 'Apple', 'James', 'Calvin', 'Earl');
		$lnames = array('Aardvark', 'Pie', 'Smith', 'Johnson', 'Johns', 'Mans', 'Rabb', 'Bynoe', 'Alquhist', 'McMahon');
		$address1 = array('12 White Alder Elephant', '212 Loden Lane', '34 Tannon Drive South',
			'34 Gibson Lane');
		$address2 = array('Rochester', 'Henrietta');
		
		foreach($fnames as $fname){
			foreach($lnames as $lname){
			
				$query = sprintf("INSERT INTO %s (fname, lname, coachId, level, address1, address2, zip, phone, email, dob) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
					DIVERS_TABLE,
					mysql_real_escape_string($fname),
					mysql_real_escape_string($lname),
					'1000',
					rand(1, 5),
					$address1[rand(0, 3)],
					$address2[rand(0, 1)],
					'14623',
					'555-555-5555',
					'notareal@email.com',
					'' . rand(1990, 2004) . '-' . rand(1, 12) . '-' . rand(1, 31));

				$result = mysql_query($query, $conn);

				if(!$result){
					echo 'Error!';
					break;
				}
			}
		}

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
	<!-- <div id="ajax_loader" class="ajax-loader loader-lg center"></div> -->
</body>
</html>
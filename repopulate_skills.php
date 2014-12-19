<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php include("include.php");
			include("common/exercise.php");
			session_start();
			// TODO: if Cliff isn't id 1000 change this
			if(!isset($_SESSION['dive_trainer']['userId']) || !($_SESSION['dive_trainer']['userId'] == 1000 && $_SESSION['dive_trainer']['isAdmin'])){
				
				header('Location: auth_error.php');
			}
			// Correct user: repopulate skills
			else {
				$filename = 'SkillList.csv';
				if (file_exists($filename)) {
					$file = fopen($filename, 'r');
				
					// Get headers
					$line = trim(fgets($file));
					$headers = explode(',', $line);
					
					// Read in new columns
					$skills = array();
					
					$line = trim(fgets($file));
					while ($line) {
						$temp = explode(',', $line);
						$skill = array();
						
						if (count($temp) == count($headers)) {
							if ((int)$temp[0] != 0) {
								$skill['id'] = (int)$temp[0];
							}
							
							$skill['diveNum'] = $temp[1];
							$skill['name'] = $temp[2];
							$skill['type'] = strtolower($temp[3]);
							$skill['type'] = preg_replace('/\s+/', '', $skill['type']);
							$skill['description'] = $temp[4];
							
							// Get level from string
							$temp[5] = strtolower($temp[5]);
							if ($temp[5] == 'general') {
								$skill['level'] = 7;
							} else if ($temp[5] == 'ltd') {
								$skill['level'] = 1;
							} else if ($temp[5] == 'sparks') {
								$skill['level'] = 2;
							} else if ($temp[5] == 'fire') {
								$skill['level'] = 3;
							} else if ($temp[5] == 'blaze') {
								$skill['level'] = 4;
							} else if ($temp[5] == 'elite') {
								$skill['level'] = 5;
							} else if ($temp[5] == 'college') {
								$skill['level'] = 6;
							} else {
								$skill['level'] = 0;
							}
							
							$skill['videoURL'] = $temp[9];
							$skills[] = $skill;
						}
						$line = trim(fgets($file));
					}
					$skillCount = count($skills);
					
					// Drop all columns
					$conn = getConnection();
					$query = sprintf('TRUNCATE TABLE %s ',
						mysql_real_escape_string(EXERCISES_TABLE));

					$result = mysql_query($query,$conn);
					if(!$result){
						$message = "Error inserting exercise into database";
						throw new Exception($message);
					}
					
					// Save new columns to db
					foreach ($skills as $skill) {
						if (isset($skill['id'])){
							create_exercise_with_id($skill['id'], $skill['name'], $skill['diveNum'], $skill['level'], $skill['type'], $skill['description'], $skill['videoURL']);
						} else {
							create_exercise($skill['name'], $skill['diveNum'], $skill['level'], $skill['type'], $skill['description'], $skill['videoURL']);
						}
					}
					
				}
				// Error getting file
				else {
					echo 'Error reading file. Ensure it is named "SkillList.csv".';
				}
			}
		?>
	</head>
	<body>
	<div class="container-fluid">
		<div class="row row-lg blue">
			<div class="col-sm-offset-1 col-xs-offset-1 col-md-offset-1 col-lg-offset-1">
				<h1 class="white ptsans">Dive Trainer</h1>
			</div>
		</div>
		<h2>
			<?php echo $skillCount ?> skills added.
		</h2>
	</div>
	</body>
</html>
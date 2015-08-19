<html>
<head>
<title>New Problem</title>
</head>
<body style="font-family:'Lucida Console', Monaco, monospace;">

<h1><em>project555</em></h1>

<h3>Processing request...</h3>

<?php

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$layout_str = $_POST["value"];
$objective_sum = $_POST["rows"];

foreach ($layout_str as $nshknxz) 
{
	$layout[] = array_map('intval', $nshknxz);
}

sleep(2);

//echo "<pre>";
//print_r($layout);
//echo "</pre>";
//echo "<br /><br />";

require_once __DIR__.'/../solver.php';


/////////////////////////////////////////    ///


$hostname = "127.0.0.1";
$username = "root";
$password = "root";

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=numberwang", $username, $password);
 //   echo "<br />Connected to database\n";
}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}


function upload1($dbh, $no_of_rows, $no_of_sides, $objective_sum, $layout)
{
	$encoded = json_encode($layout);
	$query = "INSERT INTO problems (rows, sides, sum, start_layout) VALUES (:no_of_rows, :no_of_sides, :objective_sum, :encoded)";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':no_of_rows', $no_of_rows); 
	$stmt->bindParam(':no_of_sides', $no_of_sides); 
	$stmt->bindParam(':objective_sum', $objective_sum); 
	$stmt->bindParam(':encoded', $encoded); 
	$stmt->execute();
}

function upload2($dbh, $solutions, $no_of_rows, $no_of_sides, $problem_id)
{
		foreach ($solutions as $solution)
	{
		$x = 0;
		$y = 0;
	
		while ($y < $no_of_rows)
		{
			while ($x < $no_of_sides)
			{
				$transpose[$y][$x] = $solution[$x][$y];
				$x++;
			}
			$x = 0;
			$y++;
		}
		$solution_encoded = json_encode($transpose);
		$query = "INSERT INTO solutions (problem_id, solution) VALUES (:problem_id, :solution_encoded)";
		$stmt = $dbh->prepare($query);
		$stmt->bindParam(':problem_id', $problem_id); 
		$stmt->bindParam(':solution_encoded', $solution_encoded); 
		$stmt->execute();
	}
}


function find_id($dbh, $no_of_rows, $no_of_sides, $objective_sum)
{
	$query = "SELECT problem_id FROM problems WHERE rows = :no_of_rows AND sides = :no_of_sides AND sum = :objective_sum";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':no_of_rows', $no_of_rows); 
	$stmt->bindParam(':no_of_sides', $no_of_sides); 
	$stmt->bindParam(':objective_sum', $objective_sum); 
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);

	if ($result[0] == NULL)
	{
		return (bool)false;
	}

	return $result[0];
}




$problem_id = find_id($dbh, $no_of_rows, $no_of_sides, $objective_sum);

if ($problem_id != NULL)
{	
	echo "<br /><br />\nThis puzzle already exists in our database :) it's ID is $problem_id";
	echo "<br /><br /><a href=\"/project555/index.php/home\">HOME</a> <a href=\"/project555/index.php/problem/$problem_id\">Problem ID $problem_id</a>";
}
elseif ($solutions != NULL)
{
	upload1($dbh, $no_of_rows, $no_of_sides, $objective_sum, $layout);
	echo "<br />Inserted problem information\n<br />";
	$problem_id = find_id($dbh, $no_of_rows, $no_of_sides, $objective_sum);
	upload2($dbh, $solutions, $no_of_rows, $no_of_sides, $problem_id);
	echo "Uploaded solution(s)\n<br />";
	echo "\n<br />";
	echo "It has been assigned the ID $problem_id\n";

	echo "<br /><br /><a href=\"/project555/index.php/home\">HOME</a> <a href=\"/project555/index.php/problem/$problem_id\">Problem ID $problem_id</a>";
}
else
{
	echo "<br /><br />";
	echo "This problem either has no solutions or the input was invalid.";
	echo "<br /><br /><a href=\"/project555/index.php/home\">HOME</a>";
	die();
}




?>

</body>
</html>
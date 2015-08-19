<?php 


$hostname = "127.0.0.1";
$username = "root";
$password = "root";

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=numberwang", $username, $password);
//    echo "Connected to database\n";
    }
catch(PDOException $e) { 
	echo $e->getMessage(); 
	}


/////////////////////////////////////////    FUNCTIONS :)    ///



function decode_layout($encoded_data) // decodes original layout from JSON format to a PHP array
{
	foreach ($encoded_data as $value) {
		$decoded_data[] = json_decode($value, true);
	}
	return $decoded_data;
}



function decode_solutions($encoded_data) // decodes solutions from JSON format to a PHP array
{
	foreach ($encoded_data as $value) {
		$decoded_data[] = json_decode($value[0], true);
	}
	return $decoded_data;
}



function query_info_rows($dbh, $problem_id) // returns the number of rows/discs of the specified puzzle
{
	$query = "SELECT rows FROM problems WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);   
	return $result;
}



function query_info_sides($dbh, $problem_id) // returns the number of sides of the specified puzzle
{
	$query = "SELECT sides FROM problems WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);   
	return $result;
}



function query_info_sum($dbh, $problem_id) // returns the objective sum of each side of the specified puzzle
{
	$query = "SELECT sum FROM problems WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);   
	return $result;
}



function query_original_layout($dbh, $problem_id) // returns an array of the original layout of the specified puzzle
{
	$query = "SELECT start_layout FROM problems WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);   
	return $result;
}



function query_solutions($dbh, $problem_id) // returns an array of the solutions to the specified puzzle
{
	$query = "SELECT solution FROM solutions WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_NUM); 
	return $result;
}



function query_no_of_solutions($dbh, $problem_id) // returns an integer number of the solutions to the specified puzzle
{
	$query = "SELECT COUNT(solution) FROM solutions WHERE problem_id = :problem_id";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':problem_id', $problem_id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_NUM);   
	return $result;
}



function create_table($input_array, $no_of_sides)
{
	$table = "<table border=\"1\"><tr>";
	$count = 1;
	while ($count <= $no_of_sides) {
		$table .= "<th>Side $count</th>";
		$count++;
	}
	$table .= "</tr>";
	$reverse = array_reverse($input_array);
	foreach ($reverse as $row) {
		$table .= "<tr>";	
		foreach ($row as $value) {
			$table .= "<td>".$value."</td>";
		}
		$table .= "</tr>";
	}
	$table .= "</table>";
	return $table;
}



function solution_table($input_array, $no_of_sides)
{
	$table = '';
	$c = 1;
	foreach ($input_array as $solution) {
		$table .= "<br />Solution $c:";
		$table .= create_table($solution, $no_of_sides);
		$c++;
	}
	return $table;
}



function query_all($dbh)
{
	$query = "SELECT problem_id, rows, sides, sum FROM problems ORDER BY sum";
	$stmt = $dbh->query($query);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}




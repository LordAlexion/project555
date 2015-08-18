<?php 

$cxn = mysqli_connect("127.0.0.1","numberwang","","numberwang") 
    or die ("\nCouldn't connect to server.\n\n");



/////////////////////////////////////////    FUNCTIONS :)    ///



function query_info_rows($cxn, $problem_id) // returns the number of rows/discs of the specified puzzle
{
	$query = "SELECT rows FROM problems WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);
	
    while ($row = mysqli_fetch_row($result))
    {
        $no_of_rows = ($row[0]);
    }
    mysqli_free_result($result);

	return $no_of_rows;
}



function query_info_sides($cxn, $problem_id) // returns the number of sides of the specified puzzle
{
	$query = "SELECT sides FROM problems WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);

    while ($row = mysqli_fetch_row($result))
    {
        $no_of_sides = ($row[0]);
    }
    mysqli_free_result($result);

	return $no_of_sides;
}



function query_info_sum($cxn, $problem_id) // returns the objective sum of each side of the specified puzzle
{
	$query = "SELECT sum FROM problems WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);

	while ($row = mysqli_fetch_row($result))
	{
	    $sum = ($row[0]);
	}
	mysqli_free_result($result);

	return $sum;
}



function query_original_layout($cxn, $problem_id) // returns an array of the original layout of the specified puzzle
{
	$query = "SELECT start_layout FROM problems WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);

	while ($row = mysqli_fetch_row($result))
	{
		$layout_array[] = ($row[0]);
	}
	mysqli_free_result($result);

	return $layout_array;
}



function query_solutions($cxn, $problem_id) // returns an array of the solutions to the specified puzzle
{
	$query = "SELECT solution FROM solutions WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);

    while ($row = mysqli_fetch_row($result))
    {
        $solution_array[] = ($row[0]); 
    }
    mysqli_free_result($result);

	return $solution_array;
}



function query_no_of_solutions($cxn, $problem_id) // returns an integer number of the solutions to the specified puzzle
{
	$query = "SELECT COUNT(solution) FROM solutions WHERE problem_id = $problem_id";

	$result = mysqli_query($cxn, $query);

    while ($row = mysqli_fetch_row($result))
    {
        $no_of_solutions = ($row[0]);
    }
    mysqli_free_result($result);

	return $no_of_solutions;
}



function decode($encoded_data) // decodes data from JSON format to a PHP array
{
	foreach ($encoded_data as $value)
	{
		$decoded_data[] = json_decode($value, true);
	}

	return $decoded_data;
}



function create_table($input_array, $no_of_sides)
{
	$table = "<table border=\"1\"><tr>";
	$count = 1;
	while ($count <= $no_of_sides)
	{
		$table .= "<th>Side $count</th>";
		$count++;
	}
	$table .= "</tr>";
	$reverse = array_reverse($input_array);
	foreach ($reverse as $row)
	{
		$table .= "<tr>";	
		foreach ($row as $value)
		{
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
	foreach ($input_array as $solution)
	{
		$table .= "<br />Solution $c:";
		$table .= create_table($solution, $no_of_sides);
		$c++;
	}
	return $table;
}














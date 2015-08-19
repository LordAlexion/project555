<?php 


/////////////////////////////////////////    FUNCTIONS :)    ///


function create_table($layout, $sides)
{
	$table = "<table border=\"1\"><tr>";
	$count = 1;
	while ($count <= $sides) {
		$table .= "<th>Side $count</th>";
		$count++;
	}
	$table .= "</tr>";
	$reverse = array_reverse($layout);
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

function solution_table($input_array, $sides)
{
	$table = '';
	$c = 1;
	foreach ($input_array as $solution) {
		$table .= "<br />Solution $c:";
		$table .= create_table($solution, $sides);
		$c++;
	}
	return $table;
}





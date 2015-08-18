<?php 


/////////////////////////////////////////    REQUIRED VALUES    ///
/*

$objective_sum = 240;

$layout = array(
	array(65, 15, 80, 30),
	array(5, 45, 30, 20),
	array(35, 20, 45, 15),
	array(20, 35, 50, 30),
	array(25, 30, 25, 15),
	array(5, 55, 10, 10),
	array(10, 55, 10, 5),
	array(45, 20, 30, 70),
);

*/
/////////////////////////////////////////    VARIABLES    ///


$no_of_rows = count($layout);
$no_of_sides = count($layout[0]);

$max_iterations = pow($no_of_sides, ($no_of_rows - 1));

$i = 0;
$solution_count = 0;


/////////////////////////////////////////    FUNCTIONS    ///


function slice($input, $no_of_rows)
{
	$string = (string)$input;
	$string_pad = str_pad($string, $no_of_rows, "0", STR_PAD_LEFT);
	$output = str_split($string_pad);
	return $output;
}

function array_val($input, $array, $no_of_sides, $no_of_rows, $offset)
{
	$c = 0;
	while ($c < $no_of_rows)
	{
		$output[] = $array[$c][($input[$c] + $offset) % $no_of_sides];
		$c++;
	}

	return $output;
}


/////////////////////////////////////////    SCRIPT    ///


while ($i < $max_iterations)
{	
	$array_pos = base_convert($i, 10, $no_of_sides);
	$array_itr = slice($array_pos, $no_of_rows);	
	$front_values = array_val($array_itr, $layout, $no_of_sides, $no_of_rows, 0);
	$front_sum = array_sum($front_values);

	if ($front_sum == $objective_sum)
	{	
		$c = 2;
		while($c <= $no_of_sides) 
		{
			$other_side_values[$c] = array_val($array_itr, $layout, $no_of_sides, $no_of_rows, ($c - 1));
			$c++;
		}

		$c = 2;
		foreach($other_side_values as $each_side_values)
		{	
			$other_side_sums[$c] = array_sum($each_side_values);
			$c++;		
		}

		if (count(array_unique($other_side_sums)) == 1)
		{
			$solutions[$solution_count][0] = $front_values;
			$c = 1;
			foreach($other_side_values as $each_side_values) 
			{
				$solutions[$solution_count][$c] = $each_side_values;
				$c++;
			}
			$solution_count++;
		}
	}
	$i++;
}


/////////////////////////////////////////    OUTPUT    ///


echo "No. of rows:\n<br />".$no_of_rows."\n<br />";
echo "No. of sides:\n<br />".$no_of_sides."\n<br />";
echo "Objective sum:\n<br />".$objective_sum."\n<br />";
$problem_encoded = json_encode($layout);
echo "Problem JSON:\n<br />".$problem_encoded."\n<br />";
echo "Solution count:\n<br />".$solution_count."\n<br />";
echo "Solution JSON:\n<br />";

if ($solutions == NULL)
{
	echo "Error finding solution(s)\n";
}
else 
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
		echo $solution_encoded."\n<br />";
	}
}

echo "\n";







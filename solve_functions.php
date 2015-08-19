<?php 


/////////////////////////////////////////    FUNCTIONS    ///


function slice($input, $no_of_rows)
{
	$string = (string)$input;
	$string_pad = str_pad($string, $no_of_rows, "0", STR_PAD_LEFT);
	$output = str_split($string_pad);
	return $output;
}

function array_val($input, $array, $sides, $rows, $offset)
{
	$c = 0;
	while ($c < $rows)
	{
		$output[] = $array[$c][($input[$c] + $offset) % $sides];
		$c++;
	}

	return $output;
}

function solve($sides, $rows, $layout, $obj_sum)
{
	$i = 0;
	$solution_count = 0;
	$max_iterations = pow($sides, ($rows - 1));
	
	while ($i < $max_iterations)
	{
		$array_pos = base_convert($i, 10, $sides);
		$array_itr = slice($array_pos, $rows);	
		$front_values = array_val($array_itr, $layout, $sides, $rows, 0);
		$front_sum = array_sum($front_values);
	
		if ($front_sum == $obj_sum)
		{	
			$c = 2;
			while($c <= $sides) 
			{
				$other_side_values[$c] = array_val($array_itr, $layout, $sides, $rows, ($c - 1));
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
	return $solutions;
}

function transpEncode($solutions, $encode = true)
{
	foreach ($solutions as $solution)
	{
		$x = 0;
		$y = 0;
	
		while ($y < count($solution[0]))
		{
			while ($x < count($solution))
			{
				$transpose[$y][$x] = $solution[$x][$y];
				$x++;
			}
			$x = 0;
			$y++;
		}
		$solution_std[] = $transpose;
		$solution_encoded[] = json_encode($transpose);
	}
	if ($encode == true) {
		return $solution_encoded;
	}
	else {
		return $solution_std;
	}
}







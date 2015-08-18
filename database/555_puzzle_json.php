<!-- /////////////////////////////// OPEN /// -->


<html>
<head><title>Numberwang MK5</title></head>
<body style="font-family:Verdana">
<?php

echo "<h2>This one generates it in JSON format...</h2>\n";
echo "<h3>Executing program:</h3>\n";


//////////////////////////////////// ARRAYS & GLOBAL VARIABLES ///


$puzzle_array = array(
	array(55, 55, 60, 75), 
	array(35, 55, 55, 70), 
	array(55, 55, 75, 65), 
	array(15, 55, 45, 95), 
	array(55, 60, 90, 85), 
	array(55, 90, 80, 90), 
	array(15, 45, 55, 65), 
	array(10, 20, 50, 55), 
	array(25, 20, 70, 55),
	array(30, 25, 60, 95)
);

$x = 0; // Total count
$y = 0; // 555 count
$z = 0; // Solution count

$array_pos = base_convert($x, 10, 4);

$solutions = array();

$active_working = false; // Determines whether 'working out' is displayed


/////////////////////////////////// FUNCTIONS ///


function slice($input)
{
	$string = (string)$input;
	$string_pad = str_pad($string, 10, "0", STR_PAD_LEFT);
	$output = str_split($string_pad);
	return $output;
}

function array_val($input, $array, $offset = 0)
{
	$output = array(
		$array[0][($input[0] + $offset) % 4],
		$array[1][($input[1] + $offset) % 4],
		$array[2][($input[2] + $offset) % 4],
		$array[3][($input[3] + $offset) % 4],
		$array[4][($input[4] + $offset) % 4],
		$array[5][($input[5] + $offset) % 4],
		$array[6][($input[6] + $offset) % 4],
		$array[7][($input[7] + $offset) % 4],
		$array[8][($input[8] + $offset) % 4],
		$array[9][($input[9] + $offset) % 4]
	);
	return $output;
}

function for_iteration($it_base10, $array)
{
	$it_base4 = base_convert($it_base10, 10, 4);
	$it_slice = slice($it_base4);	
	$it_side1 = array_val($it_slice, $array, 0);
	$it_side2 = array_val($it_slice, $array, 1);
	$it_side3 = array_val($it_slice, $array, 2);
	$it_side4 = array_val($it_slice, $array, 3);

	echo "For the ".$it_base10."th iteration, the sides on the puzzle are:<br /><br />\n";
	print_r($it_side1);
	echo "<br />\n";
	print_r($it_side2);
	echo "<br />\n";
	print_r($it_side3);
	echo "<br />\n";
	print_r($it_side4);
}

function pretty_print($it_base10, $array)
{
	$it_base4 = base_convert($it_base10, 10, 4);
	$it_slice = slice($it_base4);	
	$it_side1 = array_val($it_slice, $array, 0);
	$it_side2 = array_val($it_slice, $array, 1);
	$it_side3 = array_val($it_slice, $array, 2);
	$it_side4 = array_val($it_slice, $array, 3);

	echo "For the ".$it_base10."th iteration, the sides on the puzzle are:<br /><br />\n";
	echo "<pre>
		          Side 1  |  Side 2  |  Side 3  |  Side 4   <br />\n
		Top         $it_side1[9]    |    $it_side2[9]    |    $it_side3[9]    |    $it_side4[9]\n
		            $it_side1[8]    |    $it_side2[8]    |    $it_side3[8]    |    $it_side4[8]\n
		            $it_side1[7]    |    $it_side2[7]    |    $it_side3[7]    |    $it_side4[7]\n
		            $it_side1[6]    |    $it_side2[6]    |    $it_side3[6]    |    $it_side4[6]\n
		            $it_side1[5]    |    $it_side2[5]    |    $it_side3[5]    |    $it_side4[5]\n
		            $it_side1[4]    |    $it_side2[4]    |    $it_side3[4]    |    $it_side4[4]\n
		            $it_side1[3]    |    $it_side2[3]    |    $it_side3[3]    |    $it_side4[3]\n
		            $it_side1[2]    |    $it_side2[2]    |    $it_side3[2]    |    $it_side4[2]\n
		            $it_side1[1]    |    $it_side2[1]    |    $it_side3[1]    |    $it_side4[1]\n
		Bottom      $it_side1[0]    |    $it_side2[0]    |    $it_side3[0]    |    $it_side4[0]\n
	</pre>";
}
  

////////////////////////////////// ITERATION SCRIPT /// 


while ($x < 262144) // 262144 max
{	
	$array_pos = base_convert($x, 10, 4);
	$array_itr = slice($array_pos);	
	$array_val = array_val($array_itr, $puzzle_array);
	$sum = array_sum($array_val);

	if ($sum == 555)
	{	
		if ($active_working == true) 
		{
			echo "\n<strong>Iteration number ".($x)."</strong>";
			echo "\nSum = 555! Checking...<br />\n";
			print_r($array_val);
		}

		$y++;
		$val2 = array_val($array_itr, $puzzle_array, 1);
		$val3 = array_val($array_itr, $puzzle_array, 2);
		$val4 = array_val($array_itr, $puzzle_array, 3);

		$sum2 = array_sum($val2);
		$sum3 = array_sum($val3);
		$sum4 = array_sum($val4);

		if ($active_working == true) 
		{
			echo "\n<br />Side 2: $sum2, Side 3: $sum3, Side 4: $sum4.<br />";
		}

		if (($sum2 == 555)&&($sum3 == 555)&&($sum4 == 555))
		{
			if ($active_working == true) 
			{
				echo "\n<strong>SOLUTION FOUND!</strong>\n";
				echo "<br />";
			}

			$solutions[] = ($x);

			$z++;
		}
		else 
		{
			if ($active_working == true) 
			{
				echo "\n... not a solution.\n";
				echo "<br />";
			}
		}
	}
	$x++;
}


/////////////////////////////////// EPILOGUE & SOLUTIONS /// NOEP (dat speeling) ///

/*	
 *	if ($x == 262144)
 *	{
 *		$all = "All";
 *	}
 *	else 
 *	{
 *		$all = "";
 *	}
 *	
 *	if ($y == 1)  
 *	{ 
 *		$yverb = "is";
 *		$ynoun = "route";
 *	}
 *	else  
 *	{
 *		$yverb = "are";
 *		$ynoun = "routes";
 *	}	
 *	
 *	if ($z == 1)
 *	{
 *		$zverb = "is";
 *		$znoun = "solution";
 *	}
 *	else  
 *	{
 *		$zverb = "are";
 *		$znoun = "unique solutions";
 *	}	
 *	
 *	echo "<br /><br />\n";
 *	echo "$all $x possibilities checked.\n";
 *	echo "There $yverb $y $ynoun to making 555 on one side.\n";
 *	echo "There $zverb $z $znoun to the puzzle in this set of iterations.<br />\n";
 *	echo "<br /><br />\n\n";
 *	echo "<h4>The solutions are as follows:</h4>\n";
 *	
 *	foreach ($solutions as $iteration) 
 *	{
 *		pretty_print($iteration, $puzzle_array);
 *		echo "<br /><br />"; 
 *	}
 */	

////////////////////////////////////// JSON ARRAY SCRIPTING ///

$c = 0;
$js_multiarray = array();

foreach ($solutions as $iteration) 
{
	$itr4 = base_convert($iteration, 10, 4);
	$js_slice = slice($itr4);

	$js_array1 = array_val($js_slice, $puzzle_array);
	$js_array2 = array_val($js_slice, $puzzle_array, 1);
	$js_array3 = array_val($js_slice, $puzzle_array, 2);
	$js_array4 = array_val($js_slice, $puzzle_array, 3);

	$js_subarray = array($js_array1, $js_array2, $js_array3, $js_array4);
	
	$rotated[0][0] = $js_subarray[0][0];
	$rotated[0][1] = $js_subarray[1][0];
	$rotated[0][2] = $js_subarray[2][0];
	$rotated[0][3] = $js_subarray[3][0];
	$rotated[1][0] = $js_subarray[0][1];
	$rotated[1][1] = $js_subarray[1][1];
	$rotated[1][2] = $js_subarray[2][1];
	$rotated[1][3] = $js_subarray[3][1];	
	$rotated[2][0] = $js_subarray[0][2];
	$rotated[2][1] = $js_subarray[1][2];
	$rotated[2][2] = $js_subarray[2][2];
	$rotated[2][3] = $js_subarray[3][2];
	$rotated[3][0] = $js_subarray[0][3];
	$rotated[3][1] = $js_subarray[1][3];
	$rotated[3][2] = $js_subarray[2][3];
	$rotated[3][3] = $js_subarray[3][3];	
	$rotated[4][0] = $js_subarray[0][4];
	$rotated[4][1] = $js_subarray[1][4];
	$rotated[4][2] = $js_subarray[2][4];
	$rotated[4][3] = $js_subarray[3][4];
	$rotated[5][0] = $js_subarray[0][5];
	$rotated[5][1] = $js_subarray[1][5];
	$rotated[5][2] = $js_subarray[2][5];
	$rotated[5][3] = $js_subarray[3][5];
	$rotated[6][0] = $js_subarray[0][6];
	$rotated[6][1] = $js_subarray[1][6];
	$rotated[6][2] = $js_subarray[2][6];
	$rotated[6][3] = $js_subarray[3][6];
	$rotated[7][0] = $js_subarray[0][7];
	$rotated[7][1] = $js_subarray[1][7];
	$rotated[7][2] = $js_subarray[2][7];
	$rotated[7][3] = $js_subarray[3][7];	
	$rotated[8][0] = $js_subarray[0][8];
	$rotated[8][1] = $js_subarray[1][8];
	$rotated[8][2] = $js_subarray[2][8];
	$rotated[8][3] = $js_subarray[3][8];
	$rotated[9][0] = $js_subarray[0][9];
	$rotated[9][1] = $js_subarray[1][9];
	$rotated[9][2] = $js_subarray[2][9];
	$rotated[9][3] = $js_subarray[3][9];

	$multiarray[$c] = array("0" => $rotated[0], 
							"1" => $rotated[1],
							"2" => $rotated[2],
							"3" => $rotated[3],
							"4" => $rotated[4],
							"5" => $rotated[5],
							"6" => $rotated[6],
							"7" => $rotated[7],
							"8" => $rotated[8],
							"9" => $rotated[9] );

	$c++;
}

//	echo "<pre>";
//	print_r($js_multiarray);
//	echo "</pre>";


$encoded1 = json_encode($multiarray);
$encoded2 = json_encode($puzzle_array);

echo $encoded1;
echo "<br /><br />";
echo $encoded2;

echo "<pre>";
print_r($multiarray);
print_r($puzzle_array);
echo "</pre>";

echo "And that's the problem.";



////////////////////////////////////// CLOSE TAGS ///


?>
</body>
</html>


<!-- ///////////////////////////////// END /// --> 


<?php echo "\n\n"; ?>

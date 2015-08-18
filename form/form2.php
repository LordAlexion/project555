<html>
<head>
<title>New Problem</title>
</head>
<body style="font-family:'Lucida Console', Monaco, monospace;">



<?php

$sides = $rows = 0;

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$rows = (int)test_input($_POST["rows"]);
$sides = (int)test_input($_POST["sides"]);

if (($rows == 0) || ($sides == 0) || ($sides > 10) || ($rows > 20))
{
	echo "Invalid input. The problem should be no more than 20 rows high and have no more than 10 sides, and must have a numerical input.";
	die();
}

?>

<h1><em>project555</em></h1>

<h3>New problem - enter objective sum and values on the problem</h3>

<form name="data" method="post" action="form3.php">
	<table width="450px">
	<tr>
 		<td valign="top">
  			<label for="rows">Objective Sum *</label>
 		</td>
 		<td valign="top">
  			<input type="text" name="rows" maxlength="4" size="5">
 		</td>
	</tr>


	<?php	
	
	$c1 = 0;
	
	while ($c1 < $rows)
	{
		$c2 = 0;
		echo 	"<tr>
					<td valign=\"top\">
						<label for=\"rows\">Row ".($c1 + 1)." *</label>
					</td>";
	 	
	 	while ($c2 < $sides)
	 	{
	 		echo 	"<td valign=\"top\">
	 					<input type=\"text\" name=\"value[$c1][$c2]\" maxlength=\"2\" size=\"5\">
 					</td>";
	 		$c2++;
	 	}
	
		echo 	"</tr>";
		$c1++;
	}	
	
	?>


	<tr>
 		<td colspan="2" style="text-align:center">
  			<input type="submit" value="Submit">
 		</td>
	</tr>

	</table>

</form>


</body>
</html>
<?php

$cxn = mysqli_connect("127.0.0.1","numberwang","","numberwang") 
    or die ("\nCouldn't connect to server.\n\n");


  //////////////////////////
      $problem_id = 1;  /// 
//////////////////////////


/////////////////////////////////////////    SOLUTION DATA    ///


$query_solution_data = "SELECT solution FROM solutions WHERE problem_id = $problem_id";

if ($result = mysqli_query($cxn, $query_solution_data)) 
{
    while ($row = mysqli_fetch_row($result)) // fetch array
    {
        $xsolution_array[] = ($row[0]); 
    }
    mysqli_free_result($result); // free result set
}

$json_decoded[0] = NULL;

foreach ($xsolution_array as $xsolution)
{
  $json_decoded[] = json_decode($xsolution, true);
}

print_r($json_decoded);

echo $json_decoded[1][1][0][0]."\n";

/// STRUCTURE OF SOLUTIONS:
///
/// $json_decoded[$solution_no][$solution_no][column][row]
///
/// 


/////////////////////////////////////////    OTHER QUERIES


$query_no_of_rows = "SELECT COUNT(solution) FROM solutions WHERE problem_id = $problem_id";

if ($result = mysqli_query($cxn, $query_no_of_rows)) 
{
    while ($row = mysqli_fetch_row($result)) // fetch variable
    {
        $no_rows = ($row[0]);
    }
    mysqli_free_result($result); // free result set
}

echo "No. rows: ".$no_rows."\n";













/*-------------------*/
  mysqli_close($cxn);
/*-------------------*/
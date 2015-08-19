<?php


require_once __DIR__.'/../silex/vendor/autoload.php';
$app = new Silex\Application();

require_once __DIR__.'/../silex/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

require_once __DIR__.'/db_functions.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/templates',));


/////////////////////////////////////////    /home    ///


$app->get('/home', function () use ($app, $dbh) {

	// URLs and instructions
	$new = "/project555/form/form1.php";
	$layouts = query_all($dbh);

	return $app['twig']->render('homepage.twig', array(
		
		'new' => $new,
		'layouts' => $layouts,

	));
}); 


/////////////////////////////////////////    /{problem_id}    ///


$app->get('/problem/{problem_id}', function ($problem_id) use ($app, $dbh) {

	$no_of_rows = query_info_rows($dbh, $problem_id);
	$no_of_sides = query_info_sides($dbh, $problem_id);
	$sum = query_info_sum($dbh, $problem_id);

	$original_layout = decode_layout(query_original_layout($dbh, $problem_id));
	$print_original_layout = create_table($original_layout[0], $no_of_sides[0]);

	$no_of_solutions = query_no_of_solutions($dbh, $problem_id);

	$solutions = decode_solutions(query_solutions($dbh, $problem_id));
	$print_solutions = solution_table($solutions, $no_of_sides[0]);

	$spoiler1 = "<div id=\"spoiler\" style=\"display:none\">";
	$spoiler2 = "</div><button title=\"Click to show/hide content\" type=\"button\" onclick=\"if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}\">Show/hide solution(s)</button>";


	if (($no_of_solutions == 0)&&($no_of_sides > 0)) { $error = "ERROR: This problem has no solutions."; }
	elseif ($no_of_sides == 0) { $error = "ERROR: This problem ID is not in our database."; }
	else { $error = ''; }

	return $app['twig']->render('problem_id.twig', array(

		'id' => $problem_id,
		'rows' => $no_of_rows[0],
		'sides' => $no_of_sides[0],
		'sum' => $sum[0],
		'original' => $print_original_layout,
		'solu_no' => $no_of_solutions[0],
		'solutions' => $print_solutions,
		'error' => $error,
		'spoiler1' => $spoiler1,
		'spoiler2' => $spoiler2,
		
	));
});


/////////////////////////////////////////    /new    ///






$app->run();

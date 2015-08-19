<?php


require_once __DIR__.'/../silex/vendor/autoload.php';
$app = new Silex\Application();

require_once __DIR__.'/../silex/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

require_once __DIR__.'/solve_functions.php';
require_once __DIR__.'/db_classes.php';
require_once __DIR__.'/table_functions.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/templates',));


/////////////////////////////////////////    /home    ///


$app->get('/home', function () use ($app, $dbh, $allProb) {

	// URLs and instructions
	$new = "/project555/form/form1.php";

	return $app['twig']->render('homepage.twig', array(
		
		'new' => $new,
		'info' => $allProb,

	));
}); 


/////////////////////////////////////////    /{problem_id}    ///


$app->get('/problem/{problem_id}', function ($problem_id) use ($app, $dbh, $obProb) {

	$info = $obProb[$problem_id]->getInfo();
	
	$layout = create_table($info['layout'], $info['sides']);

	$rawSolutions = $obProb[$problem_id]->getSolutions();
	$solutions = solution_table($rawSolutions, $info['sides']);

	$no_of_solutions = count($rawSolutions);
	$spoiler1 = "<div id=\"spoiler\" style=\"display:none\">";
	$spoiler2 = "</div><button title=\"Click to show/hide content\" type=\"button\" onclick=\"if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}\">Show/hide solution(s)</button>";


	if (($no_of_solutions == 0)&&($info['sides'] > 0)) { $error = "ERROR: This problem has no solutions."; }
	elseif ($info['pid'] == 0) { $error = "ERROR: This problem ID is not in our database."; }
	else { $error = ''; }

	return $app['twig']->render('problem_id.twig', array(

		'id' => $problem_id,
		'rows' => $info['rows'],
		'sides' => $info['sides'],
		'sum' => $info['sum'],
		'original' => $layout,

		'solu_no' => $no_of_solutions,
		'solutions' => $solutions,
		'error' => $error,
		'spoiler1' => $spoiler1,
		'spoiler2' => $spoiler2,
		
	));
});


/////////////////////////////////////////    /new    ///






$app->run();

<?php

require_once __DIR__.'/solve_functions.php';

/////////////////////////////////////////    CLASSES    ///


class problem
{
	public $problem_id = NULL;
	public $rows = NULL;
	public $sides = NULL;
	public $sum = NULL;
	public $layout = NULL;

	function getInfo()
	{
		$info['pid'] = $this->problem_id;
		$info['rows'] = $this->rows;
		$info['sides'] = $this->sides;
		$info['sum'] = $this->sum;
		$info['layout'] = json_decode($this->start_layout);

		return $info;
	}

	function getSolutions()
	{
		$info['pid'] = $this->problem_id;
		$info['rows'] = $this->rows;
		$info['sides'] = $this->sides;
		$info['sum'] = $this->sum;
		$info['layout'] = json_decode($this->start_layout);

		$solutions = solve($info['sides'], $info['rows'], $info['layout'], $info['sum']);
		$solutions = transpEncode($solutions, false);

		return $solutions;
	}
}

class solution
{
	public $solution_id = NULL;
	public $problem_id = NULL;
	public $solution = NULL;

	function getInfo()
	{
		$info['sid'] = $this->solution_id;
		$info['pid'] = $this->problem_id;
		$info['solution'] = json_decode($this->solution);

		return $info;
	}
}


/////////////////////////////////////////    ///


try {

	$hostname = "127.0.0.1";
	$username = "root";
	$password = "root";

    $dbh = new PDO("mysql:host=$hostname;dbname=numberwang", $username, $password);

 
/////////////////////////////////////////    QUERIES    ///


	$query = "SELECT * FROM `problems`";
	$stmt = $dbh->query($query);
	$obProb = $stmt->fetchAll(PDO::FETCH_CLASS, 'problem');
	
	$query = "SELECT * FROM `solutions`";
	$stmt = $dbh->query($query);
	$obSol = $stmt->fetchAll(PDO::FETCH_CLASS, 'solution');

	$query = "SELECT * FROM `problems` ORDER BY sum";
	$stmt = $dbh->query($query);
	$allProb = $stmt->fetchAll(PDO::FETCH_ASSOC);


/////////////////////////////////////////    EXCEPTION    ///


}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}






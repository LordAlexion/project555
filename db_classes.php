<?php

class problem
{
	function getSolutions()
	{
		$problem_id = $this->problem_id;
		$no_of_rows = $this->rows;
		$no_of_sides = $this->sides;
		$objective_sum = $this->sum;
		$layout = json_decode($this->start_layout);

		require_once __DIR__."/solver.php"; // requests solution-finding script

		return $solution_std;
	}

	function getInfo()
	{
		$info['id'] = $this->problem_id;
		$info['rows'] = $this->rows;
		$info['sides'] = $this->sides;
		$info['sum'] = $this->sum;
		$info['layout'] = print_r(json_decode($this->start_layout), true);

	//	echo "ID = {$info['id']}\nRows = {$info['rows']}\nSides = {$info['sides']}\nSum = {$info['sum']}\nLayout = {$info['layout']}\n";
		return $info;
	}
}

class solution
{
	//function 
}


/////////////////////////////////////////    ///


try {

	$hostname = "127.0.0.1";
	$username = "root";
	$password = "root";

    $dbh = new PDO("mysql:host=$hostname;dbname=numberwang", $username, $password);

 
/////////////////////////////////////////    ///


	$query = "SELECT * FROM `problems`";
	$stmt = $dbh->query($query);
	$obProb = $stmt->fetchAll(PDO::FETCH_CLASS, 'problem');
	
	$query = "SELECT * FROM `solutions`";
	$stmt = $dbh->query($query);
	$obSol = $stmt->fetchAll(PDO::FETCH_CLASS, 'solution');


/////////////////////////////////////////    ///


}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}


$obProb[2]->getInfo();

<?php

class problem
{
	public $problem_id;
	public $rows;
	public $sides;
	public $sum;
	public $start_layout;
}

class solution
{
	public $solution_id;
	public $problem_id;
	public $solution;
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
	$propertiesObject = $stmt->fetchAll(PDO::FETCH_CLASS, 'problem');
	
//	var_dump($propertiesObject);
	
	$query = "SELECT * FROM `solutions`";
	$stmt = $dbh->query($query);
	$solutionsObject = $stmt->fetchAll(PDO::FETCH_CLASS, 'solution');
	
//	var_dump($solutionsObject);


/////////////////////////////////////////    ///


}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}






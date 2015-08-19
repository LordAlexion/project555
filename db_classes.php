<?php


$hostname = "127.0.0.1";
$username = "root";
$password = "root";

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=numberwang", $username, $password);
//    echo "Connected to database\n";
    }
catch(PDOException $e) { 
	echo $e->getMessage(); 
	}


$query = "SELECT problem_id, rows, sides, sum FROM problems ORDER BY sum";
$stmt = $dbh->query($query);
$result = $stmt->fetchAll(PDO::FETCH_OBJ);

var_dump($result);
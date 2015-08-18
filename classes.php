<?php


class Problem
{
	public $objective_sum;
	public $original_layout;

	function __construct($objective_sum, $original_layout)
	{
		$this->sum = $objective_sum;
		$this->layout = $original_layout;
	}

	function findSides($original_layout)
	{
		$original_layout = json_decode($original_layout);
		$no_of_rows = count($original_layout);
		return $no_of_rows;
	}

	function findRows($original_layout)
	{
		$original_layout = json_decode($original_layout);
		$no_of_sides = count($original_layout[0]);
		return $no_of_sides;
	}

	function Solve($layout, $objective_sum)
	{
		$objective_sum = json_decode($original_layout);

		require_once __DIR__."/classFNsolve.php";

		return $solution_encoded;
	}
}



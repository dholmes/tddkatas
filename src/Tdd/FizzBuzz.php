<?php
namespace Tdd;

class FizzBuzz
{
	public function getLabel($number)
	{
		$label = $number;
		if(($number % 3) == 0){
			$label = "Fizz";
		}
		return ($label);
		
	}
}
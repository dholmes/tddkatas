<?php
namespace Tdd;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
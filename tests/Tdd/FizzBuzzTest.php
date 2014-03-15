<?php
namespace Tdd\Test;

use Tdd\FizzBuzz;
use \PHPUnit_Framework_TestCase;

/* 
Write a program that prints the numbers from 1 to 100. But for multiples of three print “Fizz” instead of the number and for the multiples of five print “Buzz”. For numbers which are multiples of both three and five print “FizzBuzz”.
 */

class FizzBuzzTest extends PHPUnit_Framework_TestCase
{
	protected $fizzBuzz;
	public function setUp()
	{
		parent::setUp();
		$this->fizzBuzz = new FizzBuzz();
	}
	public function testMultipleOfThree()
	{
		$number = 3;
		$answer = $this->fizzBuzz->getLabel($number);
		$this->assertEquals(
			'Fizz',
			$answer
		);
	}

}



?>

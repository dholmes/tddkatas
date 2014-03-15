<?php

namespace Tdd\Test;
use Tdd\PennyDoubler;

/**
 * This Kata was given to me by my Family.
 *   They wanted to know how quickly, if you started with someone paying 
 *   you a penny, and then doubled how much someone would give you once each 
 *   day, what would that start to look like.
 */

class PennyDoublerTest extends \PHPUnit_Framework_TestCase
{   
    protected $pennyDoubler;
    public function setUp(){
        parent::setUp();
        $this->pennyDoubler = new PennyDoubler();
    }

    public function testDefaultSetup()
    {
	$this->assertEquals(
		$this->pennyDoubler->day, 
		1
	);
	$this->assertEquals(
		$this->pennyDoubler->todaysRate,
		.01
	);
	$this->assertEquals(
		$this->pennyDoubler->todaysRate,
		$this->pennyDoubler->total
	);
    }

    public function testAddOneDay(){
	$this->pennyDoubler->addDay();
	$this->assertEquals(
		$this->pennyDoubler->day,
		2
	);
	$this->assertEquals(
		$this->pennyDoubler->todaysRate,
		.02
	);
	$this->assertEquals(
		$this->pennyDoubler->total,
		.03
	);
    }
    public function testAddTwoDatys()
    {
	$this->pennyDoubler->addDay();
	$this->pennyDoubler->addDay();
	$this->assertEquals(
		$this->pennyDoubler->total,
		.07
	);
		
    }
    
    public function testExerciseDoubler() 
    {
        $days = range(2, 60);
	$this->printDayAndRate($this->pennyDoubler);
        foreach($days as $day){
            $this->pennyDoubler->addDay();
	    $this->printDayAndRate($this->pennyDoubler);
        }
        $this->assertTrue(true);
    }
    public function printDayAndRate(PennyDoubler $pennyDoubler)
    {
	print_r(
	  array(
	    'day' => $pennyDoubler->day,
	    'todaysRate' => $pennyDoubler->todaysRate,
	    'total' => number_format($pennyDoubler->total,2)
	  )
	);    
    }
}
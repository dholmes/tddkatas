<?php
namespace Tdd;

class PennyDoubler
{
    public $day = 1;
    public $total = 0.01;
    public $todaysRate = 0.01;
    
    public function addDay()
    {
        $this->todaysRate = $this->todaysRate + $this->todaysRate;
        $this->total += $this->todaysRate;
	$this->day ++;
	
    }
}
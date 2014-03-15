<?php
namespace Tdd;
class BowlingGame {
    protected $rolls = array();
    protected $currentRoll = 0;
    
    function __construct() {
        $this->rolls = array_fill(0,20,0);
    }
    function roll($pins){
        $this->rolls[$this->currentRoll++] = $pins;
    }
    
    function getScore() {
        $score = 0;
        $frameIndex = 0;
        $rolls = $this->rolls;
        for( $frame=0; $frame < 10; $frame++){
            if($this->isStrike($frameIndex))
            {
                $score += 10 + $this->strikeBonus($frameIndex);
                $frameIndex++;
            }
            else if($this->isSpare($frameIndex)) 
            {
                // Some example comment
                $score += 10 + $this->spareBonus($frameIndex);
                $frameIndex += 2;
            }
            else 
            {
                $score += $this->sumOfBallsInFrame($frameIndex);
                $frameIndex += 2;
            }
        }
        return $score;
    }    
    protected function sumOfBallsInFrame($frameIndex) {
        return $this->rolls[$frameIndex] 
               + $this->rolls[$frameIndex+1];
    }
    protected function spareBonus($frameIndex){
        return $this->rolls[$frameIndex + 2];
    } 
    protected function strikeBonus($frameIndex){
        return $this->rolls[$frameIndex + 1] 
                + $this->rolls[$frameIndex + 2];
    }
    protected function isStrike($frameIndex) {
        return ($this->rolls[$frameIndex] == 10);
    }
    protected function isSpare($frameIndex) {
        $rolls = $this->rolls;
        return ($rolls[$frameIndex] + 
                $rolls[$frameIndex + 1] == 10);
    }
    
}

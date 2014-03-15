<?php
namespace Tdd\Test;
use Tdd\BowlingGame;

class BowlingGameTest extends \PHPUnit_Framework_TestCase {
    protected $game;
    
    public function setUp(){
        $this->game = new BowlingGame();
    }
    
    protected function rollMany($times, $pins){
        for($i=0; $i<$times; $i++){
            $this->game->roll($pins);
        }
    }
    
    protected function rollStrike(){
        $this->game->roll(10);
    }
    
    protected function rollSpare() {
        $this->game->roll(7);
        $this->game->roll(3);
    }

    public function testGutterGame() {
        $this->rollMany(20, 0);
        $this->assertEquals(0,$this->game->getScore());
    }
    public function testAllOnes() {
        $this->rollMany(20, 1);
        $this->assertEquals(20,$this->game->getScore());
    }
    
    public function testOneSpare(){
        $game = $this->game;
        $this->rollSpare();
        $game->roll(3);
        $this->rollMany(17,0);
        $this->assertEquals(16, $game->getScore());
    }
    
    public function testOneStrike(){
        $game = $this->game;
        $this->rollStrike();
        $game->roll(3);
        $game->roll(4);
        $this->rollMany(16,0);
        $this->assertEquals(24, $game->getScore());
    }
    
    public function testPerfectGame(){
        $this->rollMany(12,10);
        $this->assertEquals(300,$this->game->getScore());
    }
    public function testRandomGame(){
        $game = $this->game;
        $this->rollStrike();
        $game->roll(6);
        $game->roll(2);
        $this->rollMany(12,1);
        $game->roll(6);
        $game->roll(2);
        $this->rollStrike();
        $this->rollStrike();
        $this->rollStrike();
        $this->assertEquals(76, $game->getScore());
    }
    
}

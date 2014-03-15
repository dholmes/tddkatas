<?php
namespace Tdd\Test;

use Tdd\CreditPurchaseCalculator;
use \PHPUnit_Framework_TestCase as TestCase;

class CreditPurchaseCalculatorTest extends TestCase
{
	protected $creditPurchase;
	public function setUp()
	{
		parent::setUp();
		$this->creditPurchase = new CreditPurchaseCalculator();

		$this->defaultLevels = array(
			10000=>7000,
			1000=>800,
			100=>90,
			1=>1
		);
		$this->creditPurchase->setDefaultLevels($this->defaultLevels);
	}

    public function multiCreditsProvider()
    {
        return array(
            [0,0],
            [-10,0],
            [123,90+23],
            [5,5],
            [100,90],
            [110,100],
            [115,(90+15)],
            [1000,800],
            [5523,((800*5)+(90*5)+(10*2)+(3*1))],
            [10000,7000],
            [90000, 9*7000],
            [99,99],
            [9980,(800*9)+(90*9)+(1*80)]
        );
    }
    public function multiPricesProvider()
    {
        return array(
            [0,0],
            [-10,0],
            [123,(100)+33],
            [5,5],
            [90,100],
            [99,109],
            [100,110],
            [115,(100)+25],
            [800,1000],
            [4473,(1000*5)+(100*5)+(23)],
            [7000,10000],
            [63000,(9 * 10000)],
            [8090,(10000*1)+(1000*1)+(100*3)+(1*20)]
        );
    }
    public function testHandlesRemainder()
    {
        $this->creditPurchase->setDefaultLevels([10=>100]);
        $cost = $this->creditPurchase->getPriceForCredits(55);
        $this->assertEquals(500,$cost);
        
    }
	public function testZeroCredits()
	{
		$cost = $this->creditPurchase->getPriceForCredits(0);
        $this->assertTrue($cost === 0,"Cost for 0 credits should be 0");
	}
    public function testOneCredit()
    {
        $cost = $this->creditPurchase->getPriceForCredits(1);
        $this->assertEquals(1, $cost,"Cost for 1 credit should be 1");
    }
  
    /**
     * @dataProvider multiCreditsProvider
     */
    public function testManyCredits($credits, $expectedPrice)
    {
        $price = $this->creditPurchase->getPriceForCredits($credits);
        $this->assertEquals($expectedPrice, $price, "Price for $credits should be $expectedPrice");
    }
    
        /**
     * @dataProvider multiPricesProvider
     */
    public function testManyPrices($price, $expectedCredits)
    {
        if($expectedCredits < 0) $expectedCredits = 0;
        $credits = $this->creditPurchase->getCreditsForPrice($price);
        $this->assertEquals($expectedCredits, $credits, "$price should get $expectedCredits credits");
    }
        
}
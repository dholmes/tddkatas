<?php
namespace Tdd;
class CreditPurchaseCalculator {
	protected $levels = array(
		10000=>7000,
		1000=>800,
		100=>90,
		1=>1
	);
    public $calculationLog;
    
    public function setDefaultLevels($levels){
		if(is_array($levels)) $this->levels = $levels;
		return $this;
	}
    /**
     * 
     * @param int $credits
     * @return float Cost in USD of credits
     */
    public function getPriceForCredits($credits)
    {
        $finalPrice = 0;
        $creditsRemaining = $credits;
        
        foreach($this->levels as $creditsAtLevel => $price){
             
            while ($creditsAtLevel <= $creditsRemaining && $creditsRemaining > 0){
                    $finalPrice += $price;
                    $creditsRemaining -= $creditsAtLevel;
            }
        }
        
        return ($finalPrice);
        
    }
    public function getCreditsForPrice($price)
    {
        $finalCredits = 0;
        $priceRemaining = $price;
        
        foreach($this->levels as $creditsAtLevel => $priceAtLevel){
             
            while ($priceAtLevel <= $priceRemaining && $priceRemaining > 0){
                $finalCredits += $creditsAtLevel;
                $priceRemaining -= $priceAtLevel;
            }
        }
        
        return ($finalCredits);
        
    }
}

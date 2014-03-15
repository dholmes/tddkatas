<?php
namespace Tdd\Test;

use Tdd\BucketBallDistribution;
use \PHPUnit_Framework_TestCase;

class BucketBallDistributionTest extends PHPUnit_Framework_TestCase
{
    private $bucketIds = array();
    private $ballIds = array();
    private $bucketsMinBalls = 0;
    private $ballsMinBuckets = 0;
    
    protected function setUp ()
    {
        $this->distributer = new BucketBallDistribution();
        parent::setUp();
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->email = null;
        parent::tearDown();
    }
    public function testDistributeOneBucketToOneApp()
    {
        $this->bucketIds = array('100');
        $this->ballIds = array('200');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('200')),$results);
    }
    
    public function testDistributeOneBucketToManyApps()
    {
        $this->bucketIds = array('100');
        $this->ballIds = array('201','202','203');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('201','202','203')),$results);
    }
    
    public function testDistributeManyBucketToManyApps()
    {
        $this->bucketIds = array('100','101');
        $this->ballIds = array('201','202','203');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('201','203'),'101'=>array('202')),$results);
    }
    
    public function testDistributeManyBucketToManyAppsLimit1()
    {
        $this->bucketIds = array('100','101','102','103');
        $this->ballIds = array('201','202','203','204');
        $this->ballsMinBuckets = 1;
        $this->bucketsMinBalls = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201'),
        	'101'=>array('202'),
        	'102'=>array('203'),
        	'103'=>array('204')
        ),$results);
    }
    
    public function testDistributeManyBucketToManyAppsLimit3()
    {
        $this->bucketIds = array('100','101','102','103');
        $this->ballIds = array('201','202','203','204','205','206','207','208','209','210');
        $this->ballsMinBuckets = 3;
        $this->bucketsMinBalls = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','209','203','207','204','208'),
        	'101'=>array('202','206','210','204','208','201','205','209'),
        	'102'=>array('203','207','201','205','209','202','206','210'),
        	'103'=>array('204','208','202','206','210','203','207')
        ),$results);
    }
    
    public function testDistributeManyBucketToManyAppsLimit6ButCapped()
    {
        $this->bucketIds = array('100','101','102','103');
        $this->ballIds = array('201','202','203','204','205','206','207','208','209','210');
        $this->ballsMinBuckets = 6;
        $this->bucketsMinBalls = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','209','203','207','204','208','202','206','210'),
        	'101'=>array('202','206','210','204','208','201','205','209','203','207'),
        	'102'=>array('203','207','201','205','209','202','206','210','204','208'),
        	'103'=>array('204','208','202','206','210','203','207','201','205','209')
        ),$results);
    }

    public function testDistributeManyAppsToFewBuckets()
    {
        $this->bucketIds = array('100','101','102','103');
        $this->ballIds = array('201','202','203','204','205','206');
        $this->ballsMinBuckets = 0;
        $this->bucketsMinBalls = 3;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','203'),
        	'101'=>array('202','206','204'),
        	'102'=>array('203','201','205'),
        	'103'=>array('204','202','206')
        ),$results);
    }
    
    public function testDistributeManyAppsToManyBuckets3x4()
    {
        $this->bucketIds = array('100','101','102','103');
        $this->ballIds = array('201','202','203','204','205','206');
        $this->ballsMinBuckets = 3;
        $this->bucketsMinBalls = 4;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','203','204'),
        	'101'=>array('202','206','204','201','205'),
        	'102'=>array('203','201','205','202','206'),
        	'103'=>array('204','202','206','203')
        ),$results);
    }
    
    public function testDistributeManyAppsToManyBuckets6x6()
    {
        $this->bucketIds = array('100','101','102','103','104','105');
        $this->ballIds = array('201','202','203','204','205','206');
        $this->ballsMinBuckets = 5;
        $this->bucketsMinBalls = 2;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','206','205','204','203'),
        	'101'=>array('202','201','206','205','204'),
        	'102'=>array('203','202','201','206','205'),
        	'103'=>array('204','203','202','201','206'),
        	'104'=>array('205','204','203','202','201'),
        	'105'=>array('206','205','204','203','202')
        ),$results);
    }
    public function testDistributeManyAppsToManyBuckets2x12min7()
    {
        $this->bucketIds = array('100','101',);
        $this->ballIds = array(
        	'201','202','203','204','205','206',
        	'207','208','209','210','211','212'
        );
        
        $this->ballsMinBuckets = 0;
        $this->bucketsMinBalls = 7;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','203','205','207','209','211','202','204','206','208','210','212'),
        	'101'=>array('202','204','206','208','210','212','201','203','205','207','209','211'),
        ),$results);
  
    }
    
    public function testDistributeManyAppsToManyBuckets3x2()
    {
        $this->bucketIds = array('100','101','102');
        $this->ballIds = array('201','202');
        $this->ballsMinBuckets = 1;
        $this->bucketsMinBalls = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','202'),
        	'101'=>array('202'),
        	'102'=>array('201'),
        ),$results);
    }
    
    public function testDistributeManyAppsToManyBuckets16x12()
    {
        $this->bucketIds = array('100','101','102','103','104','105','106','107','108','109','110','112','113','114','115');
        $this->ballIds = array('201','202','203','204','205','206','207','208','209','210','211');
        $this->ballsMinBuckets = 4;
        $this->bucketsMinBalls = 4;

        $results = $this->runDistribution();
        
        $message = $this->distributer->getBallPoolMessage();
        $expectedMessage = "Each ball has been assigned 6 times to allow at least 4 buckets per ball and 4 balls per bucket.";
        $this->assertEquals($expectedMessage, $message);
        
    }
    
    protected function runDistribution()
    {
        $this->distributer
            ->setBucketIds($this->bucketIds)
            ->setBallIds($this->ballIds)
            ->setBucketsMinBalls($this->bucketsMinBalls)
            ->setBallsMinBuckets($this->ballsMinBuckets);
        $this->distributer->run();
        return $this->distributer->getResults();
    }

}

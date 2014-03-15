<?php
namespace Tdd\Test;

use Tdd\FizzBuzz;
use \PHPUnit_Framework_TestCase;

class Istart_Judging_DistributionTest extends PHPUnit_Framework_TestCase
{
    private $judgeIds = array();
    private $applicationIds = array();
    private $judgesMinApplications = 0;
    private $applicationsMinJudges = 0;
    
    protected function setUp ()
    {
        $this->distributer = new Istart_Judging_Distribution();
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
    public function testDistributeOneJudgeToOneApp()
    {
        $this->judgeIds = array('100');
        $this->applicationIds = array('200');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('200')),$results);
    }
    
    public function testDistributeOneJudgeToManyApps()
    {
        $this->judgeIds = array('100');
        $this->applicationIds = array('201','202','203');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('201','202','203')),$results);
    }
    
    public function testDistributeManyJudgeToManyApps()
    {
        $this->judgeIds = array('100','101');
        $this->applicationIds = array('201','202','203');
        $results = $this->runDistribution();
        $this->assertEquals(array('100'=>array('201','203'),'101'=>array('202')),$results);
    }
    
    public function testDistributeManyJudgeToManyAppsLimit1()
    {
        $this->judgeIds = array('100','101','102','103');
        $this->applicationIds = array('201','202','203','204');
        $this->applicationsMinJudges = 1;
        $this->judgesMinApplications = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201'),
        	'101'=>array('202'),
        	'102'=>array('203'),
        	'103'=>array('204')
        ),$results);
    }
    
    public function testDistributeManyJudgeToManyAppsLimit3()
    {
        $this->judgeIds = array('100','101','102','103');
        $this->applicationIds = array('201','202','203','204','205','206','207','208','209','210');
        $this->applicationsMinJudges = 3;
        $this->judgesMinApplications = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','209','203','207','204','208'),
        	'101'=>array('202','206','210','204','208','201','205','209'),
        	'102'=>array('203','207','201','205','209','202','206','210'),
        	'103'=>array('204','208','202','206','210','203','207')
        ),$results);
    }
    
    public function testDistributeManyJudgeToManyAppsLimit6ButCapped()
    {
        $this->judgeIds = array('100','101','102','103');
        $this->applicationIds = array('201','202','203','204','205','206','207','208','209','210');
        $this->applicationsMinJudges = 6;
        $this->judgesMinApplications = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','209','203','207','204','208','202','206','210'),
        	'101'=>array('202','206','210','204','208','201','205','209','203','207'),
        	'102'=>array('203','207','201','205','209','202','206','210','204','208'),
        	'103'=>array('204','208','202','206','210','203','207','201','205','209')
        ),$results);
    }

    public function testDistributeManyAppsToFewJudges()
    {
        $this->judgeIds = array('100','101','102','103');
        $this->applicationIds = array('201','202','203','204','205','206');
        $this->applicationsMinJudges = 0;
        $this->judgesMinApplications = 3;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','203'),
        	'101'=>array('202','206','204'),
        	'102'=>array('203','201','205'),
        	'103'=>array('204','202','206')
        ),$results);
    }
    
    public function testDistributeManyAppsToManyJudges3x4()
    {
        $this->judgeIds = array('100','101','102','103');
        $this->applicationIds = array('201','202','203','204','205','206');
        $this->applicationsMinJudges = 3;
        $this->judgesMinApplications = 4;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','205','203','204'),
        	'101'=>array('202','206','204','201','205'),
        	'102'=>array('203','201','205','202','206'),
        	'103'=>array('204','202','206','203')
        ),$results);
    }
    
    public function testDistributeManyAppsToManyJudges6x6()
    {
        $this->judgeIds = array('100','101','102','103','104','105');
        $this->applicationIds = array('201','202','203','204','205','206');
        $this->applicationsMinJudges = 5;
        $this->judgesMinApplications = 2;
        
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
    public function testDistributeManyAppsToManyJudges2x12min7()
    {
        $this->judgeIds = array('100','101',);
        $this->applicationIds = array(
        	'201','202','203','204','205','206',
        	'207','208','209','210','211','212'
        );
        
        $this->applicationsMinJudges = 0;
        $this->judgesMinApplications = 7;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','203','205','207','209','211','202','204','206','208','210','212'),
        	'101'=>array('202','204','206','208','210','212','201','203','205','207','209','211'),
        ),$results);
  
    }
    
    public function testDistributeManyAppsToManyJudges3x2()
    {
        $this->judgeIds = array('100','101','102');
        $this->applicationIds = array('201','202');
        $this->applicationsMinJudges = 1;
        $this->judgesMinApplications = 1;
        
        $results = $this->runDistribution();
        
        $this->assertEquals(
        array(
        	'100'=>array('201','202'),
        	'101'=>array('202'),
        	'102'=>array('201'),
        ),$results);
    }
    
    public function testDistributeManyAppsToManyJudges16x12()
    {
        $this->judgeIds = array('100','101','102','103','104','105','106','107','108','109','110','112','113','114','115');
        $this->applicationIds = array('201','202','203','204','205','206','207','208','209','210','211');
        $this->applicationsMinJudges = 4;
        $this->judgesMinApplications = 4;

        $results = $this->runDistribution();
        
        $message = $this->distributer->getApplicationPoolMessage();
        $expectedMessage = "Each application has been assigned 6 times to allow at least 4 judges per application and 4 applications per judge.";
        $this->assertEquals($expectedMessage, $message);
        
    }
    
    protected function runDistribution()
    {
        $this->distributer
            ->setJudgeIds($this->judgeIds)
            ->setApplicationIds($this->applicationIds)
            ->setJudgesMinApplications($this->judgesMinApplications)
            ->setApplicationsMinJudges($this->applicationsMinJudges);
        $this->distributer->run();
        return $this->distributer->getResults();
    }

}

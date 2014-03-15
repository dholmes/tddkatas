<?php
namespace Tdd;

class Distribution
{
    protected $bucketIds = array();
    protected $ballIds = array();
    
    protected $bucketsMinBalls = 0;
    protected $ballsMinBuckets = 0;
    protected $ballPool = array();
    protected $results = array();
    protected $resultsByBall = array();
    
    public function setBucketIds($bucketIds)
    {
        $this->bucketIds = $bucketIds;
        return $this;
    }
    public function setBallIds($ballIds)
    {
        $this->ballIds = $ballIds;
        return $this;
    }
    
    public function setBucketsMinBalls($count)
    {
        $this->bucketsMinBalls = intval($count);
        return $this;
    }
    public function setBallsMinBuckets($count)
    {
        $this->ballsMinBuckets = intval($count);
        return $this;
    }
    public function run()
    {
        $this->results = array();
        $this->resultsByBall = array();
        
        $ballPool = $this->createBallIdPool();
        $lastPoolCount = 0;
        while(count($ballPool) > 0 && $lastPoolCount != count($ballPool)) {
            $lastPoolCount = count($ballPool);
            foreach($this->bucketIds as $bucketId){
                $ballId = reset($ballPool);
                if($this->checkBallIdForBucketId($ballId, $bucketId)) {
                    $ballId = array_shift($ballPool);
                    $this->results[$bucketId][] = $ballId;
                    $this->resultsByBall[$ballId][] = $bucketId;
                }
            }
            
        }
        return $this->results;
    }
    
    public function getResults()
    {
        return $this->results;
    }
    
    public function getResultsByBall()
    {
        return $this->resultsByBall;
    }
    
    public function getBallMinBuckets()
    {
        return min(intval($this->ballsMinBuckets), count($this->bucketIds));
    }
    
    public function getBucketMinBalls()
    {
        return min(intval($this->bucketsMinBalls), count($this->ballIds));
    }
    
    public function getBallPoolSize()
    {
        $ballsMinBuckets = $this->getBallMinBuckets();
        $bucketMinBalls = $this->getBucketMinBalls();
        $ballPoolSizeByApp   = ($ballsMinBuckets * count($this->ballIds));
        $ballPoolSizeByBucket = ($bucketMinBalls * count($this->bucketIds));
        return max(count($this->ballIds),$ballPoolSizeByApp,$ballPoolSizeByBucket);
    }
    
    public function getBallPoolMessage()
    {
        $ballsMinBuckets = $this->getBallMinBuckets();
        $bucketsMinBalls = $this->getBucketMinBalls();
        $ballPoolSizeByApp   = ($ballsMinBuckets * count($this->ballIds));
        $ballPoolSizeByBucket = ($bucketsMinBalls * count($this->bucketIds));
        $poolSize = count($this->ballPool);
        if($poolSize == 0) return "";
        
        $assignCount = ceil($poolSize / count($this->ballIds));
        
        $message = "";
        
        switch ($poolSize) {
            case $ballPoolSizeByApp:
                if($this->ballsMinBuckets > 0 && $ballsMinBuckets < $this->ballsMinBuckets){
                    $message .= "Not enough selected buckets to meet the requested minimum. Each ball has been assigned $assignCount times to provide $ballsMinBuckets buckets per ball. ";
                } else {
                    $message .= "Each ball has been assigned $assignCount times to match your number of buckets per ball. ";
                }
                break;
            case $ballPoolSizeByBucket:
                if($this->bucketsMinBalls > 0 && $bucketsMinBalls < $this->bucketsMinBalls){
                    $message .= "Not enough balls to meet the requested minimum. Each ball has been assigned $assignCount times to provide $bucketsMinBalls balls per bucket.";
                } else {
                    $message .= "Each ball has been assigned $assignCount times to match your requested number of balls per bucket.";
                }
                break;
            case count($this->ballIds):
                $message .= "Each of your selected balls were assigned once.";
                break;
            default:
                $message .= "Each ball has been assigned $assignCount times to allow at least";
                $needsAnd = false;
                if($this->ballsMinBuckets > 0){
                     $message .= " $ballsMinBuckets buckets per ball";
                     $needsAnd = true;
                }
                if($this->bucketsMinBalls > 0){
                    if($needsAnd) $message .= " and";
                    $message .= " $bucketsMinBalls balls per bucket. ";
                    $needsAnd = true;
                } 
                
        }
        
        return trim($message);
    }
    
    public function createBallIdPool()
    {
        $ballPoolSize = $this->getBallPoolSize();
        $ballPool = array_values($this->ballIds);

        while(count($ballPool) < $ballPoolSize) {
            $ballPool = array_merge($ballPool, $this->ballIds);
        }
        $this->ballPool = $ballPool;
        return $ballPool;
    }
    public function checkBallIdForBucketId($ballId, $bucketId)
    {
        return (bool)($ballId && 
           ( !isset($this->results[$bucketId]) ||
             !in_array($ballId, $this->results[$bucketId] )
           )
        );
    }
}

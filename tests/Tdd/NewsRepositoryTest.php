<?php

namespace Tdd\Test;
use Tdd\NewsRepository;

class NewsRepositoryTests extends 
    \PHPUnit_Extensions_Database_TestCase 
{
    protected $pdo = null;
    protected $newsRepository = null;
    
    public function getConnection()
    {
        global $PDO;
        $this->pdo = $PDO;

        return $this->createDefaultDBConnection($PDO,'default');
    }
    public function getDataSet()
    {
        return $this->createXMLDataSet(
            FILE_DIR_PATH.'/NewsRepository-data.xml'
        );
    }
    
    public function setUp(){
        parent::setUp();
        $this->newsRepository = new NewsRepository($this->pdo);
    }
    
    public function testGetAllNewsItems() 
    {
        $news = $this->newsRepository->getAllNews();
        $this->assertEquals(3,count($news));
    }
    
    public function testGetDefaultQueryLimit()
    {
        $queryLimit = $this->newsRepository->getQueryLimit();
        $this->assertEquals(0, $queryLimit);
    }
    public function testSetQueryLimit()
    {
        $this->newsRepository->setQueryLimit(1);  
        return $this->newsRepository;
    }
    /**
     * @depends testSetQueryLimit
     */
    public function testGetQueryLimitAfterSet($newsRepository)
    {
        $queryLimit = $newsRepository->getQueryLimit();
        $this->assertEquals(1, $queryLimit);
        return $newsRepository;
    }
    /**
     * @depends testGetQueryLimitAfterSet
     */
    public function testGetLimitedItems($newsRepository)
    {
        $news = $newsRepository->getAllNews();
        $this->assertEquals(1, count($news));
    }
}
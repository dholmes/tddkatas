<?php

namespace Tdd\Test;
use Tdd\UserAuthentication;

class UserAuthenticationTests extends 
    \PHPUnit_Extensions_Database_TestCase 
{
    protected $pdo = null;
    protected $userAuthentication = null;
    
    public function getConnection()
    {
        global $PDO;
        $this->pdo = $PDO;

        return $this->createDefaultDBConnection($PDO,'default');
    }
    public function getDataSet()
    {
           $this->markTestSkipped(
              'This test is not setup yet.'
            );
        return $this->createXMLDataSet(
            FILE_DIR_PATH.'/Users-data.xml'
        );
    }
    
    public function setUp()
    {
        parent::setup();
        $this->userAuthentication = new Tdd\UserAuthentication($this->pdo);
    }
    
    public function testGeneratePasswordHash()
    {
        $password = "password";
        $this->userAuthentication->setPassword();
        $this->userAuthentication->getPasswordHash();
    }
    
    
    
}
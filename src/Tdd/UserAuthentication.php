<?php
namespace Tdd;

class UserAuthentication
{
    protected $db;
    
    public function __construct($db){
        $this->db = $db;
    }
    
}
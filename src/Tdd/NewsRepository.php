<?php
namespace Tdd;

class NewsRepository
{
    protected $db;
    protected $queryLimit = 0;
    
    public function __construct($db){
        $this->db = $db;
    }
    
    public function getQueryLimit(){
        return $this->queryLimit;
    }
    
    public function setQueryLimit($limit){
        $this->queryLimit = (int)$limit;
    }
    
    protected function appendQueryLimiter($sql){
        if($this->queryLimit){
            $sql .= " LIMIT {$this->queryLimit}";
        }
        return $sql;
    }
    
    public function getAllNews()
    {
        $sql = "SELECT * from news order by published_at 
            DESC";
        $sql = $this->appendQueryLimiter($sql);
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
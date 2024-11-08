<?php
class SectoresService {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db->getConnection();
    }

    public function getAll(){
        $query = 'SELECT * FROM sectores;';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }    
    
}
?>
<?php
require_once __DIR__.'/../database/index.php';

class DepartamentosService {
    private $db;
    public function __construct(Database $db) {
        $this->db = $db->getConnection();
    }
    public function getAll(){
        $query = 'SELECT cod_depto,nomb_depto FROM departamentos;';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>
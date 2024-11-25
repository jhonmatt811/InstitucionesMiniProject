<?php
require_once __DIR__ . '/../services/Departamentos.php';
class Departamentos {
    private $service;

    public function __construct() {
        $this->service = new DepartamentosService(new Database());
    }

    public function getAll(){
        $departamentos = $this->service->getAll();   
        return $departamentos;     
    }
}

?>
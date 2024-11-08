<?php
    require_once __DIR__.'/../services/CaracterAcademico.php';
    class CaracterAcademico {
        private $service;
        public function __construct() {
            $this->service = new CaracterAcademicoService(new Database());
        }
        public function getAll(){
            $tiposCaracterAcademico = $this->service->getAll();
            return $tiposCaracterAcademico;
        }
    }
?>
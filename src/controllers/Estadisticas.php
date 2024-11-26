<?php

require_once __DIR__.'/../services/Estadisticas.php';

class Estadisticas {
    private $service;


    public function __construct() {
        $this->service = new EstadisticaServices(new Database());
        session_start();
    }
    
    public function getStatisticsByAcademicCharacter(){
        $estadistica = $this->service->getStatisticsByAcademicCharacter();
        return $estadistica;
    }
    public function getInstitutionsByDepartmentAndStatus(){
        $estadistica = $this->service->getInstitutionsByDepartmentAndStatus();
        return $estadistica;
    }


    public function getInstitutionsByDepartmentAndStatusById($id){
        $estadistica = $this->service->getInstitutionsByDepartmentAndStatusById($id);
        return $estadistica;   
    }

    public function getStatisticsBySectorAndDepartment(){
        $estadistica = $this->service->getStatisticsBySectorAndDepartment();
        return $estadistica;
    }
    public function getStatisticsBySectorAndDepartmentById($id){
        $estadistica = $this->service->getStatisticsBySectorAndDepartmentById($id);
        
        return $estadistica;
    }

    public function getStatisticsByAdministrativeAct(){
        $estadistica = $this->service->getStatisticsByAdministrativeAct();
        return $estadistica;
    }
    public function getStatisticsByCreationNorm(){
        $estadistica = $this->service->getStatisticsByCreationNorm();
        return $estadistica;
    }
}
?>
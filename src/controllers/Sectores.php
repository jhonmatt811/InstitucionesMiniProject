<?php
require_once __DIR__ . '/../services/Sectores.php';

class Sectores {
    private $model;

    public function __construct() {
        $this->model = new SectoresService(new Database());
    }    

    // Método para obtener todos los sectores (GET)
    public function getAll() {
        $sectores = $this->model->getAll();
        return $sectores;
    }
   
}
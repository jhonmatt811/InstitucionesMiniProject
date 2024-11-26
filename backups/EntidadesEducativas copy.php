<?php

require_once __DIR__.'/../services/EntidadesEducativas.php';

class EntidadesEducativas {
    private $service;

    private function generateTimeBasedId() {
        // Obtener la fecha actual en el formato: AAHHMMSS (año, hora, minuto, segundo)
        $id = (int)date('yHis'); // 'y' es el año en dos dígitos, 'His' es hora, minutos y segundos
    
        // Verificar que el ID esté dentro del rango de un entero de 32 bits
        if ($id > 2147483647) {
            throw new Exception('El ID generado supera el límite de un entero de 32 bits.');
        }
    
        return $id;
    }

    public function __construct() {
        $this->service = new EntidadesEducativasService(new Database());
        session_start();
    }

    public function getAll(){
        $entidadesEducativas = $this->service->getAll();
        return $entidadesEducativas;
    }
    
    public function create(){
        $name = $_POST['name'];
        $sector = $_POST['cod_sector'];
        $caracterAcademico = $_POST['cod_academ'];
        $id = $this->generateTimeBasedId();
        $result = $this->service->create($id,$name, $sector, $caracterAcademico);
        echo $result;
        // Verifica si hubo un error
        if (isset($result['error'])) {
            // Redirige al formulario con el mensaje de error
            $_SESSION['error'] = "El nombre ".$name. " ya se encuentra en uso";
            header('Location: /src/views/Instituciones/CreateInstitucion.php');
            exit();
        }
        header('Location: /src/views/Instituciones/InstitucionesView.php');
        exit;
        
    }

    public function update(){
        $id = $_POST['cod_inst'];
        $name = $_POST['nomb_inst'];
        $sector = $_POST['cod_sector'];
        $caracterAcademico = $_POST['cod_academ'];
        $this->service->update($id, $name, $sector, $caracterAcademico);
        header('Location: /src/views/Instituciones/InstitucionesView.php');
        exit;
    }

    public function delete(){
        $id = $_POST['cod_inst'];
        $this->service->delete($id);
        header('Location: /src/views/Instituciones/InstitucionesView.php');
        exit;
    }

    public function getStadistcByDepStatus(){
        $entidadesEducativas = $this->service->getStadistcByDepStatus();
        return $entidadesEducativas;
    }

    public function getInstByStatus($codEstado){
        return $this->service->getInstByStatus($codEstado);
    }
    public function getInstByDeptStatus($codEstado,$codDept){
        return $this->service->getInstByDeptStatus($codEstado,$codDept);
    }

    public function getStadistcByDepStatusById($id){
        $entidadesEducativas = $this->service->getStadistcByDepStatusById($id);
        return $entidadesEducativas;   
    }

    public function stadisticsByAcademicCharacter(){
        $entidadesEducativas = $this->service->stadisticsByAcademicCharacter();
        return $entidadesEducativas;
    }
    public function getByAcademicCHaracter($caracterAcademico){
        $entidadesEducativas = $this->service->getByAcademicCHaracter($caracterAcademico);
        return $entidadesEducativas;
    }
    public function stadisticBySectorDept(){
        $entidadesEducativas = $this->service->stadisticBySectorDept();
        return $entidadesEducativas;
    }
    public function stadisticBySectorDeptById($id){
        $entidadesEducativas = $this->service->stadisticBySectorDeptById($id);
        
        return $entidadesEducativas;
    }

    public function instBySector($codSector){
        $entidadesEducativas = $this->service->instBySector($codSector);
        return $entidadesEducativas;
    }

    public function instBySectorDept($codSector,$codDept){
        $entidadesEducativas = $this->service->instBySectorDept($codSector,$codDept);
        return $entidadesEducativas;
    }

    public function stadisticByActoAdmon(){
        $entidadesEducativas = $this->service->stadisticByActoAdmon();
        return $entidadesEducativas;
    }
    public function stadisticByNormaCreacion(){
        $entidadesEducativas = $this->service->stadisticByNormaCreacion();
        return $entidadesEducativas;
    }
    public function actoAdmin(){
        $tipoActo = $this->service->actoAdmin();
        return $tipoActo;
    }
}

$entidadesEducativas = new EntidadesEducativas();
$action = $_GET['action'] ?? 'getAll';
switch ($action) {
    case 'getAll':
        $entidadesEducativas->getAll();
        break;
    case 'create':
        $entidadesEducativas->create();
        break;
    case 'update':
        $entidadesEducativas->update();
        break;
    case 'delete':
        $entidadesEducativas->delete();
        break;
    default:
        break;
}

?>
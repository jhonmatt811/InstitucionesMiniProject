<?php
    require_once __DIR__.'/../database/index.php';
    class EntidadesEducativasService {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db->getConnection();
        }

        public function getAll(){
            $query = 'SELECT * FROM instituciones;';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function create($id,$name, $sector, $caracterAcademico){
            $query = 'INSERT INTO instituciones (cod_inst,nomb_inst,cod_sector,cod_academ) VALUES (:cod_inst,:nomb_inst,:cod_sector,:cod_academ);';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cod_inst', $id);
            $stmt->bindParam(':nomb_inst', $name);
            $stmt->bindParam(':cod_sector', $sector);
            $stmt->bindParam(':cod_academ', $caracterAcademico);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function update($id, $name, $sector, $caracterAcademico){
            $query = 'UPDATE instituciones SET nomb_inst = :nomb_inst, cod_sector = :cod_sector, cod_academ = :cod_academ WHERE cod_inst = :cod_inst;';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cod_inst', $id);
            $stmt->bindParam(':nomb_inst', $name);
            $stmt->bindParam(':cod_sector', $sector);
            $stmt->bindParam(':cod_academ', $caracterAcademico);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function delete($id){
            $query = 'DELETE FROM instituciones WHERE cod_inst = :cod_inst;';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cod_inst', $id);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getStadistcByDepStatus(){
            $query = "SELECT  d.nomb_depto,est.nomb_estado,COUNT(inst.*) AS total_instituciones FROM inst_por_municipio inst
                JOIN estados est ON est.cod_estado = inst.cod_estado
                JOIN municipios m ON inst.cod_munic = m.cod_munic
                JOIN departamentos d ON d.cod_depto = m.cod_depto
                GROUP  BY d.nomb_depto,est.nomb_estado ORDER BY d.nomb_depto ASC; 
            ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function stadisticsByAcademicCharacter(){
            $query = "SELECT  c.nomb_academ,COUNT(inst.cod_inst) AS  total_inst FROM instituciones inst
                    JOIN caracter_academico c ON inst.cod_academ = c.cod_academ
                    GROUP BY c.nomb_academ ORDER BY total_inst DESC;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function stadisticBySectorDept(){
            $query = "SELECT  dept.nomb_depto,sect.nomb_sector,COUNT(inst_pm.*) as total_inst 
                FROM instituciones inst
                JOIN sectores sect ON sect.cod_sector = inst.cod_sector
                JOIN  inst_por_municipio inst_pm ON inst_pm.cod_inst = inst.cod_inst
                JOIN municipios m ON m.cod_munic = inst_pm.cod_munic
                JOIN departamentos dept ON dept.cod_depto = m.cod_depto
                GROUP BY dept.nomb_depto,sect.nomb_sector
                ORDER BY dept.nomb_depto ASC;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function stadisticByActoAdmon(){
            $query = "SELECT act.nomb_admon, COUNT(inst.*) AS total_inst FROM inst_por_municipio inst
                JOIN acto_admon act ON act.cod_admon = inst.cod_admon
                GROUP BY act.nomb_admon 
                HAVING act.nomb_admon = 'Gobierno Nacional' OR act.nomb_admon = 'Congreso de la Republica' OR act.nomb_admon = 'Congreso de Colombia' 
                OR act.nomb_admon = 'Ministerio de Educación Nacional'
                ORDER BY act.nomb_admon DESC;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function stadisticByNormaCreacion(){
            $query = "SELECT nc.nomb_norma, COUNT(inst.*) AS total_inst FROM inst_por_municipio inst
                JOIN norma_creacion nc ON  inst.cod_norma = nc.cod_norma
                GROUP BY nc.nomb_norma;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
    }
?>
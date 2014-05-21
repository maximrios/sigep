<?php

class Localidades_model extends CI_Model {

    /**
     * Localidades_model class
     *
     * @package default
     * @author  Silvia Farfan
     * @version MySql 1.0.0
     * 
     * Adaptado a  MySql por Nacho Fassini
     */
    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT loc.inIdLocalidad, dep.inIdDepartamento, pr.inIdProvincia, pr.inIdPais, loc.vcLocNombre,loc.vcLocCodPostal, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre
                            FROM tsislocalidades AS loc	
                                    left join tsisdepartamentos AS dep ON loc.inIdDepartamento = dep.inIdDepartamento	        
                                    left join tsisprovincias AS pr ON pr.inIdProvincia = dep.inIdProvincia 
                                    left join tsispaises AS pa ON pr.inIdPais = pa.inIdPais		       
                            WHERE lower(CONCAT_WS(" ",loc.vcLocNombre, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre)) LIKE ? 
                            ORDER BY pa.vcPaisNombre ASC, pr.vcProNombre ASC, dep.vcDepNombre ASC , loc.vcLocNombre ASC
                            LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdLocalidad) AS inCant 
                            FROM tsislocalidades AS loc	
                                    left join tsisdepartamentos AS dep ON loc.inIdDepartamento = dep.inIdDepartamento	        
                                    left join tsisprovincias AS pr ON pr.inIdProvincia = dep.inIdProvincia 
                                    left join tsispaises AS pa ON pr.inIdPais = pa.inIdPais		       
                            WHERE lower(CONCAT_WS(" ",loc.vcLocNombre, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre)) LIKE ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'select loc.inIdLocalidad,dep.inIdDepartamento, pr.inIdProvincia, pr.inIdPais, loc.vcLocNombre, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre, loc.vcLocCodPostal
                            FROM tsislocalidades AS loc	
                                 left join tsisdepartamentos AS dep ON loc.inIdDepartamento = dep.inIdDepartamento	        
                                 left join tsisprovincias AS pr ON pr.inIdProvincia = dep.inIdProvincia 
                                 left join tsispaises AS pa ON pr.inIdPais = pa.inIdPais
                            WHERE loc.inIdLocalidad = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsislocalidadesguardar(?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsislocalidadesborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

}

// EOF provincias_model.php
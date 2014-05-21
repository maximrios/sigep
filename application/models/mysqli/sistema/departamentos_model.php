<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Diego G
 * @version MySql 1.0.0
 * @copyright 2011-12
 * @package base
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class Departamentos_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT dep.inIdDepartamento, pr.inIdProvincia, pr.inIdPais, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre 
                        FROM tsisdepartamentos as dep		        
                                    LEFT JOIN tsisprovincias as pr ON pr.inIdProvincia = dep.inIdProvincia 
                                    LEFT JOIN tsispaises as pa ON pr.inIdPais = pa.inIdPais		       
                        WHERE LOWER(CONCAT_WS(" ",pa.vcPaisNombre, pr.vcProNombre, dep.vcDepNombre)) LIKE ? 
                        ORDER BY pa.vcPaisNombre ASC, pr.vcProNombre ASC, dep.vcDepNombre ASC 
                        LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdDepartamento) AS inCant 
                        FROM tsisdepartamentos AS dep		        
                            LEFT JOIN tsisprovincias AS pr ON pr.inIdProvincia = dep.inIdProvincia 
                            LEFT JOIN tsispaises AS pa ON pr.inIdPais = pa.inIdPais		       
                        WHERE lower(CONCAT_WS(" ",pa.vcPaisNombre, pr.vcProNombre, dep.vcDepNombre)) like ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT dep.inIdDepartamento, pr.inIdProvincia, pr.inIdPais, dep.vcDepNombre, pr.vcProNombre, pa.vcPaisNombre 
                        FROM tsisdepartamentos AS dep
                            LEFT JOIN tsisprovincias AS pr ON pr.inIdProvincia = dep.inIdProvincia 
                            LEFT JOIN tsispaises AS pa ON pr.inIdPais = pa.inIdPais 
                        WHERE dep.inIdDepartamento = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsisdepartamentosguardar(?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisdepartamentosborrar(? ) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerPaises() {
        $sql = 'SELECT * FROM tsispaises ORDER BY vcPaisNombre;';
        $result = $this->db->query($sql);
        $resultSimple = array();
        foreach ($result->result() as $row) {
            $resultSimple[$row->inIdPais] = $row->vcPaisNombre;
        }
        return $resultSimple;
    }

}

// EOF provincias_model.php
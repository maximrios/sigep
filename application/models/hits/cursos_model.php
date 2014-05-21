<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cursos Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Cursos_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_cursos
            WHERE busqueda LIKE ? 
            ORDER BY nombreCurso ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idCursoComision) AS inCant FROM hits_view_cursos WHERE lower(CONCAT_WS(" ", nombreCurso, nombreOrganismo)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_view_noticias WHERE idNoticia = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT hits_sp_noticias_guardar(?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerCCAlumnos($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_cursos_alumnos
            WHERE completoPersona LIKE ? 
            ORDER BY apellidoPersona ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function ObtInstrumentos($simple=true) {
        $this->db->select('inIdTipoInstrumentoLegal, vcDescripcion')->from('ttipoinstrumentolegal')->order_by('vcDescripcion ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdTipoInstrumentoLegal] = $row->vcDescripcion;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }
}

// EOF provincias_model.php
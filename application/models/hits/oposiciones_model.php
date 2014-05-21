<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Noticias Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Oposiciones_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_encuestas
            WHERE nombreOposicion LIKE ? 
            ORDER BY idOposicion ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idOposicion) AS inCant FROM hits_view_encuestas WHERE lower(CONCAT_WS(" ", nombreOposicion)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_view_encuestas WHERE idOposicion = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT hits_sp_oposiciones_guardar(?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function dropdownEstadosEncuestas() {
        $sql = 'SELECT * FROM hits_oposiciones_estados WHERE idOposicionEstado = 1 or idOposicionEstado = 2';
        $query = $this->db->query($sql)->result();
        $estados[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $estados[$row->idOposicionEstado] = $row->nombreOposicionEstado; 
        }
        return $estados;
    }
}

// EOF provincias_model.php
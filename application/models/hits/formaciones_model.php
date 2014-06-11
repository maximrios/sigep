<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo Provincias
 * 
 * @package base
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Formaciones_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $order='', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * 
        FROM hits_view_formaciones
        WHERE nombreFormacionTitulo LIKE ? 
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * 
                FROM hits_view_formaciones
                WHERE idFormacion = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idFormacion) AS inCant FROM hits_view_formaciones
        WHERE nombreFormacionTitulo LIKE ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function guardar($aParms) {
        $sql = 'SELECT hits_sp_formaciones_guardar(?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function eliminar($id) {
        $sql = 'DELETE FROM hits_formaciones WHERE idFormacion = ? ';
        $result = $this->db->query($sql, $id);
        return TRUE;
    }
    public function obtenerUnoPersona($idPersona) {
        $sql = 'SELECT * 
                FROM hits_view_formaciones
                WHERE idPersona = ? 
                ORDER BY idFormacionTipo DESC
                LIMIT 1;';
        return array_shift($this->db->query($sql, array($idPersona))->result_array());
    }
    public function dropdownTitulos() {
        $sql = 'SELECT * FROM hits_formaciones_titulos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un titulo ...';
        foreach($query as $row) {
            $subgrupos[$row->idFormacionTitulo] = $row->nombreFormacionTitulo; 
        }
        return $subgrupos;
    }
    public function dropdownAvances() {
        $sql = 'SELECT * FROM hits_formaciones_avances';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione el avance ...';
        foreach($query as $row) {
            $subgrupos[$row->idFormacionAvance] = $row->nombreFormacionAvance; 
        }
        return $subgrupos;
    }
    public function dropdownNiveles() {
        $sql = 'SELECT * FROM hits_formaciones_tipos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione el nivel ...';
        foreach($query as $row) {
            $subgrupos[$row->idFormacionTipo] = $row->nombreFormacionTipo; 
        }
        return $subgrupos;
    }
}

// EOF provincias_model.php
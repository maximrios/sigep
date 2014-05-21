<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cargos Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Cuadrocargos_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM sigep_view_cuadrocargosagentes
            WHERE denominacionCargo LIKE ? 
            ORDER BY ordenCuadroCargo ASC
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idCuadroCargo) AS inCant FROM sigep_view_cuadrocargosagentes WHERE lower(idCuadroCargo) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM sigep_view_cuadrocargosagentes WHERE idCuadroCargo = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_cuadrocargos_guardar(?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'UPDATE sigep_cargos SET estadoCargo = 0  WHERE idCargo = '.$id.';';
        $result = $this->db->query($sql, array($id));
        return 1;
    }
}

// EOF cargos_model.php
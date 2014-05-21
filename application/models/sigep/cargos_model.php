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
class Cargos_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM sigep_view_cargos
            WHERE denominacionCargo LIKE ? 
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idCargo) AS inCant FROM sigep_view_cargos WHERE lower(denominacionCargo) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM sigep_view_cargos WHERE idCargo = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_cargos_guardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'UPDATE sigep_cargos SET estadoCargo = 0  WHERE idCargo = '.$id.';';
        $result = $this->db->query($sql, array($id));
        return 1;
    }

    public function dropdownCargosFiltro() {
        $sql = 'SELECT * FROM sigep_cargos';
        $query = $this->db->query($sql)->result();
        $funciones[0] = 'Todos';
        foreach($query as $row) {
            $funciones[$row->idCargo] = $row->denominacionCargo; 
        }
        return $funciones;
    }

    public function obtenerAutocompleteCargos($vcBuscar) {
        $sql = 'SELECT *
            FROM sigep_view_cargos
            WHERE denominacionCargo LIKE ?';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $new_row['label']=htmlentities(stripslashes($row['denominacionCargo']));
                $new_row['value']=htmlentities(stripslashes($row['denominacionCargo']));
                $new_row['id']=htmlentities(stripslashes($row['idCargo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set);
        }
    }
}

// EOF cargos_model.php
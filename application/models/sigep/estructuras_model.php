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
class Estructuras_model extends CI_Model {

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
        $sql = 'SELECT * FROM sigep_view_estructuras WHERE idEstructura = ?;';
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

    public function obtenerAutocomplete($vcBuscar) {
        $sql = 'SELECT *
            FROM sigep_view_estructuras
            WHERE nombreEstructura LIKE ?';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $new_row['label']=htmlentities(stripslashes($row['nombreEstructura']));
                $new_row['value']=htmlentities(stripslashes($row['nombreEstructura']));
                $new_row['id']=htmlentities(stripslashes($row['idEstructura']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set);
        }
    }
    public function dropdownEstructuras() {
        $sql = 'SELECT * FROM sigep_estructuras ORDER BY leftEstructura';
        $query = $this->db->query($sql)->result();
        foreach($query as $row) {
            $estados[$row->idEstructura] = $row->nombreEstructura; 
        }
        return $estados;
    }
    
    public function obtenerUnoIud($iud) {
        $sql = 'SELECT * FROM sigep_view_estructuras WHERE iudEstructura = ?;';
        return array_shift($this->db->query($sql, array((int) $iud))->result_array());
    }
}

// EOF cargos_model.php
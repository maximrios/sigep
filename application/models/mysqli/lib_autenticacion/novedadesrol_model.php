<?php

/**
 * @package default
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class NovedadesRol_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $inIdRol = null, $limit = 0, $offset = 9999999) {
        $sql = 'CALL hits_sp_novedades_rol(? ,null ,? ,? );';
        return $this->db->query($sql, array(strtolower($vcBuscar), (double) $limit, (double) $offset))->result_array();
    }

    public function leer($vcBuscar, $inIdRol = null, $limit = 0, $offset = 9999999) {
        $sql = 'CALL hits_sp_novedades_rol(? ,null ,? ,? );';
        return $this->db->query($sql, array(strtolower($vcBuscar), (double) $limit, (double) $offset))->result_array();
    }

    public function numRegs($vcBuscar, $inIdRol = null) {
        $sql = 'SELECT hits_sp_novedades_rol_num(? ,null ) as inCant;';
        $result = $this->db->query($sql, array(strtolower($vcBuscar)))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        return array_shift($this->db->query('CALL ufn30tsisnovedadesrolobtreg(? )', array((double) $id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsisnovedadesrolguardar(? ,? ,? ,? ,? ,? ,?) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisnovedadesrolborrar(? ) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

}

// EOF novedadesrole_model.php
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo Paises
 * 
 * @package base
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class Paises_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * FROM tsispaises WHERE lower(vcPaisNombre) LIKE ? ORDER BY vcPaisNombre ASC LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdPais) AS inCant FROM tsispaises WHERE lower(vcPaisNombre) LIKE ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        return array_shift($this->db->get_where('tsispaises', array('inIdPais' => (double) $id), 1, 0)->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsispaisesguardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsispaisesborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

}

// EOF paises_model.php
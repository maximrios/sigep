<?php

/**
 * @package default
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */

class Estados_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * FROM tsegestados WHERE lower(CONCAT_WS(" ",vcSegEstDesc, vcSegEstCod)) LIKE ? ORDER BY vcSegEstDesc ASC LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdSegEstado) AS inCant FROM tsegestados WHERE lower(CONCAT_WS(" ",vcSegEstDesc, vcSegEstCod)) LIKE ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        return array_shift($this->db->get_where('tsegestados', array('inIdSegEstado' => (double) $id), 1, 0)->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsegestadosguardar(? ,? ,? ,? ) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsegestadosborrar(? ) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerTodosDdl() {
        $rsRegs = $this->obtener('');
        $aResult = array();
        foreach ($rsRegs as $Reg) {
            $aResult[$Reg['inIdRol']] = $Reg['vcRolNombre'];
        }
        return $aResult;
    }

}

// EOF roles_model.php
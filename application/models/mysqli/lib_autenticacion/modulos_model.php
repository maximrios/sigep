<?php

/**
 * Modulos_model class
 *
 * @package default
 * @author  Silvia Farfan
 * @version MySql 1.0.0
 * 
 * Adaptado a MySql por Nacho Fassini
 */
class Modulos_model extends CI_Model {

    function __constructor() {
        parent::__construct();
    }

    public function obtener($vcCaracterProf = '', $boEsMenu = null) {
        $aParms = array($vcCaracterProf, ($boEsMenu != null) ? (($boEsMenu == true) ? 't' : 'f') : null);
        $query = 'CALL hits_sp_modulos_obtener(? ,? );';
        /*$query = 'CALL ufn30tsegmodulosobtarbolu(? ,? );';*/
        return $this->db->query($query, $aParms)->result_array();
    }

    public function busqueda($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * FROM tsegmodulos WHERE lower(CONCAT_WS(" ",vcModNombre, vcModUrl, vcModTitulo) LIKE ? ORDER BY vcModNombre ASC LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdModulo) AS inCant FROM tsegmodulos WHERE lower(CONCAT_WS(" ",vcModNombre, vcModUrl, vcModTitulo) LIKE ?;';
        $result = $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%'))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        return array_shift($this->db->get_where('tsegmodulos', array('inIdModulo' => (double) $id), 1, 0)->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsegmodulosguardar(? ,? ,? ,? ,? ,? ,? ,? ) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsegmodulosborrar(?) as ufn30tsegmodulosborrar;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result;
    }

    public function obtenerHijos($id, $vcCaracterProf = '') {
        $aParms = array(
            $id
            , $vcCaracterProf
        );
        $sql = 'CALL ufn30tsegmodulosobthijos(? ,? );';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result;
    }

    public function obtenerTodosNodos($id) {
        $rsRegs = $this->obtener('&nbsp;&nbsp;-&nbsp;&nbsp;');
        $aResult = array();
        foreach ($rsRegs as $Reg) {
            if ($Reg['inIdModulo'] != $id)
                $aResult[$Reg['inIdModulo']] = $Reg['vcModNombre'];
        }
        return $aResult;
    }

    public function obtenerPadres($id, $vcCaracterProf = '') {
        $aParms = array(
            $id
            , $vcCaracterProf
        );
        $sql = 'CALL ufn30tsegmodulosobtpadres(? ,? );';
        return $this->db->query($sql, $aParms)->result_array();
    }

    public function obtenerTodosPadres($id) {
        $rsRegs = $this->obtenerPadres($id, '&nbsp;&nbsp;-&nbsp;&nbsp;');
        $aResult = array();
        foreach ($rsRegs as $Reg) {
            if ($Reg['inIdModulo'] != $id)
                $aResult[$Reg['inIdModulo']] = $Reg['vcModNombre'];
        }
        return $aResult;
    }

}

?>
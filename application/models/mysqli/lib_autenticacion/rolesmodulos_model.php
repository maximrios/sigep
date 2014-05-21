<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Duran Francisco Javier
 * @version MySql 1.0.0
 * @copyright 2011-12
 * @package base
 * 
 * Adapatado a MySql por Nacho Fassini
 */
class Rolesmodulos_model extends CI_Model {

    function __constructor() {
        parent::__construct();
    }

    public function obtenerUno($inId) {
        
    }

    public function obtenerPermisosMenu($inIdRol) {
        $aParms = array(
            (int) $inIdRol
        );
        $query = 'CALL ufn30tsegrolesmodulosobtarbolu(? );';
        return $this->db->query($query, $aParms)->result_array();
    }

    public function obtener($vcCaracterProf = '', $inIdRol = 0) {
        $aParms = array(
            $vcCaracterProf
            , $inIdRol
        );
        $query = 'CALL ufn30tsegrolesmodulosobt(? ,? );';
        return $this->db->query($query, $aParms)->result_array();
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsegrolesmodulosguardar(? ,? ,? ,? ,? ,? ,? ) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function obtenerRoles() {
        $sql = 'SELECT * FROM hits_usuarios_roles ORDER BY nombreRol;';
        $result = $this->db->query($sql);
        return $result->result_array();
    }

}

?>
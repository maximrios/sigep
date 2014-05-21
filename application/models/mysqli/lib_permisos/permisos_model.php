<?php

/**
 * @author Marcelo
 * @copyright 2012
 * @category Modelo
 * @version MySql 1.0.0
 * 
 * Adaptado a MySql por Nacho Fassini
 */
class Permisos_Model extends CI_Model {

    /**
     * Permisos_Model::uriPermitida()
     * 
     * @param string $vcUri
     * @param integer $inIdRol
     * @return boolean 
     */
    public function uriPermitida($vcUri='', $inIdRol=0) {
        $aParam = array(
            $vcUri
            , (int) $inIdRol
        );
        $sql = 'CALL ufn30uripermitida(? ,?) as rta';
        $aReg = $this->db->query($sql, $aParam)->result_array();
        $rta = (bool) $aReg[0]['rta'];
        return ($rta == 1) ? true : false;
    }

    /**
     * Permisos_Model::obtenerPermisosPorRol()
     * 
     * @param string $vcUri un cadena de uri separadas por comas Ej: 'controlador/metodo, controlador/metodo2,..../controlador/metodos'
     * @param integer $inIdRol
     * @return Retorna un aReg de uri permitidas segun el rol
     */
    public function obtenerPermisosPorRol($vcUri='', $inIdRol) {
        $aParam = array(
            $vcUri
            , (int) $inIdRol
        );
        $sql = 'SELECT hits_sp_permisos_rol_obtener(? ,?) as permisos;';
        $aReg = $this->db->query($sql, $aParam)->result_array();

        return (sizeof($aReg) == 0) ? array() : $aReg[0]['permisos'];
    }

}

//fin de la clase
// EOF permisos-model.php
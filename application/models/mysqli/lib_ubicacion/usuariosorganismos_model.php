<?php
/**
 * @package default
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class UsuariosOrganismos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function obtOrganismos($inIdUsuario) {
        $aParms = array(
            $inIdUsuario
        );
        $query = 'CALL ufn30tsegusuariosobtorganismos(?);';

        return $this->db->query($query, $aParms)->result_array();
    }

    public function obtOrganismosArray($inIdUsuario) {
        $rsRegs = $this->obtOrganismos($inIdUsuario);
        $aRet = array();
        foreach ($rsRegs as $Reg) {
            $aRet[$Reg['inIdOrganismo']] = $Reg['vcOrgDescripcion'];
        }
        return $aRet;
    }

    public function obtOrganismo($inIdOrganismo, $inIdUsuario) {
        $aParms = array(
            $inIdUsuario
            , $inIdOrganismo
        );
        $query = 'CALL ufn30tsegusuariosobtorganismo(?, ?);';
        $reg = array();
        $rs = $this->db->query($query, $aParms)->result_array();
        if (sizeof($rs) > 0) {
            $reg = $rs[0];
        }
        return $reg;
    }

    public function obtCaminoOrg() {
        $query = 'SELECT distinct padre.* 
                            FROM torgorganismos padre, torgorganismos nodo
                            WHERE 
                                padre.inOrgLft > 0
                                AND padre.inOrgLft <= nodo.inOrgLft
                                AND padre.inOrgRgt >= nodo.inOrgLft
                                AND nodo.inIdOrganismo = ?
                            ORDER BY padre.inOrgLft ASC';
    }

}

?>
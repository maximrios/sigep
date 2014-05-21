<?php

/**
 * Pin_model class
 *
 * @package suap
 * @author  Marcelo Gutierrez
 * @copyright 2012-01-03
 */
class Pin_model extends CI_Model {

    function __constructor() {
        parent::__constructor();
    }

    public function validar($inIdUsr, $vcPIN, $vcIpRequest) {
        $aParms = array($inIdUsr, $vcPIN, $vcIpRequest);
        $query = 'select ufn30tsegusuariosvalidarpin(? ,? ,? ) ;';
        $rsRet = $this->db->query($query, $aParms)->result_array();

        return (sizeof($rsRet) > 0) ? $rsRet[0] : false;
    }

}
?>
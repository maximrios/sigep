<?php

/**
 * @package default
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class AdminUsuarios_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $idUsuario, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT usuario.*, estados.*, personas.*, roles.*
                        FROM tsegusuarios AS usuario
                                INNER JOIN tsegestados AS estados ON (usuario.inIdSegEstado = estados.inIdSegEstado) 
                                INNER JOIN tperpersonas AS personas ON (usuario.inIdPersona = personas.inIdPersona) 
                                INNER JOIN tsegroles AS roles ON (usuario.inIdRol = roles.inIdRol)                
                                INNER JOIN tsegusuarios AS usuarioactual ON (usuarioactual.inIdUsuario = ?)
                                INNER JOIN tsegroles AS rolactual ON (rolactual.inIdRol = usuarioactual.inIdRol)                                
                        WHERE lower(CONCAT_WS(" ",usuario.vcUsuLogin, personas.vcPerNombre, estados.vcSegEstDesc, roles.vcRolNombre)) LIKE ?
                            AND  rolactual.inRolRango <= roles.inRolRango
                        ORDER BY usuario.vcUsuLogin ASC 
                        LIMIT ? , ?;';
        return $this->db->query($sql, array($idUsuario,strtolower('%' . strtolower($vcBuscar) . '%'), (double) $limit, (double) $offset))->result_array();
    }

    public function numRegs($vcBuscar, $idUsuario) {

        $sql = 'SELECT count(usuario.inIdUsuario) as inCant
                        FROM tsegusuarios AS usuario
                                INNER JOIN tsegestados AS estados ON (usuario.inIdSegEstado = estados.inIdSegEstado) 
                                INNER JOIN tperpersonas AS personas ON (usuario.inIdPersona = personas.inIdPersona) 
                                INNER JOIN tsegroles AS roles ON (usuario.inIdRol = roles.inIdRol)                
                                INNER JOIN tsegusuarios AS usuarioactual ON (usuarioactual.inIdUsuario = ?)
                                INNER JOIN tsegroles AS rolactual ON (rolactual.inIdRol = usuarioactual.inIdRol)                                
                        WHERE lower(CONCAT_WS(" ",usuario.vcUsuLogin, personas.vcPerNombre, estados.vcSegEstDesc, roles.vcRolNombre)) LIKE ?
                                AND  rolactual.inRolRango <= roles.inRolRango;';
        $result = $this->db->query($sql, array($idUsuario, strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT usu.*,
                              per.vcPerNombre,
                              rol.vcRolNombre,
                              est.vcSegEstDesc
                        FROM tsegusuarios AS usu
                                LEFT JOIN tperpersonas AS per ON usu.inIdPersona = per.inIdPersona
                                LEFT JOIN tsegroles AS rol ON usu.inIdRol = rol.inIdRol
                                LEFT JOIN tsegestados AS est ON usu.inIdSegEstado = est.inIdSegEstado
                        WHERE usu.inIdUsuario = ?
                        LIMIT 1';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        //var_dump($aParms);
        $sql = 'SELECT  ufn30tsegusuariosguardar(? ,? ,? ,? ,? ,? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsegusuariosborrar(?) as result;';
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

    public function getPersonaPorDni($dni) {
        $where = array('inPerDni' => (int) $dni);
        $consulta = $this->db->get_where('tperpersonas', $where);
        return $consulta->result_array();
    }

    public function getEstados() {
        $consulta = $this->db->get_where('tsegestados');
        return $consulta->result_array();
    }

    public function getRoles($aParams) {
        if (empty($aParams)) {
            return;
        }

        $sql = 'SELECT t1.* 
                        FROM tsegroles AS t1
                            INNER JOIN tsegroles  AS t2 ON t2.inIdRol = ?
                        WHERE t2.inRolRango <= t1.inRolRango
                        ORDER BY t2.inRolRango;';

        /*
          $sql = 'SELECT t2.*
          FROM "tSegRoles" t1
          INNER JOIN "tSegRoles" t2 ON t2."inRolRango" >= t1."inRolRango"
          WHERE t1."inIdRol"=?::integer
          ORDER BY t2."inRolRango";';
         */
        return $this->db->query($sql, $aParams)->result_array();
    }

    public function getUsuarioPorId($id) {
        $where = array('inIdUsuario' => (int) $id);
        $consulta = $this->db->get_where('tsegusuarios', $where);
        return $consulta->result_array();
    }

    public function getPersonaPorId($id) {
        $where = array('inIdPersona' => (int) $id);
        $consulta = $this->db->get_where('tperpersonas', $where);
        return $consulta->result_array();
    }

    public function recet_pin($id_usuario) {
        $sql = 'UPDATE tsegusuarios SET inUsuCantIntentosPin = 0  WHERE inIdUsuario = ? ;';
        $result = $this->db->query($sql, array($id_usuario));
        return $result[0]['result'];
    }

    public function guardarPass($parametros) {
        $sql = 'SELECT ufn30tsegusuariosmodificarpass(? ,? ) AS result;';
        $result = $this->db->query($sql, $parametros)->result_array();
        return $result[0]['result'];
    }

    public function guardarPin($parametros) {
        $sql = 'SELECT ufn30tsegusuariosmodificarpin(? ,? ) as result;';
        $result = $this->db->query($sql, $parametros)->result_array();
        return $result[0]['result'];
    }

    public function get_usuarioYmail($id_usuario) {
        $sql = 'SELECT * 
                        FROM tsegusuarios as tu 
                            INNER JOIN tperpersonas as tp ON tu.inIdPersona = tp.inIdPersona
                        WHERE inIdUsuario = ? ;';
        $consulta = $this->db->query($sql, array((int) $id_usuario));
        $array = $consulta->result_array();
        foreach ($array as $fila) {
            break;
        }
        return $fila;
    }

    public function tomarPersona($id) {
        $where = array('inIdPersona' => (int) $id);
        $consulta = $this->db->get_where('tperpersonas', $where);
        $array = $consulta->result_array();
        foreach ($array as $fila) {
            return $fila['vcPerNombre'];
            break;
        }
    }

}
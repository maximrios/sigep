<?php

/**
 * @author Duran Francisco Javier
 * @version MySql 1.0.0
 * @copyright 2011-12
 * @package base
 * 
 * Adaptado a MySql por Nacho Fassini
 */
class Personas_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * 
                        FROM v30perpersonas as v
                        WHERE concat(lower(v.vcPerNombre),lower(v.inPerDni)) like ? 
                        ORDER BY vcPerNombre ASC
                        limit ? offset ?;';
        //$sql = 'select * from "v30PerPersonas" where lower("vcPerNombre"||"inPerDni") like ? order by "vcPerNombre" asc limit ? offset ?;';
        //$aux = str_replace(' ','%\' \'%',strtolower($vcBuscar));
        //$aux = 'lower(CONCAT_WS("",vcPerNombre, inPerDni)) like \'%'.str_replace(' ',' or lower(CONCAT_WS("",vcPerNombre, inPerDni)) like ',strtolower($aux)).'%\'';
        //$sql = 'select * from v30PerPersonas where '.$aux.' order by vcPerNombre asc limit ? offset ?;';
        //echo $sql;
        //return $this->db->query($sql,array($offset,$limit))->result_array();
        //echo $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit));
        return $this->db->query($sql, array('%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdPersona) AS inCant FROM tperpersonas WHERE lower(vcPerNombre) like ?;';
        //En la query de abajo no funciona el concat_ws. la de abajo es la original, la de arriba funciona. 
        //$sql = 'SELECT count(inIdPersona) AS inCant FROM tperpersonas WHERE lower(CONCAT_WS(" ",vcPerNombre, inPerDni)) like ?;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'CALL ufn30tperpersonasobt(?);';
        $result = $this->db->query($sql, array($id))->result_array();
        return array_shift($result);
    }

    public function guardar($aParms) {
        //print_r($aParms);
        //Parametros = ( ?::integer,?::integer,?::integer,?::integer,?::bigint,?::character varying,?::date,?::character varying,?::character varying,?::character varying,?::character varying,?::character varying,?::character varying,?::character varying,?::character varying,?::character varying,?::integer,?::integer,?::integer,?::integer) as result;';
        $sql = 'SELECT ufn30tperpersonasguardar( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tperpersonasborrar(? ) as result;';
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

    public function obtenerTipDoc() {
        $sql = 'SELECT * FROM tpertipodocumento ORDER BY vcPerTipoDocDesc;';
        $result = $this->db->query($sql);
        $resultSimple = array();
        foreach ($result->result() as $row) {
            $resultSimple[$row->inIdPerTipoDoc] = $row->vcPerTipoDocDesc;
        }
        return $resultSimple;
    }

    public function obtenerEstCiv() {
        $sql = 'SELECT * FROM tperestadocivil ORDER BY vcEstCivDesc;';
        $result = $this->db->query($sql);
        $resultSimple = array();
        foreach ($result->result() as $row) {
            $resultSimple[$row->inIdEstadoCivil] = $row->vcEstCivDesc;
        }
        return $resultSimple;
    }

}

//EOF personas_model.php
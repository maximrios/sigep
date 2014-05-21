<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mensajes Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Mensajes_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_mensajes
            WHERE busqueda LIKE ? 
            ORDER BY idTipoMensaje ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idMensaje) AS inCant FROM hits_view_mensajes WHERE lower(CONCAT_WS(" ", asuntoMensaje, textoMensaje)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_view_mensajes WHERE idMensaje = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function cambiarEstado($aParms) {
        $sql = 'UPDATE hits_mensajes SET estadoMensaje = ? WHERE idMensaje = ?;';
        $result = $this->db->query($sql, $aParms);
        return $this->db->affected_rows();
    }
    public function guardar($aParms) {
        $sql = 'SELECT hits_sp_mensajes_guardar(?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerInstrumentos() {
        $sql = 'SELECT * FROM ttipoinstrumentolegal ORDER BY vcDescripcion;';
        $result = $this->db->query($sql);
        $resultSimple = array();
        foreach ($result->result() as $row) {
            $resultSimple[$row->inIdTipoInstrumentoLegal] = $row->vcDescripcion;
        }
        return $resultSimple;
    }
    public function ObtInstrumentos($simple=true) {
        $this->db->select('inIdTipoInstrumentoLegal, vcDescripcion')->from('ttipoinstrumentolegal')->order_by('vcDescripcion ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdTipoInstrumentoLegal] = $row->vcDescripcion;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }
}

// EOF provincias_model.php
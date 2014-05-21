<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Noticias Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Cuestionarios_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_noticias
            WHERE busqueda LIKE ? 
            ORDER BY idTipoNoticia ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idNoticia) AS inCant FROM hits_view_noticias WHERE lower(CONCAT_WS(" ", tituloNoticia, descripcionNoticia)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_view_noticias WHERE idNoticia = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT hits_sp_noticias_guardar(?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    /*
     * Comentarios
     */
    public function obtenerComentario($comentario) {
        $sql = "SELECT * FROM hits_view_noticias_comentarios 
        WHERE idNoticiaComentario = ?";
        return array_shift($this->db->query($sql, array($comentario))->result_array());
    }
    public function obtenerComentarios($noticia) {
        $sql = "SELECT * FROM hits_view_noticias_comentarios 
        WHERE idNoticia = ?
        ORDER BY fechaNoticiaComentario DESC
        LIMIT 0, 5";
        return $this->db->query($sql, $noticia)->result_array();
    }
    public function guardarComentario($aParams) {
        $sql = 'SELECT hits_sp_noticia_comentario_guardar(?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParams)->result_array();
        return $result[0]['result'];
    }

    /*public function obtenerInstrumentos() {
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
    }*/
}

// EOF provincias_model.php
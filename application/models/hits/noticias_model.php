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
class Noticias_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_noticias
            WHERE busqueda LIKE ? 
            ORDER BY inicioNoticia DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function obtenerNoticias($limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_noticias
            WHERE publicadoNoticia = 1
            ORDER BY inicioNoticia DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array((double) $offset, (double) $limit))->result_array();
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

    public function cambiarEstado($aParms) {
        $sql = 'UPDATE hits_noticias SET publicadoNoticia = ? WHERE idNoticia = ?;';
        $result = $this->db->query($sql, $aParms);
        return TRUE;   
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function dropdownNoticiasTipos() {
        $sql = 'SELECT * FROM hits_tipo_noticias';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $subgrupos[$row->idTipoNoticia] = $row->nombreTipoNoticia; 
        }
        return $subgrupos;
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
}

// EOF noticias_model.php
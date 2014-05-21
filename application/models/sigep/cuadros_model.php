<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cargos Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Cuadros_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM sigep_view_cuadros
            WHERE instrumentoCuadro LIKE ? 
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idCuadro) AS inCant FROM sigep_view_cuadros WHERE lower(instrumentoCuadro) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM sigep_view_cuadros WHERE idCuadro = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function obtenerVigente() {
        $sql = 'SELECT * FROM sigep_view_cuadros WHERE estadoCuadro = 1;';
        return array_shift($this->db->query($sql)->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_cuadros_guardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'UPDATE sigep_cuadros SET estadoCuadro = 0  WHERE idCuadro = '.$id.';';
        $result = $this->db->query($sql, array($id));
        return 1;
    }

    public function dropdownSubgrupos() {
        $sql = 'SELECT * FROM sigep_subgrupos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $subgrupos[$row->idSubgrupo] = $row->nombreSubgrupo; 
        }
        return $subgrupos;
    }
    public function dropdownEquivalentes() {
        $sql = 'SELECT * FROM sigep_equivalentes';
        $query = $this->db->query($sql)->result();
        $equivalentes[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $equivalentes[$row->idEquivalente] = $row->denominacionEquivalente; 
        }
        return $equivalentes;
    }
    public function dropdownAgrupamientos() {
        $sql = 'SELECT * FROM sigep_agrupamientos';
        $query = $this->db->query($sql)->result();
        $agrupamientos[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $agrupamientos[$row->idAgrupamiento] = $row->nombreAgrupamiento; 
        }
        return $agrupamientos;
    }
    public function dropdownEscalafones() {
        $sql = 'SELECT * FROM sigep_escalafones';
        $query = $this->db->query($sql)->result();
        $funciones[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $funciones[$row->idEscalafon] = $row->nombreEscalafon; 
        }
        return $funciones;
    }
    public function dropdownFunciones() {
        $sql = 'SELECT * FROM sigep_funciones';
        $query = $this->db->query($sql)->result();
        $funciones[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $funciones[$row->idFuncion] = $row->nombreFuncion; 
        }
        return $funciones;
    }
}

// EOF cargos_model.php
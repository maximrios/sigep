<?php

/**
 * @FAQ class
 * @package Default
 * @author  Nacho Fassini
 * @copyright 2012-01
 * @version MySql 1.0.0
 */
class Faq_model extends CI_Model {

    function __constructor() {
        
    }

//Busca todas las preguntas y puefe filtrar por tema en caso de existir un id de tema
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'CALL hits_sp_faqs_obtener(? ,? ,? );';
        return $this->db->query($sql, array(strtolower($vcBuscar), (double) $limit, (double) $offset))->result_array();
    }

    //Obtiene las preguntas ordenadas por cantidad de lecturas
    public function obtenerPorLecturas($offset = 0, $limit = 9999999) {
        $sql = 'SELECT   idFaq, nombreFaqTema, preguntaFaq, respuestaFaq, estadoFaq, idFaqTema
                        FROM hits_view_faqs as v
                        WHERE v.estadoFaq = 1
                        LIMIT ? OFFSET ? ;';
        return $this->db->query($sql, array((double) $limit, (double) $offset))->result_array();
    }

//Obtiene un array con todos los temas de preguntas
    public function obtTemas() {
        $sql = 'SELECT DISTINCT * FROM hits_faqs_temas;';
        return $this->db->query($sql)->result_array();
    }

//Lista de temas para un menu desplegable
    public function obtTemasDdl($boAddEmpty = false, $boAddTemasDesactivados = true) {
        $rsRegs = $this->obtTemas();
        $aResult = array();
        if ($boAddEmpty == TRUE) {
            $aResult[''] = 'Seleccionar...';
        }
        foreach ($rsRegs as $Reg) {
            if ($boAddTemasDesactivados == false) {
                ($Reg['bActivo'] == 't') ? $aResult[$Reg['inIdTemaFaq']] = $Reg['vcTemaFaq'] : '';
            } else {
                $aResult[$Reg['inIdTemaFaq']] = $Reg['vcTemaFaq'];
            }
        }
        return $aResult;
    }

//Cantidad de preguntas
    public function numRegs($vcBuscar, $inIdTemaFaq = 0) {
        $sql = 'select ufn30tsisfaqnumregs(?, ?) as inCant;';
        $result = $this->db->query($sql, array(strtolower($vcBuscar), (double) $inIdTemaFaq))->result_array();
        return $result[0]['inCant'];
    }

    //Cantidad de temas que existen
    public function obtCantTemas() {
        $sql = 'SELECT DISTINCT * FROM tsistemafaq ;';
        return sizeof($this->db->query($sql)->result_array());
    }

//Obtiene un array con los datos de una pregunta
    public function obtenerUno($id) {
        return array_shift($this->db->query('CALL ufn30tsisfaqobtreg(? )', array((double) $id))->result_array());
    }

//Obtiene un array con los datos del tema buscado
    public function obtUnTema($inIdTemaFaq = 0) {
        $sql = 'SELECT * FROM tsistemafaq WHERE inIdTemaFaq = ? ;';
        return array_shift($this->db->query($sql, (double) $inIdTemaFaq)->result_array());
    }

//Guarda cambios en una pregunta o una nueva pregunta  devuelve el id creado
    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsisfaqguardar(? ,? ,? ,? ,? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function guardarTema($aParms) {
        $sql = 'SELECT ufn30tsistemafaqguardar(? ,? ,? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

//Elimina la pregunta cuyo id es pasado como parametro
    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisfaqborrar(? ) as result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function eliminarTema($id) {
        $sql = 'SELECT ufn30tsistemafaqborrar(? ) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function sumarLectura($id=0) {
        $sql = 'UPDATE tsisfaq SET inCantLecturas = inCantLecturas +1 WHERE inIdFaq = ? ;';
        return ($this->db->query($sql, (double) $id)) ? true : false;
    }

    public function reiniciarLecturas($id=0) {
        $sql = 'UPDATE tsisfaq SET inCantLecturas = 1 WHERE inIdFaq = ? ;';
        return $this->db->query($sql, (double) $id);
    }

}

//EOF FAQ_Model
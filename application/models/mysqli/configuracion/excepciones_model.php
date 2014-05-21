<?php

/**
 * @author Marcelo Gutierrez
 * @version MySql 1.0.0
 * @copyright 2011-12-19
 * @package base 
 * 
 * Adaptado a MySql por Nacho Fassini
 * 
 * Modelo encargado de gestionar la tabla tSisExcepciones donde se guardan los mensajes de error codificados con valores negativos.
 * Del -1 al -100 errores del motor de base de datos
 * A partir del -101 errores específicos del sistema.
 */
class Excepciones_model extends CI_Model {

    function __construct() {
        
    }

    public function obtenerUnoPorCodigo($inExpCodigo) {
        return array_shift($this->db->get_where('tsisexcepciones', array('inExpCodigo' => (double) $inExpCodigo), 1, 0)->result_array());
    }

}

?>
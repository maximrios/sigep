<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Ivan Soliz
 * @copyright 2011
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class Localizacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function ObtPaises($simple=true) {
        $this->db->select('inIdPais, vcPaisNombre')->from('tsispaises')->order_by('vcPaisNombre ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdPais] = $row->vcPaisNombre;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }

    public function ObtProvincias($inIdPais, $simple=true) {
        $this->db->select('inIdProvincia, vcProNombre')->from('tsisprovincias')->where('inIdPais', $inIdPais)->order_by('vcProNombre ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdProvincia] = $row->vcProNombre;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }

    public function ObtLocalidades($inIdProvincia, $simple=true) {
        $this->db->select('inIdLocalidad, vcLocNombre')->from('tsislocalidades')->where('inIdDepartamento', $inIdProvincia)->order_by('vcLocNombre ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdLocalidad] = $row->vcLocNombre;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }

    public function ObtLocalidadesPorDep($inIdDepartamento, $simple=true) {
        $this->db->select('inIdLocalidad, vcLocNombre')->from('tsislocalidades')->where('inIdDepartamento', $inIdDepartamento)->order_by('vcLocNombre ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdLocalidad] = $row->vcLocNombre;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }

    public function ObtDepartamentos($inIdProvincia, $simple=true) {
        $this->db->select('inIdDepartamento, vcDepNombre')->from('tsisdepartamentos')->where('inIdProvincia', $inIdProvincia)->order_by('vcDepNombre ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdDepartamento] = $row->vcDepNombre;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }

}

//fin de la clase
?>
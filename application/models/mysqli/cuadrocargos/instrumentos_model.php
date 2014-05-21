<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo Provincias
 * 
 * @package base
 * @copyright 2012
 * @version MySql 1.0.0
 * 
 * Adaptado a  MySql por Nacho Fassini
 */
class Provincias_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT pr.inIdProvincia, pr.inIdPais, pr.vcProNombre, pa.vcPaisNombre 
                        FROM ttipoinstrumentolegal AS til
                        WHERE lower(CONCAT_WS(" ",pa.vcPaisNombre, pr.vcProNombre)) LIKE ? 
                        ORDER BY pa.vcPaisNombre ASC, pr.vcProNombre ASC  
                        limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(inIdProvincia) AS inCant 
                        FROM tsisprovincias AS pr 
                            INNER JOIN tsispaises  AS pa ON pr.inIdPais = pa.inIdPais
                        WHERE lower(CONCAT_WS(" ",pa.vcPaisNombre,pr.vcProNombre)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT pr.inIdProvincia, pr.inIdPais, pr.vcProNombre, pa.vcPaisNombre 
                        FROM tsisprovincias AS pr
                            INNER JOIN tsispaises  AS pa ON pr.inIdPais = pa.inIdPais 
                        WHERE pr.inIdProvincia = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsisprovinciasguardar(?, ?, ?) AS result;';
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
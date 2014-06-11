<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Agentes Model
 * 
 * @package sigep
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Agentes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('sigep/estructuras_model', 'estructura');
    }

    public function obtener($vcBuscar = '', $area = 1, $cargo = 0, $limit = 0, $offset = 9999999) {
        ($area == 0)? $area=1:$area=$area;
        ($cargo == 0)? $cargos = '':$cargos = 'AND idCargo = '.$cargo.' ';
        $estructura = $this->estructura->obtenerUno($area);
        $sql = 'SELECT *
            FROM sigep_view_agentes
            WHERE busqueda LIKE ? AND leftArea >= '.$estructura['leftEstructura'].' AND rightArea <= '.$estructura['rightEstructura'].' '.$cargos.' AND vigenteCuadroCargoAgente = 1
            ORDER BY apellidoPersona
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar, $area=1, $cargo=0) {
        ($area == 0)? $area=1:$area=$area;
        ($cargo == 0)? $cargos = '':$cargos = 'AND idCargo = '.$cargo.' ';
        $estructura = $this->estructura->obtenerUno($area);
        $sql = 'SELECT count(idAgente) AS inCant FROM sigep_view_agentes WHERE lower(busqueda) LIKE ? AND vigenteCuadroCargoAgente = 1;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * FROM sigep_view_agentes WHERE idAgente = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function obtenerDni($dni) {
        $sql = 'SELECT * FROM sigep_view_agentes WHERE dniPersona = ?;';
        return array_shift($this->db->query($sql, array($dni))->result_array());
    }

    public function obtenerAgentePersona($id) {
        $sql = 'SELECT * FROM sigep_view_agentes WHERE idPersona = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_agentes_guardar2(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function organismos($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerAutocompleteAgentes($vcBuscar) {
        $sql = 'SELECT p.idPersona, p.nombrePersona, p.apellidoPersona, concat_ws(", ", p.apellidoPersona, p.nombrePersona) as nombreCompletoPersona, a.idAgente
            FROM hits_personas p
            INNER JOIN sigep_agentes a ON p.idPErsona = a.idPersona
            WHERE nombrePersona LIKE ? OR apellidoPersona LIKE ? ';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', '%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
                $new_row['label']= 'VACANTE';
                $new_row['value']= 'VACANTE';
                $new_row['id']= 0;
                $row_set[] = $new_row;
            foreach ($query->result_array() as $row){
                $new_row['label']=stripslashes($row['nombreCompletoPersona']);
                $new_row['value']=stripslashes($row['nombreCompletoPersona']);
                $new_row['id']=htmlentities(stripslashes($row['idAgente']));
                $row_set[] = $new_row;
            }
            echo json_encode($row_set);
        }
    }

    public function dropdownAgentes() {
        $sql = 'SELECT * FROM sigep_agentes a
        INNER JOIN hits_personas p on p.idPersona = a.idPersona
        ORDER BY apellidoPersona';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un agente ...';
        foreach($query as $row) {
            $subgrupos[$row->idAgente] = $row->apellidoPersona.', '.$row->nombrePersona; 
        }
        return $subgrupos;
    }

    public function dropdownAgentesP() {
        $sql = 'SELECT p.* FROM sigep_agentes a
        INNER JOIN hits_personas p on p.idPersona = a.idPersona
        ORDER BY apellidoPersona';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un agente ...';
        foreach($query as $row) {
            $subgrupos[$row->idPersona] = $row->apellidoPersona.', '.$row->nombrePersona; 
        }
        return $subgrupos;
    }

    public function dropdownSituacionesRevistas() {
        $sql = 'SELECT * FROM sigep_situacionesrevistas';
        $query = $this->db->query($sql)->result();
        $funciones[0] = 'Seleccione un item...';
        foreach($query as $row) {
            $funciones[$row->idSituacionRevista] = $row->nombreSituacionRevista; 
        }
        return $funciones;
    }
}

// EOF provincias_model.php
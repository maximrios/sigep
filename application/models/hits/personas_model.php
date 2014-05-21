<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personas_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_view_personas
            WHERE busqueda LIKE ? 
            ORDER BY idPersona ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
	function obtenerPersonaId($id) {
		$sql = 'SELECT * FROM hits_view_personas WHERE idPersona = '.$id.' ';
		$result = $this->db->query($sql)->result_array();
		return array_shift($result);
	}
	function obtenerPersonaDni($dni) {
		$sql = 'SELECT * FROM hits_view_personas WHERE dniPersona = '.$dni.' ';
		$result = $this->db->query($sql)->result_array();
		return array_shift($result);
	}
	function obtenerUno($dni) {
		$sql = 'SELECT * FROM sigep_view_personas WHERE dniPersona = '.$dni.' ';
		$result = $this->db->query($sql)->result_array();
		return $result;
	}
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idPersona) AS inCant FROM hits_view_personas WHERE busqueda LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
	function guardar($aParams) {
		$sql = 'SELECT hits_sp_personas_guardar(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) as result;';
        $result = $this->db->query($sql, $aParams)->result_array();
        return $result[0]['result'];
	}
    public function dropdownSexo() {
        $sexos = array(
            0 => 'Seleccione un item...'
            ,1 => 'M'
            , 2 => 'F'
        );
        return $sexos;
    }
    public function dropdownEstadoCivil() {
        $sql = 'SELECT * FROM hits_ecivil';
        $query = $this->db->query($sql)->result();
        $estados[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $estados[$row->idEcivil] = $row->nombreEcivil; 
        }
        return $estados;
    }
	public function obtenerAutocompletePersonas($vcBuscar) {
        $sql = 'SELECT *
            FROM hits_view_personas
            WHERE nombrePersona LIKE ? AND idPersona NOT IN (SELECT idPersona FROM sigep_view_agentes)';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $new_row['label']=stripslashes($row['apellidoPersona'].', '.$row['nombrePersona']);
                $new_row['value']=stripslashes($row['apellidoPersona'].', '.$row['nombrePersona']);
                $new_row['id']=stripslashes($row['idPersona']);
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set);
        }
    }
}

/* End of file personas_model.php */
/* Location: ./application/models/personas_model.php */
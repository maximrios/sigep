<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function cumpleanos() {
		/*$sql = 'SELECT * FROM sigep_view_personas WHERE nacimientoPersona = "'.date('Y-m-d').'" ';
		$result = $this->db->query($sql)->result_array();
		return $result;*/
	}
	function verificar_cumpleanos($persona) {
		/*$sql = 'SELECT * FROM sigep_view_personas WHERE nacimientoPersona = "'.date('Y-m-d').'" AND dniPersona = '.$persona;
		$result = $this->db->query($sql)->result_array();
		return $result;*/
	}
	function mensajesNuevos($agente=0) {
		/*if($agente > 0) {
			$sql = 'SELECT * FROM hits_view_mensajes WHERE estadoMensaje = 1 and idDestinatario = '.$agente;
			$result = $this->db->query($sql)->result_array();
			return $result;	
		}
		return false;*/
	}

	public function dropdownSexo() {
        //$sql = 'SELECT * FROM hits_sexos';
        //$query = $this->db->query($sql)->result();
        $sexos = array(
        	0 => 'Seleccione un item...'
        	,1 => 'M'
        	, 2 => 'F'
        );
        //$subgrupos[0] = 'Seleccione un item ...';
        //foreach($sexos as $row) {
        //    $subgrupos[$row->idSubgrupo] = $row->nombreSubgrupo; 
        //}
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
}

/* End of file layout_model.php */
/* Location: ./application/models/layout_model.php */
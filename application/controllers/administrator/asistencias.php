<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asistencias extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('asistencias_model', 'asistencia');
	}
	function index() {
		echo "aca andamio";
	}
	function solicitud() {
		echo "todo bien por ahora";
	}
	function perfil() {
		if(!$this->input->post('idPersona')) {
			$data['persona'] = $this->persona->obtenerUnoId($this->session->userdata('idPersona'));
			$data['main_content'] = 'administrator/personas/perfil';
			$this->load->view('administrator/template', $data);
		}
	}
	function cumpleanos($persona) {
		if(count($this->layout_model->verificar_cumpleanos($persona)) > 0) {
			$data['cumpleanero'] = $this->persona->obtenerUno($persona);
			$this->load->view('administrator/personas/cumpleano', $data);
			//$data['main_content'] = 'administrator/personas/cumpleano';
			//$this->load->view('administrator/template', $data);
		}
		else {
			echo "si no es el cumpleanos para que jodes";
		}
	}
}

/* End of file asistencias.php */
/* Location: ./application/controllers/administrator/asistencias.php */
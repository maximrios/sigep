<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller {

	public function index() {
		$data['cumpleanos'] = $this->layout_model->cumpleanos();
		$data['main_content'] = 'administrator/personas/persona';
		$this->load->view('administrator/template', $data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/administrator/home.php */
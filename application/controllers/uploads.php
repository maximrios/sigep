<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uploads extends CI_Controller {
	public function index() {
		parent::__construct();		
	}
	function do_upload() {
		$this->load->library("hits/uploadhandler");
	}

}

/* End of file uploads.php */
/* Location: ./application/controllers/uploads.php */
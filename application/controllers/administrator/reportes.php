<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reportes extends Ext_crud_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('diario/pedidos_model', 'pedidos');
		$this->load->model('diario/lineas_model', 'lineas');
	}
	function index() {
		$this->config->set_item('impreso', $this->session->userdata('username'));
		$this->config->set_item('header_on', FALSE);
		$this->load->view('administrator/sigep/agentes/rPlanilla');
	}
	function detalleCliente() {
		$this->config->set_item('page_orientation', 'P');
		$this->config->set_item('page_format', 'A4');
		$aData['pedidos'] = $this->pedidos->obtener();
        $this->load->view('administrator/diario/reportes/pedidos', $aData);
	}
	function especial() {
		$this->config->set_item('page_orientation', 'P');
		$this->config->set_item('page_format', 'A4');
		$aData['pedidos'] = $this->pedidos->obtener();
        $this->load->view('administrator/diario/reportes/pedidos', $aData);
	}
}
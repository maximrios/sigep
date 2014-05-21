<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
class Inicio extends Ext_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('rosobe/rosobe_model', 'layout');
		$this->load->library('Messages');
        $this->load->helper('utils_helper');
		$this->_aReglas = array(
			array(
	        	'field'   => 'txtnombre',
	            'label'   => 'Nombre',
	            'rules'   => 'trim|max_length[80]|xss_clean|required'
			)
			, array(
	        	'field'   => 'txttelefono',
	            'label'   => 'Telefono',
	            'rules'   => 'trim|max_length[1]|xss_clean|required'
			)
		);
	}
	protected function _inicReglasWeb() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	public function index() {
		$aData = array();
		$aData['slider'] = $this->layout->obtenerSlider();
		$aData['productos'] = $this->layout->obtenerDestacados();
		$this->_SiteInfo['title'] .= ' - Inicio';
		$this->_menu = 'inicio';
		$this->_vcContentPlaceHolder = $this->load->view('inicio', $aData, true);
		parent::index();
	}
	public function nosotros() {
		$aData = array();
		$this->_SiteInfo['title'] .= ' - Nosotros';
		$this->_menu = 'nosotros';
		$this->_vcContentPlaceHolder = $this->load->view('nosotros', $aData, true);
		parent::index();
	}
	public function mayoristas() {
		$aData = array();
		$this->_SiteInfo['title'] .= ' - Mayoristas';
		$this->_menu = 'mayoristas';
		$this->_vcContentPlaceHolder = $this->load->view('productos', $aData, true);
		parent::index();
	}
	public function productos() {
		$aData = array();
		$this->_SiteInfo['title'] .= ' - Productos';
		$this->_menu = 'productos';
		$aData['productos'] = $this->layout->obtenerProductos();
		$this->_vcContentPlaceHolder = $this->load->view('productos', $aData, true);
		parent::index();
	}
	public function producto($slug) {
		$aData = array();
		$this->load->model('rosobe/productos_model', 'productos');
		$aData['producto'] = $this->productos->obtenerUnoSlug($slug);
		if(!$aData['producto']) {
			redirect('inicio/no_producto');
		}
		else {
			$aData['imagenes'] = $this->productos->obtenerImagenes($aData['producto']['idProducto']);
			$aData['productos'] = $this->layout->obtenerRelacionados($aData['producto']['idProducto']);
		}
		$this->_SiteInfo['title'] .= ' - '.$aData['producto']['nombreProducto'];
		$this->_menu = 'productos';
		$this->_vcContentPlaceHolder = $this->load->view('producto', $aData, true);
		parent::index();
	}
	public function no_producto() {
		echo "no existe";
	}
	public function servicios() {
		$aData = array();
		$this->_SiteInfo['title'] .= ' - Servicios';
		$this->_menu = 'servicios';
		$this->_vcContentPlaceHolder = $this->load->view('servicios', $aData, true);
		parent::index();
	}
	public function galeria() {
		$aData = array();
		$aData['galeria'] = $this->layout->obtener_galeria();
		$this->_SiteInfo['title'] .= ' - Galería';
		$this->_menu = 'galeria';
		$this->_vcContentPlaceHolder = $this->load->view('galeria', $aData, true);
		parent::index();
	}
	public function contacto() {
		$this->load->library('hits/googlemaps');
		$config = array();
		$config['center'] = '-24.859007,-65.452682';
		$config['zoom'] = 14;
		$config['directions'] = TRUE;
		
		//$config['directionsStart'] = '-24.782889,-65.41174';
		//$config['directionsStart'] = '-24.847344,-65.46155';
		//$config['directionsEnd'] = '-24.859007,-65.452682';
		//$config['directionsDivID'] = 'prueba';
		
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '-24.859007,-65.452682';
		$marker['title'] = 'INDUSTRIAS y SERVICIOS Ro.So.Be';
		$marker['infowindow_content'] = 'Industrias y Servicios Ro.So.Be';
		$this->googlemaps->add_marker($marker);
		$aData['map'] = $this->googlemaps->create_map();
		$aData['vcMsjSrv']='';
		$this->_SiteInfo['title'] .= ' - Contacto';
		$this->_menu = 'contacto';
		if($this->input->post('form')) {
			$this->_inicReglasWeb();
        	if ($this->_validarReglas()) {
	        	$aData['vcMsjSrv'] = 'Se envio con exito';
        	}
        	else {
	        	$this->_aEstadoOperWeb['status'] = 0;
            	$this->_aEstadoOperWeb['message'] = validation_errors();
            	$aData['vcMsjSrv'] = $this->_aEstadoOperWeb['message'];
        	}
		}
		$this->_vcContentPlaceHolder = $this->load->view('contacto', $aData, true);
		parent::index();
	}
	public function consultar() {
		$this->_inicReglasWeb();
        if ($this->_validarReglas()) {
        	echo "si paso";
        }
        else {
        	$this->_aEstadoOperWeb['status'] = 0;
            $this->_aEstadoOperWeb['message'] = validation_errors();
        }
        if($this->_aEstadoOperWeb['status'] > 0) {
			$this->listado();
		} else {
			//redirect('contacto');
			$this->contacto();
		}
	}
}
?>
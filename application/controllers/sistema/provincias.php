<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * Provincias class
 *
 * @author Duran Francisco Javier
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
class Provincias extends Ext_crud_controller
{
	private $_paises = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/sistema/provincias_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');
		
		$this->_paises = $this->_oModel->obtenerPaises();
		
    	$this->_aReglas = array(
    						   array(
	                              'field'   => 'inIdPais',
	                              'label'   => 'Nombre del Pais',
	                              'rules'   => 'trim|required|xss_clean'
	                          )   
	                          ,array(
	                              'field'   => 'vcProNombre',
	                              'label'   => 'Nombre de la Provincia',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          )
                      );
    	$this->_aBuscar = array(
	                          array(
	                              'field'   => 'vcBuscar',
	                              'label'   => 'Buscar por texto',
	                              'rules'   => 'trim|required|xss_clean|min_length[3]|max_length[50]|callback_onlySearch'
	                          )
                      );
	}
	
	public function index()
	{
		//
		$this->_vcContentPlaceHolder = $this->load->view('sistema/principal-provincias',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdProvincia' => null, 'inIdPais' => null, 'vcProNombre' => ''
		);
		$inId = ($this->input->post('inIdProvincia')!==false)? $this->input->post('inIdProvincia'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
				  'inIdProvincia' => $inId
				, 'inIdPais' => set_value('inIdPais')
				, 'vcProNombre' => set_value('vcProNombre')
			);
		}
		return $this->_reg;
	}
	
	protected function _inicReglas() {
	
    	$val = $this->form_validation->set_rules($this->_aReglas);      		
	}
	
	public function listado() {
		
		$this->form_validation->set_rules($this->_aBuscar);
        if($this->form_validation->run()==FALSE) {
            $vcBuscar = '';
        } else {
            $vcBuscar = ($this->input->post('vcBuscar')===FALSE)?'': $this->input->post('vcBuscar');
        }
		
		$this->gridview->initialize(
			array(
				'sResponseUrl' => 'sistema/provincias/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar)
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 4: $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		
		$this->gridview->addControl('inIdRolCtrl',array('face'=>'<a href="sistema/provincias/formulario/{inIdProvincia}" title="click para editar {vcProNombre}" class="icono-editar btn-accion" rel="{\'inIdProvincia\': {inIdProvincia}}">&nbsp;</a><a href="sistema/provincias/consulta/{inIdProvincia}" title="click para eliminar {vcProNombre}" class="icono-eliminar btn-accion" rel="{\'inIdProvincia\': {inIdProvincia}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));
		
		$this->gridview->addColumn('inIdProvincia','#','int');
		$this->gridview->addColumn('vcPaisNombre','Nombre pais');
		$this->gridview->addColumn('vcProNombre','Nombre provincia');
		
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->_oModel->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		$this->load->view('sistema/lst-provincias'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        		, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
		$this->load->view('sistema/frm-provincias'
			, array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'paises'          => $this->_paises
				, 'vcFrmAction'     => 'sistema/provincias/guardar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdProvincia']>0)? 'Modificar': 'Agregar'
			)
		);
	}
    
	public function consulta() {
		
		$this->load->view('sistema/frm-provincias-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'paises'          => $this->_paises
				, 'vcFrmAction'     => 'sistema/provincias/eliminar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdProvincia']>0)? 'Eliminar': ''
			)
		);
	}
	
	public function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
		$this->_inicReglas();
		
		if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));
			
			$this->_aEstadoOper['status'] = $this->_oModel->guardar(
				array(
					  $this->_reg['inIdProvincia']
					, $this->_reg['inIdPais']
					, $this->_reg['vcProNombre']
				)
			);
			
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
		
		if($this->_aEstadoOper['status'] > 0) {
			$this->listado();
		} else {
			$this->formulario();
		}
	}
	
	public function eliminar() {
		antibotCompararLlave($this->input->post('vcForm'));      
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdProvincia'));
	   	if($this->_aEstadoOper['status'] > 0) {
			$this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
	   	} else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	   	}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));		
		
       	$this->listado();    
	}
    public function onlySearch($str) {
        $regex = "/^[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\ \-\_\.\@\']*[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/";
        return ($str=='' or preg_match($regex, $str));
    }
}
//EOF provincias.php
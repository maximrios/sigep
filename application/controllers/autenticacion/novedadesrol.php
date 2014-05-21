<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * NovedadesRol class
 *
 * @package base30
 * @author  Marcelo Gutierrez
 * @copyright 2012-01
 */
class NovedadesRol extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/novedadesrol_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');
		
    	$this->_aReglas = array(   
	                          array(
	                              'field'   => 'inIdRol',
	                              'label'   => 'Nombre del Rol',
	                              'rules'   => 'trim|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'tsFechaInicio',
	                              'label'   => 'Fecha de Publicación',
	                              'rules'   => 'trim|required|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'tsFechaCaducidad',
	                              'label'   => 'Fecha de Caducidad',
	                              'rules'   => 'trim|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcNovTitulo',
	                              'label'   => 'Título',
	                              'rules'   => 'trim|required|max_length[256]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcNovResumen',
	                              'label'   => 'Resúmen',
	                              'rules'   => 'trim|max_length[300]|required|max_length[256]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcNovDescripcion',
	                              'label'   => 'Contenido',
	                              'rules'   => 'trim|max_length[5000]|required|max_length[5000]|xss_clean'
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
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-novedadesrol',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdNovedadesRol'=> null, 'inIdRol' => null, 'tsFechaInicio' => null, 'tsFechaCaducidad' => null, 'vcNovTitulo' => '', 'vcNovResumen' => '', 'vcNovDescripcion' => ''
		);
		$inId = ($this->input->post('inIdNovedadesRol')!==false)? $this->input->post('inIdNovedadesRol'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
			$this->_reg['tsFechaInicio'] = GetDateFromISO($this->_reg['tsFechaInicio'],FALSE);
			$this->_reg['tsFechaCaducidad'] = GetDateFromISO($this->_reg['tsFechaCaducidad'],FALSE);
		} else {
			$this->_reg = array(
				  'inIdNovedadesRol' => $inId
				, 'inIdRol' => $this->input->post('inIdRol')
				, 'tsFechaInicio' => ($this->input->post('tsFechaInicio')===FALSE)? GetToday('d/m/Y'):  set_value('tsFechaInicio')
				, 'tsFechaCaducidad' => set_value('tsFechaCaducidad')
				, 'vcNovTitulo' => set_value('vcNovTitulo')
                , 'vcNovResumen' => set_value('vcNovResumen')
				, 'vcNovDescripcion' => set_value('vcNovDescripcion')
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

		$inIdRol = $this->input->post('inIdRolBuscar');
		$inIdRol = (!empty($inIdRol))? $inIdRol: null;
		
		$this->gridview->initialize(
			array(
				'sResponseUrl' => 'autenticacion/novedadesrol/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar, $inIdRol)
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		
		$this->gridview->addControl('inIdNovedadesRolCtrl',array('face'=>'<a href="autenticacion/novedadesrol/formulario/{inIdNovedadesRol}" title="click para editar {vcNovTitulo}" class="icono-editar btn-accion" rel="{\'inIdNovedadesRol\': {inIdNovedadesRol}}">&nbsp;</a><a href="autenticacion/novedadesrol/consulta/{inIdNovedadesRol}" title="click para eliminar {vcNovTitulo}" class="icono-eliminar btn-accion" rel="{\'inIdNovedadesRol\': {inIdNovedadesRol}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));
		
		$this->gridview->addColumn('inIdNovedadesRol','#','int');
		$this->gridview->addColumn('vcRolNombre','Rol','text');
		$this->gridview->addColumn('tsFechaInicio','Fecha','date');
		$this->gridview->addColumn('vcNovTitulo','Título');
        $this->gridview->addColumn('vcNovResumen','Resúmen');
		#$this->gridview->addColumn('vcNovDescripcion','Contenido','text',array('stripTags'=>true, 'numChars'=>100));
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		$this->gridview->addParm('inIdRolBuscar', $this->input->post('inIdRol'));
		$rsRegs = $this->_oModel->obtener($vcBuscar, $inIdRol, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		
		$this->load->view('lib_autenticacion/lst-novedadesrol'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        		, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/roles_model','roles');
		
		$rsRoles = $this->roles->obtenerTodosDdl(TRUE);
		
		$this->load->view('lib_autenticacion/frm-novedadesrol'
			, array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/novedadesrol/guardar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdNovedadesRol'] > 0)? 'Modificar': 'Agregar'
				, 'rsRoles' => $rsRoles
			)
		);
	}
    
	public function consulta() {
		
		$this->load->view('lib_autenticacion/frm-novedadesrol-borrar'
			, array(
				  'Reg' 		=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/novedadesrol/eliminar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' 	=> ($this->_reg['inIdNovedadesRol']>0)? 'Eliminar': ''
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
					$this->_reg['inIdNovedadesRol']
					, (!empty($this->_reg['inIdRol']))? $this->_reg['inIdRol']: null
					, GetDateTimeFromFrenchToISO($this->_reg['tsFechaInicio'])
					, (!empty($this->_reg['tsFechaCaducidad'])) ? GetDateTimeFromFrenchToISO($this->_reg['tsFechaCaducidad']): null
					, $this->_reg['vcNovTitulo']
                    , $this->_reg['vcNovResumen']
					, $this->_reg['vcNovDescripcion']
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
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdNovedadesRol'));
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
// EOF novedadesrol.php
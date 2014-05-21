<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * Roles class
 *
 * @package base
 * @author  Marcelo Gutierrez
 * @copyright 2011-12
 */
class Roles extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/roles_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');
		
    	$this->_aReglas = array(   
	                          array(
	                              'field'   => 'vcRolNombre',
	                              'label'   => 'Nombre del Rol',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcRolCod',
	                              'label'   => 'Código',
	                              'rules'   => 'trim|required|max_length[10]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'inRolRango',
	                              'label'   => 'Rango / Orden',
	                              'rules'   => 'trim|required|xss_clean|is_natural'
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
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-roles',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdRol' => null, 'vcRolNombre' => '', 'vcRolCod' => '', 'inRolRango' => ''
		);
		$inId = ($this->input->post('inIdRol')!==false)? $this->input->post('inIdRol'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
				'inIdRol' => $inId
				, 'vcRolNombre' => set_value('vcRolNombre')
				, 'vcRolCod' => set_value('vcRolCod')
				, 'inRolRango' => set_value('inRolRango')
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
				'sResponseUrl' => 'autenticacion/roles/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar)
				,'iPerPage' => $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		
		$this->gridview->addControl('inIdRolCtrl',array('face'=>'<a href="autenticacion/roles/formulario/{inIdRol}" title="click para editar {vcRolNombre}" class="icono-editar btn-accion" rel="{\'inIdRol\': {inIdRol}}">&nbsp;</a>'.
                                                                '<a href="autenticacion/roles/consulta/{inIdRol}" title="click para eliminar {vcRolNombre}" class="icono-eliminar btn-accion" rel="{\'inIdRol\': {inIdRol}}">&nbsp;</a>'.
                                                                '<a href="autenticacion/rolesmodulos/listadoEditar/{inIdRol}" title="click para editar roles de {vcRolNombre}" class="icono-editando btn-accion" rel="{\'inIdRol\': {inIdRol}}">&nbsp;</a>'
                                                                ,'class'=>'acciones', 'style'=>'width:96px;'));
		$this->gridview->addColumn('inIdRol','#','int');
		$this->gridview->addColumn('vcRolNombre','Nombre');
		$this->gridview->addColumn('vcRolCod','Cod.');
		$this->gridview->addColumn('inRolRango','Ord. Rango','int');
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->_oModel->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		
		$this->load->view('lib_autenticacion/lst-roles'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        		, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
		$aData['vcFrmAction'] = 'autenticacion/roles/guardar';
		$aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
		$aData['vcAccion'] = ($this->_reg['inIdRol']>0)? 'Modificar': 'Agregar';
		$this->load->view('lib_autenticacion/frm-roles',$aData);
	}
    
	public function consulta() {
        $this->load->view('lib_autenticacion/frm-roles-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/roles/eliminar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdRol']>0)? 'Eliminar': ''
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
					$this->_reg['inIdRol']
					, $this->_reg['vcRolNombre']
					, $this->_reg['vcRolCod']
					, $this->_reg['inRolRango']
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
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdRol'));
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
// EOF roles.php
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Estados class
 *
 * @package base
 * @author  Artigas Daniel
 * @copyright 2011-12
 */
class Estados extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/estados_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');     
        $this->load->helper('pin_helper'); 
		$this->_aReglas = array(   
	                          array(
	                              'field'   => 'vcSegEstDesc',
	                              'label'   => 'Nombre del Estado',
	                              'rules'   => 'trim|required|required|max_length[50]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcSegEstCod',
	                              'label'   => 'Código',
	                              'rules'   => 'trim|required|required|max_length[10]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'boSegEstHabilitado',
	                              'label'   => 'Habilitado',
	                              'rules'   => ''
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
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-estados',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdSegEstado' => null, 'vcSegEstDesc' => '', 'vcSegEstCod' => '', 'boSegEstHabilitado' => ''
		);
		$inId = ($this->input->post('inIdSegEstado')!==false)? $this->input->post('inIdSegEstado'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
				'inIdSegEstado' => $inId
				, 'vcSegEstDesc' => set_value('vcSegEstDesc')
				, 'vcSegEstCod' => set_value('vcSegEstCod')
				, 'boSegEstHabilitado' => set_value('boSegEstHabilitado')
			);
		}
		return $this->_reg;
	}
	
	protected function _inicReglas() 
	{
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
				'sResponseUrl' => 'autenticacion/estados/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar)
				,'iPerPage' => 4
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);

		$this->gridview->addControl('inIdEstadoCtrl',array('face'=>'<a href="autenticacion/estados/formulario/{inIdSegEstado}" title="click para editar {vcSegEstDesc}" class="icono-editar btn-accion" rel="{\'inIdSegEstado\': {inIdSegEstado}}">&nbsp;</a><a href="autenticacion/estados/consulta/{inIdSegEstado}" title="click para eliminar {vcSegEstDesc}" class="icono-eliminar btn-accion" rel="{\'inIdSegEstado\': {inIdSegEstado}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));
	
		$this->gridview->addColumn('inIdSegEstado','#','int');
		$this->gridview->addColumn('vcSegEstDesc','Nombre');
		$this->gridview->addColumn('vcSegEstCod','Cod.');
		$this->gridview->addColumn('boSegEstHabilitado','Habilitado','bool');
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->_oModel->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		
		$this->load->view('lib_autenticacion/lst-estados'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
		$aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
		$aData['vcFrmAction'] = 'autenticacion/estados/guardar';
		$aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
		$aData['vcAccion'] = ($this->_reg['inIdSegEstado']>0)? 'Modificar': 'Agregar';
		$this->load->view('lib_autenticacion/frm-estados',$aData);
	}
    
	public function consulta() {
		
		$this->load->view('lib_autenticacion/frm-estados-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/estados/eliminar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdSegEstado']>0)? 'Eliminar': ''
			)
		);
	}
	
	public function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
	//cuando checkbox no es seleccionado devuelve vacio y no false como deberia el siguiente codigo es para asignarle un valor para ese caso 
		if (!isset($_POST['boSegEstHabilitado']))
			{	
				$_POST['boSegEstHabilitado'] = 0;
			}
		$this->_inicReglas();
		if($this->_validarReglas()) {
			$this->_inicReg((bool)$this->input->post('vcForm'));
			$this->_aEstadoOper['status'] = $this->_oModel->guardar(
				array(
					$this->_reg['inIdSegEstado']
					, $this->_reg['vcSegEstDesc']
					, $this->_reg['vcSegEstCod']
					, $this->_reg['boSegEstHabilitado'] 
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
	
	public function eliminar()
	{
		antibotCompararLlave($this->input->post('vcForm'));      
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdSegEstado'));
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
// EOF estados.php
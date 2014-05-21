<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * 
 * Modulos Class
 *
 * @package		base
 * @category	Localidades
 * @author		Silvia E.Farfan
 * @link
 * @copyright	2012-02-06
 */
class Localidades extends Ext_crud_controller
{
    function __construct()
	{
		parent::__construct();
        
        $this->load->model($this->db->dbdriver.'/sistema/localidades_model','_oModel');		
        $this->load->library('gridview');
		$this->load->library('Messages');
        $this->loadJs('ddlcascada/ddlcascada.js');	
        		
		$this->_aReglas = array(
    						   array(
	                              'field'   => 'inIdPais',
	                              'label'   => 'Nombre del Pais',
	                              'rules'   => 'trim|required|xss_clean'
	                          )   
	                          ,array(
	                              'field'   => 'inIdProvincia',
	                              'label'   => 'Nombre de la Provincia',
	                              'rules'   => 'trim|required|xss_clean'
	                          )
                              ,array(
	                              'field'   => 'inIdDepartamento',
	                              'label'   => 'Nombre del Departamento',
	                              'rules'   => 'trim|required|xss_clean'
	                          )   
	                          ,array(
	                              'field'   => 'vcLocNombre',
	                              'label'   => 'Nombre de la Localidad',
	                              'rules'   => 'trim|required|max_length[80]|xss_clean'
	                          )
                              ,array(
	                              'field'   => 'vcLocCodPostal',
	                              'label'   => 'Codigo Postal',
	                              'rules'   => 'trim|xss_clean|max_length[10]|is_natural'
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
		$this->_vcContentPlaceHolder = $this->load->view('sistema/principal-localidades',array(),true);
	
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdLocalidad' => null, 'inIdDepartamento' => null,'inIdProvincia' => null,'inIdPais' => null, 'vcLocNombre' => null, 'vcLocCodPostal' => ''
		);
		$inId = ($this->input->post('inIdLocalidad')!==false)? $this->input->post('inIdLocalidad'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
				  'inIdLocalidad' => $inId
				, 'inIdDepartamento' => set_value('inIdDepartamento')
                , 'inIdProvincia' => set_value('inIdProvincia')
                , 'inIdPais' => set_value('inIdPais')
                , 'vcLocNombre' => set_value('vcLocNombre')
                , 'vcLocCodPostal' => set_value('vcLocCodPostal')
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
				 'sResponseUrl' => 'sistema/localidades/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar)
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 4: $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		
		$this->gridview->addControl('inIdLocalidadesCtrl',array('face'=>'<a href="sistema/localidades/formulario/{inIdLocalidad}" title="click para editar {vcLocNombre}" class="icono-editar btn-accion" rel="{\'inIdLocalidad\': {inIdLocalidad}}">&nbsp;</a><a href="sistema/localidades/consulta/{inIdLocalidad}" title="click para eliminar {vcLocNombre}" class="icono-eliminar btn-accion" rel="{\'inIdLocalidad\': {inIdLocalidad}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));
		
        $this->gridview->addColumn('inIdLocalidad','#','int');
		$this->gridview->addColumn('vcPaisNombre','País');
		$this->gridview->addColumn('vcProNombre','Provincia');
        $this->gridview->addColumn('vcDepNombre','Departamento');
		$this->gridview->addColumn('vcLocNombre','Localidad');
        $this->gridview->addColumn('vcLocCodPostal','Código Postal');       
        
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->_oModel->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		
		$this->load->view('sistema/lst-localidades'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        		, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
	   
        $reg = $this->_inicReg($this->input->post('vcForm'));        
       			
		$aData = array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction'     => 'sistema/localidades/guardar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdLocalidad']>0)? 'Modificar': 'Agregar'
		);
        /****************************************************************/
        /***** DROP DOWN EN CASCADA *************************************/
        $this->load->library('dropdowncascade');
        $aData['ddc'] = $this->dropdowncascade->dropdowncascade(
            array(
                array(
                    'dbId' => 'inIdPais',
                    'dbName' => 'vcPaisNombre',
                    'html' => classRegValidation('inIdPais'),
                    'modelo' => 'sistema/localizacion/jsonpaises',
                    'txtSeleccione' => 'Seleccione un País',
                    'selected' => $this->_reg['inIdPais']?$this->_reg['inIdPais']:$this->input->post('inIdPais')
                ),
                array(
                    'dbId' => 'inIdProvincia',
                    'dbName' => 'vcProNombre',
                    'html' => classRegValidation('inIdProvincia'),
                    'modelo' => 'sistema/localizacion/jsonprovincias',
                    'txtSeleccione' => 'Seleccione una Provincia',
                    'selected' => $this->_reg['inIdProvincia']?$this->_reg['inIdProvincia']:$this->input->post('inIdProvincia')
                ),
                array(
                    'dbId' => 'inIdDepartamento',
                    'dbName' => 'vcDepNombre',
                    'html' => classRegValidation('inIdDepartamento'),
                    'modelo' => 'sistema/localizacion/jsondepartamentos',
                    'txtSeleccione' => 'Seleccione un Departamento',
                    'selected' => $this->_reg['inIdDepartamento']?$this->_reg['inIdDepartamento']:$this->input->post('inIdDepartamento')
                )
            )
        );
        /****************************************************************/
        /****************************************************************/
		$this->load->view('sistema/frm-localidades', $aData);
	}
    
	public function consulta() {
		
		$this->load->view('sistema/frm-localidades-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))				
				, 'vcFrmAction'     => 'sistema/localidades/eliminar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdLocalidad']>0)? 'Eliminar': ''
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
                     ($this->_reg['inIdLocalidad'] != '' && $this->_reg['inIdLocalidad'] != 0)? $this->_reg['inIdLocalidad'] : 0
					, $this->_reg['inIdDepartamento']
					, $this->_reg['vcLocNombre']
					, $this->_reg['vcLocCodPostal']
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
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdLocalidad'));
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
//EOF Localidades.php
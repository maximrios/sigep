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
 * @author Maximiliano R.
 * @version 1.0.0
 * @copyright 2011-12
 * @package sarh
 */
class Cuadro extends Ext_crud_controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model('sigep/cuadros_model','cuadro');
		$this->load->library('gridview');
		$this->load->library('Messages');	
		$this->loadJs('ddlcascada/ddlcascada.js');			
		$this->_aReglas = array(
			array(
	        	'field'   => 'idTipoInstrumentoLegal',
	            'label'   => 'Tipo de Instrumento Legal',
	            'rules'   => 'trim|required|xss_clean'
	        )   
	        ,array(
	        	'field'   => 'numeroInstrumentoLegal',
	            'label'   => 'Numero de Instrumento Legal',
	            'rules'   => 'trim|required|xss_clean'
	        )							  
			,array(
	        	'field'   => 'anioInstrumentoLegal',
	            'label'   => 'Año del Instrumento Legal',
	            'rules'   => 'trim|required|max_length[2]|xss_clean'
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
		$this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/cuadro/cuadros/principal',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'inIdDepartamento' => null,'inIdProvincia' => null, 'inIdPais' => null, 'vcDepNombre' => '' 
		);
		
		$inId = ($this->input->post('inIdDepartamento')!==false)? $this->input->post('inIdDepartamento'):0;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->cuadro->obtenerUno($inId);
		} else {
			$this->_reg = array(
				  'inIdDepartamento' => $inId
				, 'inIdPais' => set_value('inIdPais')
				, 'inIdTipoInstrumentoLegal' => set_value('inIdTipoInstrumentoLegal')
				, 'inIdProvincia' => set_value('inIdProvincia')
				, 'vcDepNombre' => set_value('vcDepNombre')
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
				'sResponseUrl' => 'cuadro/cuadro/listado'
				,'iTotalRegs' => $this->cuadro->numRegs($vcBuscar)
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 4: $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		
		$this->gridview->addControl('inIdRolCtrl',array('face'=>'<a href="cuadro/cuadros/formulario/{idCuadro}" title="click para editar {instrumentoCuadro anioCuadro}" class="icono-editar btn-accion" rel="{\'idCuadro\': {idCuadro}}">&nbsp;</a><a href="cuadro/cuadros/consulta/{idCuadro}" title="click para eliminar {instrumentoCuadro}" class="icono-eliminar btn-accion" rel="{\'idCuadro\': {idCuadro}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));
		
		$this->gridview->addColumn('idCuadro','#','int');		
		$this->gridview->addColumn('instrumentoCuadro','Instrumento Legal');
		$this->gridview->addColumn('anioCuadro','Año');
		$this->gridview->addColumn('fechaCuadro','Fecha');
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->cuadro->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
		
		$this->load->view('administrator/sigep/cuadro/cuadros/listado'
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
				  'Reg' 			=> $reg
				, 'vcFrmAction'     => 'sistema/departamentos/guardar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdDepartamento']>0)? 'Modificar': 'Agregar'
			);
        /****************************************************************/
        /***** DROP DOWN EN CASCADA *************************************/
        $this->load->library('dropdowncascade');
        $aData['ddc'] = $this->dropdowncascade->dropdowncascade(
            array(
                array(
                    'dbId' => 'inIdTipoInstrumentoLegal',
                    'dbName' => 'vcDescripcion',
                    'html' => classRegValidation('inIdTipoInstrumentoLegal'),
                    'modelo' => 'general/selects/jsonInstrumentos',
                    'txtSeleccione' => 'Seleccione un Tipo de Instrumento',
                    'selected' => $this->_reg['inIdTipoInstrumentoLegal']?$this->_reg['inIdTipoInstrumentoLegal']:$this->input->post('inIdTipoInstrumentoLegal')
                ),
                array(
                    'dbId' => 'inIdProvincia',
                    'dbName' => 'vcProNombre',
                    'html' => classRegValidation('inIdProvincia'),
                    'modelo' => 'sistema/localizacion/jsonprovincias',
                    'txtSeleccione' => 'Seleccione una Provincia',
                    'selected' => $this->_reg['inIdProvincia']?$this->_reg['inIdProvincia']:$this->input->post('inIdProvincia')
                )
            )
        );
        /****************************************************************/
        /****************************************************************/
		$this->load->view('administrator/sigep/cuadro/cuadros/formulario',$aData);
	}
    
	public function consulta() {
		
		$this->load->view('sistema/frm-departamentos-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))				
				, 'vcFrmAction'     => 'sistema/departamentos/eliminar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['inIdDepartamento']>0)? 'Eliminar': ''
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
					   // Por que JQuery utiliza el inIdDepartamento y lo pone en '' por lo tanto se pierde el 0
					  ($this->_reg['inIdDepartamento'] != '' && $this->_reg['inIdDepartamento'] != 0)? $this->_reg['inIdDepartamento'] : 0   
					, $this->_reg['inIdProvincia']
					, $this->_reg['vcDepNombre']
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
    	$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdDepartamento'));
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
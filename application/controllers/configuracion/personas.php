<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Duran Francisco Javier
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */

/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
class Personas extends Ext_crud_controller
{
	private $_aTipDoc = array();
	private $_aEstCiv = array();
	private $_aSexo = array('F'=>'Femenino', 'M'=>'Masculino');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/configuracion/personas_model','_oModel');
		$this->load->model($this->db->dbdriver.'/sistema/localizacion_model','_oLocalizacionModel');		
		$this->load->library('gridview');
		$this->load->library('Messages');
		$this->load->helper('utils_helper');
		$this->loadJs('ddlcascada/ddlcascada.js');
		
		$this->_aTipDoc = $this->_oModel->obtenerTipDoc();			
		$this->_aEstCiv = $this->_oModel->obtenerEstCiv();
		$this->_aReglas = array(   
                          array(
                              'field'   => 'inPerDni',
                              'label'   => 'Documento',
                              'rules'   => 'trim|required|is_natural_no_zero|min_length[8]|xss_clean'
                          ),
                          array(
                              'field'   => 'vcPerNombre',
                              'label'   => 'Apellido y Nombre',
                              'rules'   => 'trim|required|max_length[100]|xss_clean'
                          ),
                          array(
                              'field'   => 'inIdPerTipoDoc',
                              'label'   => 'Tipo Docuento',
                              'rules'   => 'trim|required|xss_clean'
                          ),
						  array(
                              'field'   => 'inIdEstadoCivil',
                              'label'   => 'Estado Civil',
                              'rules'   => 'trim|xss_clean'
                          ),
						  array(
                              'field'   => 'biPerCuil',
                              'label'   => 'CUIL',
                              'rules'   => 'trim|is_natural_no_zero|xss_clean'
                          ),
						  array(
                              'field'   => 'dtPerFechaNac',
                              'label'   => 'Fecha Nacimiento',
                              'rules'   => 'trim|callback_validate_date_check|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerSexo',
                              'label'   => 'Sexo',
                              'rules'   => 'trim|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerCalle',
                              'label'   => 'Domicilio',
                              'rules'   => 'trim|max_length[50]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerNro',
                              'label'   => 'Numero',
                              'rules'   => 'trim|is_natural_no_zero|max_length[5]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerPiso',
                              'label'   => 'Piso',
                              'rules'   => 'trim|alpha_numeric|max_length[5]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerDto',
                              'label'   => 'Dpto',
                              'rules'   => 'trim|alpha_numeric|max_length[5]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerTelefono',
                              'label'   => 'Telefono',
                              'rules'   => 'trim|alpha_numeric|max_length[15]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerCelular',
                              'label'   => 'Celular',
                              'rules'   => 'trim|alpha_numeric|max_length[15]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerEmail',
                              'label'   => 'E-Mail',
                              'rules'   => 'trim|valid_email|max_length[256]|xss_clean'
                          ),
						  array(
                              'field'   => 'vcPerBarrio',
                              'label'   => 'Barrio',
                              'rules'   => 'trim|max_length[100]|xss_clean'
                          ),
						  array(
                              'field'   => 'inIdLocalidad',
                              'label'   => 'Localidad',
                              'rules'   => 'trim|xss_clean'
                          ),
						  array(
                              'field'   => 'inIdDepartamento',
                              'label'   => 'Departamento',
                              'rules'   => 'trim|xss_clean'
                          ),
						  array(
                              'field'   => 'inIdProvincia',
                              'label'   => 'Provincia',
                              'rules'   => 'trim|xss_clean'
                          ),
						  array(
                              'field'   => 'inIdPais',
                              'label'   => 'Pais',
                              'rules'   => 'trim|xss_clean'
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
		$this->_SiteInfo['title'] = 'Personas';		
		$this->_vcContentPlaceHolder = $this->load->view('configuracion/principal-personas',array(),true);                        
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		//Inicializa Array en vacio, para el alta
		$this->_reg = array(
			  'inIdPersona' => null
			, 'inIdPerTipoDoc' => '' 
			, 'inIdEstadoCivil' => ''
			, 'inPerDni' => ''
			, 'biPerCuil' => ''
			, 'vcPerNombre' => ''
			, 'dtPerFechaNac' => ''
			, 'vcPerSexo' => ''
			, 'vcPerCalle' => ''
			, 'vcPerNro' => ''
			, 'vcPerPiso' => ''
			, 'vcPerDto' => ''
			, 'vcPerTelefono' => ''
			, 'vcPerCelular' => ''
			, 'vcPerEmail' => ''
			, 'vcPerBarrio' => ''
			, 'inIdLocalidad' => ''
			, 'inIdDepartamento' => ''
			, 'inIdProvincia' => ''
			, 'inIdPais' => ''
		);
		$inId = ($this->input->post('inIdPersona')!==false)? $this->input->post('inIdPersona'):0;
		if($inId!=0 && !$boIsPostBack) {
			//Editar y Eliminar
			$this->_reg = $this->_oModel->obtenerUno($inId);
			$this->_reg['dtPerFechaNac'] = GetDateFromISO($this->_reg['dtPerFechaNac'],FALSE);
		} else {
			//Alta
			$this->_reg = array(
				  'inIdPersona' => $inId			
				, 'inIdPerTipoDoc' => set_value('inIdPerTipoDoc')
				, 'inIdEstadoCivil' => set_value('inIdEstadoCivil')
				, 'inPerDni' => set_value('inPerDni')
				, 'biPerCuil' => set_value('biPerCuil')
				, 'vcPerNombre' => set_value('vcPerNombre')
				, 'dtPerFechaNac' => set_value('dtPerFechaNac')
				, 'vcPerSexo' => set_value('vcPerSexo')
				, 'vcPerCalle' => set_value('vcPerCalle')
				, 'vcPerNro' => set_value('vcPerNro')
				, 'vcPerPiso' => set_value('vcPerPiso')
				, 'vcPerDto' => set_value('vcPerDto')
				, 'vcPerTelefono' => set_value('vcPerTelefono')
				, 'vcPerCelular' => set_value('vcPerCelular')
				, 'vcPerEmail' => set_value('vcPerEmail')
				, 'vcPerBarrio' => set_value('vcPerBarrio')
				, 'inIdLocalidad' => set_value('inIdLocalidad')
				, 'inIdDepartamento' => set_value('inIdDepartamento')
				, 'inIdProvincia' => set_value('inIdProvincia')
				, 'inIdPais' => set_value('inIdPais')
			);
		}
		return $this->_reg;
	}
	
	protected function _inicReglas() {
		$this->form_validation->set_rules($this->_aReglas);
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
				'sResponseUrl' => 'configuracion/personas/listado'
				,'iTotalRegs' => ($vcBuscar!='')?$this->_oModel->numRegs($vcBuscar):0
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 4: $this->input->post('per_page')
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);
		$this->gridview->addControl('inIdPersonaCtrl'
		                            ,array('face'=>'<a href="configuracion/personas/formulario/{inIdPersona}" title="click para editar {vcPerNombre}" class="icono-editar btn-accion" rel="{\'inIdPersona\': {inIdPersona}}">&nbsp;</a><a href="configuracion/personas/borrar/{inIdPersona}" title="click para eliminar {vcPerNombre}" class="icono-eliminar btn-accion" rel="{\'inIdPersona\': {inIdPersona}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;')
									);										
		//$this->gridview->addColumn('inIdPersona','#','int');		
		$this->gridview->addColumn('vcPerTipoDocDesc','Tipo Doc.');
		$this->gridview->addColumn('inPerDni',config_item('ext_base_login_username'),'int');
		$this->gridview->addColumn('biPerCuil','CUIL');
		$this->gridview->addColumn('vcPerNombre','Nombre');		
		$this->gridview->addColumn('vcPerSexo','Sexo');
		$this->gridview->addColumn('vcEstCivDesc','Est. Civ.');
		$this->gridview->addColumn('vcPerTelefono','Telefono');
		$this->gridview->addColumn('vcPerCelular','Celular');
		$this->gridview->addColumn('vcPerEmail','Email');

		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		if ($vcBuscar != '') {	
			$rsRegs = $this->_oModel->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
			$this->load->view('configuracion/lst-personas'
				,array(
					  'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
					, 'vcMsjSrv'    => $this->_aEstadoOper['message']
					, 'txtvcBuscar' => $vcBuscar
				)
			);	
		} else {
			$this->load->view('configuracion/lst-personas'
				,array(
					'vcGridView'	=> $this->messages->do_message(array('message'=>'Por favor escriba un Nombre ó Apellido en el Buscador','type'=> 'info'))
					, 'vcMsjSrv'    => $this->_aEstadoOper['message']
					, 'txtvcBuscar' => $vcBuscar
				)
			);	
		}	
	}

	public function formulario() {
		$reg = $this->_inicReg($this->input->post('vcForm'));
		$aData = array(
				  'Reg' 	      => $reg
				, 'aTipDoc'       => $this->_aTipDoc
				, 'aEstCiv'       => $this->_aEstCiv
				, 'aSexo'         => $this->_aSexo
				, 'vcFrmAction'   => 'configuracion/personas/guardar'
				, 'vcMsjSrv'      => $this->_aEstadoOper['message']
				, 'vcAccion'      => ($this->_reg['inIdPersona']>0)? 'Modificar': 'Agregar'
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
                ),
                array(
                    'dbId' => 'inIdLocalidad',
                    'dbName' => 'vcLocNombre',
                    'html' => classRegValidation('inIdLocalidad'),
                    'modelo' => 'sistema/localizacion/jsonlocalidades',
                    'txtSeleccione' => 'Seleccione una Localidad',
                    'selected' => $this->_reg['inIdLocalidad']?$this->_reg['inIdLocalidad']:$this->input->post('inIdLocalidad')
                )
            )
        );
        /****************************************************************/
        /****************************************************************/
		$this->load->view('configuracion/frm-personas', $aData);
	}
	
	public function borrar() {
		$this->load->view('configuracion/frm-personas-borrar'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'configuracion/personas/eliminar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdPersona']>0)? 'Eliminar': ''
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
					  $this->_reg['inIdPersona']
					, $this->_reg['inIdPerTipoDoc']
					, ($this->_reg['inIdEstadoCivil']=='')?null:$this->_reg['inIdEstadoCivil']
					, $this->_reg['inPerDni']
					, ($this->_reg['biPerCuil']=='')?null:$this->_reg['biPerCuil']
					, $this->_reg['vcPerNombre']
					, ($this->_reg['dtPerFechaNac']=='')?null:GetDateTimeFromFrenchToISO($this->_reg['dtPerFechaNac'])
					//, ($this->_reg['dtPerFechaNac']=='')?null:$this->_reg['dtPerFechaNac']
					, ($this->_reg['vcPerSexo']=='')?null:$this->_reg['vcPerSexo']
					, ($this->_reg['vcPerCalle']=='')?null:$this->_reg['vcPerCalle']
					, ($this->_reg['vcPerNro']=='')?null:$this->_reg['vcPerNro']
					, ($this->_reg['vcPerPiso']=='')?null:$this->_reg['vcPerPiso']
					, ($this->_reg['vcPerDto']=='')?null:$this->_reg['vcPerDto']
					, ($this->_reg['vcPerTelefono']=='')?null:$this->_reg['vcPerTelefono']
					, ($this->_reg['vcPerCelular']=='')?null:$this->_reg['vcPerCelular']
					, ($this->_reg['vcPerEmail']=='')?null:$this->_reg['vcPerEmail']
					, ($this->_reg['vcPerBarrio']=='')?null:$this->_reg['vcPerBarrio']
					, ($this->_reg['inIdLocalidad']=='')?null:$this->_reg['inIdLocalidad']
					, ($this->_reg['inIdDepartamento']=='')?null:$this->_reg['inIdDepartamento']
					, ($this->_reg['inIdProvincia']=='')?null:$this->_reg['inIdProvincia']
					, ($this->_reg['inIdPais']=='')?null:$this->_reg['inIdPais']
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
		$this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdPersona'));
			
		if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue eliminado con exito.';
	    } else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	    }      
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'info':'alert'));
        $this->listado();  
	}
	
	public function validate_date_check($str) {
    	if($str!='' and !dateFrenchIsValid($str)) {
			$this->form_validation->set_message('validate_date_check', 'La %s no es válida.');
        	return FALSE;
    	}
        return TRUE;
    }
    public function onlySearch($str) {
        $regex = "/^[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\ \-\_\.\@\']*[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/";
        return ($str=='' or preg_match($regex, $str));
    }
}
//EOF personas.php
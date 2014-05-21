<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sobremi extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('hits/personas_model', 'persona');
		//$this->load->model('sigep/agentes_model', 'agentes');
		//$this->load->model('sigep/cuadrocargosagentes_model', 'cargos');
		//$this->load->model('sigep/designaciones_model', 'designaciones');
		$this->load->library('gridview');
		$this->load->library('Messages');
        $this->load->helper('utils_helper');
        
		$this->estados = $this->persona->dropdownEstadoCivil();
		$this->sexos = $this->persona->dropdownSexo();
		$this->_aReglas = array(
			array(
	        	'field'   => 'dniPersona',
	            'label'   => 'Numero de documento',
	            'rules'   => 'trim|max_length[8]|min_length[7]|xss_clean'
	        )
	        ,array(
	        	'field'   => 'idTipoDni',
	            'label'   => 'Tipo de documento',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
			,array(
				'field'   => 'apellidoPersona',
	            'label'   => 'Apellido de la persona',
	            'rules'   => 'trim|required|xss_clean'
	        )   
			,array(
	        	'field'   => 'nombrePersona',
	            'label'   => 'Nombre de la persona',
	            'rules'   => 'trim|required|xss_clean'
	        )  
	        ,array(
	        	'field'   => 'cuilPersona',
	            'label'   => 'Numero de Cuil de la Persona',
	            'rules'   => 'trim|xss_clean|max_length[11]|min_length[11]'
	        ) 
			,array(
	        	'field'   => 'nacimientoPersona',
	            'label'   => 'Fecha de nacimiento de la Persona',
	            'rules'   => 'trim|required|xss_clean'
	        )
	        ,array(
	        	'field'   => 'idEcivil',
	            'label'   => 'Estado civil de la Persona',
	            'rules'   => 'trim|xss_clean'
	        ) 
			,array(
	        	'field'   => 'idSexo',
	            'label'   => 'Sexo de la Persona',
	            'rules'   => 'trim|xss_clean'
	        ) 
	        ,array(
	        	'field'   => 'nacionalidadPersona',
	            'label'   => 'Nacionalidad de la Persona',
	            'rules'   => 'trim|xss_clean'
	        )
	        ,array(
	        	'field'   => 'domicilioPersona',
	            'label'   => 'Domicilio de la Persona',
	            'rules'   => 'trim|xss_clean|max_length[80]'
	        ) 
	        ,array(
	        	'field'   => 'telefonoPersona',
	            'label'   => 'Numero de telefono de la Persona',
	            'rules'   => 'trim|xss_clean|is_numeric'
	        )
			,array(
	        	'field'   => 'celularPersona',
	            'label'   => 'Numero de celular de la Persona',
	            'rules'   => 'trim|xss_clean|is_numeric'
	        )
	        ,array(
	        	'field'   => 'laboralPersona',
	            'label'   => 'Numero de Telefono Laboral',
	            'rules'   => 'trim|max_length[80]|xss_clean|is_numeric'
	        )
	        ,array(
	        	'field'   => 'emailPersona',
	            'label'   => 'Correo electronico de la Persona',
	            'rules'   => 'trim|xss_clean|valid_email'
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
	protected function _inicReg($boIsPostBack=false) {
		$this->_reg = array(
			'idPersona' => null
			,'idTipoDni' => null
			, 'dniPersona' => null
			, 'apellidoPersona' => null
			, 'nombrePersona' => null
			, 'cuilPersona' => null
			, 'nacimientoPersona' => null
			, 'idSexo' => null
			, 'idEcivil' => null
			, 'nacionalidadPersona' => null
			, 'domicilioPersona' => null
			, 'telefonoPersona' => null
			, 'celularPersona' => null
			, 'emailPersona' => null
			, 'laboralPersona' => null
		);
		//$id = ($this->input->post('idPersona')!==false)? $this->input->post('idPersona'):0;
		$id = $this->lib_autenticacion->idPersona();
		if($id!=0 && !$boIsPostBack) {
			$this->_reg = $this->persona->obtenerPersonaId($id);
			$this->_reg['nacimientoPersona'] = GetDateFromISO($this->_reg['nacimientoPersona'], FALSE);
		} 
		else {
			$this->_reg = array(
				'idPersona' => $id
				,'idTipoDni' => set_value('idTipoDni')
				, 'dniPersona' => set_value('dniPersona')
				, 'apellidoPersona' => set_value('apellidoPersona')
				, 'nombrePersona' => set_value('nombrePersona')
				, 'cuilPersona' => set_value('cuilPersona')
				, 'nacimientoPersona' => set_value('nacimientoPersona')
				, 'idSexo' => set_value('idSexo')
				, 'idEcivil' => set_value('idEcivil')
				, 'nacionalidadPersona' => set_value('nacionalidadPersona')
				, 'domicilioPersona' => set_value('domicilioPersona')
				, 'telefonoPersona' => set_value('telefonoPersona')
				, 'celularPersona' => set_value('celularPersona')
				, 'emailPersona' => set_value('emailPersona')
				, 'laboralPersona' => set_value('laboralPersona')
			);			
		}
		return $this->_reg;
	}
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/jose/principal', array(), true);
        parent::index();
	}
	public function listado() {
		$this->form_validation->set_rules($this->_aBuscar);
        if($this->form_validation->run()==FALSE) {
            $vcBuscar = '';
        } else {
            $vcBuscar = ($this->input->post('vcBuscar')==FALSE)?'': $this->input->post('vcBuscar');
        }
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/personas/listado'
                    , 'iTotalRegs' => $this->persona->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Personas'
                    , 'identificador' => 'idPersona'
                )
        );
        $this->gridview->addColumn('idPersona', '#', 'int');
        $this->gridview->addColumn('completoPersona', 'Nombre Persona', 'text');
        $this->gridview->addColumn('domicilioPersona', 'Domicilio', 'text');
        $this->gridview->addColumn('telefonoPersona', 'Telefono', 'int');
        $this->gridview->addColumn('celularPersona', 'Celular', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/personas/formulario/{idPersona}" title="Editar datos de {nombrePersona}" class="icon-pencil btn-accion" rel="{\'idPersona\': {idPersona}}">&nbsp;</a>','class' => '', 'style' => 'width:32px;'));
        $this->_rsRegs = $this->persona->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/hits/personas/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
	function perfil() {
		if($this->lib_autenticacion->dniPersona()) {
			$agente = $this->agentes->obtenerDni($this->lib_autenticacion->dniPersona());
			$aData['cargos'] = $this->cargos->obtenerCCAAgente($agente['idAgente']);
			$aData['designacion'] = $this->designaciones->obtenerDesignacionAgente($agente['idAgente']);
			$aData['persona'] = $this->persona->obtenerPersonaDni($this->lib_autenticacion->dniPersona());
			$aData['vcFrmAction'] = 'administrator/personas/guardarPerfil';
			$aData['ecivil'] = $this->estados;
			$this->load->view('administrator/personas/perfil', $aData);
		}
	}
	function guardarPerfil() {
		$reg = $this->_inicReg(FALSE);
		$this->_aEstadoOper['status'] = $this->persona->guardar(
			array(
				($this->_reg['idPersona'] != '' && $this->_reg['idPersona'] != 0)? $this->_reg['idPersona'] : 0   
				, $this->_reg['idTipoDni']
				, $this->_reg['dniPersona']
				, $this->_reg['apellidoPersona']
				, $this->_reg['nombrePersona']
				, $this->_reg['cuilPersona']
				, $this->_reg['nacimientoPersona']
				, $this->_reg['idSexo']
				, $this->input->post('idEcivil')
				, $this->input->post('domicilioPersona')
				, $this->input->post('telefonoPersona')
				, $this->input->post('celularPersona')
				, $this->_reg['emailPersona']
				, $this->_reg['laboralPersona']
			)
		);
		if($this->_aEstadoOper['status'] > 0) {
			$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
		} 
		else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
		}
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
	}
	function cumpleanos($persona) {
		if(count($this->layout_model->cumpleanos($persona)) > 0) {
			$data['cumpleanero'] = $this->persona->obtenerUno($persona);
			$this->load->view('administrator/personas/cumpleano', $data);
			//$data['main_content'] = 'administrator/personas/cumpleano';
			//$this->load->view('administrator/template', $data);
		}
		else {
			echo "si no es el cumpleanos para que jodes";
		}
	}
	function formulario() {
		$aData['ckeditor'] = array(
			'id' 	=> 	'content',
			'path'	=>	'assets/libraries/ckeditor',
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height
			),
			'styles' => array(
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)				
			)
		);
		$aData['Reg'] =  $this->_inicReg(FALSE);
        $aData['vcFrmAction'] = 'administrator/personas/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = 'Agregar';
		$this->load->view('administrator/jose/formulario-sobremi', $aData);
	}
	function rapido() {
		$aData['estados'] = $this->estados;
		$aData['sexos'] = $this->sexos;
		$aData['Reg'] =  $this->_inicReg(TRUE);
        $aData['vcFrmAction'] = 'administrator/personas/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = 'Agregar';
		$this->load->view('administrator/hits/personas/formulario-rapido', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
           	$this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->persona->guardar(
				array(
					$this->_reg['idPersona']
					, $this->_reg['idTipoDni']
					, $this->_reg['dniPersona']
					, $this->_reg['apellidoPersona']
					, $this->_reg['nombrePersona']
					, $this->_reg['cuilPersona']
					, GetDateTimeFromFrenchToISO($this->_reg['nacimientoPersona'])
					, $this->_reg['idSexo']
					, $this->_reg['idEcivil']
					, $this->_reg['domicilioPersona']
					, $this->_reg['telefonoPersona']
					, $this->_reg['celularPersona']
					, $this->_reg['emailPersona']
					, $this->_reg['laboralPersona']
				)
			);
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
			} 
			else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
        }
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
		//Lo que sigue a continuacion deberia de ir dentro de un if que controle las validaciones
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));

		if($this->_aEstadoOper['status'] > 0) {
			$this->formulario();
		} else {
			$this->formulario();
		}
	}
	function buscar() {
		$registro = $this->_inicReg(false);
		
		if($this->input->post('buscar_persona')) {

		}
		else {
			redirect('administrator/home');
		}
	}
	function consulta($id) {
		echo "por aca andamio";
	}
	public function obtenerAutocompletePersonas() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->persona->obtenerAutocompletePersonas($q);
        }
    }
    function formacion() {
    	$this->load->view('administrator/hits/personas/formulario-academico');
    }
    public function onlySearch($str) {
        $regex = "/^[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\ \-\_\.\@\']*[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/";
        return ($str=='' or preg_match($regex, $str));
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */
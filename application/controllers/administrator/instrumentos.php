<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * Instrumentos Legales
 *
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package Sigep
 */
class Instrumentos extends Ext_crud_controller {
	function __construct() {
		parent::__construct();
		$this->load->model('sigep/instrumentos_model','instrumentos');
		$this->_temas = $this->instrumentos->dropdownTemas();
        $this->_tipos = $this->instrumentos->dropdownTipos();
        $this->_anios = $this->instrumentos->dropdownAnios();
		
		$this->load->library('gridview');
		$this->load->library('Messages');	
		$this->load->helper('utils_helper');
		//$this->loadJs('ddlcascada/ddlcascada.js');			
		
		$this->_aReglasResolucion = array(
	                          	array(
	                              'field'   => 'numeroInstrumentoLegal',
	                              'label'   => 'Numero de Instrumento Legal',
	                              'rules'   => 'trim|required|xss_clean'
	                          	)	
	                          	, array(
	                              'field'   => 'fechaInstrumentoLegal',
	                              'label'   => 'Fecha de aprobacion del Instrumento Legal',
	                              'rules'   => 'trim|required|xss_clean'
	                          	)
	                          	, array(
	                              'field'   => 'idTipoInstrumentoLegal',
	                              'label'   => 'Tipo de Instrumento Legal',
	                              'rules'   => 'trim|required|xss_clean'
	                          	)
	                          	, array(
	                              'field'   => 'idTema',
	                              'label'   => 'Tema de Instrumento Legal',
	                              'rules'   => 'trim|required|xss_clean'
	                        	)
	                        	, array(
	                              'field'   => 'asuntoInstrumentoLegal',
	                              'label'   => 'Asunto del Instrumento Legal',
	                              'rules'   => 'trim|required|xss_clean'
	                        	)
	                        	, array(
	                              'field'   => 'archivoInstrumentoLegal',
	                              'label'   => 'Archivo de Instrumento Legal',
	                              'rules'   => 'trim|xss_clean'
	                        	)
                      );
		$this->_aBuscar = array(
	                          array(
	                              'field'   => 'vcBuscar',
	                              'label'   => 'Buscar por texto',
	                              'rules'   => 'trim|xss_clean|min_length[3]|max_length[50]|callback_onlySearch'
	                          )
                      );
		$this->_aReglasTemas = array(
    		array(
	        	'field'   => 'textoTema',
	            'label'   => 'Descripcion del Tema',
	            'rules'   => 'trim|required|xss_clean'
	        )   
		);
	}
	
	public function index()
	{
		$this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/instrumentos/principal',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		$this->_reg = array(
			'idInstrumentoLegal' => null
			, 'numeroInstrumentoLegal' => null
			, 'fechaInstrumentoLegal' => null
			, 'idTipoInstrumentoLegal' => null
			, 'idTema' => null
			, 'asuntoInstrumentoLegal' => ''
			, 'archivoInstrumentoLegal' => ''
		);
		
		$inId = ($this->input->post('idInstrumentoLegal')!==false)? $this->input->post('idInstrumentoLegal'):0;
		$idEstado = ($this->input->post('idEstado')!==false)? $this->input->post('idEstado'):1;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->instrumentos->obtenerUno($inId);
		} else {
			$this->_reg = array(
				'idInstrumentoLegal' => $inId
				, 'numeroInstrumentoLegal' => set_value('numeroInstrumentoLegal')
				, 'fechaInstrumentoLegal' => set_value('fechaInstrumentoLegal')
				, 'idTipoInstrumentoLegal' => set_value('idTipoInstrumentoLegal')
				, 'idTema' => set_value('idTema')
				, 'asuntoInstrumentoLegal' => set_value('asuntoInstrumentoLegal')
				, 'archivoInstrumentoLegal' => set_value('archivoInstrumentoLegal')
			);			
		}
		return $this->_reg;
	}

	protected function _inicRegTemas($boIsPostBack=false, $tema=0) {
		$this->_reg = array(
			'idTema' => null
			, 'textoTema' => null
		);
		$inId = ($this->input->post('idTema')!==false)? $this->input->post('idTema'):$tema;
		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->instrumentos->obtenerUnoTemas($inId);
		} else {
			$this->_reg = array(
				  'idTema' => $inId
				, 'textoTema' => set_value('textoTema')
			);			
		}
		return $this->_reg;
	}
	
	protected function _inicReglas() {
    	$val = $this->form_validation->set_rules($this->_aReglasResolucion);      		
	}
	protected function _inicReglasTemas() {
    	$val = $this->form_validation->set_rules($this->_aReglasTemas);      		
	}
	public function reporte() {
		$data['fecha'] = date('d-m-Y');
		$data['visto'] = TRUE;
		$data['considerando'] = TRUE;
		$this->load->view('administrator/sigep/instrumentos/instrumentos-resoluciones', $data);
	}
	public function listado() {
		
        $vcBuscar = ($this->input->post('vcBuscar')===FALSE)?'': $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/instrumentos/listado'
                    , 'iTotalRegs' => $this->instrumentos->numRegs($vcBuscar, $this->input->post('anio'), $this->input->post('idTipoInstrumentoLegal'), $this->input->post('idTema'))
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Instrumentos Legales'
                    , 'identificador' => 'idInstrumentoLegal'
                )
        );
        $this->gridview->addColumn('numeroInstrumentoLegal', '#', 'int');
        $this->gridview->addColumn('fechaInstrumentoLegal', 'Fecha', 'date');
        $this->gridview->addColumn('textoTipoInstrumento', 'Tipo', 'text');
        $this->gridview->addColumn('temaInstrumentoLegal', 'Tema', 'text');
        $this->gridview->addColumn('asuntoInstrumentoLegal', 'Asunto', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $this->gridview->addParm('anio', $this->input->post('anio'));
        $this->gridview->addParm('idTipoInstrumentoLegal', $this->input->post('idTipoInstrumentoLegal'));
        $this->gridview->addParm('idTema', $this->input->post('idTema'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/instrumentos/formulario/{idInstrumentoLegal}" title="click para editar el instrumento {numeroInstrumentoLegal}" class="icono-editar btn-accion" rel="{\'idInstrumentoLegal\': {idInstrumentoLegal}}">&nbsp;</a>'.
                                                                   '<a href="{archivoInstrumentoLegal}" target="_blank" title="click para cambiar el estado de {numeroInstrumentoLegal}" class="icono-refresca" rel="{\'idInstrumentoLegal\': {idInstrumentoLegal}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:64px;'));


        $this->_rsRegs = $this->instrumentos->obtener($vcBuscar, $this->input->post('anio'), $this->input->post('idTipoInstrumentoLegal'), $this->input->post('idTema'), $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/instrumentos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'vcBuscar' => $this->input->post('vcBuscar')
                , 'anio' => $this->input->post('anio')
                , 'tipo' => $this->input->post('idTipoInstrumentoLegal')
                , 'tema' => $this->input->post('idTema')
                , 'temas' => $this->_temas
                , 'tipos' => $this->_tipos
                , 'anios' => $this->_anios
            )
        );
	}

	public function formulario() {
		$reg = $this->_inicReg($this->input->post('vcForm'));
		$aData = array (
				  'Reg' 			=> $reg
				, 'vcFrmAction'     => 'administrator/instrumentos/guardar'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['idInstrumentoLegal']>0)? 'Modificar': 'Agregar'
				, 'temas' 			=> $this->_temas
                , 'tipos' 			=> $this->_tipos
                , 'anios' 			=> $this->_anios
			);
		$this->load->view('administrator/sigep/instrumentos/formulario-manual',$aData);
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
			$this->_aEstadoOper['status'] = $this->instrumentos->guardar(
				array(
					  ($this->_reg['idInstrumentoLegal'] != '' && $this->_reg['idInstrumentoLegal'] != 0)? $this->_reg['idInstrumentoLegal'] : 0   
					, $this->_reg['numeroInstrumentoLegal']
					, $this->_reg['fechaInstrumentoLegal']
					, $this->_reg['idTipoInstrumentoLegal']
					, $this->_reg['idTema']
					, $this->_reg['asuntoInstrumentoLegal']
					, $this->_reg['archivoInstrumentoLegal']
				)
			);
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} 
		else {
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
    public function obtenerInstrumentosAutocomplete() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->instrumentos->obtenerInstrumentosAutocomplete($q);
        }
    }


    public function temas() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/instrumentos/principal-temas',array(),true);
		//		
		parent::index();
	}
	public function listadoTemas() {
		$vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/instrumentos/listadoTemas'
                    , 'iTotalRegs' => $this->instrumentos->numRegsTemas($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Temas de Instrumentos Legales'
                    , 'identificador' => 'idTema'
                )
        );

        

        $this->gridview->addColumn('idTema', '#', 'int');
        $this->gridview->addColumn('textoTema', 'Tema', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/instrumentos/formularioTemas/{idTema}" title="Editar el tema {textoTema}" class="icono-editar editar-online" rel="{\'idTema\': {idTema}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:32px;'));


        $this->_rsRegs = $this->instrumentos->obtenerTemas($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/instrumentos/listado-temas'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
	}
	public function guardarTemas() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasTemas();
        if ($this->_validarReglas()) {
            $this->_inicRegTemas((bool) $this->input->post('vcForm'));
			$this->_aEstadoOper['status'] = $this->instrumentos->guardarTemas(
                array(
                	$this->_reg['idTema']
                    , $this->_reg['textoTema']
                )
            );
        }
        else {
            echo "no se valido";
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));

		if($this->_aEstadoOper['status'] > 0) {
			$this->listadoTemas();
		} else {
			$this->formularioTemas();
		}
	}
	public function formularioTemas($tema=0) {
		$reg = $this->_inicRegTemas($this->input->post('vcForm'), $tema);
		$aData = array (
				  'Reg' 			=> $reg
				, 'vcFrmAction'     => 'administrator/instrumentos/guardarTemas'
				, 'vcMsjSrv'        => $this->_aEstadoOper['message']
				, 'vcAccion'        => ($this->_reg['idTema']>0)? 'Modificar': 'Agregar'
			);
		$this->load->view('administrator/sigep/instrumentos/formulario-temas',$aData);
	}

}
//EOF provincias.php
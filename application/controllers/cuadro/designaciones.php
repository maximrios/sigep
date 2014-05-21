<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  Maxim
 * @package sigep
 * @copyright 2013
 */
class Designaciones extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/cuadros_model', 'cuadro');
        $this->load->model('sigep/agentes_model', 'agente');
        $this->load->model('sigep/designaciones_model', 'designacion');
        $this->load->model('sigep/cuadrocargosagentes_model', 'cuadrocargoagente');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idDesignacion',
                'label' => 'Designacion',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idEstructura',
                'label' => 'Organismo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idCargo',
                'label' => 'Cargo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'nombreEstructura',
                'label' => 'Noombre de Organismo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idAgente',
                'label' => 'Agente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'apellidoPersona',
                'label' => 'Apellido',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'nombrePersona',
                'label' => 'Nombre',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'completoPersona',
                'label' => 'Nombre',
                'rules' => 'trim|xss_clean'
            ),
         
            array(
                'field' => 'fechaInicioDesignacion',
                'label' => 'Fecha de inicio de designacion',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'fechaFinDesignacion',
                'label' => 'Fecha de fin de designacion',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idInstrumentoLegal',
                'label' => 'Instrumento legal de designacion',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'instrumentoLegal',
                'label' => 'Instrumento legal de designacion',
                'rules' => 'trim|xss_clean'
            ),
        );
        //$this->cuadro_actual = $this->cuadro->obtenerVigente();
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/cuadro/designaciones/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idDesignacion' => null
            //, 'idCuadro' => $this->cuadro_actual['idCuadro']
            //, 'instrumentoCuadro' => $this->cuadro_actual['instrumentoCuadro']
            , 'idAgente' => null
            , 'completoPersona' => null
            , 'idEstructura' => null
            , 'nombreEstructura' => null
            , 'idCargo' => null
            , 'denominacionCargo' => null
            , 'idInstrumentoLegal' => null
            , 'instrumentoLegal' => null
            , 'fechaInstrumentoLegal' => null
            , 'fechaInicioDesignacion' => null
            , 'fechaFinDesignacion' => null
        );
        $inId = ($this->input->post('idDesignacion') !== false) ? $this->input->post('idDesignacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->designacion->obtenerUno($inId);
            $this->_reg['fechaInstrumentoLegal'] = GetDateFromISO($this->_reg['fechaInstrumentoLegal'], FALSE);

            $this->_reg['fechaInicioDesignacion'] = GetDateFromISO($this->_reg['fechaInicioDesignacion'], FALSE);
            ($this->_reg['fechaInicioDesignacion'] == NULL)? $this->_reg['fechaInicioDesignacion'] = $this->_reg['fechaInstrumentoLegal']:$this->_reg['fechaInicioDesignacion']=$this->_reg['fechaInicioDesignacion'];
            $this->_reg['fechaFinDesignacion'] = GetDateFromISO($this->_reg['fechaFinDesignacion'], FALSE);
        } else {
            $this->_reg = array(
                //'idDesignacion' => set_value('idDesignacion')
                //,'idCuadro' => $this->cuadro_actual['idCuadro']
                //, 'instrumentoCuadro' => $this->cuadro_actual['instrumentoCuadro']
                'idDesignacion' => $inId
                , 'idAgente' => set_value('idAgente')
                , 'completoPersona' => set_value('completoPersona')
                , 'idEstructura' => set_value('idEstructura')
                , 'nombreEstructura' => set_value('nombreEstructura')
                , 'idCargo' => set_value('idCargo')
                , 'denominacionCargo' => set_value('denominacionCargo')
                , 'idInstrumentoLegal' => set_value('idInstrumentoLegal')
                , 'instrumentoLegal' => set_value('instrumentoLegal')
                , 'fechaInstrumentoLegal' => set_value('fechaInstrumentoLegal')
                , 'fechaInicioDesignacion' => set_value('fechaInicioDesignacion')
                , 'fechaFinDesignacion' => set_value('fechaFinDesignacion')
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function listado($idNoticia = 0) {

        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'cuadro/cuadrocargosagentes/listado'
                    , 'iTotalRegs' => $this->designacion->numRegs($vcBuscar)
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );
        $this->gridview->addColumn('idDesignacion', 'Cod.', 'int');
        $this->gridview->addColumn('dniPersona', 'Documento', 'int');
        $this->gridview->addColumn('completoPersona', 'Agente', 'text');
        $this->gridview->addColumn('nombreEstructura', 'Gerencia / Area', 'text');
        $this->gridview->addColumn('instrumentoLegal', 'Instrumento Legal de Designacion', 'text');
        $this->gridview->addColumn('estadoDesignacionReal', 'Estado', 'text');
        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="cuadro/designaciones/formulario/{idDesignacion}" title="click para editar designacion {idDesignacion}" class="icono-editar btn-accion" rel="{\'idDesignacion\': {idDesignacion}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:32px;'));

        $this->_rsRegs = $this->designacion->obtener($vcBuscar, 0, 10000);
        $this->load->view('administrator/sigep/cuadro/designaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'cuadro/designaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idDesignacion'] > 0) ? 'Modificar' : 'Agregar';
        $aData['agrupamientos'] = $this->cuadro->dropdownAgrupamientos();
        $aData['escalafones'] = $this->cuadro->dropdownEscalafones();
        $aData['subgrupos'] = $this->cuadro->dropdownSubgrupos();
        $aData['equivalentes'] = $this->cuadro->dropdownEquivalentes();
        $aData['funciones'] = $this->cuadro->dropdownFunciones();
        $this->load->view('administrator/sigep/cuadro/designaciones/formulario', $aData);
    }
    public function consulta() {
        $this->load->view('administrator/sigep/cuadro/cuadrocargos/formulario-borrar'
                , array(
            'Reg' => $this->_inicReg($this->input->post('vcForm'))
            , 'vcFrmAction' => 'cuadro/cuadrocargos/eliminar'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_reg['idCuadroCargo'] > 0) ? 'Eliminar' : ''
                )
        );
    }

    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->designacion->guardar(
                    array(
                        $this->_reg['idDesignacion']
                        , $this->_reg['idAgente']
                        , $this->_reg['idEstructura']
                        , $this->_reg['idCargo']
                        , $this->_reg['idInstrumentoLegal']
                        , GetDateTimeFromFrenchToISO($this->_reg['fechaInicioDesignacion'])
                        , GetDateTimeFromFrenchToISO($this->_reg['fechaFinDesignacion'])
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        if ($this->_aEstadoOper['status'] > 0) {
            $this->listado();
        } else {
            
            $this->formulario();
        }
    }
    public function eliminar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->cargo->eliminar($this->input->post('idCargo'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
        } else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->listado();
    }

    public function obtenerAutocompleteAgentes() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->agente->obtenerAutocompleteAgentes($q);
        }
    }
}
?>
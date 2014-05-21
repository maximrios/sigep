<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @Cargos class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Cuadrocargosagentes extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/cuadros_model', 'cuadro');
        $this->load->model('sigep/agentes_model', 'agente');
        $this->load->model('sigep/cuadrocargos_model', 'cuadrocargo');
        $this->load->model('sigep/cuadrocargosagentes_model', 'cuadrocargoagente');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idCuadro',
                'label' => 'Cuadro',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idCuadroCargoAgente',
                'label' => 'Cuadro de Cargo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idCuadroCargo',
                'label' => 'Cuadro de Cargo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'ordenCuadroCargo',
                'label' => 'Numero de Orden',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idEstructura',
                'label' => 'Nombre de area',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idCargo',
                'label' => 'Denominacion del Cargo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idEscalafon',
                'label' => 'Escalafon',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idAgrupamiento',
                'label' => 'Agrupamiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idFuncion',
                'label' => 'Funcion jerarquica',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'nombrePersona',
                'label' => 'Nombre del Agente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idAgente',
                'label' => 'Codigo del Agente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idAgrupamientoCCA',
                'label' => 'Agrupamiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idSubgrupo',
                'label' => 'Agrupamiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idEquivalente',
                'label' => 'Agrupamiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idSituacionRevista',
                'label' => 'Agrupamiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'observacionesCuadroCargoAgente',
                'label' => 'Observaciones',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'perteneceCuadroCargoAgente',
                'label' => 'Pertenece',
                'rules' => 'trim|xss_clean'
            ),
        );
        $this->cuadro_actual = $this->cuadro->obtenerVigente();
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/cuadro/cuadrocargosagentes/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCuadroCargoAgente' => null
            , 'idCuadro' => $this->cuadro_actual['idCuadro']
            , 'instrumentoCuadro' => $this->cuadro_actual['instrumentoCuadro']
            , 'idCuadroCargo' => null
            , 'ordenCuadroCargo' => null
            , 'idEstructura' => null
            , 'nombreEstructura' => null
            , 'idCargo' => null
            , 'denominacionCargo' => null
            , 'idEscalafon' => null
            , 'idAgrupamiento' => null
            , 'idFuncion' => null
            , 'nombrePersona' => null
            , 'idAgente' => null
            , 'idAgrupamientoCCA' => null
            , 'idSubgrupo' => null
            , 'idEquivalente' => null
            , 'idSituacionRevista' => null
            , 'observacionesCuadroCargoAgente' => null
            , 'perteneceCuadroCargoAgente' => 1
        );
        $inId = ($this->input->post('idCuadroCargo') !== false) ? $this->input->post('idCuadroCargo') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->cuadrocargo->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idCuadroCargoAgente' => set_value('idCuadroCargoAgente')
                ,'idCuadro' => $this->cuadro_actual['idCuadro']
                , 'instrumentoCuadro' => $this->cuadro_actual['instrumentoCuadro']
                , 'idCuadroCargo' => $inId
                , 'ordenCuadroCargo' => set_value('ordenCuadroCargo')
                , 'idEstructura' => set_value('idEstructura')
                , 'nombreEstructura' => set_value('nombreEstructura')
                , 'idCargo' => set_value('idCargo')
                , 'denominacionCargo' => set_value('denominacionCargo')
                , 'idEscalafon' => set_value('idEscalafon')
                , 'idAgrupamiento' => set_value('idAgrupamiento')
                , 'idFuncion' => set_value('idFuncion')
                , 'nombrePersona' => set_value('nombrePersona')
                , 'idAgente' => set_value('idAgente')
                , 'idAgrupamientoCCA' => set_value('idAgrupamientoCCA')
                , 'idSubgrupo' => set_value('idSubgrupo')
                , 'idEquivalente' => set_value('idEquivalente')
                , 'observacionesCuadroCargoAgente' => set_value('observacionesCuadroCargoAgente')
                , 'perteneceCuadroCargoAgente' => set_value('perteneceCuadroCargoAgente')
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
                    , 'iTotalRegs' => $this->cuadrocargoagente->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Cargos por Agente'
                    , 'identificador' => 'idCuadroCargoAgente'
                )
        );
        $this->gridview->addColumn('ordenCuadroCargo', 'Ord.', 'text');
        $this->gridview->addColumn('nombreEstructura', 'Area', 'text');
        $this->gridview->addColumn('denominacionCargo', 'Denominacion del cargo', 'text');
        $this->gridview->addColumn('idEscalafon', 'Esc.', 'int');
        $this->gridview->addColumn('nombreAgrupamientoCC', 'Agr.', 'text');
        $this->gridview->addColumn('nombreFuncion', 'Fun.', 'text');
        $this->gridview->addColumn('nombrePersona', 'Ocupado', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $this->gridview->addColumn('nombreAgrupamientoCCA', 'Agr.', 'text');
        $this->gridview->addColumn('idSubgrupo', 'Subg.', 'text');
        $this->gridview->addColumn('denominacionEquivalente', 'Eq. Rem.', 'text');
        $this->gridview->addColumn('observacionesCuadroCargoAgente', 'Obs.', 'text');

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="cuadro/cuadrocargosagentes/formulario/{idCuadroCargo}" title="click para editar {denominacionCargo}" class="icono-editar btn-accion" rel="{\'idCuadroCargo\': {idCuadroCargo}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:32px;'));

        $this->_rsRegs = $this->cuadrocargo->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/cuadro/cuadrocargosagentes/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'cuadro/cuadrocargosagentes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCuadroCargo'] > 0) ? 'Modificar' : 'Agregar';
        $aData['agrupamientos'] = $this->cuadro->dropdownAgrupamientos();
        $aData['escalafones'] = $this->cuadro->dropdownEscalafones();
        $aData['subgrupos'] = $this->cuadro->dropdownSubgrupos();
        $aData['equivalentes'] = $this->cuadro->dropdownEquivalentes();
        $aData['funciones'] = $this->cuadro->dropdownFunciones();
        $this->load->view('administrator/sigep/cuadro/cuadrocargosagentes/formulario', $aData);
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
            $this->_aEstadoOper['status'] = $this->cuadrocargoagente->guardar(
                    array(
                        $this->_reg['idCuadroCargoAgente']
                        , $this->_reg['idAgrupamientoCCA']
                        , $this->_reg['idSubgrupo']
                        , $this->_reg['idEquivalente']
                        , $this->_reg['idCuadroCargo']
                        , $this->_reg['idAgente']
                        , $this->_reg['idSituacionRevista']
                        , $this->_reg['observacionesCuadroCargoAgente']
                        , $this->_reg['perteneceCuadroCargoAgente']
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
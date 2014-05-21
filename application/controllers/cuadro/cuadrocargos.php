<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @Cargos class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Cuadrocargos extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/cuadros_model', 'cuadro');
        $this->load->model('sigep/cuadrocargos_model', 'cuadrocargo');
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
        );
        $this->cuadro_actual = $this->cuadro->obtenerVigente();
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/cuadro/cuadrocargos/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCuadro' => $this->cuadro_actual['idCuadro']
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
        );
        $inId = ($this->input->post('idCuadroCargo') !== false) ? $this->input->post('idCuadroCargo') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->cuadrocargo->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idCuadro' => $this->cuadro_actual['idCuadro']
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
                    'sResponseUrl' => 'cuadro/cuadrocargos/listado'
                    , 'iTotalRegs' => $this->cuadrocargo->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Cuadro de Cargos'
                )
        );
        $this->gridview->addColumn('ordenCuadroCargo', 'Orden', 'text');
        $this->gridview->addColumn('nombreEstructura', 'Area', 'text');
        $this->gridview->addColumn('denominacionCargo', 'Denominacion del cargo', 'text');
        $this->gridview->addColumn('idEscalafon', 'Esc.', 'int');
        $this->gridview->addColumn('nombreAgrupamientoCC', 'Agr.', 'text');
        $this->gridview->addColumn('nombreFuncion', 'Fun.', 'text');
        $this->gridview->addColumn('nombrePersona', 'Ocupado', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="cuadro/cuadrocargos/formulario/{idCuadroCargo}" title="click para editar {denominacionCargo}" class="icono-editar btn-accion" rel="{\'idCuadroCargo\': {idCuadroCargo}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:32px;'));

        $this->_rsRegs = $this->cuadrocargo->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/cuadro/cuadrocargos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {

        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'cuadro/cuadrocargos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCuadroCargo'] > 0) ? 'Modificar' : 'Agregar';
        $aData['agrupamientos'] = $this->cuadro->dropdownAgrupamientos();
        $aData['escalafones'] = $this->cuadro->dropdownEscalafones();
        $aData['funciones'] = $this->cuadro->dropdownFunciones();
        $this->load->view('administrator/sigep/cuadro/cuadrocargos/formulario', $aData);
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
            $this->_aEstadoOper['status'] = $this->cuadrocargo->guardar(
                    array(
                        $this->_reg['idCuadroCargo']
                        , $this->_reg['ordenCuadroCargo']
                        , $this->_reg['idCargo']
                        , $this->_reg['idEscalafon']
                        , $this->_reg['idAgrupamiento']
                        , $this->_reg['idFuncion']
                        , $this->_reg['idEstructura']
                        , $this->_reg['idCuadro']
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

    public function obtenerAutocomplete() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->estructura->obtenerAutocomplete($q);
        }
    }
    public function obtenerAutocompleteCargos() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->cargo->obtenerAutocompleteCargos($q);
        }
    }
}
?>
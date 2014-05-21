<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @Cargos class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Cargos extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idCargo',
                'label' => 'Cargo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'denominacionCargo',
                'label' => 'Denominacion del cargo',
                'rules' => 'trim|xss_clean|required'
            )
        );
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/cuadro/cargos/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCargo' => null
            , 'denominacionCargo' => null
        );
        $inId = ($this->input->post('idCargo') !== false) ? $this->input->post('idCargo') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->cargo->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idCargo' => $inId
                , 'denominacionCargo' => set_value('denominacionCargo')
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
                    'sResponseUrl' => 'cuadro/cargos/listado'
                    , 'iTotalRegs' => $this->cargo->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Cargos'
                    , 'identificador' => 'idCargo'
                )
        );
        $this->gridview->addColumn('idCargo', '#', 'int');
        $this->gridview->addColumn('denominacionCargo', 'Denominacion del cargo', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="cuadro/cargos/formulario/{idCargo}" title="click para editar {denominacionCargo}" class="icono-editar btn-accion" rel="{\'idCargo\': {idCargo}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:32px;'));

        $this->_rsRegs = $this->cargo->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/cuadro/cargos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'cuadro/cargos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCargo'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/cuadro/cargos/formulario', $aData);
    }
    public function consulta() {
        $this->load->view('administrator/sigep/cuadro/cargos/formulario-borrar'
                , array(
            'Reg' => $this->_inicReg($this->input->post('vcForm'))
            , 'vcFrmAction' => 'cuadro/cargos/eliminar'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_reg['idCargo'] > 0) ? 'Eliminar' : ''
                )
        );
    }

    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->cargo->guardar(
                    array(
                        $this->_reg['idCargo']
                        , $this->_reg['denominacionCargo']
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
}
?>
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */

/**
 * @Noticias class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Formaciones extends Ext_crud_controller {
    private $_aTemas = array();
    private $_rsRegs = array();
    private $_temas = array();
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/agentes_model', 'agentes');
        $this->load->model('hits/formaciones_model', 'formaciones');
        
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->load->helper('ckeditor_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idFormacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idPersona',
                'label' => 'Agente',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idNivel',
                'label' => 'Nivel de Estudio',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idTitulo',
                'label' => 'Titulo',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idAvance',
                'label' => 'Avance',
                'rules' => 'trim|xss_clean|required'
            ),
        );
    }

    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/formaciones/principal', array(), true);
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idFormacion' => null
            , 'idPersona' => null
            , 'idNivel' => null
            , 'idTitulo' => null
            , 'idAvance' => null
        );
        $inId = ($this->input->post('idFormacion') !== false) ? $this->input->post('idFormacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->actuaciones->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idFormacion' => $inId
                , 'idPersona' => $this->input->post('idPersona')
                , 'idNivel' => $this->input->post('idNivel')
                , 'idTitulo' => $this->input->post('idTitulo')
                , 'idAvance' => $this->input->post('idAvance')
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $vcOrder = ($this->input->post('order') === FALSE) ? '' : $this->input->post('order');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/hits/formaciones/listado'
                    , 'iTotalRegs' => $this->formaciones->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Formaciones'
                    , 'buscador' => TRUE
                    , 'identificador' => 'idFormacion'
                )
        );
        $this->gridview->addColumn('idFormacion', '#', 'int', array('order' => TRUE));
        $this->gridview->addColumn('nombrePersona', 'Nombre', 'text');
        $this->gridview->addColumn('nombreFormacionTipo', 'Nivel', 'text');
        $this->gridview->addColumn('nombreFormacionTitulo', 'Titulo', 'text');
        $this->gridview->addColumn('nombreFormacionAvance', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="administrator/formaciones/formulario/{idFormacion}" title="Editar {nombreFormacionTitulo}" class="btn-accion" rel="{\'idFormacion\': {idFormacion}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $eliminar = '<a href="administrator/formaciones/eliminar/{idFormacion}" title="Eliminar formacion {nombreFormacionTitulo}" class="btn-accion" rel="{\'idFormacion\': {idFormacion}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $acciones = $editar.$eliminar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:60px;'));
        $this->_rsRegs = $this->formaciones->obtener($vcBuscar, $vcOrder, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/hits/formaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $aData['niveles'] = $this->formaciones->dropdownNiveles();
        $aData['titulos'] = $this->formaciones->dropDownTitulos();
        $aData['avances'] = $this->formaciones->dropDownAvances();
        $aData['agentes'] = $this->agentes->dropdownAgentesP();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/formaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idFormacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/hits/formaciones/formulario', $aData);
    }
    public function consulta() {
        $this->load->view('lib_autenticacion/frm-faq-borrar'
                , array(
            'Reg' => $this->_inicReg($this->input->post('vcForm'))
            , 'vcFrmAction' => 'autenticacion/faq/eliminar'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_reg['inIdFaq'] > 0) ? 'Eliminar' : ''
                )
        );
    }
    function ver($noticia) {
        $aData['noticia'] = $this->noticia->obtenerUno($noticia);
        if($aData['noticia']) {
            $this->_SiteInfo['title'] .= ' - '.$aData['noticia']['tituloNoticia'];
            $aData['comentarios'] = $this->noticia->obtenerComentarios($aData['noticia']['idNoticia']);
            $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/noticias/ver', $aData, true);
            parent::index();
            //$this->load->view('administrator/hits/noticias/ver', $aData);
        }
        else {

        }
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->formaciones->guardar(
                    array(
                        $this->_reg['idFormacion']
                        , $this->_reg['idPersona']
                        , $this->_reg['idNivel']
                        , $this->_reg['idTitulo']
                        , $this->_reg['idAvance']
                        , 0
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
        } 
        else {
            $this->formulario();
        }
    }
    public function eliminar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->formaciones->eliminar($this->input->post('idFormacion'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con éxito.';
        } 
        else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->listado();
    }
}
?>
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
class Actuaciones extends Ext_crud_controller {
    private $_aTemas = array();
    private $_rsRegs = array();
    private $_temas = array();
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/actuaciones_model', 'actuaciones');
        $this->load->model('sigep/instrumentos_model', 'instrumentos');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->load->helper('ckeditor_helper');
        $this->capa = array(
            'id'    =>  'ckeditor',
            'path'  =>  'assets/libraries/ckeditor',
            'config' => array(
                'toolbar'   =>  "Full",     //Using the Full toolbar
                'width'     =>  "100%",    //Setting a custom width
                'height'    =>  '300px',    //Setting a custom height
 
            ),
        );
        $this->_aReglas = array(
            array(
                'field' => 'idActuacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'fechaCreacionActuacion',
                'label' => 'Fecha Creación | Recepción',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'foliosActuacion',
                'label' => 'Cantidad de Folios',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idIniciador',
                'label' => 'Codigo Iniciador',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'iudIniciador',
                'label' => 'I.U.D. Iniciador',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'nombreIniciador',
                'label' => 'Nombre Iniciador',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idActuacionTipo',
                'label' => 'Tipo de Actuación',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idActuacionTema',
                'label' => 'Tema de Actuación',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'caratulaActuacion',
                'label' => 'Carátula | Extracto',
                'rules' => 'trim|xss_clean|required'
            ),
        );
    }

    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/actuaciones/principal', array(), true);
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idActuacion' => null
            , 'fechaCreacionActuacion' => null
            , 'referenciaActuacion' => null
            , 'numeroActuacion' => null
            , 'foliosActuacion' => null
            , 'idIniciador' => null
            , 'iudIniciador' => null
            , 'nombreIniciador' => null
            , 'idEstructura' => null
            , 'iudEstructura' => null
            , 'nombreEstructura' => null
            , 'idActuacionEstado' => 1
            , 'idActuacionTipo' => null
            , 'idActuacionTema' => null
            , 'caratulaActuacion' => null
            , 'idUsuario' => null
        );
        $inId = ($this->input->post('idActuacion') !== false) ? $this->input->post('idActuacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->actuaciones->obtenerUno($inId);
            $this->_reg['fechaCreacionActuacion'] = GetDateFromISO($this->_reg['fechaCreacionActuacion'], FALSE);
        } else {
            $this->_reg = array(
                'idActuacion' => $inId
                , 'fechaCreacionActuacion' => ($this->input->post('fechaCreacionActuacion') === FALSE) ? GetToday('d/m/Y') : set_value('fechaCreacionActuacion')
                , 'referenciaActuacion' => $this->input->post('referenciaActuacion')
                , 'numeroActuacion' => $this->input->post('numeroActuacion')
                , 'foliosActuacion' => $this->input->post('foliosActuacion')
                , 'idIniciador' => $this->input->post('idIniciador')
                , 'iudIniciador' => $this->input->post('iudIniciador')
                , 'nombreIniciador' => $this->input->post('nombreIniciador')
                , 'idEstructura' => $this->lib_ubicacion->idEstructura()
                , 'iudEstructura' => $this->lib_ubicacion->iudEstructura()
                , 'nombreEstructura' => $this->lib_ubicacion->nombreEstructura()
                , 'idActuacionEstado' => $this->input->post('idActuacionEstado')
                , 'idActuacionTipo' => $this->input->post('idActuacionTipo')
                , 'idActuacionTema' => $this->input->post('idActuacionTema')
                , 'caratulaActuacion' => $this->input->post('caratulaActuacion')
                , 'idUsuario' => $this->lib_autenticacion->idUsuario()
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
                    'sResponseUrl' => 'administrator/actuaciones/listado'
                    , 'iTotalRegs' => $this->actuaciones->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Actuaciones'
                    , 'buscador' => TRUE
                    , 'identificador' => 'idActuacion'
                )
        );
        $this->gridview->addColumn('idActuacion', '#', 'int', array('order' => TRUE));
        $this->gridview->addColumn('codigoActuacion', 'Codigo', 'text');
        $this->gridview->addColumn('referenciaActuacion', 'Referencia', 'text');
        $this->gridview->addColumn('nombreActuacionTipo', 'Tipo', 'text');
        $this->gridview->addColumn('nombreActuacionTema', 'Tema', 'text', array('order' => TRUE));
        $this->gridview->addColumn('caratulaActuacion', 'Carátula', 'tinyText');
        $this->gridview->addColumn('nombreActuacionEstado', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $pases = '<a href="administrator/pases/listado/{idActuacion}" title="Ver detalle de pases de Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-th-list"></span></a>';
        $print = '<a href="administrator/usuarios/formulario/{idActuacion}" title="Imprimir Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-print"></span></a>';
        $eliminar = '<a href="administrator/usuarios/formulario/{idActuacion}" title="Eliminar actuacion N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $editar = '<a href="administrator/actuaciones/formulario/{idActuacion}" title="Editar Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $acciones = $editar.$eliminar.$pases.$print;

        
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:86px;'));
        $this->_rsRegs = $this->actuaciones->obtener($vcBuscar, $vcOrder, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/actuaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        //echo str_pad(001, 4, '0', STR_PAD_LEFT);
        $aData['tipos'] = $this->instrumentos->dropdownTipos();
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/actuaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/formulario', $aData);
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
    public function buscarMesa() {
        $this->load->model('sigep/estructuras_model', 'estructura');
        $data = $this->estructura->obtenerUnoIud($this->input->post('iud'));
        echo json_encode($data);
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->actuaciones->guardar(
                    array(
                        $this->_reg['idActuacion']
                        , $this->_reg['referenciaActuacion']
                        , $this->_reg['idIniciador']
                        , $this->_reg['iudIniciador']
                        , $this->_reg['foliosActuacion']
                        , $this->_reg['caratulaActuacion']
                        , $this->_reg['idActuacionEstado']
                        , $this->_reg['idActuacionTipo']
                        , $this->_reg['idActuacionTema']
                        , $this->_reg['idEstructura']
                        , $this->lib_autenticacion->idUsuario()
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
            echo '<script>delete CKEDITOR.instances["descripcionNoticia"]</script>';
            $this->listado();
        } else {
            
            $this->formulario();
            
        }
    }
    public function eliminar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdFaq'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
        } else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        $this->listado();
    }
    public function nuevo() {
        $aData['ckeditor_texto'] = $this->capa;
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/actuaciones/crear';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/nuevo', $aData);
    }
    public function crear() {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['nota'] = $_POST;
        //$aData['pase'] = $this->pases->obtenerUno($idPase);
        //$aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        $this->load->view('administrator/sigep/actuaciones/notas/previa', $aData);
    }
}
?>
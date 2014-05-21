<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package Sigep
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
class Pases extends Ext_crud_controller {
    private $_aTemas = array();
    private $_rsRegs = array();
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/actuaciones_model', 'actuaciones');
        $this->load->model('sigep/pases_model', 'pases');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idPase',
                'label' => 'Pase',
                'rules' => 'trim|xss_clean'
            ),
        );
    }
    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/actuaciones/pases/principal', array(), true);
        parent::index();
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idActuacionPase' => null
            , 'idActuacion' => null
            , 'numeroActuacionPase' => null
            , 'fechaEnvioActuacionPase' => null
            , 'fechaRecepcionActuacionPase' => null
            , 'idEstructuraOrigen' => null
            , 'nombreOrigen' => null
            , 'idEstructuraDestino' => null
            , 'nombreDestino' => null
            , 'observacionActuacionPase' => null
            , 'idPaseEstado' => null
            , 'idUsuario' => $this->lib_autenticacion->idUsuario()
        );
        $inId = ($this->input->post('idNoticia') !== false) ? $this->input->post('idNoticia') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->noticia->obtenerUno($inId);
            $this->_reg['inicioNoticia'] = GetDateFromISO($this->_reg['inicioNoticia'], FALSE);
            $this->_reg['vencimientoNoticia'] = GetDateFromISO($this->_reg['vencimientoNoticia'], FALSE);
        } 
        else {
            $this->_reg = array(
                'idActuacionPase' => $inId
                , 'idActuacion' => $this->input->post('idActuacion')
                , 'numeroActuacionPase' => $this->input->post('numeroActuacionPase')
                , 'fechaEnvioActuacionPase' => ($this->input->post('fechaEnvioActuacionPase') === FALSE) ? GetToday('d/m/Y') : set_value('fechaEnvioActuacionPase')
                , 'fechaRecepcionActuacionPase' => ($this->input->post('fechaRecepcionActuacionPase') === FALSE) ? GetToday('d/m/Y') : set_value('fechaRecepcionActuacionPase')
                , 'idEstructuraOrigen' => $this->input->post('idEstructuraOrigen')
                , 'nombreOrigen' => $this->lib_ubicacion->nombreEstructura()
                , 'idEstructuraDestino' => $this->input->post('idEstructuraDestino')
                , 'nombreDestino' => $this->input->post('nombreDestino')
                , 'observacionActuacionPase' => $this->input->post('observacionActuacionPase')
                , 'idPaseEstado' => $this->input->post('idPaseEstado')
                , 'idUsuario' => $this->lib_autenticacion->idUsuario()
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function listado($idActuacion = 0) {
        $actuacion = $this->actuaciones->obtenerUno($idActuacion);
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/pases/listado'
                    , 'iTotalRegs' => $this->pases->numRegs($idActuacion, $vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Pases - Actuacion N° '.$actuacion['numeroActuacion'].'/'.date('Y', strtotime($actuacion['fechaCreacionActuacion']))
                    , 'buscador' => TRUE
                    , 'identificador' => 'idActuacion'
                )
        );
        $this->gridview->addColumn('idActuacionPase', '#', 'int');
        $this->gridview->addColumn('nombreOrigen', 'Origen', 'text');
        $this->gridview->addColumn('apellidoPersonaOrigen', 'Usuario', 'text', array('order' => TRUE));
        $this->gridview->addColumn('fechaEnvioActuacionPase', 'Envío', 'datetime');
        $this->gridview->addColumn('nombreDestino', 'Destino', 'text');
        $this->gridview->addColumn('apellidoPersonaDestino', 'Usuario', 'text', array('order' => TRUE));
        $this->gridview->addColumn('fechaRecepcionActuacionPase', 'Recepción', 'datetime');
        $this->gridview->addColumn('nombrePaseEstado', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $print = '<a href="administrator/pases/comprobante/{idActuacionPase}" target="_blank" title="Imprimir Pase" class="" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-print"></span></a>';
        $usuario = '<a href="administrator/usuarios/formulario/{idActuacionPase}" title="Eliminar Pase" class="btn-accion" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $usuario = '<a href="administrator/pases/formulario/{idActuacionPase}" title="Editar Pase N°" class="btn-accion" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-pencil"></span></a>'.$usuario.$print;
            $acciones = $usuario;

        
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:66px;'));
        $this->_rsRegs = $this->pases->obtener($idActuacion, $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/actuaciones/pases/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idActuacion' => $this->input->post('idActuacion')
            )
        );
    }
    public function formulario($idActuacion) {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['mesas'] = $this->pases->dropdownEstructurasMesas($this->lib_ubicacion->idEstructura());
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['vcFrmAction'] = 'administrator/pases/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacionPase'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/pases/formulario', $aData);
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
        }
        else {

        }
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->pases->guardar(
                    array(
                        $this->_reg['idNoticia']
                        , $this->_reg['tituloNoticia']
                        , $this->_reg['descripcionNoticia']
                        , GetDateTimeFromFrenchToISO($this->_reg['inicioNoticia'])
                        , GetDateTimeFromFrenchToISO($this->_reg['vencimientoNoticia'])
                        , $this->_reg['idTipoNoticia']
                        , $this->_reg['publicadoNoticia']
                        , 1
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
        } 
        else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->listado();
    }
    public function comprobante($idPase) {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['pase'] = $this->pases->obtenerUno($idPase);
        $aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        $this->load->view('administrator/sigep/actuaciones/pases/comprobante2', $aData);
    }
}
?>
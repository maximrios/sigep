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
class Mensajes extends Ext_crud_controller {

    private $_aTemas = array();
    private $_rsRegs = array();

    function __construct() {
        parent::__construct();

        //$this->load->model($this->db->dbdriver . '/lib_autenticacion/faq_model', '_oModel');
        $this->load->model('hits/mensajes_model', 'mensaje');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');

        //$this->_aTemas = $this->_oModel->obtTemas();

        $this->_aReglas = array(
            array(
                'field' => 'idMensaje',
                'label' => 'Noticia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idTipoMensaje',
                'label' => 'Fecha de Inicio',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'asuntoMensaje',
                'label' => 'Fecha de Vencimiento',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'deMensaje',
                'label' => 'Titulo',
                'rules' => 'trim|required'
            ),
            /*array(
                'field' => 'destinatarioMensaje',
                'label' => 'Descripcion',
                'rules' => 'trim|required'
            ),*/
            array(
                'field' => 'textoMensaje',
                'label' => 'Tipo de Noticia',
                'rules' => 'trim|xss_clean'
            )
        );
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/mensajes/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idMensaje' => null
            , 'idTipoMensaje' => null
            , 'asuntoMensaje' => 'Sin asunto'
            , 'deMensaje' => ''
            , 'destinatarioMensaje' => ''
            , 'textoMensaje' => null
        );
        $inId = ($this->input->post('idMensaje') !== false) ? $this->input->post('idMensaje') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->mensaje->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idMensaje' => $inId
                , 'idTipoMensaje' => set_value('idTipoMensaje')
                , 'asuntoMensaje' => (set_value('asuntoMensaje') == '')?'Sin Asunto':set_value('asuntoMensaje')
                , 'deMensaje' => set_value('deMensaje')
                , 'destinatarioMensaje' => set_value('destinatarioMensaje')
                , 'textoMensaje' => set_value('textoMensaje')
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
                    'sResponseUrl' => 'administrator/noticias/listado'
                    , 'iTotalRegs' => $this->noticia->numRegs($vcBuscar)
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );

        

        $this->gridview->addColumn('idNoticia', '#', 'int');
        $this->gridview->addColumn('tituloNoticia', 'Titulo', 'text');
        $this->gridview->addColumn('inicioNoticia', 'Inicio', 'date');
        $this->gridview->addColumn('vencimientoNoticia', 'Fin', 'date');
        $this->gridview->addColumn('nombrePersona', 'Usuario', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/noticias/formulario/{idNoticia}" title="click para editar {tituloNoticia}" class="icono-editar btn-accion" rel="{\'idNoticia\': {idNoticia}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/consulta/{idNoticia}" title="click para eliminar {tituloNoticia}" class="icono-eliminar btn-accion" rel="{\'idNoticia\': {idNoticia}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/reiniciarLecturas/{idNoticia}" title="reiniciar lecturas de {tituloNoticia}" class="icono-refresca btn-accion" rel="{\'idNoticia\': {idNoticia}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:96px;'));


        $this->_rsRegs = $this->noticia->obtener($vcBuscar, 0, 10000);
        $this->load->view('administrator/hits/noticias/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'aTemas' => $this->_aTemas
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario($agente=0) {
        ($agente!=0)? $aData['destinatarioMensaje']=$agente:$aData['destinatarioMensaje']=0;
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/mensajes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idMensaje'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/hits/mensajes/formulario', $aData);
    }
    public function formularioUno($agente=0) {
        ($agente!=0)? $aData['destinatarioMensaje']=$agente:'';
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/mensajes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idMensaje'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/hits/mensajes/formulario-privado', $aData);
    }
    public function ver($mensaje) {
        $this->mensaje->cambiarEstado(array(2, $mensaje));
        $data['mensaje'] = $this->mensaje->obtenerUno($mensaje);
        $this->load->view('administrator/hits/mensajes/ver', $data);
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
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            if(count($this->input->post('destinatarioMensaje')) > 0) {
                echo "entro en el if";
                foreach ($this->input->post('destinatarioMensaje') as $destinatarioMensaje) {
                    $this->_aEstadoOper['status'] = $this->mensaje->guardar(
                        array(
                            $this->_reg['idMensaje']
                            , $this->_reg['idTipoMensaje']
                            , $this->_reg['asuntoMensaje']
                            , $this->_reg['deMensaje']
                            , $destinatarioMensaje
                            , $this->_reg['textoMensaje']
                        )
                    );
                }    
            }
            else {
                echo "entro en el else";
                $this->_aEstadoOper['status'] = $this->mensaje->guardar(
                    array(
                        $this->_reg['idMensaje']
                        , $this->_reg['idTipoMensaje']
                        , $this->_reg['asuntoMensaje']
                        , $this->_reg['deMensaje']
                        , $this->_reg['destinatarioMensaje']
                        , $this->_reg['textoMensaje']
                    )
                );
            }
        }
        else {
            echo "no se valido";
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
    public function obtenerMensajesNuevos() { 
        $this->load->model('sigep/layout_model', 'layout');
        $rsReg = $this->layout->mensajesNuevos($this->lib_autenticacion->idPersona());
        return $rsReg;
    }
}

?>
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */

/**
 * @FAQ class
 * @package Base
 * @author  Nacho Fassini
 * @copyright 2012-01
 */
class Materiales extends Ext_crud_controller {

    private $_aTemas = array();
    private $_rsRegs = array();

    function __construct() {
        parent::__construct();

        $this->load->model($this->db->dbdriver . '/lib_autenticacion/faq_model', '_oModel');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');

        $this->_aTemas = $this->_oModel->obtTemas();

        $this->_aReglas = array(
            array(
                'field' => 'idNoticia',
                'label' => 'Tema',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'inicioNoticia',
                'label' => 'Fecha de Inicio',
                'rules' => 'trim/xss_clean'
            ),
            array(
                'field' => 'vencimientoNoticia',
                'label' => 'Fecha de Vencimiento',
                'rules' => 'trim/xss_clean'
            ),
            array(
                'field' => 'tituloNoticia',
                'label' => 'Titulo',
                'rules' => 'trim|required|min_length[5]|max_length[300]|xss_clean'
            ),
            array(
                'field' => 'descripcionNoticia',
                'label' => 'Descripcion',
                'rules' => 'trim|required|min_length[5]|max_length[5000]|xss_clean'
            ),
            array(
                'field' => 'idTipoNoticia',
                'label' => 'Orden',
                'rules' => 'trim|is_natural|max_length[4]|xss_clean'
            ),
            array(
                'field' => 'publicadoNoticia',
                'label' => 'Activo',
                'rules' => 'trim|xss_clean'
            )
        );

        /*$this->_aReglasTema = array(
            array(
                'field' => 'vcTemaFaq',
                'label' => 'Tema',
                'rules' => 'trim|required|max_length[50]|xss_clean'
            ),
            array(
                'field' => 'vcTemaDesc',
                'label' => 'Descripcion',
                'rules' => 'trim|max_length[100]|xss_clean'
            ),
            array(
                'field' => 'inIdOrden',
                'label' => 'Orden',
                'rules' => 'trim|is_natural|xss_clean'
            ),
            array(
                'field' => 'bActivo',
                'label' => 'Activo',
                'rules' => 'trim|xss_clean'
            )
        );*/
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/noticias/noticias', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idNoticia' => null
            , 'inicioNoticia' => null
            , 'vencimientoNoticia' => null
            , 'tituloNoticia' => ''
            , 'descripcionNoticia' => ''
            , 'idTipoNoticia' => null
            , 'publicadoNoticia' => null
        );
        $inId = ($this->input->post('idNoticia') !== false) ? $this->input->post('idNoticia') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->_oModel->obtenerUno($inId);
            $this->_reg['inicioNoticia'] = GetDateFromISO($this->_reg['inicioNoticia'], FALSE);
            $this->_reg['vencimientoNoticia'] = GetDateFromISO($this->_reg['vencimientoNoticia'], FALSE);
        } else {
            $this->_reg = array(
                'idNoticia' => $inId
                , 'inicioNoticia' => ($this->input->post('inicioNoticia') === FALSE) ? GetToday('d/m/Y') : set_value('inicioNoticia')
                , 'vencimientoNoticia' => ($this->input->post('vencimientoNoticia') === FALSE) ? GetToday('d/m/Y') : set_value('vencimientoNoticia')
                , 'idTipoNoticia' => $this->input->post('idTipoNoticia')
                , 'tituloNoticia' => set_value('tituloNoticia')
                , 'descripcionNoticia' => set_value('descripcionNoticia')
                , 'publicadoNoticia' => ((bool)(set_value('publicadoNoticia')))
            );
        }
        return $this->_reg;
    }

    protected function _inicRegTema($boIsPostBack=false) {
        $this->_regTema = array(
            'inIdTemaFaq' => null, 'vcTemaFaq' => '', 'vcTemaDesc' => '', 'inIdOrden' => null, 'bActivo' => null
        );
        $inIdTemaFaq = ($this->input->post('inIdTemaFaq') !== false) ? $this->input->post('inIdTemaFaq') : 0;
        if ($inIdTemaFaq != 0 && !$boIsPostBack) {
            $this->_regTema = $this->_oModel->obtUnTema($inIdTemaFaq);
        } else {
            $this->_regTema = array(
                'inIdTemaFaq' => $inIdTemaFaq
                , 'vcTemaFaq' => set_value('vcTemaFaq')
                , 'vcTemaDesc' => set_value('vcTemaDesc')
                , 'inIdOrden' => set_value('inIdOrden')
                , 'bActivo' => ((bool)(set_value('bActivo')))
            );
        }
        return $this->_regTema;
    }

    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }

    protected function _inicReglasTema() {
        $val = $this->form_validation->set_rules($this->_aReglasTema);
    }

    public function listado($inIdTemaFaq = 0) {

        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'autenticacion/faq/listado'
                    , 'iTotalRegs' => $this->_oModel->numRegs($vcBuscar)
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="autenticacion/faq/formulario/{inIdFaq}" title="click para editar {vcPregunta}" class="icono-editar btn-accion" rel="{\'inIdFaq\': {inIdFaq}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/consulta/{inIdFaq}" title="click para eliminar {vcPregunta}" class="icono-eliminar btn-accion" rel="{\'inIdFaq\': {inIdFaq}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/reiniciarLecturas/{inIdFaq}" title="reiniciar lecturas de {vcPregunta}" class="icono-refresca btn-accion" rel="{\'inIdFaq\': {inIdFaq}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:96px;'));

        //$this->gridview->addColumn('inIdFaq', '#', 'int');
        $this->gridview->addColumn('tsFecPublicacion', 'Publicacion', 'date');
        $this->gridview->addColumn('vcTemaFaq', 'Tema', 'text');
        $this->gridview->addColumn('vcPregunta', 'Pregunta', 'text');
        $this->gridview->addColumn('vcRespuesta', 'Respuesta', 'text');
        $this->gridview->addColumn('inIdOrden', 'Orden', 'int', array('face' => '', 'class' => '', 'style' => 'padding: 6px 0 0 32px; width:50px;'));
        $this->gridview->addColumn('bActivo', 'Activo', 'bool', array('face' => '', 'class' => '', 'style' => 'padding: 6px 0 0 32px; width:50px;'));
        $this->gridview->addColumn('inCantLecturas', 'Lecturas', 'int', array('face' => '', 'class' => '', 'style' => 'padding: 6px 0 0 32px; width:50px;'));

        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->_rsRegs = $this->_oModel->obtener($vcBuscar, 0, 10000);

        $this->load->view('lib_autenticacion/lst-faq'
                , array(
            'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'aTemas' => $this->_aTemas
            , 'txtvcBuscar' => $vcBuscar
                )
        );
    }

    public function listadoTemas() {
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'autenticacion/faq/listadoTemas'
                    , 'iTotalRegs' => ''
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );
        // 'iTotalRegs' => $this->_oModel->obtCantTemas()
        $this->gridview->addControl('inIdTemaFaqCtrl', array('face' => '<a href="autenticacion/faq/formularioTema/{inIdTemaFaq}" title="click para editar {vcTemaFaq}" class="icono-editar btn-accion" rel="{\'inIdTemaFaq\': {inIdTemaFaq}}">&nbsp;</a><a href="autenticacion/faq/consultaTema/{inIdTemaFaq}" title="click para eliminar {vcTemaFaq}" class="icono-eliminar btn-accion" rel="{\'inIdTemaFaq\': {inIdTemaFaq}}">&nbsp;</a>', 'class' => 'acciones', 'style' => 'width:64px;'));

        //$this->gridview->addColumn('inIdTemaFaq', '#', 'int');
        $this->gridview->addColumn('vcTemaFaq', 'Tema', 'text');
        $this->gridview->addColumn('vcTemaDesc', 'Descripcion', 'text');
        $this->gridview->addColumn('inIdOrden', 'Orden', 'int');
        $this->gridview->addColumn('bActivo', 'Activo', 'bool', array('face' => '', 'class' => '', 'style' => 'padding: 6px 0 0 32px; width:50px;'));

        $this->_rsRegs = $this->_oModel->obtTemas();

        $this->load->view('lib_autenticacion/lst-faq-tema'
                , array(
            'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'btOpciones' => '<div class="toolbar-rgt-sb-der"><div style="margin-top: 30px;"><a href="autenticacion/faq/listado" id="btn-editar" title="Editar Preguntas" class="button editar btn-accion">Editar Preguntas</a></div></div>
                    <div class="toolbar-rgt-sb-izq"><a href="autenticacion/faq/listadoTemasEditar" id="btn-editar-tema" title="Editar el orden de los temas" class="button editar btn-accion" >Editar Orden</a>
            <a href="autenticacion/faq/formularioTema" id="btn-nuevo" title="Agregar Tema" class="button agregar btn-accion">Agregar Tema</a></div>'
                )
        );
    }

    public function listadoTemasEditar() {
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'autenticacion/faq/listadoTemas'
                    , 'iTotalRegs' => ''
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );
        // 'iTotalRegs' => $this->_oModel->obtCantTemas()
        //$this->gridview->addColumn('inIdTemaFaq', '#', 'int');
        $this->gridview->addColumn('vcTemaFaq', 'Tema', 'text');
        $this->gridview->addColumn('vcTemaDesc', 'Descripcion', 'text');

        $this->gridview->addControl('inIdOrdenCtrl'
                , array(
            'face' => '<SELECT name="inIdOrden" id="{inIdTemaFaq}" ' . classRegValidation("{inIdTemaFaq}") . '> {opciones} </SELECT>'
            , 'class' => ''
            , 'style' => 'padding: 6px 0 0 38px; width:50px;')
                , 'Orden');
        $this->gridview->addControl('bActivoCtrl'
                , array(
            'face' => '<input type="checkbox" name="bActivo" {chkbActivo} id="{inIdTemaFaq}" value ="{bActivo}" ' . classRegValidation("{inIdTemaFaq}") . '/>'
            , 'class' => ''
            , 'style' => 'padding: 6px 0 0 38px; width:50px;')
                , 'Activo');

        $this->_rsRegs = $this->_oModel->obtTemas();
        $this->_numTemas = sizeof($this->_rsRegs);

        for ($i = 0; $i < count($this->_rsRegs); $i++) {
            $fila = $this->_rsRegs[$i];
            //Cargo los checkbox
            if ((bool)$fila['bActivo'] == true) {
                $fila = $fila + array('chkbActivo' => 'checked = "checked"');
            } else {
                $fila = $fila + array('chkbActivo' => '');
            }
            //Cargo las listas desplegables
            $opciones = '';
            for ($j = 1; $j < ($this->_numTemas + 1); $j++) {
                $opciones .= ' <OPTION ' . (($j == $fila['inIdOrden']) ? 'selected="selected"' : '') . ' value="' . ($j) . '">' . $j . '</OPTION>';
            }
            $fila['opciones'] = $opciones;
            $this->_rsRegs[$i] = $fila;
        }

        $this->load->view('lib_autenticacion/lst-faq-tema'
                , array(
            'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'btGuardar' => '<a   href="autenticacion/faq/listadoTemas" id="lnkGuardar"   class="button guardar btn-accion">Guardar</a>'
            , 'btCancelar' => '<a  href="autenticacion/faq/listadoTemas" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>'
                )
        );
    }

    public function formulario() {
        $rsTemas = $this->_oModel->obtTemasDdl(TRUE, TRUE);
        $this->load->view('lib_autenticacion/frm-faq'
                , array(
            'Reg' => $this->_inicReg($this->input->post('vcForm'))
            , 'vcFrmAction' => 'autenticacion/faq/guardar'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_reg['inIdFaq'] > 0) ? 'Modificar' : 'Agregar'
            , 'rsTemas' => $rsTemas
                )
        );
    }

    public function formularioTema() {
        $this->load->view('lib_autenticacion/frm-faq-tema'
                , array(
            'RegTema' => $this->_inicRegTema($this->input->post('vcForm'))
            , 'vcFrmAction' => 'autenticacion/faq/guardarTema'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_regTema['inIdTemaFaq'] > 0) ? 'Modificar' : 'Agregar'
                )
        );
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

    public function consultaTema() {
        $this->load->view('lib_autenticacion/frm-faq-borrar-tema'
                , array(
            'RegTema' => $this->_inicRegTema($this->input->post('vcForm'))
            , 'vcFrmAction' => 'autenticacion/faq/eliminarTema'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_regTema['inIdTemaFaq'] > 0) ? 'Eliminar' : ''
                )
        );
    }

    public function guardar() {

        antibotCompararLlave($this->input->post('vcForm'));

        $this->_inicReglas();

        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            if ((bool)$this->_reg['bActivo'] == true) {
                $bActivo = true;
            } else {
                $bActivo = false;
            }
            $this->_aEstadoOper['status'] = $this->_oModel->guardar(
                    array(
                        $this->_reg['inIdFaq']
                        , GetDateTimeFromFrenchToISO($this->_reg['tsFecPublicacion'])
                        , $this->_reg['inIdTemaFaq']
                        , $this->_reg['vcPregunta']
                        , $this->_reg['vcRespuesta']
                        , ($this->_reg['inIdOrden'] > 0 ) ? $this->_reg['inIdOrden'] : 99
                        , (bool)$bActivo
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } else {
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

    public function guardarTema() {

        antibotCompararLlave($this->input->post('vcForm'));

        $this->_inicReglasTema();

        if ($this->_validarReglas()) {
            $this->_inicRegTema((bool) $this->input->post('vcForm'));
            if ((bool)$this->_regTema['bActivo'] == true) {
                $bActivo = true;
            } else {
                $bActivo = false;
            }
            $this->_aEstadoOper['status'] = $this->_oModel->guardarTema(
                    array(
                        $this->_regTema['inIdTemaFaq']
                        , $this->_regTema['vcTemaFaq']
                        , $this->_regTema['vcTemaDesc']
                        , ($this->_regTema['inIdOrden'] > 0 ) ? $this->_regTema['inIdOrden'] : 99
                        , (bool)$bActivo
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        if ($this->_aEstadoOper['status'] > 0) {
            $this->listadoTemas();
        } else {
            $this->formularioTema();
        }
    }

    //Guarda los cambios en el orden de los temas modificados y que son enviados viaAjax
    public function guardarTemasEditar() {
        //antibotCompararLlave($this->input->post('vcForm'));
        $aux = $this->input->post('cnct');
        if ($aux != '') {
            $aGrilla = explode("|", $aux);
            $tamGrilla = count($aGrilla);
            foreach ($aGrilla as $fila) {
                $aFila = explode(",", $fila);
                $aTema = $this->_oModel->obtUnTema($aFila[0]);
                $aParam = array(
                    'inIdTemaFaq' => $aTema['inIdTemaFaq']
                    , 'vcTemaFaq' => $aTema['vcTemaFaq']
                    , 'vcTemaDesc' => $aTema['vcTemaDesc']
                    , 'inIdOrden' => $aFila[1]
                    , 'bActivo' => (bool)$aFila[2]
                );
                $this->_aEstadoOper['status'] = $this->_oModel->guardarTema($aParam);
            }
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Los registros fueron actualizados correctamente.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }

            $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
            //Mostramos la vista
            //$this->listadoTemas();
        } else {
            //Mostramos la vista
            $this->listadoTemasEditar();
        }
    }

//Elimina la pregunta seleccionada
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

//Elimina el tema selecionado
    public function eliminarTema() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->_oModel->eliminarTema($this->input->post('inIdTemaFaq'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
        } else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        $this->listadoTemas();
    }

//Funcion que carga la lista de preguntas en el inicio del sistema
    public function verPorLecturas($cantMostrar = 5) {
            $aFaq = ($cantMostrar <= 5) ? $this->_oModel->obtenerPorLecturas(0, $cantMostrar) : $this->_oModel->obtenerPorLecturas();
            $this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/ver-faq-por-lecturas', array(
                'aFaq' => $aFaq
                , 'esViaAjax' => $cantMostrar > 5
                , 'cantMostrar' => $cantMostrar
                    ));
    }
        
        public function verPorTemas () {
            $this->_aTemas = $this->_oModel->obtTemas();
            $aFaq = $this->_oModel->obtener('');
            $this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/ver-faq-por-temas', array(
                'aFaq' => $aFaq
                , 'aTemas' => $this->_aTemas
                    ));
        }

    //Cada vez que se lee una pregunta se le suma 1 a la cantidad de veces que fue leida. No se le muestra nada al usuario.
    public function sumarLectura($id=0) {
        if ($id != 0 ) {
            $this->_oModel->sumarLectura($id);
        }
    }

    //Reiniciar el contador de lecturas de la pregunta seleccionada. Solo desde el panel para administradores
    public function obtenerPadres() {
        $this->load->model('hits/materiales_model', 'materiales');
        $data = $this->materiales->obtenerPadres();
        echo json_encode($data);
    }

}

?>
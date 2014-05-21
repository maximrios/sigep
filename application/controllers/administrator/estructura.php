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
class Estructura extends Ext_crud_controller {

    private $_aTemas = array();
    private $_rsRegs = array();

    function __construct() {
        parent::__construct();

        //$this->load->model($this->db->dbdriver . '/lib_autenticacion/faq_model', '_oModel');
        $this->load->model('hits/noticias_model', 'noticia');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');

        //$this->_aTemas = $this->_oModel->obtTemas();

        $this->_aReglas = array(
            array(
                'field' => 'idNoticia',
                'label' => 'Noticia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'inicioNoticia',
                'label' => 'Fecha de Inicio',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'vencimientoNoticia',
                'label' => 'Fecha de Vencimiento',
                'rules' => 'trim|xss_clean'
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
                'label' => 'Tipo de Noticia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'publicadoNoticia',
                'label' => 'Publicación',
                'rules' => 'trim|xss_clean'
            )
        );
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/estructura/principal', array(), true);
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
            $this->_reg = $this->noticia->obtenerUno($inId);
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
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function listado($idNoticia = 0) {

        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/estructura/listado'
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
        $this->load->view('administrator/sigep/estructura/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'aTemas' => $this->_aTemas
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        /*echo '<script>if (CKEDITOR.instances["descripcionNoticia"]) {
                            //alert("existe la instancia");
//CKEDITOR.instances["descripcionNoticia"].destroy();
                for(var instanceName in CKEDITOR.instances) {
            CKEDITOR.instances[instanceName].destroy();
        }
}
else {
   alert("no existe la instanca");
}
//CKEDITOR.replace("descripcionNoticia");
</script>';*/

         $aData['ckeditor_texto1'] = array
        (
            //id da textarea a ser substituída pelo CKEditor
            'id'   => 'descripcionNoticia',
             // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
            'path' => 'assets/libraries/ckeditor',
             // configurações opcionais
            'config' => array
            (
                'toolbar' => "None",
                'width'   => "800px",
                'height'  => "200px",
            )
        );
        //$aData['vcFrmAction'] = 'administrator/noticias/guardar';
        //$rsTemas = $this->_oModel->obtTemasDdl(TRUE, TRUE);
        
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/noticias/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idNoticia'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/hits/noticias/formulario', $aData);
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
            $this->_aEstadoOper['status'] = $this->noticia->guardar(
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
    public function reiniciarLecturas($id = 0) {
        if ($id != 0 && $id != null) {
        $this->_aEstadoOper['status'] = $this->_oModel->reiniciarLecturas($id);

        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'Los registros fueron actualizados correctamente.';
        } else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->listado();
        } else {
            $this->listado();
        }
    }
    public function obtenerEstructuraAutocomplete() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->estructura->obtenerAutocomplete($q);
        }
    }
}

?>
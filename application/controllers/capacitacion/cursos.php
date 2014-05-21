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
class Cursos extends Ext_crud_controller {

    private $_aTemas = array();
    private $_rsRegs = array();

    function __construct() {
        parent::__construct();

        //$this->load->model($this->db->dbdriver . '/lib_autenticacion/faq_model', '_oModel');
        $this->load->model('hits/cursos_model', 'curso');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');

        //$this->_aTemas = $this->_oModel->obtTemas();

        $this->_aReglas = array(
            array(
                'field' => 'idCurso',
                'label' => 'Curso',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'nombreCurso',
                'label' => 'Fecha de Inicio',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'fechaInicioCurso',
                'label' => 'Fecha de Inicio',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'fechaFinCurso',
                'label' => 'Fecha de Finalizacion',
                'rules' => 'trim|required|min_length[5]|max_length[300]|xss_clean'
            ),
            array(
                'field' => 'idOrganismo',
                'label' => 'Organismo',
                'rules' => 'trim|required|min_length[5]|max_length[5000]|xss_clean'
            ),
            array(
                'field' => 'idEstadoCurso',
                'label' => 'Estado del Curso',
                'rules' => 'trim|xss_clean'
            )
        );
    }

    public function index() {
        //
        $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/cursos/principal', array(), true);
        //		 
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCurso' => null
            , 'nombreCurso' => null
            , 'fechaInicioCurso' => null
            , 'fechaFinCurso' => ''
            , 'idOrganismo' => ''
            , 'idEstadoCurso' => null
        );
        $inId = ($this->input->post('idCurso') !== false) ? $this->input->post('idCurso') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->noticia->obtenerUno($inId);
            $this->_reg['fechaInicioCurso'] = GetDateFromISO($this->_reg['fechaInicioCurso'], FALSE);
            $this->_reg['fechaFinCurso'] = GetDateFromISO($this->_reg['fechaFinCurso'], FALSE);
        } else {
            $this->_reg = array(
                'idCurso' => $inId
                , 'nombreCurso' => set_value('nombreCurso')
                , 'fechaInicioCurso' => ($this->input->post('fechaInicioCurso') === FALSE) ? GetToday('d/m/Y') : set_value('fechaInicioCurso')
                , 'fechaFinCurso' => ($this->input->post('fechaFinCurso') === FALSE) ? GetToday('d/m/Y') : set_value('fechaFinCurso')
                , 'idOrganismo' => set_value('idOrganismo')
                , 'idEstadoCurso' => set_value('idEstadoCurso')
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
                    'sResponseUrl' => 'capacitacion/cursos/listado'
                    , 'iTotalRegs' => $this->curso->numRegs($vcBuscar)
                    , 'iPerPage' => 10000
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                )
        );

        

        $this->gridview->addColumn('idCursoComision', '#', 'int');
        $this->gridview->addColumn('nombreCurso', 'Curso', 'text');
        $this->gridview->addColumn('fechaInicioCurso', 'Inicio', 'date');
        $this->gridview->addColumn('fechaFinCurso', 'Fin', 'date');
        $this->gridview->addColumn('numeroComision', 'Comision', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/noticias/formulario/{idCurso}" title="click para editar {nombreCurso}" class="icono-editar btn-accion" rel="{\'idCurso\': {idCurso}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/consulta/{idCurso}" title="click para eliminar {nombreCurso}" class="icono-eliminar btn-accion" rel="{\'idCurso\': {idCurso}}">&nbsp;</a>'.
                                                                   '<a href="autenticacion/faq/reiniciarLecturas/{idCurso}" title="reiniciar lecturas de {nombreCurso}" class="icono-refresca btn-accion" rel="{\'idCurso\': {idCurso}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:96px;'));


        $this->_rsRegs = $this->curso->obtener($vcBuscar, 0, 10000);
        $this->load->view('administrator/hits/cursos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'aTemas' => $this->_aTemas
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/noticias/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCurso'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/hits/cursos/formulario', $aData);
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
    public function comisiones() {
        $data['alumnos'] = $this->curso->obtenerCCAlumnos();
        $data['main_content'] = 'administrator/hits/cursos/formulario-comision';
        $this->load->view('portal', $data);
        //$this->load->view('portal', array(), true);
        //parent::index();
    }
    public function guardarComision() {
        echo "llegamos aca";
    }
    public function oferta() {
        
    }
}

?>
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */

/**
 * @Licencias class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Licencias extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/licencias_model', 'licencia');
        $this->licencias = $this->licencia->dropdownLicencias();
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field' => 'idLicencia',
                'label' => 'Licencia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'nombreLicencia',
                'label' => 'Denominacion de Licencia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'diasLicencia',
                'label' => 'Cantidad de dias por licencia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estadoLicencia',
                'label' => 'Titulo',
                'rules' => 'trim|required|min_length[5]|max_length[300]|xss_clean'
            )
        );
    }

    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/licencias/principal', array(), true);
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idLicencia' => null
            , 'nombreLicencia' => null
            , 'diasLicencia' => null
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
    function especial() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/formularios/lespecial', array(), true);
        parent::index();
    }
    public function listado($idNoticia = 0) {

        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/licencias/listado'
                    , 'iTotalRegs' => $this->licencia->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Tipos de Licencias'
                )
        );

        

        $this->gridview->addColumn('idLicencia', '#', 'int');
        $this->gridview->addColumn('nombreLicencia', 'Tipo de Licencia', 'text');
        $this->gridview->addColumn('diasLicencia', 'Dias Reglamentarios', 'int');
        $this->gridview->addColumn('estadoLicencia', 'Estado', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));

        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/licencias/formulario/{idLicencia}" title="click para editar {nombreLicencia}" class="icono-editar btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>'.
                                                                   '<a href="administrator/licencias/publicacion/{idLicencia}" title="click para cambiar el estado de {nombreLicencia}" class="icono-refresca btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:64px;'));


        $this->_rsRegs = $this->licencia->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/licencias/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {

        $aData['ckeditor_texto1'] = $this->capa;
        //$aData['vcFrmAction'] = 'administrator/noticias/guardar';
        //$rsTemas = $this->_oModel->obtTemasDdl(TRUE, TRUE);
        $aData['tiposnoticias'] = $this->tiposnoticias;
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
    /*************************************************************
    A partir de aca comienza el codigo para los modulos del empleados comun
    *************************************************************/
    public function personal() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/licencias/principal-personal', array(), true);
        parent::index();    
    }
    public function listadoPersonal() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/licencias/listadoPersonal'
                    , 'iTotalRegs' => $this->licencia->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Licencias'
                )
        );
        $this->gridview->addColumn('idLicencia', '#', 'int');
        $this->gridview->addColumn('nombreLicencia', 'Licencia', 'text');
        $this->gridview->addColumn('diasLicencia', 'Dias Reglamentarios', 'int');
        $this->gridview->addColumn('diasLicencia', 'Usufructuados', 'int');
        $this->gridview->addColumn('diasLicencia', 'A Usufructuar', 'int');
        $this->gridview->addColumn('diasLicencia', 'Pendientes', 'int');
        $this->gridview->addColumn('estadoLicencia', 'Estado', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/licencias/formulario/{idLicencia}" title="click para editar {nombreLicencia}" class="icono-editar btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>'.
                                                                   '<a href="administrator/licencias/publicacion/{idLicencia}" title="click para cambiar el estado de {nombreLicencia}" class="icono-refresca btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:64px;'));


        $this->_rsRegs = $this->licencia->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/licencias/listado-personal'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );  
    }
    /*************************************************************
    A partir de aca comienza el codigo para los modulos de solicitudes
    *************************************************************/
    public function solicitudes() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/licencias/principal-solicitudes', array(), true);
        parent::index();    
    }
    public function listadoSolicitudes() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/licencias/listadoSolicitudes'
                    , 'iTotalRegs' => $this->licencia->numRegsLicencias($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Solicitudes de Licencias'
                )
        );
        $this->gridview->addColumn('idLicencia', '#', 'int');
        $this->gridview->addColumn('nombreCompletoPersona', 'Agente', 'text');
        $this->gridview->addColumn('nombreLicencia', 'Licencia', 'text');
        $this->gridview->addColumn('fechaAgenteLicencia', 'Solicitud', 'datetime');
        $this->gridview->addColumn('cantidadAgenteLicencia', 'Días', 'int');
        $this->gridview->addColumn('desdeAgenteLicencia', 'Desde', 'date');
        $this->gridview->addColumn('hastaAgenteLicencia', 'Hasta', 'date');
        $this->gridview->addColumn('nombreLicenciaEstado', 'Estado', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $this->gridview->addControl('inIdFaqCtrl', array('face' => '<a href="administrator/licencias/formulario/{idLicencia}" title="click para editar {nombreLicencia}" class="icono-editar btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>'.
                                                                   '<a href="administrator/licencias/publicacion/{idLicencia}" title="click para cambiar el estado de {nombreLicencia}" class="icono-refresca btn-accion" rel="{\'idLicencia\': {idLicencia}}">&nbsp;</a>',
                                                                   'class' => 'acciones', 'style' => 'width:64px;'));


        $this->_rsRegs = $this->licencia->obtenerLicencias($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/licencias/listado-solicitudes'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );  
    }
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Galerias extends Ext_crud_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('rosobe/galerias_model', 'galerias');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_aReglas = array(
            array(
                'field'   => 'idGaleria',
                'label'   => 'Codigo de Galeria',
                'rules'   => 'trim|max_length[80]|xss_clean'
            )
            ,array(
                'field'   => 'nombreGaleria',
                'label'   => 'Titulo',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'descripcionGaleria',
                'label'   => 'Descripcion',
                'rules'   => 'trim|xss_clean'
            )
            ,array(
                'field'   => 'pathGaleria',
                'label'   => 'Imagen',
                'rules'   => 'trim|xss_clean'
            )
            ,array(
                'field'   => 'thumbGaleria',
                'label'   => 'Imagen',
                'rules'   => 'trim|xss_clean'
            )
        );
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idGaleria' => null
            ,'nombreGaleria' => null
            , 'descripcionGaleria' => null
            , 'pathGaleria' => null
            , 'thumbGaleria' => null
            , 'estadoGaleria' => null
        );
        $id = ($this->input->post('idGaleria')!==false)? $this->input->post('idGaleria'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->galerias->obtenerUno($id);
        } 
        else {
            $this->_reg = array(
                'idGaleria' => $id
                , 'nombreGaleria' => set_value('nombreGaleria')
                , 'descripcionGaleria' => set_value('descripcionGaleria')
                , 'pathGaleria' => set_value('pathGaleria')
                , 'thumbGaleria' => set_value('thumbGaleria')
                , 'estadoGaleria' => set_value('estadoGaleria')
            );          
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/rosobe/galerias/principal', array(), true);
        parent::index();
    }
    public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/galerias/listado'
                    , 'iTotalRegs' => $this->galerias->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Galeria de Imagenes'
                    , 'identificador' => 'idGaleria'
                )
        );
        $this->gridview->addColumn('idGaleria', '#', 'int');
        $this->gridview->addColumn('nombreGaleria', 'Titulo', 'text');
        $this->gridview->addColumn('descripcionGaleria', 'Descripcion', 'text');
        $this->gridview->addColumn('estadoGaleria', 'Estado', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        //$this->gridview->addControl('inIdFaqCtrl', array('face' => $controles, 'class' => 'acciones', 'style' => 'width:32px;'));
        $this->_rsRegs = $this->galerias->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/rosobe/galerias/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    function consulta() {
        echo "macondo";
    }
    function buscador() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/productos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idproducto'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/productos/buscador', $aData);
    }
    function formulario() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/galerias/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idGaleria'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/rosobe/galerias/formulario', $aData);
    }
    function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            /*
             * Aca comienza el codigo del do_upload que posteriormente deberia de hacerlo mas generico.
             */
            $cant = count($_FILES['userfile']['name']);
            $config['upload_path'] = 'assets/images/galeria/';
            $config['allowed_types'] = 'jpg';
            $config['max_size'] = '30000';
            $this->load->library('upload', $config);
            $this->load->library('image_lib');
            $configa['image_library'] = 'gd2';
            $configa['create_thumb'] = TRUE;
            $configa['maintain_ratio'] = TRUE;
            //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
            $configa['new_image']='assets/images/galeria/';
            $configa['width'] = 150;
            $configa['height'] = 150;
            $upload_files = $_FILES;
            $_FILES['userfile'] = array(
                'name' => $upload_files['userfile']['name'],
                'type' => $upload_files['userfile']['type'],
                'tmp_name' => $upload_files['userfile']['tmp_name'],
                'error' => $upload_files['userfile']['error'],
                'size' => $upload_files['userfile']['size']
            );
            if ( ! $this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                $this->_aEstadoOper['message'] = $error;
                echo $error;
                print_r($error);
            } 
            else {
                $data = $this->upload->data();
                $configa['source_image'] = 'assets/images/galeria/'.$data['file_name'];
                $this->image_lib->initialize($configa);
                $this->image_lib->resize();
                $this->image_lib->clear();
                
            }
            if ($data) {
                $thumb = explode('.', $data['file_name']);
                $data['file_name_thumb'] = $thumb[0].'_thumb.'.$thumb[1];
            }
            $this->_aEstadoOper['status'] = $this->galerias->guardar(
                array(
                    ($this->_reg['idGaleria'] != '' && $this->_reg['idGaleria'] != 0)? $this->_reg['idGaleria'] : 0
                    , $this->_reg['nombreGaleria']
                    , $this->_reg['descripcionGaleria']
                    , ($data['file_name'])? $config['upload_path'].$data['file_name'] : $this->_reg['pathGaleria']
                    , ($data['file_name'])? $config['upload_path'].$data['file_name_thumb'] : $this->_reg['thumbGaleria']
                    , $this->_reg['estadoGaleria']
                )
            );
        }
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
        if($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
        } 
        else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        if($this->_aEstadoOper['status'] > 0) {
            $this->listado();
        } else {
            $this->formulario();
        }
    }
    function obtener() {
        $data = $this->productos->obtenerUno($this->input->post('idProducto'));
        echo json_encode($data);
    }

    function do_upload() {
        $cant = count($_FILES['userfile']['name']);
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = '30000';
        $this->load->library('upload', $config);
        $upload_files = $_FILES;
        for($i = 0; $i < count($upload_files['userfile']['name']); $i++) {
            $_FILES['userfile'] = array(
                'name' => $upload_files['userfile']['name'][$i],
                'type' => $upload_files['userfile']['type'][$i],
                'tmp_name' => $upload_files['userfile']['tmp_name'][$i],
                'error' => $upload_files['userfile']['error'][$i],
                'size' => $upload_files['userfile']['size'][$i]
            );
            if ( ! $this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } 
            else {
                $data = $this->upload->data();
                print_r($data);
            }
        }  
    }
    function _create_thumbnail($filename, $width, $height){
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'assets/images/productos/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image']='assets/images/productos/';
        $config['width'] = $width;
        $config['height'] = $height;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
    function eliminarImagen($idProductoImagen) {
        //$this->productos->eliminarImagen($idProductoImagen);
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */
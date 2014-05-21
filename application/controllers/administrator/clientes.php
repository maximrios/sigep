<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes extends Ext_crud_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('diario/clientes_model', 'clientes');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
		$this->_aReglas = array(
		    array(
	            'field'   => 'idCliente',
	            'label'   => 'Codigo de Cliente',
	            'rules'   => 'trim|xss_clean'
	        )
            ,array(
                'field'   => 'apellidoPersona',
                'label'   => 'Apellido',
                'rules'   => 'trim|xss_clean|required'
            )
	        ,array(
	            'field'   => 'nombrePersona',
	            'label'   => 'Nombre',
	            'rules'   => 'trim|xss_clean|required'
	        )
            ,array(
	            'field'   => 'domicilioPersona',
	            'label'   => 'Domicilio',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'telefonoPersona',
	            'label'   => 'Telefono',
	            'rules'   => 'trim|xss_clean|required'
	        )
            ,array(
                'field'   => 'celularPersona',
                'label'   => 'Telefono',
                'rules'   => 'trim|xss_clean'
            )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
		$this->_reg = array(
			'idCliente' => null
            ,'apellidoPersona' => null
            ,'nombrePersona' => null
            ,'domicilioPersona' => null
            ,'telefonoPersona' => null
            ,'celularPersona' => null
		);
		$id = ($this->input->post('idCliente')!==false)? $this->input->post('idCliente'):0;
		if($id!=0 && !$boIsPostBack) {
			$this->_reg = $this->clientes->obtenerUno($id);
			$this->_reg['inicioCliente'] = GetDateFromISO($this->_reg['inicioCliente'], FALSE);
		} 
		else {
			$this->_reg = array(
				'idCliente' => $id
                , 'apellidoPersona' => set_value('apellidoPersona')
                , 'nombrePersona' => set_value('nombrePersona')
                , 'domicilioPersona' => set_value('domicilioPersona')
                , 'telefonoPersona' => set_value('telefonoPersona')
                , 'celularPersona' => set_value('celularPersona')
				, 'idPersona' => set_value('idPersona')
				, 'inicioCliente' => set_value('inicioCliente')
				, 'saldoCliente' => set_value('saldoCliente')
			);			
		}
		return $this->_reg;
	}
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/diario/clientes/principal', array(), true);
        parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');

        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/clientes/listado'
                    , 'iTotalRegs' => $this->clientes->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Clientes'
                    , 'identificador' => 'idCliente'
                )
        );
        $this->gridview->addColumn('idCliente', '#', 'int');
        $this->gridview->addColumn('completoPersona', 'Nombre Cliente', 'text');
        $this->gridview->addColumn('domicilioPersona', 'Domicilio', 'text');
        $this->gridview->addColumn('telefonoPersona', 'Telefono', 'int');
        $this->gridview->addColumn('celularPersona', 'Celular', 'int');
        $this->gridview->addColumn('saldoCliente', 'Saldo', 'double');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $usuario = '<a href="administrator/usuarios/formulario/{idCliente}" title="Editar usuario de {nombrePersona}" class="icon-pencil" rel="{\'idCliente\': {idCliente}}">&nbsp;</a>';
        $editar = '<a href="administrator/clientes/formulario/{idCliente}" title="Editar datos de {nombrePersona}" class="icon-th-list btn-accion" rel="{\'idCliente\': {idCliente}}">&nbsp;</a>';
        $mensaje = '<a href="administrator/mensajes/formularioUno/{idCliente}" title="Enviar un mensaje a {apellidoPersona} {nombrePersona}" class="icon-file" rel="{\'idCliente\': {idCliente}}">&nbsp;</a>';
        if($this->lib_autenticacion->idRol() == 1) {
        	$tamano = 96;
        	$acciones = $usuario.$editar.$mensaje;
        }
        elseif($this->lib_autenticacion->idRol() == 3) {
        	$tamano = 64;
        	$acciones = $ver.$editar.$mensaje;
        }
        else {
            $tamano = 32;
            $acciones = $mensaje;
        }
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => '', 'style' => 'width:'.$tamano.'px;'));
        $this->_rsRegs = $this->clientes->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/diario/clientes/listado'
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
        $aData['vcFrmAction'] = 'administrator/clientes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCliente'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/clientes/buscador', $aData);
	}
	function formulario() {
		$aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/clientes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idCliente'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/diario/clientes/formulario', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
			$this->_aEstadoOper['status'] = $this->agente->guardar(
				array(
					($this->_reg['idCliente'] != '' && $this->_reg['idCliente'] != 0)? $this->_reg['idCliente'] : 0
					, $this->_reg['idPersona']
					, GetDateTimeFromFrenchToISO($this->_reg['ingresoAgenteAPP'])
					, GetDateTimeFromFrenchToISO($this->_reg['ingresoclientesIGEP'])
					, $this->_reg['internoAgente']
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
		/*else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
		}*/
		/*$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
*/
		if($this->_aEstadoOper['status'] > 0) {
			$this->listado();
		} else {
			$this->formulario();
		}
	}
	function buscar() {
		$registro = $this->_inicReg(false);
		
		if($this->input->post('buscar_persona')) {

		}
		else {
			redirect('administrator/home');
		}
	}
	public function fotos() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/clientes/fotos', array(), true);
        //		 
        parent::index();
	}

	public function upload()
    {
        # Configuracion de la libreria
        # 'img_path' esta en /applications/config/pixmat.php
        //$config['upload_path']      = $this->config->item('upload_path');
        $config['upload_path']      = 'assets/images';
        $config['allowed_types']    = 'jpg|gif|png';
        $config['encrypt_name']     = 'TRUE';
        $config['max_size']             = '71680';
        $config['max_width']        = '8000';
        $config['max_height']       = '8000';
 
        $this->load->library('upload', $config);
 
        # Uploading
        if ( ! $this->upload->do_upload('Filedata')) {
            # Error
            $errors = $this->upload->display_errors();
 			echo "no se subio nada";
            # nombre de la imagen, evitando errores
            $image_name = NULL;
        } else {
            # Nombre de la foto
            echo "si se subio parece";
            $imageData  = $this->upload->data();
            $image_name = $imageData['file_name'];
            $image_ext  = $imageData['file_ext'];
 
            # Achicamos la foto
            if( ! $this->resizePhoto($image_name)){
                $errors = "La imagen no pudo redimensionarse correctamente";
            } else {
                # Agregamos a la base de datos
                $data = array(
                    'title'         => 'Foto sin titulo',
                    'image'         =>   $image_name,
                    'active'            => 0
                );
 
                # ID recien creado, verificamos
                $id = $this->photos_model->create($data);
 
                if ( ! $id) {
                    $errors = "La imagen no pudo ingresarse a la DB";
                }
            }
        }
 
        // Error?
        if (isset($errors)){
            # Borramos la foto (si existe)
            $id = isset($id) ? $id : NULL;
            $this->deletePhoto($id, $image_name);
 
            echo $errors;
        }
    }
 
    private function resizePhoto($name)
    {
        # Load library
        $this->load->library('image_lib');
 
        // Achicamos a 1024x768
        $config['image_library']        = 'gd2';
        $config['source_image']     = $this->config->item('upload_path') . $name;
        $config['new_image']        = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['maintain_ratio']       = TRUE;
        $config['width']            = 1024;
        $config['height']           = 768;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
         
        /*
 
        // Le ponemos watermark, tenemos que utilizar otra configuracion, puesto que vamos a trabajar
        // con el thumbnail y vamos a ponerle watermark
        $config2['image_library']       = 'gd2';
        $config2['source_image']        = $this->config->item('upload_path') . '1024x768/' . $name;
        $config2['wm_type']         = 'overlay';
        $config2['wm_overlay_path']     = $this->config->item('watermark');
        $config2['wm_vrt_alignment']        = 'middle';
        $config2['wm_hor_alignment']    = 'center';
 
        # Watermark
        $this->image_lib->initialize($config2);
        if ( ! $this->image_lib->watermark()){
            $error = TRUE;
        }
         
        */
 
        // Achicamos a 800x600
        $config['source_image']     = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['new_image']        = $this->config->item('upload_path') . '800x600/' . $name;
        $config['width']            = 800;
        $config['height']           = 600;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
 
        // Achicamos a 400x300
        $config['source_image']     = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['new_image']        = $this->config->item('upload_path') . '400x300/' . $name;
        $config['width']            = 400;
        $config['height']           = 300;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
 
        # Error ?
        if (isset($error) and $error === TRUE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
 
    private function deletePhoto($id, $image)
    {
        # Delete from the DB
        if ($id !== NULL) {
            $this->photos_model->delete($id);
        }
 
        if ($image !== NULL) {
            # Borramos todas las imagenes (si existen). Evitamos warnings con el @ adelante
            @unlink($this->config->item("upload_path") . $image);
            @unlink($this->config->item('upload_path') . '1024x768/' . $image);
            @unlink($this->config->item('upload_path') . '800x600/' . $image);
            @unlink($this->config->item('upload_path') . '400x300/' . $image);
        }
    }
    public function reporte($estructura=1, $filtro='') {
        $aData['clientes'] = $this->agente->obtener($filtro, $estructura);
        $this->config->set_item('page_orientation', 'P');
        if($estructura == 1) {
            $this->load->view('administrator/sigep/reportes/repo-clientes', $aData);
            //redirect('administrator/clientes/error');
        }
        echo "el filtro a buscar es ".$filtro;
    }
    public function error() {
        echo "ni ahi";
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */
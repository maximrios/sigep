<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pruebas extends Ext_crud_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('rosobe/productos_model', 'productos');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
		$this->_aReglas = array(
			array(
	            'field'   => 'idProducto',
	            'label'   => 'Codigo de Producto',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
	        ,array(
	            'field'   => 'nombreProducto',
	            'label'   => 'Nombre del Producto',
	            'rules'   => 'trim|xss_clean|required'
	        )
            ,array(
                'field'   => 'descripcionProducto',
                'label'   => 'Descripcion del Producto',
                'rules'   => 'trim|xss_clean'
            )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
		$this->_reg = array(
			'idProducto' => null
			,'nombreProducto' => null
			, 'descripcionProducto' => null
		);
		$id = ($this->input->post('idProducto')!==false)? $this->input->post('idProducto'):0;
		if($id!=0 && !$boIsPostBack) {
			$this->_reg = $this->productos->obtenerUno($id);
		} 
		else {
			$this->_reg = array(
				'idProducto' => $id
				, 'nombreProducto' => set_value('nombreProducto')
				, 'descripcionProducto' => set_value('descripcionProducto')
			);			
		}
		return $this->_reg;
	}
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/rosobe/productos/principal', array(), true);
        parent::index();
	}
	function upload() {
		echo "aca estamos";
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/productos/listado'
                    , 'iTotalRegs' => $this->productos->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Productos'
                    , 'identificador' => 'idProducto'
                )
        );
        $this->gridview->addColumn('idProducto', '#', 'int');
        $this->gridview->addColumn('nombreProducto', 'Nombre', 'text');
        $this->gridview->addColumn('descripcionProducto', 'Descripcion', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $controles = '&nbsp;<a href="administrator/productos/formulario/{idProducto}" title="Editar {nombreProducto}" 
        class="btn-accion" rel="{\'idProducto\': {idProducto}}">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</a>';
        $controles .= '<a href="administrator/productos/formulario/{idProducto}" title="Mostrar detalle de {nombreProducto}" class="btn-accion" rel="{\'idProducto\': {idProducto}}">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>';
        $controles .= '<a href="administrator/productos/formulario/{idProducto}" title="Mostrar detalle de {nombreProducto}" class="btn-accion" rel="{\'idProducto\': {idProducto}}">&nbsp;<span class="glyphicon glyphicon-trash"></span>&nbsp;</a>';
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $controles, 'class' => 'acciones', 'style' => 'width:64px;'));
        $this->_rsRegs = $this->productos->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/rosobe/productos/listado'
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
        $aData['vcFrmAction'] = 'administrator/productos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idProducto'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/rosobe/pruebas/formulario', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
			$this->_aEstadoOper['status'] = $this->productos->guardar(
				array(
					($this->_reg['idProducto'] != '' && $this->_reg['idProducto'] != 0)? $this->_reg['idProducto'] : 0
					, $this->_reg['nombreProducto']
                    , $this->_reg['descripcionProducto']
                    , url_title(strtolower($this->_reg['nombreProducto']))
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
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */
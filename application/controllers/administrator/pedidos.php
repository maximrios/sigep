<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedidos extends Ext_crud_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model('diario/clientes_model', 'clientes');
        $this->load->model('diario/lineas_model', 'lineas');
        $this->load->model('diario/pedidos_model', 'pedidos');
        $this->load->model('diario/productos_model', 'productos');
        $this->load->library('gridview');
        $this->load->library('Messages');
        $this->load->helper('utils_helper');
        $this->_clientes = $this->clientes->dropdownClientes();
        $this->_productos = $this->productos->dropdownProductos();
        $this->_aReglas = array(
            array(
                'field'   => 'idLinea',
                'label'   => 'Linea',
                'rules'   => 'trim|max_length[80]|xss_clean'
            )
            , array(
                'field'   => 'fechaPedido',
                'label'   => 'Fecha',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'idProducto',
                'label'   => 'Producto',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'precioProductoCanillita',
                'label'   => 'Precio del producto canillita',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'cantidadLinea',
                'label'   => 'Cantidad',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'precioLinea',
                'label'   => 'Precio de Linea',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'idPedido',
                'label'   => 'Pedido',
                'rules'   => 'trim|max_length[80]|xss_clean'
            )
            , array(
                'field'   => 'idCliente',
                'label'   => 'Cliente',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
        );
    $this->_aReglasLinea = array(
            array(
                'field'   => 'idLinea',
                'label'   => 'Linea',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'idProducto',
                'label'   => 'Producto',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'precioProductoCanillita',
                'label'   => 'Precio del producto canillita',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'cantidadLinea',
                'label'   => 'Cantidad',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'precioLinea',
                'label'   => 'Precio de Linea',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'cantidadLineaD',
                'label'   => 'Cantidad',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'precioLineaD',
                'label'   => 'Precio de Linea',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'pagoLineaD',
                'label'   => 'Cantidad',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'precioLinea',
                'label'   => 'Precio de Linea',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'saldoLinea',
                'label'   => 'Saldo de Linea',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
            , array(
                'field'   => 'idPedido',
                'label'   => 'Pedido',
                'rules'   => 'trim|max_length[80]|xss_clean'
            )
            , array(
                'field'   => 'idCliente',
                'label'   => 'Cliente',
                'rules'   => 'trim|max_length[80]|required|xss_clean'
            )
        );
	}
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idLinea' => null
            , 'idProducto' => null
            , 'precioProductoCanillita' => null
            , 'cantidadLinea' => null
            , 'precioLinea' => null
            , 'cantidadLineaD' => null
            , 'precioLineaD' => null
            , 'pagoLineaD' => null
            , 'saldoLinea' => null
            , 'idPedido' => null
            , 'idCliente' => null
            , 'fechaPedido' => null
        );
        $this->cliente = $this->clientes->obtenerUnoOrden($this->input->post('idCliente')+1);
        $id = ($this->input->post('idLinea')!==false)? $this->input->post('idLinea'):0;
        $pedido = ($this->input->post('idPedido')!==false)? $this->input->post('idPedido'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->lineas->obtenerUno($id);
            $this->_reg['fechaPedido'] = GetDateFromISO($this->_reg['fechaPedido'], FALSE);

        }
        elseif ($pedido!=0 && !$boIsPostBack) {
            $this->_reg = $this->pedidos->obtenerUno($pedido);
            $this->_reg['idPedido'] = ($this->input->post('idPedido')!='')? $this->input->post('idPedido'):$pedido;
            $this->_reg['idLinea'] = 0;
            $this->_reg['idProducto'] = set_value('idProducto');
            $this->_reg['cantidadLinea'] = set_value('cantidadLinea');
            $this->_reg['precioLinea'] = set_value('precioLinea');
            $this->_reg['fechaPedido'] = GetDateFromISO($this->_reg['fechaPedido'], FALSE);
        }
        else {
            $this->_reg = array(
                'idLinea' => $id
                , 'idProducto' => set_value('idProducto')
                , 'precioProductoCanillita' => set_value('precioProductoCanillita')
                , 'cantidadLinea' => set_value('cantidadLinea')
                , 'precioLinea' => set_value('precioLinea')
                , 'cantidadLineaD' => set_value('cantidadLineaD')
                , 'precioLineaD' => set_value('precioLineaD')
                , 'pagoLineaD' => set_value('pagoLineaD')
                , 'saldoLinea' => set_value('saldoLinea')
                , 'idPedido' => set_value('idPedido')
                , 'idCliente' => set_value('idCliente')
                , 'fechaPedido' => set_value('fechaPedido')
            );          
        }
        return $this->_reg;
    }
    function _inicRegLinea($boIsPostBack=false) {
        $this->_reg = array(
            'idLinea' => null
            , 'idProducto' => null
            , 'precioProductoCanillita' => null
            , 'cantidadLinea' => null
            , 'precioLinea' => null
            , 'cantidadLineaD' => null
            , 'precioLineaD' => null
            , 'pagoLineaD' => null
            , 'saldoLinea' => null
            , 'idPedido' => null
            , 'idCliente' => null
            , 'fechaPedido' => null
        );
        $this->cliente = $this->clientes->obtenerUnoOrden(1);
        $id = ($this->input->post('idLinea')!==false)? $this->input->post('idLinea'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->lineas->obtenerUno($id);
            $this->_reg['fechaPedido'] = GetDateFromISO($this->_reg['fechaPedido'], FALSE);
        }
        else {
            $this->_reg = array(
                'idLinea' => $id
                , 'idProducto' => set_value('idProducto')
                , 'precioProductoCanillita' => set_value('precioProductoCanillita')
                , 'cantidadLinea' => set_value('cantidadLinea')
                , 'precioLinea' => set_value('precioLinea')
                , 'cantidadLineaD' => set_value('cantidadLineaD')
                , 'precioLineaD' => set_value('precioLineaD')
                , 'pagoLineaD' => set_value('pagoLineaD')
                , 'saldoLinea' => set_value('saldoLinea')
                , 'idPedido' => set_value('idPedido')
                , 'idCliente' => set_value('idCliente')
                , 'fechaPedido' => ($this->_reg['fechaPedido'] == '')? date('d/m/Y'): set_value('fechaPedido')
            );          
        }
        return $this->_reg;
    }
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    protected function _inicReglasLinea() {
        $val = $this->form_validation->set_rules($this->_aReglasLinea);
    }
	function index() {
		$this->_vcContentPlaceHolder = $this->load->view('administrator/diario/pedidos/principal', array(), true);
        parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $desde = ($this->input->post('fechaDesde') === FALSE) ? '' : GetDateTimeFromFrenchToISO($this->input->post('fechaDesde'));
        $hasta = ($this->input->post('fechaHasta') === FALSE) ? '' : GetDateTimeFromFrenchToISO($this->input->post('fechaHasta'));
        $this->gridview->initialize(
            array(
                'sResponseUrl' => 'administrator/pedidos/listado'
                , 'iTotalRegs' => $this->pedidos->numRegs($vcBuscar, $this->input->post('idCliente'), $desde, $hasta)
                , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                , 'border' => FALSE
                , 'sFootProperties' => 'class="paginador"'
                , 'titulo' => 'Listado de Pedidos'
                , 'identificador' => 'idPedido'
            )
        );
        $this->gridview->addColumn('idPedido', '#', 'int');
        $this->gridview->addColumn('nombreCompletoPersona', 'Nombre', 'text');
        $this->gridview->addColumn('fechaPedido', 'Fecha', 'date');
        $this->gridview->addColumn('precioPedido', 'Precio', 'double');
        $this->gridview->addColumn('saldoPedido', 'Saldo', 'double');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $usuario = '<a href="administrator/pedidos/lineas/{idPedido}" title="Editar pedido de fecha {fechaPedido}" class="icono-usuario usuario btn-accion" rel="{\'idPedido\': {idPedido}}">&nbsp;</a>';
        
            $acciones = $usuario;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:32px;'));
        $this->_rsRegs = $this->pedidos->obtener($vcBuscar, $this->input->post('idCliente'), $desde, $hasta, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/diario/pedidos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'clientes' => $this->_clientes
                , 'desde' => ($desde == '')? $desde='': $desde=GetDateFromISO($desde)
                , 'hasta' => ($hasta == '')? $hasta='': $desde=GetDateFromISO($hasta)
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
		$aData['Reg'] = $this->_inicRegLinea($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/productos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idPedido'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/diario/pedidos/lineas', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->lineas->guardar(
                array(
                    ($this->_reg['idLinea'] != '' && $this->_reg['idLinea'] != 0)? $this->_reg['idLinea'] : 0
                    , $this->_reg['idPedido']
                    , GetDateTimeFromFrenchToISO($this->_reg['fechaPedido'])
                    , $this->_reg['idCliente']
                    , $this->_reg['idProducto']
                    , $this->_reg['cantidadLinea']
                    , $this->_reg['precioLinea']
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
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        if($this->_aEstadoOper['status'] > 0) {
            $this->lineas();
        } else {
            $this->lineas();
        }
	}
    function guardarLinea() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasLinea();
        if ($this->_validarReglas()) {
            $this->_inicRegLinea((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->lineas->guardarLinea(
                array(
                    ($this->_reg['idLinea'] != '' && $this->_reg['idLinea'] != 0)? $this->_reg['idLinea'] : 0
                    , $this->_reg['cantidadLinea']
                    , $this->_reg['precioLinea']
                    , $this->_reg['cantidadLineaD']
                    , $this->_reg['precioLineaD']
                    , $this->_reg['pagoLineaD']
                    , $this->_reg['saldoLinea']
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
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        if($this->_aEstadoOper['status'] > 0) {
            $this->linea();
        } else {
            $this->linea();
        }
    }
    public function linea($linea=0) {
        $aData['Reg'] = $this->_inicRegLinea($this->input->post('vcForm'));
        $aData['productos'] = $this->_productos;
        $aData['vcFrmAction'] = 'administrator/pedidos/guardarLinea';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($aData['Reg']['idLinea'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/diario/pedidos/linea', $aData);
    }
	public function lineas($pedido=0) {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['cliente'] = $this->cliente;
        $aData['clientes'] = $this->_clientes;
        $aData['productos'] = $this->_productos;
        $aData['vcFrmAction'] = 'administrator/pedidos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($aData['Reg']['idPedido'] > 0) ? 'Modificar' : 'Agregar';
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
            array(
                'sResponseUrl' => 'administrator/pedidos/listado'
                , 'iTotalRegs' => $this->lineas->numRegs($aData['Reg']['idPedido'], $vcBuscar)
                , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                , 'border' => FALSE
                , 'sFootProperties' => 'class="paginador"'
                , 'titulo' => 'Listado de Pedidos'
                , 'identificador' => 'idPedido'
            )
        );
        $this->gridview->addColumn('idLinea', '#', 'int');
        $this->gridview->addColumn('nombreProducto', 'Nombre', 'text');
        $this->gridview->addColumn('precioProductoCanillita', 'Precio Unit.', 'double');
        $this->gridview->addColumn('cantidadLinea', 'Cantidad', 'int');
        $this->gridview->addColumn('precioLinea', 'Total', 'double');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $usuario = '<a href="administrator/pedidos/linea/{idLinea}" title="Editar pedido de fecha {fechaPedido}" class="icono-usuario btn-accion" id="{idLinea}" target="contenido-abm" rel="{\'idLinea\': {idLinea}}">&nbsp;</a>';
        
            $acciones = $usuario;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:32px;'));
        $this->_rsRegs = $this->lineas->obtener($aData['Reg']['idPedido'], $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $aData['vcGridView'] = $this->gridview->doXHtml($this->_rsRegs);
        $aData['txtvcBuscar'] = $vcBuscar;
        $this->load->view('administrator/diario/pedidos/lineas', $aData);

	}
    public function reporte($estructura=1, $filtro='') {
        $aData['productos'] = $this->agente->obtener($filtro, $estructura);
        $this->config->set_item('page_orientation', 'P');
        if($estructura == 1) {
            $this->load->view('administrator/sigep/reportes/repo-productos', $aData);
            //redirect('administrator/productos/error');
        }
        echo "el filtro a buscar es ".$filtro;
    }
    public function error() {
        echo "ni ahi";
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 * 
 * Modulos Class
 *
 * @package		base
 * @category	Modulos
 * @author		Silvia E.Farfan
 * @link
 * @copyright	2012-02-06
 */
class Modulos extends Ext_crud_controller
{
    /**
	 * Constructor
	 *
	 * @access	public
	 * @param   Se invocan las librerias, modelo y ayudante que se utilizarán en el controlador. 
	 */
	function __construct()
	{
		parent::__construct();
		
        $this->load->helper('utils_helper');
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/modulos_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');     
        $this->load->helper('pin_helper');     
         
        $this->_aReglas = array(   
                                  array(
                                      'field'   => 'idPadreModulo',
                                      'label'   => 'Nombre del Modulo Padre',
                                      'rules'   => 'trim|required'
                                  ),
                                  array(
                                      'field'   => 'nombreModulo',
                                      'label'   => 'Nombre del modulo',
                                      'rules'   => 'trim|required|xss_clean|max_length[100]|'
                                  ),
                                  array(
                                      'field'   => 'urlModulo',
                                      'label'   => 'Url del Modulo',
                                      'rules'   => 'trim|xss_clean|max_length[256]'
                                  ),
                                  array(
                                      'field'   => 'tituloModulo',
                                      'label'   => 'Titulo del modulo',
                                      'rules'   => 'trim|required|xss_clean|max_length[100]'
                                  ),
                                  array(
                                      'field'   => 'menuModulo',
                                      'label'   => 'Es menu?',
                                      'rules'   => 'trim|required'
                                  )
                              );                            
    	$this->_aBuscar = array(
	                          array(
	                              'field'   => 'vcBuscar',
	                              'label'   => 'Buscar por texto',
	                              'rules'   => 'trim|required|xss_clean|min_length[3]|max_length[50]|callback_onlySearch'
	                          )
                      );
	}
	
	public function index()
	{	
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-modulos',array(),true);		
		parent::index();
	}   
    
	protected function _inicReg($boIsPostBack=false) {
		
		$this->_reg = array(
			'idModulo' => null
			, 'idPadreModulo' => ''
			, 'nombreModulo' => ''
			, 'urlModulo' => ''
			, 'tituloModulo' => ''
			, 'menuModulo' => ''
			, 'leftModulo' => ''
			, 'rightModulo' => ''
		);     
        
    	$inId = ($this->input->post('inIdModulo')!==false)? $this->input->post('inIdModulo'):0;
	
    	if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
			 	  'idModulo' => $inId
				, 'idPadreModulo' => set_value('idPadreModulo')
				, 'nombreModulo' => set_value('nombreModulo')
				, 'urlModulo' => set_value('urlModulo')
                , 'tituloModulo' => set_value('tituloModulo')
                , 'menuModulo' => set_value('menuModulo')
                , 'leftModulo' => set_value('leftModulo')
                , 'rightModulo' => set_value('rightModulo')
			);
		}        
             
		return $this->_reg;
	}
	
   	protected function _inicReglas() {
	
    	$val = $this->form_validation->set_rules($this->_aReglas);      		
	}
    	
	public function listado() {        
         
		$this->form_validation->set_rules($this->_aBuscar);
        if($this->form_validation->run()==FALSE) {
            $vcBuscar = '';
        } else {
            $vcBuscar = ($this->input->post('vcBuscar')===FALSE)?'': $this->input->post('vcBuscar');
        }
             
		$this->gridview->initialize(
			array(
				'sResponseUrl' => 'autenticacion/modulos/listado'
				,'sFootProperties'=>'class="paginador"'               
			)
		);	
        
        $this->gridview->addControl('inIdModCtrl',array('face'=>'<a href="autenticacion/modulos/formulario/{idModulo}" title="click para editar {nombreModulo}" class="icono-editar btn-accion" rel="{\'idModulo\': {idModulo}}">&nbsp;</a><a href="autenticacion/modulos/consulta/{idModulo}" title="click para eliminar {nombreModulo}" class="icono-eliminar btn-accion" rel="{\'idModulo\': {idModulo}}">&nbsp;</a>','class'=>'acciones', 'style'=>'width:64px;'));		
	
       	$this->gridview->addColumn('nombreModulo','Nombre');
        $this->gridview->addColumn('urlModulo','Url','text');
        $this->gridview->addColumn('tituloModulo','Titulo','text');
        $this->gridview->addColumn('menuModulo','Menu','bool');       
        $vcBuscar = $this->input->post('vcBuscar');
        if (empty($vcBuscar)) {
        	$rsRegs = $this->_oModel->obtener('&nbsp;&nbsp;-&nbsp;&nbsp;');
        } else {
        	$rsRegs = $this->_oModel->busqueda($vcBuscar);
        }
                
            
       	$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));         
  		
		$this->load->view('lib_autenticacion/lst-modulos'
			,array(
				 'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				,'vcMsjSrv'    => $this->_aEstadoOper['message']
                ,'txtvcBuscar'  =>$vcBuscar                          
			)
		);
	}
    
	public function formulario() {  	   
    
		$this->load->view('lib_autenticacion/frm-modulos'
			, array(
				  'Reg' 		=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/modulos/guardar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion'    => ($this->input->post('inIdModulo')>0)? 'Modificar': 'Agregar'
                , 'aNodPadre'   => ((int)$this->input->post('inIdModulo')!=0)? $this->_oModel->obtenerTodosPadres($this->input->post('inIdModulo')): $this->_oModel->obtenerTodosNodos(NULL)
			)
		);
	}
    
	public function consulta($inIdModulo) {
	   
       	$this->gridview->initialize(
			array(
				'sResponseUrl' => 'autenticacion/modulos/listado'
				,'sFootProperties'=>'class="paginador"'               
			)
		);        
				
       	$this->gridview->addColumn('vcModNombre','Nombre');
        $this->gridview->addColumn('vcModUrl','Url','text');
        $this->gridview->addColumn('vcModTitulo','Titulo','text');
        $this->gridview->addColumn('boModEsMenu','Menu','bool'); 
                
    	$rsRegs = $this->_oModel->obtenerHijos($inIdModulo, '&nbsp;&nbsp;-&nbsp;&nbsp;');  
                       		
		$this->load->view('lib_autenticacion/frm-modulos-borrar'
			,array(
				 'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				,'vcMsjSrv'    => $this->_aEstadoOper['message']  
                ,'Reg' 		=> $this->_inicReg($this->input->post('vcForm'))
				,'vcFrmAction' => 'autenticacion/modulos/eliminar' 
                ,'vcAccion' => ($inIdModulo>0)? 'Eliminar': ''                                     
			)
		); 
	}
	
	public function guardar() {
	    antibotCompararLlave($this->input->post('vcForm'));
		$this->_inicReglas();
		
		if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));  
            
            if (($this->_reg['inLft'] == '') and ($this->_reg['inRgt'] =='')){
                $this->_reg['inLft'] = 0;
                $this->_reg['inRgt'] = 0;
            }                                                                       
            
			$this->_aEstadoOper['status'] = $this->_oModel->guardar(
				array(
					  $this->_reg['inIdModulo']
					, $this->_reg['inIdModuloPadre']
					, $this->_reg['vcModNombre']
					, $this->_reg['vcModUrl']
                                                                                            , $this->_reg['vcModTitulo']
                                                                                            , $this->_reg['boModEsMenu']
                                                                                            , $this->_reg['inLft']
                                                                                            , $this->_reg['inRgt']          
				)
			);           
            
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		
		if(!$this->lib_autenticacion->crearMenues()) {
			$this->_aEstadoOper['message'] .= ' Pero, No se pudo realizar la actualización del menú para alguno de los roles.';
		}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
		
		if($this->_aEstadoOper['status'] > 0) {
			$this->listado();
		} else {
			$this->formulario();
		}
	}
	
	public function eliminar() {  
	   antibotCompararLlave($this->input->post('vcForm'));
	   $error = $this->_aEstadoOper['status'][0];      
       $this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdModulo'));       
            			
	   if((int)$this->_aEstadoOper['status'][0]['ufn30tsegmodulosborrar'] > 0) {
	       
				$this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
                
	   } else {
	       switch ((int)$this->_aEstadoOper['status'][0]['ufn30tsegmodulosborrar']) {
            case -1:
                $this->_aEstadoOper['message'] = 'El registro no pudo ser eliminado.';
            break;
            case -2:
                $this->_aEstadoOper['message'] = 'El registro posee transacciones pendientes, hay registros relacionados a este.';                
            break;
            }
		//		$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	   }      
       if(!$this->lib_autenticacion->crearMenues()) {
 			$this->_aEstadoOper['message'] += 'Pero, No se pudo realizar la actualización del menú para alguno de los roles.';
	   }       
       $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));		
	   $this->listado(); 
	}
	
    public function onlySearch($str) {
        $regex = "/^[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\ \-\_\.\@\']*[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/";
        return ($str=='' or preg_match($regex, $str));
    }
}
// EOF modulos.php
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Duran Francisco Javier
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */

/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
class RolesModulos extends Ext_crud_controller
{
	private $_aRoles = Array();
	private $_rsRegs = Array();
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/rolesmodulos_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');
		$this->load->helper('utils_helper');	
		
		$this->_aRoles= $this->_oModel->obtenerRoles();		
	}
	
	public function index()
	{
		$this->_SiteInfo['title'] = '';
		
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-rolesmodulos',array(),true);
		
		parent::index();
	}

	public function listadoEditar($inIdRol = 0) {
		
		$this->gridview->initialize(array(
				'sResponseUrl' => 'configuracion/rolesmodulos/listado'
				,'iTotalRegs' => ''
				,'iPerPage' => 10000
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			));
			
		$this->gridview->addColumn('vcModNombre','Permisos');
		$this->gridview->addColumn('vcModTitulo','Titulo ');
		
		$this->gridview->addControl('inIdPersonaCtrl'		                            
		                            ,array('face'=>'<input type="checkbox" name="boModAcceso" {chkbomodacceso} id="{inIdModulo}" value ="{inIdModuloPadre}" />'
		                                  ,'class'=>''
		                                  ,'style'=>'padding: 6px 0 0 38px; width:50px;')
									,' Acc. <br/><input type="checkbox" name="accTodos" id="accTodos">');
		$this->gridview->addControl('inIdPersonaCtrl2'									
		                            ,array('face'=>'<input type="checkbox" name="boRolModAlta" {chkborolmodalta} id="{inIdModulo}" value ="{inIdModuloPadre}" />'
		                                  ,'class'=>''
		                                  , 'style'=>'padding: 6px 0 0 38px; width:50px;')
								    ,'Alta <br/><input type="checkbox" name="altaTodos" id="altaTodos">');
		$this->gridview->addControl('inIdPersonaCtrl3'									
		                            ,array('face'=>'<input type="checkbox" name="boRolModModif" {chkborolmodmodif} id="{inIdModulo}" value ="{inIdModuloPadre}" />'
		                                  ,'class'=>'p'
		                                  , 'style'=>'padding: 6px 0 0 38px; width:50px;')
		                            ,'Modif. <br/><input type="checkbox" name="modifTodos" id="modifTodos">');
		$this->gridview->addControl('inIdPersonaCtrl4'									
		                            ,array('face'=>'<input type="checkbox" name="boRolModBaja" {chkborolmodbaja} id="{inIdModulo}" value ="{inIdModuloPadre}" />'
		                                  ,'class'=>''
		                                  , 'style'=>'padding: 6px 0 0 38px; width:50px;')
		                            ,'Baja <br/><input type="checkbox" name="bajaTodos" id="bajaTodos">');
		$this->gridview->addControl('inIdPersonaCtrl5'									
		                            ,array('face'=>'<input type="checkbox" name="boRolModReqPin" {chkborolmodreqpin} id="{inIdModulo}" value ="{inIdModuloPadre}" />'
		                                  ,'class'=>''
		                                  , 'style'=>'padding: 6px 0 0 38px; width:50px;')
								    ,'Req.PIN. <br/><input type="checkbox" name="reqpinTodos" id="reqpinTodos">');					
		
		$this->_rsRegs = $this->_oModel->obtener('&nbsp;&nbsp;-&nbsp;&nbsp',$inIdRol);
		
		for ($i=0; $i < count($this->_rsRegs); $i++) {
			$fila =  $this->_rsRegs[$i];
			if ((bool)$fila['boModAcceso'] == true) {
				$fila = $fila + array('chkbomodacceso'=>'checked = "checked"');
			} else {
				$fila = $fila + array('chkbomodacceso'=>'');
			}
			if ((bool)$fila['boRolModAlta'] == true) {
				$fila = $fila + array('chkborolmodalta'=>'checked = "checked"');
			} else {
				$fila = $fila + array('chkborolmodalta'=>'');
			}
			if ((bool)$fila['boRolModModif'] == true) {
				$fila = $fila + array('chkborolmodmodif'=>'checked = "checked"');
			} else {
				$fila = $fila + array('chkborolmodmodif'=>'');
			}
			if ((bool)$fila['boRolModBaja'] == true) {
				$fila = $fila + array('chkborolmodbaja'=>'checked = "checked"');
			} else {
				$fila = $fila + array('chkborolmodbaja'=>'');
			}
			if ((bool)$fila['boRolModReqPin'] == true) {
				$fila = $fila + array('chkborolmodreqpin'=>'checked = "checked"');
			} else {
				$fila = $fila + array('chkborolmodreqpin'=>'');
			}
			$this->_rsRegs[$i] = $fila;
		}
		
		$this->load->view('lib_autenticacion/lst-rolesmodulos'
			,array(
				  'vcGridView'	=> ($inIdRol !=0) ? $this->gridview->doXHtml($this->_rsRegs) : $this->gridview->doXHtml(array())
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'aRoles'      => $this->_aRoles
				, 'inIdRol'     => $inIdRol	
				, 'btGuardar'   => ($inIdRol == 0)?'':'<a id="lnkGuardar" href="javascript:void(0);" class="button guardar">Guardar</a>'
				, 'btCancelar'   => ($inIdRol == 0)?'':'<a id="btn-cancelar" class="button cancelar">Cancelar</a>'				
			)
		);	
	}

	public function listadoVer($inIdRol = 1) {		
		
		$this->gridview->initialize(array(
				'sResponseUrl' => 'configuracion/rolesmodulos/listado'
				,'iTotalRegs' => ''
				,'iPerPage' => 10000
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			));
		$this->gridview->addColumn('vcModNombre'
								  ,'Permisos'
								  ,'text');
		$this->gridview->addColumn('vcModTitulo'
								  ,'Titulo'
								  ,'text');
		$this->gridview->addColumn('boModAcceso'
								  ,'Acc.'
								  ,'bool'
								  ,array('face'=>''
		                                ,'class'=>''
		                                ,'style'=>'padding: 6px 0 0 32px; width:50px;'));
		$this->gridview->addColumn('boRolModAlta'
								  ,'Alta'
								  ,'bool'
								  ,array('face'=>''
		                                ,'class'=>''
		                                ,'style'=>'padding: 6px 0 0 32px; width:50px;'));
		$this->gridview->addColumn('boRolModModif'
								  ,'Modif.'
								  ,'bool'
								  ,array('face'=>''
		                                ,'class'=>''
		                                ,'style'=>'padding: 6px 0 0 32px; width:50px;'));
		$this->gridview->addColumn('boRolModBaja'
								  ,'Baja'
								  ,'bool'
								  ,array('face'=>''
		                                ,'class'=>''
		                                ,'style'=>'padding: 6px 0 0 32px; width:50px;'));
		$this->gridview->addColumn('boRolModReqPin'
								  ,'Req.PIN'
								  ,'bool'
								  ,array('face'=>''
		                                ,'class'=>''
		                                ,'style'=>'padding: 6px 0 0 32px; width:50px;'));
		
		$this->_rsRegs = $this->_oModel->obtener('&nbsp;&nbsp;-&nbsp;&nbsp',$inIdRol);
		
		$this->load->view('lib_autenticacion/lst-rolesmodulos'
			,array(
				  'vcGridView'	=> $this->gridview->doXHtml($this->_rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'aRoles'      => $this->_aRoles
				, 'inIdRol'     => $inIdRol	
			)
		);
	}
	
	public function guardar(){
		antibotCompararLlave($this->input->post('vcForm'));
		$aux = $this->input->post('cnct');
		$inIdRol = $this->input->post('inIdRol');	
		if ($aux != '') {				
			$aGrilla = explode("|", $aux);
			$tamGrilla = count($aGrilla);
			foreach ($aGrilla as $fila) {
				$fila = $inIdRol.','.$fila;
				$aFila = explode(",", $fila);
				$this->_aEstadoOper['status'] = $this->_oModel->guardar($aFila);
			}
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
			if(!$this->lib_autenticacion->crearMenu($inIdRol)) {
				$this->_aEstadoOper['message'] += 'Pero, No se pudo realizar la actualización del menú.';
			}
			$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
			//Mostramos la vista
			$this->listadoVer($inIdRol);
		}else{
			//Mostramos la vista
			$this->listadoEditar($inIdRol);
		}
	}
	public function creararchivo($inIdRol = 0)
	{
		$mensaje = $this->lib_autenticacion->escribirPermisosPorRol($inIdRol);
		echo $mensaje;
	}
	public function leerarchivo($inIdRol = 0)
	{
		$array = $this->lib_autenticacion->leerArrayPermisosPorRol($inIdRol);
		print_r($array);
	}	
}
//EOF rolesmodulos.php
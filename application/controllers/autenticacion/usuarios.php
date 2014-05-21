<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Usuarios class
 *
 * @package base
 * @author  Artigas Daniel
 * @copyright 2011-12
 */
class Usuarios extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/adminusuarios_model','_oModel');
		$this->load->library('gridview');
		$this->load->library('Messages');     
        $this->load->helper('pin_helper'); 
		//ayudante para la encriptacion
		$this->load->helper('security');
		//ayudante para la gereracion de numeros aleatorios
		$this->load->helper('string');

		//esta es la libreria para el envio de correo electronico
        $configFile = array_merge(config_item('ext_base_smtp_config'), config_item('ext_base_smtp_config_editable'));
		$this->load->library('email', $configFile); 
		
    	$this->_aReglas = array(   
	                           array(
	                              'field'   => 'vcUsuEmail',
	                              'label'   => 'Email',
	                              'rules'   => 'trim|required|valid_email|max_length[256]|xss_clean'
	                          ),
	                           array(
	                              'field'   => 'validar_documento',
	                              'label'   => 'Numero de Documento',
	                              'rules'   => 'trim|required|xss_clean|integer'
	                          ),
	                           array(
	                              'field'   => 'vcUsuPassword',
	                              'label'   => 'Contraseña 1',
	                              'rules'   => 'trim|required|xss_clean|integer|min_length[4]|max_length[50]'
	                          ),
	                           array(
	                              'field'   => 'vcUsuPassword2',
	                              'label'   => 'Contraseña 2',
	                              'rules'   => 'trim|required|xss_clean|matches[vcUsuPassword]|integer|min_length[4]|max_length[50]'
	                          ),
	                           array(
	                              'field'   => 'vcUsuPIN',
	                              'label'   => 'Pin',
	                              'rules'   => 'trim|required|exact_length[4]|xss_clean|integer'
	                          ),
	                           array(
	                              'field'   => 'vcUsuPIN2',
	                              'label'   => 'Pin',
	                              'rules'   => 'trim|required|exact_length[4]|xss_clean|integer|matches[vcUsuPIN]'
	                          ),
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
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-usuarios',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {

		
		$this->_reg = array(
			'inIdUsuario' => null,
            'vcUsuEmail' => ''
        );

		$inId = ($this->input->post('inIdUsuario')!==false)? $this->input->post('inIdUsuario'):0;

		if($inId!=0 && !$boIsPostBack) {
			$this->_reg = $this->_oModel->obtenerUno($inId);
		} else {
			$this->_reg = array(
				'inIdUsuario' => $inId
			   ,'vcUsuEmail' => set_value('vcUsuEmail')
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
            $vcBuscar = ($this->input->post('vcBuscar')===FALSE)? '': $this->input->post('vcBuscar');
        }

        $idUsuario = $this->lib_autenticacion->idUsuario() ;
		
		$this->gridview->initialize(
			array(
				'sResponseUrl' => 'autenticacion/usuarios/listado'
				,'iTotalRegs' => $this->_oModel->numRegs($vcBuscar, $idUsuario)
				,'iPerPage' => ($this->input->post('per_page')==FALSE)? 4: $this->input->post('per_page') 
				,'bOrder' => FALSE
				,'sFootProperties'=>'class="paginador"'
			)
		);	
		
		$this->gridview->addControl('inIdUsuario',array(
            'face'=>'<a href="autenticacion/usuarios/buscarPersona/{inIdUsuario}" title="click para editar {vcUsuEmail}" class="icono-editar btn-accion" rel="{\'inIdUsuario\': {inIdUsuario}}">&nbsp;</a>'.
                    '<a href="autenticacion/usuarios/consulta/{inIdUsuario}" title="click para eliminar {vcUsuEmail}" class="icono-eliminar btn-accion" rel="{\'inIdUsuario\': {inIdUsuario}}">&nbsp;</a>'.
                    '<a href="autenticacion/usuarios/mod_pin_pas/{inIdUsuario}" title="click para editar claves de {vcUsuEmail}" class="icono-key btn-accion" rel="{\'inIdUsuario\': {inIdUsuario}}">&nbsp;</a>'.
                    (config_item('asunto_pin_enabled')
                        ? ('<a href="autenticacion/usuarios/reseteo_pin_confirm/{inIdUsuario}" title="click para resetear pin de {vcUsuEmail}" class="icono-keygo btn-accion" rel="{\'inIdUsuario\': {inIdUsuario}}">&nbsp;</a>')
                        : '')
            ,'class'=>'acciones'
            ,'style'=>'width:128px;white-space: nowrap;'));


		$this->gridview->addColumn('inIdUsuario','#','int');
		$this->gridview->addColumn('vcPerNombre','Persona');
		$this->gridview->addColumn('vcUsuLogin','usuario');	
		$this->gridview->addColumn('vcUsuEmail','E-mail');
		$this->gridview->addColumn('vcSegEstDesc','Estado');  
		$this->gridview->addColumn('vcRolNombre','Rol');
		$this->gridview->addColumn('tsUsuFechaAlta','Fecha De alta','date');
		
		$this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
		
		$rsRegs = $this->_oModel->obtener($vcBuscar, $idUsuario, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        
        #print('<pre>'); print_r($rsRegs);die;
		// $rsRegs = $this->_oModel->obtener($vcBuscar);
		
		$this->load->view('lib_autenticacion/lst-usuarios'
			,array(
				'vcGridView'	=> $this->gridview->doXHtml($rsRegs)
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        		, 'txtvcBuscar' => $vcBuscar
			)
		);
	}

	public function formulario() {
		$this->load->view('lib_autenticacion/frm-usuarios'
			, array(
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/usuarios/buscarPersona'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => 'Paso 1 ) Buscar Persona'
			)
		);
	}
    
	public function consulta($id_usuario)
	{
	//tamamos los estados
	$estados=$this->_oModel->getEstados();
	//tomamos los roles
	$roles=$this->_oModel->getRoles(array($this->lib_autenticacion->idRol()));
	//aca tomamos el usuario
	$usuario=$this->_oModel->getUsuarioPorId($id_usuario);

	foreach($usuario as $row_usuario)
		{
		//tomamos el nombre de la persona
		$personas=$this->_oModel->getPersonaPorId($row_usuario['inIdPersona']);
		break;
		}

	foreach($personas as $registro)
		{
		//tomamos el documento de la persona
		 $Ndocumento=$registro['inPerDni'];
		 break;
		}
				
	$data= array('personas'=>$personas,'estados'=>$estados,'roles'=>$roles,'usuario'=>$row_usuario,'Ndocumento'=>$Ndocumento,'Reg'=>$this->_inicReg($this->input->post('vcForm')), 'vcFrmAction' => 'autenticacion/usuarios/eliminar','vcMsjSrv'=>$this->_aEstadoOper['message']				, 'vcAccion' => ($this->_reg['inIdUsuario']>0)? 'Eliminar': '');

	$this->load->view('lib_autenticacion/frm-usuarios-borrar',$data);
	}
	
	public function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
		$this->_inicReglas();
		if($this->_validarReglas()) {
			$this->_inicReg((bool)$this->input->post('vcForm'));
				$usuario=$this->input->post('vcUsuLogin');

                $sendMail = ($this->input->post('chkEmail')!='');
                $pass = (!$sendMail)                                       ? $this->input->post('vcUsuPassword') : random_string('numeric',4);
				$pin  = (!$sendMail and config_item('asunto_pin_enabled')) ? $this->input->post('vcUsuPIN')      : random_string('numeric',4);

				$pass_md5 = do_hash($pass,'md5');
				$pin_md5 = do_hash($pin,'md5');
		
				$id_usuario=0;
				if ($this->input->post('inIdUsuario')>0) {
					$id_usuario=$this->input->post('inIdUsuario');
				}

				$this->_aEstadoOper['status'] = $this->_oModel->guardar(array($id_usuario,
                                                                              $this->input->post('persona'),
                                                                              $this->input->post('rol'),
                                                                              $this->input->post('estado'),
                                                                              $this->_reg['vcUsuEmail'],
                                                                              $pass_md5,
                                                                              $pin_md5,
                                                                              $this->input->post('vcUsuLogin')));
				if($this->_aEstadoOper['status'] > 0) {
				    $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
					if ($id_usuario==0 and $sendMail){
						$dt2= $this->config->item('ext_base_smtp_config');
						$asunto = $dt2['asunto_crear_usuario'];
						$this->enviar_mensaje(
								$this->_reg['vcUsuEmail']
								,$this->_oModel->tomarPersona($this->input->post('persona'))
								,$pin
								,$pass
								,$usuario
								,$id_usuario
                                ,$asunto
								);
						$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente. se ha enviado un mensaje al E-mail '.$this->_reg['vcUsuEmail'].' con tus datos de usuario.';
					}
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
		
		if ($this->_aEstadoOper['status'] > 0) {
			$this->listado();
		} else {
			$this->formulario();
		}
	}
	
	public function eliminar() {
		antibotCompararLlave($this->input->post('vcForm'));      
      // $this->_inicReglas('true');
       $this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdUsuario'));
			
	   if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El registro fue eliminado con exito.';
	   } else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	   }
	   $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type' => ($this->_aEstadoOper['status'] > 0)?'success':'alert'));   
       $this->listado();    
	}
	
	public function buscarPersona($id_usuario=-1)
	{
		$row_usuario="";
		//tomamos los estados
		$estados=$this->_oModel->getEstados();
		//tomamos los roles
		$roles=$this->_oModel->getRoles(array($this->lib_autenticacion->idRol()));
		//si entra por el actualizar
		if ($id_usuario>0) 
			{
				$usuario=$this->_oModel->getUsuarioPorId($id_usuario);
				foreach($usuario as $row_usuario)
				{
					//tomamos el nombre de la persona
					$personas=$this->_oModel->getPersonaPorId($row_usuario['inIdPersona']);
					break;
				}
			}
		//si entre por la vista frm-usarios
		else
			{
				$personas=$this->_oModel->getPersonaPorDni($this->input->post('validar_documento'));
			}
		//preguntamos si obtuvo algun registro de personas 
		if (count($personas)>0)
		{
			$data= array('personas'=>$personas,'estados'=>$estados,'roles'=>$roles,'usuario'=>$row_usuario,'Ndocumento'=>$personas[0]['inPerDni'],
				'Reg'=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/usuarios/guardar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdUsuario']>0)? 'Modificar': 'Paso 2 ) Agregar');
			$this->load->view('lib_autenticacion/frm-usuarios-persona',$data);
		}
		else
		{
			
			$this->_aEstadoOper['status']=0;
			$this->_aEstadoOper['message'] = 'no se encontraron resultados.';
			
			$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type' => ($this->_aEstadoOper['status'] > 0)?'info':'alert'));

		$data=array('Reg'=> $this->_inicReg($this->input->post('vcForm'))
		 		, 'vcFrmAction' => 'autenticacion/usuarios/guardar'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				);
		$this->load->view('lib_autenticacion/frm-usuarios',$data);
		}
	}

	public function mod_pin_pas($id_usuario="")
	{
		#antibotCompararLlave($this->input->post('vcForm'));
		$data=array('Reg'=> $this->_inicReg()
				, 'vcFrmAction' => 'autenticacion/usuarios/guardar_pin_pas'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdUsuario']>0)? 'Modificar': 'Modificar Password y/o Pin');
		
		$this->load->view('lib_autenticacion/frm-pass-pin',$data);
		
	}
	
	public function guardar_pin_pas()
	{
			antibotCompararLlave($this->input->post('vcForm'));
			$this->_inicReg((bool)$this->input->post('vcForm'));

            $enviarmail = TRUE;
            $inpChkPas = $this->input->post('chkPas');
            $inpChkPin = $this->input->post('chkPin');
            $inpChkEmail = $this->input->post('chkEmail');
			
			if (($inpChkPas=="") and ($inpChkPin==""))
			{
				$enviarmail = FALSE;
			}

            if ($inpChkPas)
			 {
                if ($this->input->post('radPas')=='pass_auto') 
                	{
    					$pass=random_string('numeric',4);
                	}
				else
					{
    					$pass=$this->input->post('vcUsuPassword');
                	}
				$pass_md5 = do_hash($pass,'md5');
				$this->_oModel->guardarPass(array($this->input->post('inIdUsuario'),$pass_md5));
            }
			else
             {
             	$pass=-1;
             }

            if ($inpChkPin)
		     {
             	if ($this->input->post('radPin')=='pin_auto')
				 {
    				$pin=random_string('numeric',4);
                 }
				else
				 {
    				$pin=$this->input->post('vcUsuPIN');
                 }
				$pin_md5 = do_hash($pin,'md5');
				$this->_oModel->guardarPin(array($this->input->post('inIdUsuario'),$pin_md5));
             }
			else 
			 {
                $pin=-1;
             }
			//este if es para preguntar si los chekbox's fueron chequeados o no. estos if's son para los casos en que no denerian mandarse mail
            $pass_ok=$this->input->post('radPas');
			$pin_ok=$this->input->post('radPin');
			if ((!isset($inpChkPas)) and (!isset($inpChkPin)))
			{
                    $enviarmail = FALSE;
            }
			//((isset($inpChkPas)) and ($inpChkPin=="") and ($pass_ok=='pass_manual'))
			if (((isset($inpChkPas)) and ($inpChkPin=="") and ($pass_ok=='pass_manual')and ($inpChkEmail=="")) or (($inpChkPas=="") and (isset($inpChkPin)) and ($pin_ok=='pin_manual') and ($inpChkEmail=="")) or  ((isset($inpChkPas)) and (isset($inpChkPin)) and ($pass_ok=='pass_manual') and ($pin_ok=='pin_manual') and ($inpChkEmail=="")))
			{
                    $enviarmail = FALSE;
            }
            /*if (((!isset($inpChkPas)) and (!isset($inpChkPin))) or
                ((isset($inpChkPas) and (!isset($inpChkPin)) and ($pass_ok=='pass_manual') and ($inpChkEmail==""))) or
                ((!isset($inpChkPas)) and (isset($inpChkPin)) and ($pin_ok=='pin_manual') and ($inpChkEmail=="")) or
                ((isset($inpChkPas)) and (isset($inpChkPin)) and ($pass_ok=='pass_manual') and ($pin_ok=='pin_manual') and ($inpChkEmail==""))) 
			 {
                    $enviarmail = FALSE;
             }*/
			$dt2= $this->config->item('ext_base_smtp_config');
            if ($enviarmail)
             {
             	if (($pass>0) and ($pin>0))
				 {
                 	$asunto = $dt2['asunto_cambiar_contrasenia_pin'];
                 }
				 elseif($pass>0)
				  {
                  	$asunto = $dt2['asunto_cambiar_contrasenia'];
                  }
				 elseif($pin>0)
				  {
                  	$asunto = $dt2['asunto_cambiar_pin'];
                  }
				  
				$re=$this->_oModel->get_usuarioYmail($this->input->post('inIdUsuario'));
				$this->enviar_mensaje($re['vcUsuEmail']
                                      ,$re['vcPerNombre']
                                      ,$pin
                                      ,$pass
                                      ,-1
                                      ,-1
                                      ,$asunto);
            }

			if (($inpChkPas!="") || ($inpChkPin!=""))
			{
				if ($enviarmail)
				{
						$this->_aEstadoOper['status']=1;	
						$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente. Se ha enviado un mensaje al E-mail '.$re['vcUsuEmail'].' con tus datos de usuario.';
				}
				else
				{
					$this->_aEstadoOper['status']=1;	
					$this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
				}
			}
			else
			{
				if (($inpChkPas=="") and ($inpChkPin==""))
				{
					$this->_aEstadoOper['status']=0;
					$this->_aEstadoOper['message'] = 'No ha seleccionado ninguna operacion.';	}
			}
			
			$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type' => ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
			
			if($this->_aEstadoOper['status'] > 0)
			{
				$this->listado();
			}
			else
			{
				$this->mod_pin_pas();
			}
	}

	public function enviar_mensaje($email_destino,$persona,$pin=-1,$pass=-1,$usuario=-1,$id_usuario=-1,$asunto='')
	{
			//nuestro mail
            if (!$asunto) $asunto = $this->config->item('ext_base_nombre_sistema');
			$dt = config_item('ext_base_smtp_config_editable');
            $dt2= config_item('ext_base_smtp_config');
			$this->email->from($dt['smtp_user'], $asunto);
			//direccion de correo del destinatario
			$this->email->to($email_destino);

			if ($pin<=0 && $pass>=0)
			 {
				$cambio = 'de Contraseña se realizo';
                $subject = $dt2['asunto_cambiar_contrasenia'];
			 }
			if ($pin>=0 && $pass<=0)
			 {
				$cambio = 'de Pin se realizo';
                $subject = $dt2['asunto_cambiar_pin'];
			 }
			if ($pin>=0 && $pass>=0)
			 {
				$cambio = 'de Contraseña y Pin se han realizado';
                $subject = $dt2['asunto_cambiar_contrasenia_pin'];
			 }
			if ($usuario >0)
			 {
			 	$subject = $dt2['asunto_crear_usuario'];
			 } 
			$this->email->subject($subject);

			if ($id_usuario==-1)
			{
				$data=array('persona'=>$persona,
							'pin'=>$pin,
							'pass'=>$pass,
							'login'=>config_item('ext_base_login_username'),
							'sistema'=>$this->_SiteInfo['title'],
							'cambio' => $cambio,
                            'vcContenidoEmailPie'=>$dt2['contenido_email_pie'],
                            'vcUrlSitio'=>base_url()
						);
				$mensaje = $this->load->view('lib_autenticacion/mail-pin-pass-view',$data,true);
			} else {
				$data=array('persona'=>$persona,
							'usuario'=>$usuario,
							'contrasenia'=>$pass,
                            'pin'=>$pin,
							'login'=>config_item('ext_base_login_username'),
							'sistema'=>$this->_SiteInfo['title'],
                            'vcContenidoEmailPie'=>$dt2['contenido_email_pie'],
                            'vcUrlSitio'=>base_url()
							);
                $mensaje = $this->load->view('lib_autenticacion/mail-creacion-view',$data,true);
			}
			$this->email->message(nl2br($mensaje));
			//debugger
			if (!$this->email->send()):
                show_error($this->email->print_debugger());
            endif;
	}
	public function reseteo_pin_confirm($id_usuario=-1)
	{
		$row_usuario="";
		//tomamos los estados
		$estados=$this->_oModel->getEstados();
		//tomamos los roles
		$roles=$this->_oModel->getRoles(array($this->lib_autenticacion->idRol()));
		//si entra por el actualizar
		if ($id_usuario>0) 
			{
				$usuario=$this->_oModel->getUsuarioPorId($id_usuario);
				foreach($usuario as $row_usuario)
				{
					//tomamos el nombre de la persona
					$personas=$this->_oModel->getPersonaPorId($row_usuario['inIdPersona']);
					break;
				}
			}
		//si entre por la vista frm-usarios
		else
			{
				$personas=$this->_oModel->getPersonaPorDni($this->input->post('validar_documento'));
			}
		//preguntamos si obtuvo algun registro de personas 
		if (count($personas)>0)
		{
			//para el caso que entre por el agregar un nuevo usuario
            $inpVD = $this->input->post('validar_documento');
			if (isset($inpVD))
			{
				$Ndocumento=$inpVD;
			}
			//para el caso en el que entre por modificar un usuario
			else
			{
				foreach($personas as $registro)
				{
				 $Ndocumento=$registro['inPerDni'];
				 break;
				}
			}
			$data= array('personas'=>$personas,'estados'=>$estados,'roles'=>$roles,'usuario'=>$row_usuario,'Ndocumento'=>$Ndocumento,
				'Reg'=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/usuarios/reseteo_pin'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
				, 'vcAccion' => ($this->_reg['inIdUsuario']>0)? 'Resetear': 'Agregar');
			$this->load->view('lib_autenticacion/frm-pin-reseteo',$data);
		}
		else
		{
			$data['error']= 'no se encontraron resultados';
			$this->load->view('lib_autenticacion/frm-usuarios',$data);
		}
	}
	public function reseteo_pin()
	{
		$this->_oModel->recet_pin($this->input->post('inIdUsuario'));
		$array=$this->_oModel->get_usuarioYmail($this->input->post('inIdUsuario'));
		$this->_aEstadoOper['status']=1;
		$this->_aEstadoOper['message'] = 'El pin del usuario '.$array['vcPerNombre'].' se ha reseteado correctamente.';
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
		
		$this->listado();
	}
    public function onlySearch($str) {
        $regex = "/^[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\ \-\_\.\@\']*[0-9a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]+$/";
        return ($str=='' or preg_match($regex, $str));
    }
}
// EOF usuarios.php
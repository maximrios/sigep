<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * PerfilUsuario class
 *
 * @package base30
 * @author  Marcelo Gutierrez
 * @copyright 2012-01
 */
class PerfilUsuario extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/usuarios_model','usuarios');
		$this->load->library('gridview');
		$this->load->library('Messages');
		
    	$this->_aReglas = array(   
	                    'autenticacion/perfilusuario/guardar' => array(
							array(
	                              'field'   => 'vcPerNombre',
	                              'label'   => 'Apellido y Nombres del Usuario',
	                              'rules'   => 'trim|required|required|max_length[100]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcUsuEmail',
	                              'label'   => 'E-Mail',
	                              'rules'   => 'trim|required|xss_clean|required|max_length[256]|valid_email'
	                          ),
	                          array (
	                              'field'   => 'dtPerFechaNac',
	                              'label'   => 'Fecha de Nacimiento',
	                              'rules'   => 'trim|required|callback_validate_date_check|xss_clean'
	                          )
						)
						,'autenticacion/perfilusuario/cambiarpass' =>array(
							array(
	                              'field'   => 'passwordUsuario',
	                              'label'   => 'Contraseña anterior',
	                              'rules'   => 'trim|required|min_length[4]|max_length[50]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'passwordNuevo',
	                              'label'   => 'Nueva contraseña',
	                              'rules'   => 'trim|required|min_length[4]|max_length[50]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'repasswordNuevo',
	                              'label'   => 'Repetir nueva contraseña',
	                              'rules'   => 'trim|required|min_length[4]|max_length[50]|matches[vcPassNuevo]|xss_clean'
	                          )
						)
						,'autenticacion/perfilusuario/cambiarpin' =>array(
							array(
	                              'field'   => 'vcPIN',
	                              'label'   => 'PIN anterior',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          ),
	                          array(
	                              'field'   => 'vcPINNuevo',
	                              'label'   => 'Nuevo PIN',
	                              'rules'   => 'trim|required|xss_clean|min_length[4]'
	                          ),
	                          array(
	                              'field'   => 'vcPINNuevo2',
	                              'label'   => 'Repetir nuevo PIN',
	                              'rules'   => 'trim|required|xss_clean|min_length[4]|matches[vcPINNuevo]'
	                          ),
							 array(
	                              'field'   => 'vcPass',
	                              'label'   => 'Contraseña',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          )	                          
						)
						,'autenticacion/perfilusuario/desbloquearpin' =>array(
							array(
	                              'field'   => 'vcPIN',
	                              'label'   => 'PIN',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          ),
							 array(
	                              'field'   => 'vcPass',
	                              'label'   => 'Contraseña',
	                              'rules'   => 'trim|required|max_length[50]|xss_clean'
	                          )
						)
                      );
        
    }

    protected function _loadIndex($options = array()) {
        $this->_SiteInfo['title'] .= ' Cambiar mis datos';
		$rgUsr = $this->lib_autenticacion->obtenerDatos();
		
		$legibleNomb = ucwords(strtolower($rgUsr['vcPerNombre']));
	       	
		$aData = array (
			'vcAccion'	=> $legibleNomb
			, 'Reg'		=> $rgUsr
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
		);
        $aData = array_merge($aData, $options);
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/frm-usuario-datos',$aData,true);        
    }
    
	public function index()
	{
        $this->_loadIndex();
		//	
		parent::index();
	}
	
	protected function _inicReg($boIsPostBack=false) {
		if($boIsPostBack==TRUE) {
            $this->_reg = array(
                'idUsuario' => $this->lib_autenticacion->idUsuario()
                , 'nombrePersona' => set_value('nombrePersona')
                //, 'vcUsuEmail' => set_value('vcUsuEmail')
                //, 'dtPerFechaNac' => set_value('dtPerFechaNac')
            );
		} else {
            $this->_reg = $this->lib_autenticacion->obtenerDatos();
            //$this->_reg['dtPerFechaNac'] = GetDateFromISO($this->_reg['dtPerFechaNac']); 		  
		}
		return $this->_reg;
	}
	
	protected function _inicReglas($vcRegla) {
	
    	$val = $this->form_validation->set_rules($this->_aReglas[$vcRegla]);      		
	}

	public function formularioPerfil() {
        $output = $this->load->view(
            'lib_autenticacion/frm-usuario-perfil'
        	, array (
        		  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
        		, 'vcFrmAction' => 'autenticacion/perfilusuario/guardar'
        		, 'vcMsjSrv'    => $this->_aEstadoOper['message']
        	)
            ,TRUE
         );
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo $output;
        } else {
           $this->_aEstadoOper['message'] = ($this->_aEstadoOper['status'] > 0)? $this->_aEstadoOper['message']: $output;
           $this->index();
        }
	}
	
	public function formularioModifPass() {
		
		$this->load->view('lib_autenticacion/frm-usuario-modif-pass'
			, array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/perfilusuario/cambiarpass'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
			)
		);
	}	
	
	public function formularioModifPIN() {
		
		$this->load->view('lib_autenticacion/frm-usuario-modif-pin'
			, array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/perfilusuario/cambiarpin'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
			)
		);
	}

	public function formularioDesbloqPIN() {
		
		$this->load->view('lib_autenticacion/frm-usuario-desbloq-pin'
			, array (
				  'Reg' 			=> $this->_inicReg($this->input->post('vcForm'))
				, 'vcFrmAction' => 'autenticacion/perfilusuario/desbloquearpin'
				, 'vcMsjSrv'    => $this->_aEstadoOper['message']
			)
		);
	}
	
	public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
		$this->_inicReglas('autenticacion/perfilusuario/guardar');
	
		if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));
			
			$this->_aEstadoOper['status'] = $this->usuarios->guardarPerfil(
				array(
					$this->_reg['inIdUsuario']
					, $this->_reg['vcPerNombre']
                    , $this->_reg['vcUsuEmail']
					, GetDateTimeFromFrenchToISO($this->_reg['dtPerFechaNac'])
				)
			);
			
			if($this->_aEstadoOper['status'] > 0) {
                
				$this->_aEstadoOper['message'] = 'Los cambios fueron guardados correctamente.';
			} else {
				$this->_aEstadoOper['message'] = 'No se pudo efectuar la operación requerida.';
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
		
		$this->formularioPerfil();
		
	}
	
    public function cambiarPass() {
        //antibotCompararLlave($this->input->post('vcForm'));
        //$this->_inicReglas('autenticacion/perfilusuario/cambiarpass');
		//if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));
			
			$this->_aEstadoOper['status'] = $this->usuarios->cambiarPassword (
				array (
					$this->_reg['idUsuario']
					, md5($this->input->post('passwordUsuario'))
                    , md5($this->input->post('passwordNuevo'))
				)
			);
			
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'La contrase&ntilde;a fue cambiada correctamente.';
			} else {
				$this->_aEstadoOper['message'] = 'No se pudo efectuar la operaci&oacute;n requerida. La contrase&ntilde;a proporcionada no es correcta.';
			}
		//} else {
		//	$this->_aEstadoOper['status'] = 0;
		//	$this->_aEstadoOper['message'] = validation_errors();
		//}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        
        if($this->_aEstadoOper['status'] > 0) {
			echo $this->_aEstadoOper['message'];
		} else {
			$this->formularioModifPass();
		}
    }

    public function cambiarPin() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas('autenticacion/perfilusuario/cambiarpin');
		if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));
			
			$this->_aEstadoOper['status'] = $this->usuarios->cambiarPin (
				array (
					$this->_reg['inIdUsuario']
					, set_value('vcPIN')
                    , set_value('vcPINNuevo')
					, set_value('vcPass')
				)
			);
			
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El PIN fue cambiado correctamente.';
			} elseif($this->_aEstadoOper['status'] == 0) {
				$this->_aEstadoOper['message'] = 'No se pudo efectuar la operaci&oacute;n requerida. La contrase&ntilde;a proporcionada no es correcta.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        
        if($this->_aEstadoOper['status'] > 0) {
			echo $this->_aEstadoOper['message'];
		} else {
			$this->formularioModifPIN();
		}
    }

	public function desbloquearPin() {
	   antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas('autenticacion/perfilusuario/desbloquearpin');
		if($this->_validarReglas()) {
			
			$this->_inicReg((bool)$this->input->post('vcForm'));
			
			$this->_aEstadoOper['status'] = $this->usuarios->desbloquearPin (
				array (
					$this->_reg['inIdUsuario']
					, set_value('vcPIN')
					, set_value('vcPass')
				)
			);
			
			if($this->_aEstadoOper['status'] > 0) {
				$this->_aEstadoOper['message'] = 'El PIN fue desbloqueado correctamente.';
			} elseif($this->_aEstadoOper['status'] == 0) {
				$this->_aEstadoOper['message'] = 'No se pudo efectuar la operaci&oacute;n requerida. La contrase&ntilde;a proporcionada no es correcta.';
			} else {
				$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
			}
		} else {
			$this->_aEstadoOper['status'] = 0;
			$this->_aEstadoOper['message'] = validation_errors();
		}
		
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        
        if($this->_aEstadoOper['status'] > 0) {
			echo $this->_aEstadoOper['message'];
		} else {
			$this->formularioDesbloqPIN();
		}
	}

	public function eliminar() {   
        antibotCompararLlave($this->input->post('vcForm'));
    	$this->_aEstadoOper['status'] = $this->usuarios->eliminar($this->input->post('inIdNovedadesRol'));
	   	if($this->_aEstadoOper['status'] > 0) {
			$this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
	   	} else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	   	}
		
$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));		
		
       	$this->listado();
	}

    public function validate_date_check($str) {
        if($str!='' and !dateFrenchIsValid($str)) {
			$this->form_validation->set_message('validate_date_check', 'La %s no es válida.');
        	return FALSE;
    	}
        return TRUE;
    }

}
//EOF perfilusuario.php
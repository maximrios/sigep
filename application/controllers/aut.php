<?php
class Aut extends Ext_Controller {
	protected $_responseAjax = false;
	protected $_errors = array();
	protected $_PanelInfo;
	function __construct() {
		parent::__construct();
		$this->_SiteInfo['title'] .= ' - '.$this->_SiteInfo['propiedad'].' - Identificación de Usuario';
		$this->_PanelInfo = config_item('ext_base_panel');
		$this->load->model($this->db->dbdriver.'/lib_autenticacion/usuarios_model','_oModel');
		//ayudante para la encriptacion
		$this->load->helper('security');
		//esta es la libreria para el envio de correo electronico
        $configFile = array_merge(config_item('ext_base_smtp_config'), config_item('ext_base_smtp_config_editable'));
		$this->load->library('email', $configFile);
	}
	protected function _init() {
		parent::_init();
		$this->load->library('lib_autenticacion/lib_autenticacion');
		$this->load->library('Form_validation');
	}
	protected function _setError($vcMsg, $vcType='alert'){
		array_push($this->_errors, $this->messages->do_message(array('message'=>$vcMsg,'type'=>$vcType)));
	}
	protected function _getErrors($vcSep=''){
		return implode($vcSep, $this->_errors);
	}
	protected function _doRedirect($vcUrl){
	}
	public function index() {
		$this->logout();        
	}
	public function autenticar() {
        antibotCompararLlave($this->input->post('vcForm'));
		$vcResponse = '';
		if(!$this->lib_autenticacion->estaLogueado(false)) {
			$val = $this->form_validation;
			$val->set_rules('nombreUsuario', 'Usuario', 'trim|required|max_length[50]|xss_clean');
			$val->set_rules('passwordUsuario', 'Password', 'trim|required|xss_clean');
			if ($val->run() AND $this->lib_autenticacion->login($this->input->post('nombreUsuario'), $this->input->post('passwordUsuario'))) {
			    antibotBorrarLlaves();
                $vcResponse = $this->lib_autenticacion->doRedirect($this->lib_autenticacion->opciones['login_success_uri']);
            }
			else {
				if(validation_errors()!=''){
					$this->_setError(validation_errors());
				}
				if($this->lib_autenticacion->mensajeError()!=''){
					$this->_setError($this->lib_autenticacion->mensajeError());
				} 
				else {
					$this->_setError('Ocurrio un problema. No se pudo efectuar la operacion requerida.');
				}
                $vcFormName = antibotHacerLlave();
                $inputHTML = '<input type="hidden" id="vcForm" name="vcForm" value="'.$vcFormName.'" />';				
				$vcResponse = $this->_getErrors().$inputHTML;
			}
		}
		else {
			$this->lib_autenticacion->logout();
			$vcResponse = $this->lib_autenticacion->doRedirect($this->lib_autenticacion->opciones['login_uri']);
		}
		echo $vcResponse;
	}
	public function login($dni='') {
		$dataView = array('txtLogin'=>$dni?$dni:'', 'vcMsjSrv' => $this->_getErrors());
        $this->lib_autenticacion->unsetSession();
        $mySESSION_message = $this->session->userdata('message');
        if ($mySESSION_message) {
            $dataView['vcMsjSrv'] = $this->messages->do_message(array('message'=>$mySESSION_message,'type'=>'alert'));
            $this->session->unset_userdata(array('message'=>''));
		}
		$data['vcMainContent'] = $this->load->view('administrator/hits/usuarios/formulario_login',$dataView,true);
        $data['vcMenu']='';
		if(!$this->_responseAjax){
			$data['SiteInfo'] = $this->_siteInfo();
			$data['PanelInfo'] = $this->_PanelInfo;
			$this->load->view('administrator/hits/usuarios/principal',$data);
		}
		else {
			echo $data['vcAutContent'];
		}
	}
	public function olvidepass($dni='', $email='') {
		$dataView = array(
            'txtLogin'=>$dni?$dni:'',
            'txtEmail'=>$email?$email:'',
            'vcMsjSrv' => $this->_getErrors()
        );
		$this->lib_autenticacion->unsetSession();
		$data['vcMainContent'] = $this->load->view('lib_autenticacion/form-login-olvidepass',$dataView,true);
        $data['vcIncludesGlobales']='<link href="'.config_item('ext_base_url_plantilla_elegida').'css/layout.login.olvidepass.css" rel="stylesheet" type="text/css"/>';
        $data['vcMenu']='';
		if(!$this->_responseAjax){
			$data['SiteInfo'] = $this->_siteInfo();
			$this->load->view('masterpage',$data);
		} 
		else {
			echo $data['vcAutContent'];
		}
	}
	public function _puede_recuperar_pass($vcUsuLogin) {
		$vcUsuEmail = $this->input->post('txtEmail');
		$iRet = $this->lib_autenticacion->puedeRecuperarPassword($vcUsuLogin, $vcUsuEmail);
		if($iRet==1) {
			return TRUE;
		} 
		else {
			$this->form_validation->set_message('_puede_recuperar_pass', 'Esta cuenta no está habilitada para realizar esta acción, o no requiere cambios.');
			return FALSE;
		}
	}
	public function olvidepassenviar() {
        antibotCompararLlave($this->input->post('vcForm'));
		$this->load->helper('security');
		$val = $this->form_validation;
		$val->set_rules('txtLogin', $this->config->item('ext_base_login_username'), 'trim|required|max_length[50]|xss_clean|callback__puede_recuperar_pass');
		$val->set_rules('txtEmail', 'Email', 'trim|required|max_length[256]|xss_clean|valid_email');
		if($val->run()) {
            $dt = $this->config->item('ext_base_smtp_config_editable');
            $dt2= $this->config->item('ext_base_smtp_config');
            $this->email->from($dt['smtp_user'], $this->config->item('ext_base_nombre_sistema'));
            $this->email->to($this->input->post('txtEmail'));
            $this->email->subject($dt2['asunto_recuperar_contrasenia']);
			$codActivacion = $this->_oModel->obtenerDatosPorUsuarioAndEmail($this->input->post('txtLogin'), $this->input->post('txtEmail'));
			$resultado = $this->_oModel->obtenerDatos($codActivacion['inIdUsuario']);
            $resultado['vcUsuCodActivacionCta'] = $codActivacion['vcUsuCodActivacionCta'];
            $vcKey = base64_encode(random_string('numeric',10).@date("Ymd"));
            $resultado['vcUsuCodActivacionCta'] = $this->lib_autenticacion->actualizarTokenDeUsuario($resultado['inIdUsuario'], $vcKey, $resultado['vcUsuCodActivacionCta']);
			$siteinfo=config_item('ext_base_site_info');
			$data=array('persona' => $resultado['vcPerNombre'],
						'sistema' => $siteinfo['title'],
                        'vcContenidoEmailPie'=>$dt2['contenido_email_pie'],
                        'vcUrlResetPass' => base_url().
                                            'aut/resetpass/'.
                                            $resultado['inIdUsuario'].
                                            '/'.
                                            trim($resultado['vcUsuCodActivacionCta']),
                        'vcUrlSitio' => base_url()
	                   );

			$mensaje = $this->load->view('mail-aut-view',$data,true);
			$this->email->message(nl2br($mensaje));
			if (! $this->email->send())
			{
                $this->_setError('Ha ocurrido un error. Por favor reintente');
			} else {
                $this->_setError('Se ha enviado un Email. Por favor revise su correo electrónico','success');
			}			
		} else {
            $vcFormName = antibotHacerLlave();
            $inputHTML = '<input type="hidden" id="vcForm" name="vcForm" value="'.$vcFormName.'" />';				
			$this->_setError(validation_errors().$inputHTML);
		}

		$this->output->set_output($this->_getErrors());
	}


	public function resetpass($inIdUsuario, $vcKey)
	{
        $resultado= $this->_oModel->obtenerDatos($inIdUsuario);
		$codActivacion = $this->_oModel->obtenerDatosPorUsuarioAndEmail($resultado['vcUsuLogin'], $resultado['vcUsuEmail']);
        $resultado['vcUsuCodActivacionCta'] = $codActivacion['vcUsuCodActivacionCta'];

        if ($resultado['vcUsuCodActivacionCta']==$vcKey) {
            $pass = random_string('numeric',4);
            $pass_md5 = do_hash($pass,'md5');
            $this->_oModel->guardarPass(array($resultado['inIdUsuario'], $pass_md5));
            $this->lib_autenticacion->actualizarTokenDeUsuario($resultado['inIdUsuario']);

            $dt = $this->config->item('ext_base_smtp_config_editable');
            $dt2= $this->config->item('ext_base_smtp_config');
            $this->email->from($dt['smtp_user'], $this->config->item('ext_base_nombre_sistema'));
            //direccion de correo del destinatario
            $this->email->to($resultado['vcUsuEmail']);
            $this->email->subject($dt2['asunto_recuperar_contrasenia']);

			$siteinfo=config_item('ext_base_site_info');
			$data=array('persona'=>$resultado['vcPerNombre'],
						'sistema'=>$siteinfo['title'],
                        'cambio'=>'de su Contraseña ha sido realizado',
                        'pass'=>$pass,
                        'pin'=>-1,
                        'vcContenidoEmailPie'=>$dt2['contenido_email_pie'],
                        'vcUrlResetPass'=>'',
                        'vcUrlSitio'=>base_url()
	                   );
			$mensaje = $this->load->view('lib_autenticacion/mail-pin-pass-view',$data,true);
			$this->email->message(nl2br($mensaje));
            if (! $this->email->send()) {
                $this->_setError('Ha ocurrido un error. Por favor reintente');
            } else {
                $this->_setError('Se ha enviado un Email. Por favor revise su correo electrónico','success');
            }
        } else {
    		$this->_setError('El enlace al cual intenta acceder no realiza ninguna operación. Por favor reintente');
        }
        $this->login($resultado['vcUsuLogin']);        
	}

	public function logout($redirect='si')
	{
		$this->lib_autenticacion->logout();
		//if ($redirect=='si') redirect(base_url(),'location');
		if ($redirect=='si') redirect(config_item('lib_autenticacion_login_uri'),'location');
	}
}
?>
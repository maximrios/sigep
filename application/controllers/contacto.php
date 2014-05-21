<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de m�todos y variables respetando la notacion camel case en min�sculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 * 
 * Contacto Class
 *
 * @package		base
 * @category	Contacto
 * @author		Silvia E.Farfan
 * @link
 * @copyright	2012-02-01
 */
 
class Contacto extends Ext_controller {
    /**
    * Constructor
	*
	* @access	public
	* @param   Se invocan las librerias que se utilizaran en el controlador.
	* @return
	*/
	function __construct() {
		parent::__construct();		
		//$this->load->library('email');
        //$this->load->library('Form_validation');
        //$this->load->library('Messages');
        $this->_aReglas = array(   
            array(
                'field'   => 'nombresContacto',
                'label'   => 'Nombre',
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'emailContacto',
                'label'   => 'Email',
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'asuntoContacto',
                'label'   => 'Asunto',
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'mensajeContacto',
                'label'   => 'Mensaje',
                'rules'   => 'trim|required|xss_clean'
            )                              
        );         
	}
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }  
    protected function _inicReg() {
        $this->_reg = array(            
            'nombresContacto' => $this->input->post('nombresContacto')
            , 'emailContacto' => $this->input->post('emailContacto')
            , 'asuntoContacto' => $this->input->post('asuntoContacto')
            , 'mensajeContacto' => $this->input->post('mensajeContacto')
        );
        return $this->_reg;
    }
    public function index() {	
        //antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if($this->_validarReglas()) {
            $this->_inicReg((bool)$this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = 1;
            if($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Hemos recibido su consulta. Nos comunicaremos con Ud. a la brevedad.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));
        if($this->_aEstadoOper['status'] > 0) {
            //$this->listado();
        } else {
            //$this->formulario();
        }
        /*$config = $this->config->item('ext_base_site_info');
        $configmail = $this->config->item('ext_base_smtp_config_editable');
        $this->load->library('hits/mailer', array(), 'mailer');
        $destinatarios = array(
            'email'  => $configmail['mail'],
            'nombre' => $config['title']
        );
        $this->mailer->enviarMail($configmail['asunto_mail'], $configmail['cuerpo_mail'], array(), $destinatarios);*/
		
        //$this->_vcContentPlaceHolder = $this->load->view('soporte/principal-contacto',array(),true);		
		//parent::index();        
	}
	/**
	 * Contacto::enviarEmail()
	 * 
     * Se establecen las preferencias en un arreglo de configuracion, se completa el contenido del email y se envia el correo.
     * 
	 * @param $vcEmail
	 * @param $vcAsunto
	 * @param $vcConsulta
	 * @return
	 */
	public function enviarEmail($vcEmail, $vcAsunto,$vcConsulta) {
        $this->email->initialize(config_item('ext_base_smtp_config'));
        $eAdmin = 'testsice@gmail.com';        
        $aUsuario = $this->lib_autenticacion->usuario();       
        $this->email->from($vcEmail, $aUsuario['vcPerNombre']);
        $this->email->to($eAdmin);
        $this->email->cc($eAdmin);     
        $this->email->subject($vcAsunto);
        $this->email->message($vcConsulta);
        $this->email->send();
        //echo $this->email->print_debugger();    
	} 
    public function enviar() {
		$this->_inicReglas();     
        
        $this->enviarEmail($this->input->post('vcEmail'), $this->input->post('vcAsunto'), $this->input->post('vcConsulta'));   
   /* 
		if($this->_validarReglas()) {
		  	$this->_inicReg((bool)$this->input->post('vcForm'));          
            echo "##";
         }   
          
        print_r($this->_inicReg((bool)$this->input->post('vcForm')));        
        $this->_inicReg();  
        echo  $this->_reg['vcAsunto']; 
        echo  $this->_reg['vcEmail'];
        echo  $this->_reg['vcConsulta'];
    */      
	}
}
/* End of file Contacto.php */
/* Location: ./application/controllers/soporte/contacto.php */
// EOF contacto.php
?>
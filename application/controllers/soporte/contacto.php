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
 
class Contacto extends Ext_crud_controller
{
    
    
    
    /**
	 * Constructor
	 *
	 * @access	public
	 * @param   Se invocan las librerias que se utilizaran en el controlador.
	 */
	/**
	 * Contacto::__construct()
	 * 
	 * @return
	 */
	function __construct()
	{
		parent::__construct();		
        		
		$this->load->library('email');
		$this->load->library('Messages');           
        
        $this->_aReglas = array(   
                                  array(
                                      'field'   => 'vcAsunto',
                                      'label'   => 'Asunto del email',
                                      'rules'   => 'trim|required|xss_clean'
                                  ),
                                  array(
                                      'field'   => 'vcEmail',
                                      'label'   => 'Email del contacto',
                                      'rules'   => 'trim|required|xss_clean'
                                  ),
                                  array(
                                      'field'   => 'vcConsulta',
                                      'label'   => 'Consulta',
                                      'rules'   => 'trim|xss_clean|xss_clean'
                                  )                              
                              );         
	}
    /**
     * contacto::index()
     * Este el metodo por defecto del controlador. Aqui se llama a la vista principal de este controlador.
     * @return void
     */	
    /**
     * Contacto::index()
     * 
     * @return
     */
    public function index()
	{	
		$this->_vcContentPlaceHolder = $this->load->view('soporte/principal-contacto',array(),true);		
		parent::index();        
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
      //  echo $this->email->print_debugger();    
	} 
    /**
     * contacto::_inicReglas()
     * Del arreglo $this->aReglas se toman las configuraciones de validacion
     *           
     * @return void
     */       
    protected function _inicReglas() {
	
    	$val = $this->form_validation->set_rules($this->_aReglas);      		
	}  
    
    /**
     * contacto::_inicReg()
     * 
     * Este metodo toma las variables POST que son enviadas a traves del formulario        
     * @return Array
     */ 
    protected function _inicReg() {
			
		$this->_reg = array(			
				  'vcAsunto' => $this->input->post('vcAsunto')
				, 'vcEmail' => $this->input->post('vcEmail')
				, 'vcConsulta' => $this->input->post('vcConsulta')
			);
		return $this->_reg;
	}   
     
    /**
     * Contacto::enviar()
     * 
     * Este metodo se utiliza para inicializar las reglas de validacion y enviar un correo.
     * @return void
     */
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
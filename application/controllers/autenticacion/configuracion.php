<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
/**
 * Roles class
 *
 * @package base
 * @author  Marcelo Gutierrez
 * @copyright 2011-12
 */
class Configuracion extends Ext_crud_controller
{
	function __construct()
	{
		parent::__construct();		
		$this->load->library('Messages');
        $this->load->helper('editarconfig');
		
		$this->_aReglas = array(   
	                         
                      );
	}
	
	public function index()
	{
		//
		$this->_vcContentPlaceHolder = $this->load->view('lib_autenticacion/principal-configuracion',array(),true);
		//		
		parent::index();
	}
	
	protected function _inicReglas() {
	
    	$val = $this->form_validation->set_rules($this->_aReglas);      		
	}
	
	protected function _inicReg() {		
		include ('application/config/config.editable.php');
        $arrReturn1 = array('config' => $config);
		include ('application/config/config.editable.titulos.php');
        $arrReturn2 = array('titulo' => $config);
        $arrReturn = array_merge($arrReturn1, $arrReturn2);
		return $arrReturn;
	}

	public function ver() {	
		
		$aData = $this->_inicReg();
		$aData['vcFrmAction'] = 'autenticacion/configuracion/formulario';
		$aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
		$aData['vcAccion'] = 'Ver';
		$this->load->view('lib_autenticacion/configuracion-view',$aData);
	}
	
	public function formulario() {
		
		$aData = $this->_inicReg();
		$aData['vcFrmAction'] = 'autenticacion/configuracion/guardar';
		$aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
		$aData['vcAccion'] = 'Modificar';
		$this->load->view('lib_autenticacion/frm-configuracion',$aData);
	}
	
	public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));

		$strfputs = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		$strfputs.= "\n";
		$strfputs.= "/******************************************************************************************/\n";
        $strfputs.= "/* Los valores que escribas en este archivo serán editables desde la interfaz del sistema */\n";
        $strfputs.= "/* Los títulos de interfaz de sistema debes escribirlos en config.editable.titulos.php    */\n";
		$strfputs.= "/******************************************************************************************/\n";
		$strfputs.= "\n";

        // Traer Config en un Array
		$aData = $this->_inicReg();
        $config = $aData['config'];
        $titulo = $aData['titulo'];

        // Hacer operaciones para traer POST y escribirlo como un config
        if (is_array($config)){
    		foreach ($config as $clave => $valor){
    		    if (is_array($valor)){
    				foreach ($valor as $clave2 => $valor2){
    				    $clave3 = 'arr_'.$clave.'_arr_'.$clave2;
                        $strfputs .= "\$config['{$clave}']['{$clave2}'] = ".putInputConfig($this->input->post($clave3), $valor2).";\n";
    				}
                    $strfputs .= "\n";
    		    } else {
                    $strfputs .= "\$config['{$clave}'] = ".putInputConfig($this->input->post($clave), $valor).";\n";
    		    }
    		}
        }//print '<pre>'.$strfputs; die();

        // Guardar en el archivo en disco
		$file = fopen ('application/config/config.editable.php', "w");
		fputs($file,$strfputs);		
		fclose($file);
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>'El registro fue guardado correctamente.','success'));
		
		$this->ver();		
	}
}
?>
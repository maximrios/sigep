<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */
class Selects extends Ext_AutController
{
	private $_modulo;
	private $_ruta;
	private $_config = array('lblPais'=>''
							,'lblProvincia'=>''
							,'lblDepartamento'=>''
							);
	public function _initialize($aParms)
	{
		//$this->_config['']= ($aParms[''])?:;
		
	}
	function __construct()
	{
		parent::__construct();
		$this->load->model($this->db->dbdriver.'/cuadrocargos/instrumentos_model','instrumentos_model');
		$this->_modulo = 'cuadrocargos'; 
		$this->_ruta = $this->_modulo.'/'.strtolower(get_class($this)).'/';
	}
	
	public function jsonInstrumentos()
	{
		echo json_encode($this->instrumentos_model->ObtInstrumentos(false));                
	}

	public function ddlProvincias($inIdPais = 0)
	{
		$provincias = $this->localizacion_model->ObtProvincias($inIdPais);
		if(!$provincias){
			$provincias = form_dropdown('inIdProvincia',array(''=>'Sin Resultados'),'','id="inIdProvincia"');
		} else {
			$extra = 'id="inIdProvincia" onChange="javascript:$.ddlCascada.obtDepartamentos(\''.base_url().'sistema/localizacion/ddlDepartamentos\',\'divDepartamentos\',\'inIdProvincia\');"'; 
			$provincias = array(''=>'Seleccione...') + $provincias;
			$provincias = form_dropdown('inIdProvincia',$provincias,array(),$extra);
		}	
		$vcRet  = '<label>Provincia:</label><span id="ddl_provincias">'.$provincias;
		$vcRet .= '</span>';
		echo $vcRet;
	}
	public function jsonProvincias($inIdPais = 0)
	{
        echo json_encode($this->localizacion_model->ObtProvincias($inIdPais, false));
	}

	public function ddlDepartamentos($inIdProvincia = 0)
	{
		$departamentos = $this->localizacion_model->ObtDepartamentos($inIdProvincia);
		if(!$departamentos){
			$departamentos = form_dropdown('inIdDepartamento',array(''=>'Sin Resultados'),'id="inIdDepartamento"');
		} else {
			$extra = 'id="inIdDepartamento" onChange="javascript:$.ddlCascada.obtLocalidades(\''.base_url().'\',\'divLocalidades\',\'inIdDepartamento\');"';
			$departamentos = array(''=>'Seleccione...') + $departamentos;
			$departamentos = form_dropdown('inIdDepartamento',$departamentos,'id="inIdDepartamento"',$extra);
		}	
		$vcRet  = '<label>Departamento:</label><span id="ddl_departamentos">'.$departamentos;
		$vcRet .= '</span>';
		echo $vcRet;
	}
	public function jsonDepartamentos($inIdProvincia = 0)
	{
        echo json_encode($this->localizacion_model->ObtDepartamentos($inIdProvincia,false));
	}
	
	public function ddlLocalidades($inIdDepartamento = 0)
	{
		if($inIdDepartamento!==false){
			$localidades = $this->localizacion_model->ObtLocalidadesPorDep($inIdDepartamento);
			if(!$localidades){
				$localidades = array(''=>'Sin Resultados');
			} else {
				$localidades = array(''=>'Seleccione...') + $localidades;
			}
			$localidades = form_dropdown('inIdLocalidad',$localidades,array($this->input->post('inIdLocalidad')),'id="inIdLocalidad"');
		}
		$vcRet  = '<label>Localidad:</label><span id="ddl_Localidades">'.$localidades;
		$vcRet .= '</span>';
		echo $vcRet;		
		
	}	
	public function jsonLocalidades($inIdDepartamento = 0)
	{
        echo json_encode($this->localizacion_model->ObtLocalidadesPorDep($inIdDepartamento,false));
		
	}	
}
?>
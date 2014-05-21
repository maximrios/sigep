<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dep extends Ext_AutController
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _init()
	{
		parent::_init();
		$this->load->library('Form_validation');
		$this->load->library('lib_ubicacion/lib_ubicacion');
		$this->load->library('Messages');
	}
	
	public function ingresar($viaAjax='')
	{
		$Usr = $this->lib_autenticacion->usuario();
		
		$dataView = array('vcUsuLogin'=> $this->lib_autenticacion->nombreUsuario(), 'ErroresSrv'=>'');
		
		$data['SiteInfo'] = $this->_siteInfo();
		
		if(!$this->lib_ubicacion->organismo())
		{
			$rsOrganismos = $this->lib_ubicacion->organismosDisponiblesArray($Usr['inIdUsuario']);
			
			$inOrganismos = sizeof($rsOrganismos);
			
			if($inOrganismos==1)
			{
				
				$this->lib_ubicacion->ingresar($rsOrganismos[0]['inIdOrganismo'],$this->lib_autenticacion->idUsuario());
				// Redirect to homepage
				redirect(base_url().'inicio', 'location');						
			}
			else
			{
				$val = $this->form_validation;
				
				$val->set_rules('selOrganismo', 'Dependencia', 'trim|required|xss_clean');
				
				if ($val->run() AND $this->lib_ubicacion->ingresar($val->set_value('selOrganismo'),$this->lib_autenticacion->idUsuario()))
				{
					// Redirect to homepage
					redirect(base_url().'inicio', 'location');
				}
				else
				{
					$dataView['vcMsjSrv'] = array(
						form_error('selOrganismo')
						, $this->lib_ubicacion->mensajeError()	
					);
					$data['SiteInfo'] = $this->_siteInfo();
					
					$dataView['vcMsjSrv'] = '';
					if(validation_errors()!='' && $this->input->post('vcSrcForm')=='login-access'){
						$dataView['vcMsjSrv'] = $this->messages->do_message(array('message'=>validation_errors(),'type'=>'alert'));
					}
					
					if($this->lib_ubicacion->mensajeError()!=''){
						$dataView['vcMsjSrv'] .= $this->messages->do_message(array('message'=>$this->lib_ubicacion->mensajeError(),'type'=>'alert'));
					}
					$dataView['vcRedirSrc'] = $this->input->post('vcRedirSrc');
					$dataView['rsOrganismos'] = $rsOrganismos;
					
					$data['vcAutContent'] = $this->load->view('lib_ubicacion/form-selecc-organismo',$dataView,true);	
				}
			}

		}
		else 
		{
			// verificar esta parte
			$this->lib_autenticacion->salir();
			$this->index();
		}
		
		
		if($viaAjax!='')
		{
			$this->error(404);
			return false;
		}
		
		if(!$viaAjax)
		{
			$this->load->view('masterpage-aut',$data);
		}
		else
		{
			echo $data['ContentInfo'];		
		}		
	}
	
}
?>
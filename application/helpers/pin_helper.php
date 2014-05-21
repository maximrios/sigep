<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * CodeIgniter Pin Helpers
 *
 * @package		base
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Marcelo Gutierrez
 */

/**
 * pin_do_control
 *
 * 
 * 
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('pin_do_control'))
{
	function pin_do_control()
	{
		$rule = pin_get_rules();
		$data = array(
              'name'        => $rule['field'],
              'id'          => $rule['field']
            );
		return form_password($data);
	}
}

/**
 * pin_set_rule
 *
 * Asigna la regla al control generado con pin_do_control
 * 
 * @access	public
 * @param	string
 * @param	string
 * @return	boolean if form_validation is not loaded returns FALSE.
 */
if ( ! function_exists('pin_set_rule'))
{
	function pin_set_rule($title = '')
	{
		$CI =& get_instance();
		$return = FALSE;
		
		if (FALSE !== ($object = $CI->load->is_loaded('form_validation')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}
			$rule = pin_get_rules($title);
			$CI->$object->set_rules($rule['field'], $rule['label'], $rule['rules']);
			$return = TRUE;
		}
		
		return $return;
	}
}
/**
 * pin_set_rule
 *
 * Asigna la regla al control generado con pin_do_control
 * 
 * @access	public
 * @param	string
 * @param	string
 * @return	boolean
 */
if ( ! function_exists('pin_validate'))
{
	/* */
	function pin_get_rules($title = 'PIN')
	{
		return array (
					'field' => 'pin'
					, 'label' => $title
					, 'rules' => 'trim|required|max_length[150]|xss_clean|callback_pin_validate'
				);
	}

}
/**
 * pin_set_rule
 *
 * Asigna la regla al control generado con pin_do_control
 * 
 * @access	public
 * @param	string
 * @param	string
 * @return	boolean
 */
if ( ! function_exists('pin_validate'))
{
	function pin_validate($str, $inIdUsr='')
	{
		$CI =& get_instance();
		
		if (FALSE !== ($object = $CI->load->is_loaded('form_validation'))) {
			if ( ! isset($CI->$object) OR ! is_object($CI->$object)) {
				return $return;
			}
			
			$CI->load->model($this->db->dbdriver.'/lib_autenticacion/pin_model');
			$inIdUsr = (empty($inIdUsr))? $CI->lib_autenticacion->idUsuario(): $inIdUsr;
			$ret = $CI->pin_model->validar($inIdUsr, $str, $CI->input->ip_address());
			
			if($ret===FALSE) {
				$CI->$object->set_message('pin_validate', 'El usuario no existe.');
				$return = FALSE;
			} else {
				if($ret['inRet'] >= 0) {
					$return = TRUE;
				} else {
					
					$CI->$object->set_message('pin_validate', $ret['vcMensaje']);
					return FALSE;
				}
			}
		}
		
		return $return;
	}
}
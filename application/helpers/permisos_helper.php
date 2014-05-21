<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------
/**
 * CodeIgniter Permisos Helpers
 *
 * @package		base
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Marcelo Gutierrez
 */

if ( ! function_exists('iniciar_buffer_permisos'))
{
    function iniciar_buffer_permisos() {
		if (FALSE === ($OBJ =& _get_permisos_object()))
		{
			return '';
		}
		ob_start();
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('filtrar_html_buffer'))
{
	function filtrar_html_buffer($boSendOutPut = TRUE)
	{
		if (FALSE === ($PERM_OBJ =& _get_permisos_object())) {
			return '';
		}
		
		if (FALSE === ($AUT_OBJ =& _get_autenticacion_object())) {
			return '';
		}
		
		$buffer = ob_get_contents();
		
		ob_end_clean();
		
		
		$buffer = $PERM_OBJ->filtrarPermisosPorRol($buffer, $AUT_OBJ->idRol());
		
		if($boSendOutPut == TRUE) {
			$CI = & get_instance();
			$CI->output->set_output($buffer);
		} else {
			return $buffer;
		}
	}
}
// ------------------------------------------------------------------------

/**
 * lib_permisos Object
 *
 * Determines what the form validation class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_permisos_object'))
{
	function &_get_permisos_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;
		
		if (FALSE !== ($object = $CI->load->is_loaded('lib_permisos')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}
			
			return $CI->$object;
		}
		
		return $return;
	}
}

/**
 * lib_autentication Object
 *
 * Determines what the form validation class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_autenticacion_object'))
{
	function &_get_autenticacion_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;
		
		if (FALSE !== ($object = $CI->load->is_loaded('lib_autenticacion')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}
			
			return $CI->$object;
		}
		
		return $return;
	}
}
//EOF permisos_helper.php
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
 * val_bool
 *
 * Devuelve un valor del tipo boolean a partir de un valor booleano valido conocido
 * 
 * @access	public
 * @param	mixed
 * @param	boolean
 * @param	boolean
 *
 */
if ( ! function_exists('val_bool'))
{
	function val_bool($val, $strict = false, $forceLowercase = true)
	{
		if(is_string($val) && $forceLowercase) {
			$val = strtolower($val);
		}
	    $out = null;
	    // 
	    if (in_array($in,array('f', 'false', 'False', 'FALSE', 'no', 'No', 'n', 'N', '0', 'off',
	                           'Off', 'OFF', false, 0, null), true)) {
	        $out = false;
	    } else if ($strict) {
	        // 
	        if (in_array($in,array('t', 'true', 'True', 'TRUE', 'yes', 'Yes', 'y', 'Y', '1',
	                               'on', 'On', 'ON', 'SI','Sí', 'si', 'sí', true, 1), true)) {
	            $out = true;
	        }
	    } else {
	        $out = ($in?true:false);
	    }
	    return $out;
  }
}

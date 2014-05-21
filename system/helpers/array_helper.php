<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('element'))
{
	function element($item, $array, $default = FALSE)
	{
		if ( ! isset($array[$item]) OR $array[$item] == "")
		{
			return $default;
		}

		return $array[$item];
	}
}

// ------------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('random_element'))
{
	function random_element($array)
	{
		if ( ! is_array($array))
		{
			return $array;
		}

		return $array[array_rand($array)];
	}
}

// --------------------------------------------------------------------

/**
 * Elements
 *
 * Returns only the array items specified.  Will return a default value if
 * it is not set.
 *
 * @access	public
 * @param	array
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('elements'))
{
	function elements($items, $array, $default = FALSE)
	{
		$return = array();
		
		if ( ! is_array($items))
		{
			$items = array($items);
		}
		
		foreach ($items as $item)
		{
			if (isset($array[$item]))
			{
				$return[$item] = $array[$item];
			}
			else
			{
				$return[$item] = $default;
			}
		}

		return $return;
	}
}

if ( ! function_exists('recortar_texto'))
{
	function recortar_texto($texto, $longitud = 180)
	{
		if((mb_strlen($texto) > $longitud)) {
    		$pos_espacios = mb_strpos($texto, ' ', $longitud) - 1;
    		if($pos_espacios > 0) {
        		$caracteres = count_chars(mb_substr($texto, 0, ($pos_espacios + 1)), 1);
        		/*echo $caracteres[ord('>')];
        		if ($caracteres[ord('<')] > $caracteres[ord('>')]) {
            		$pos_espacios = mb_strpos($texto, ">", $pos_espacios) - 1;
        		}*/
        		$texto = mb_substr($texto, 0, ($pos_espacios + 1)).'...';
    		}
    		if(preg_match_all("|(<([\w]+)[^>]*>)|", $texto, $buffer)) {
        		if(!empty($buffer[1])) {
            		preg_match_all("|</([a-zA-Z]+)>|", $texto, $buffer2);
            		if(count($buffer[2]) != count($buffer2[1])) {
                		$cierrotags = array_diff($buffer[2], $buffer2[1]);
                		$cierrotags = array_reverse($cierrotags);
                		foreach($cierrotags as $tag) {
		                    $texto .= '</'.$tag.'>';
                		}
            		}
        		}
    		}
		}
		return $texto;
	}
}


/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */
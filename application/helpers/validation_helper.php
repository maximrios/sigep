<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * classRegValidation
 *
 * Asigna la regla al control generado con pin_do_control
 * 
 * @access	public
 * @param	string
 * @param	string
 * @return	boolean if form_validation is not loaded returns FALSE.
 */
/**
 * Roles class
 *
 * @package base
 * @author  Diego G
 * @copyright 2012-01
 */
if ( ! function_exists('classRegValidation'))
{
  // PARAMETROS
  // @param $campo : el nombre del campo que se va a validar segun lo especificado en $this->_aReglas
  // @param $adicionalvalidate : un string para agregar una validacion adicional para JQuery que no este en CI
  // @param $adicional_class : un class adicional para agregar despues de validate[...]
  // @param $form_action : url del formulario en caso de que en un mismo controlador se valide diferentes cosas
  function classRegValidation($campo, $adicionalvalidate='', $adicional_class='', $form_action=''){
    $CI =& get_instance();
    $return = '';
    if (isset($CI->_aBuscar)) {
        $aReglas = array_merge($CI->_getReglas(), $CI->_aBuscar);
    } else {
        $aReglas = $CI->_getReglas();
    }
    if ($aReglas !== FALSE)
    {
      if ($form_action)
      {
		  if (array_key_exists($form_action, $aReglas))
	      {
	        $aReglas = $aReglas[$form_action];
	      }
		  else
		  {
		  	return $return;
		  }
	  }

      $field_rules=''; 
      for($i=0; $i<count($aReglas); $i++){
        if ($aReglas[$i]['field']==$campo) {
          $field_rules=$aReglas[$i]['rules'];
        }
      }
      if ($field_rules=='') {
        return $return;
      }

      // Calcular Equivalencias de form_validation y  jquery.validation
      $field_rules = classRegValidationEquivalencia($field_rules);

        if (strpos($field_rules, "required") !== false or
            strpos($adicionalvalidate, "required") !== false) {
            $validate_required = 'validate_required';
        } else {
            $validate_required = '';
        }

        if (($field_rules || $adicionalvalidate) || $adicional_class) {
            if (($field_rules || $adicionalvalidate) && $adicional_class) {
                $field_rules = 'validate['.$field_rules.(($field_rules && $adicionalvalidate)?',':'').$adicionalvalidate.']'.
                               ($adicional_class?' '.$adicional_class:'').
                               ($validate_required?' '.$validate_required:'');
            } else {
                if ($field_rules || $adicionalvalidate) {
                    $field_rules = 'validate['.$field_rules.(($field_rules && $adicionalvalidate)?',':'').$adicionalvalidate.']'.
                                   ($validate_required?' '.$validate_required:'');
                } else {
                    $field_rules = $adicional_class.''.
                                   ($validate_required?' '.$validate_required:'');
                }
            }
            $field_rules = ' class="'.$field_rules.'" ';
        }
        $return = $field_rules;
    }

    return $return;
  }
}

if ( ! function_exists('sortTrimFirst'))
{
  function sortTrimFirst($a, $b)
  {
    if ($a == 'trim') {
      return 0;
    } else {
      return 1;
    }
  }
}

if ( ! function_exists('classRegValidationEquivalencia'))
{
  function classRegValidationEquivalencia($Regla){
    // Reglas de Equivalencia entre CI y JQuery
    // Ordenar el array de mayor longitud a menor longitud de los strings claves
    // el mas largo es is_natural_no_zero, el mas corto es trim
    // Dejar siempre primero "integer" para que no reemplaze lo que ya fue reemplazado
    $arrReglasNombre=array(
    //CodeIgniter                    => JQuery
      'integer'                      => 'custom[integer]',     // DEJAR SIEMPRE PRIMERO!! **
      'callback_validate_date_check' => 'custom[date]', // EL STRING KEY MAS LARGO SEGUNDO **
      'callback_validate_hora_check' => 'custom[hour]',      
      'is_natural_no_zero'           => 'naturalNoZeroNumber',
      'alpha_numeric'                => 'custom[onlyLetterNumber]',
      'greater_than'                 => 'min',
      'exact_length'                 => 'exactLength',
      'valid_emails'                 => 'custom[variosEmails]',
      'valid_email'                  => 'custom[email]',
      'max_length'                   => 'maxSize',
      'min_length'                   => 'minSize',
      'is_natural'                   => 'naturalNumber',
      'alpa_dash'                    => 'custom[onlyAlphaDash]',
      'less_than'                    => 'max',
      'required'                     => 'required',
      'valid_ip'                     => 'custom[ipv4]',
      'numeric'                      => 'custom[number]',
      'decimal'                      => 'decNumber',
      'matches'                      => 'equals',
      'alpha'                        => 'custom[onlyLetterSp]',
      'trim'                         => 'goTrim' // EL STRING KEY MAS CORTO AL ULTIMO **
    );

    // Reemplazar Nombres segun el array de Reglas
    $arrExpresion=explode("|", $Regla);
    $arrBufferNombresRepetidos=array();
    $Regla=array();
    // Ordernar siempre Trim Primero
    usort($arrExpresion, "sortTrimFirst");
    foreach($arrExpresion as $itemExpresion){
      if (strpos($itemExpresion, "[") !== false){
        $arr = explode("[", str_replace("]", "", $itemExpresion));
        $Nombre = $arr[0];
        $Valor = $arr[1];
      } else {
        $Nombre = $itemExpresion;
        $Valor = '';
      }
      
      if (in_array($Nombre, array_keys($arrReglasNombre))) {
        $Nombre = str_replace(array_keys($arrReglasNombre), $arrReglasNombre, $Nombre);
        if (!in_array($Nombre, $arrBufferNombresRepetidos)) {
          $arrBufferNombresRepetidos[] = $Nombre;
          $Regla[] = $Nombre.($Valor?'['.$Valor.']':'');
        }
      }
    }
    $Regla = implode(",",$Regla);
    
    return $Regla;
  }
}
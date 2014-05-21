<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author marcelo encina
 * @copyright 2011
 * @category Helper
 */

/**
 * HacerListaDesplegable()
 * 
 * @param mixed $aReg: array de registros
 * @param mixed $nameCombo: nombre del tag select
 * @param mixed $cuerpo: clase y javascript necesarios
 * @param mixed $valueOption: valor que va a tomar el select cuando se elija algo
 * @param mixed $valorMostrar: valor a mostrar en el select
 * @param string $primerValor: si el primer valor del combo es vacio muestra los restantes, en caso contrario muestra el primer valor
 * @param string $valorDefault: valor que mostrara por defecto
 * @return
 */
function HacerListaDesplegable($aReg,$nameCombo,$cuerpo,$valueOption,$valorMostrar,$primerValor='',$valorDefault='')
{
    if($primerValor != '')
    { $pv = "<option value=''>$primerValor</option>"; }
    else
    { $pv = $primerValor; }
    
    $html = '<select name="'.$nameCombo.'" '.$cuerpo.'>';
        $html.= $pv;
        foreach ($aReg as $key => $row)
        { 
            if($valorDefault == $row[$valueOption])                
            { $html.= "<option value='$row[$valueOption]' selected>$row[$valorMostrar]</option>"; }
            else
            { $html.= "<option value='$row[$valueOption]'>$row[$valorMostrar]</option>"; } 
        }
    $html.= '</select>';        
    return $html;
}
?>
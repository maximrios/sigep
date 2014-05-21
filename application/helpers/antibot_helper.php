<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------
/**
 * CodeIgniter Pin Helpers
 *
 * @package		base
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Diego Garcia
 */

if ( ! function_exists('microtime_string'))
{
    function microtime_string() {
        list($useg, $seg) = explode(" ", microtime());
        $rtrn = ((float)$useg + (float)$seg);
        $rtrn = str_replace(" ", "", $rtrn);
        $rtrn = trim($rtrn * 100);
        $rtrn = round($rtrn);
        return $rtrn;
    }
}

if ( ! function_exists('serializedata'))
{
	function serializedata($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				if (is_string($val))
				{
					$data[$key] = str_replace('\\', '{{slash}}', $val);
				}
			}
		}
		else
		{
			if (is_string($data))
			{
				$data = str_replace('\\', '{{slash}}', $data);
			}
		}

		return serialize($data);
	}
}	


if ( ! function_exists('antibotHacerLlave'))
{
    function antibotHacerLlave()
    {
        $limiteDeVentanas = 50;

        $CI =& get_instance();
        $mySESSION = $CI->session->userdata('antibotLlave');

        $vcFormName = 'frm' . trim(microtime_string()) . 'frm' . substr(md5(date("is")),0,14);
        $mySESSION[] = $vcFormName;
        if (count($mySESSION) > $limiteDeVentanas) {
            unset($mySESSION[min(array_keys($mySESSION))]);
        }

        $mySESSION = $CI->session->set_userdata(array('antibotLlave'=>$mySESSION));
        return $vcFormName;
    }
}

if ( ! function_exists('antibotCompararLlave'))
{
    function antibotCompararLlave($vcForm)
    {
        $CI =& get_instance();

        $mySESSION = $CI->session->userdata('antibotLlave');
        if (!isset($mySESSION) or !$mySESSION) {
            $mySESSION = array();
        }

        if (substr($vcForm,0,3)=='frm' and strlen($vcForm)>7) {
            $tiempoIda = explode("frm",$vcForm);
            $tiempoTranscurrido = microtime_string() - $tiempoIda[1];
        } else {
            $tiempoTranscurrido = -1;
        }

        // cerrar sesión si es que no existe el post de vcForm
        if (!isset($vcForm)) {
            antibotRedirectLogout();

        // cerrar sesión si es que no posee algun valor
        }elseif(!$vcForm) {
            antibotRedirectLogout();

        // cerrar sesión si es que se confirma el formulario menos de 1 segundo luego de ser cargado
        }elseif($tiempoTranscurrido<round(config_item('antibot_time_min')/10)){
            antibotRedirectLogout();

        // cerrar sesión si es que no lo encuentra en el array de permisos de formularios
        }elseif(!in_array($vcForm,$mySESSION)){
            antibotRedirectLogout();

        // sacar del array el permiso utilizado
        }else{
            if (count($mySESSION)>1) {
                // si hay mas de 1 elemento en el array de sesión
                $arrKeys = array_keys($mySESSION);
                foreach($arrKeys as $itemKey) {
                    if ($vcForm==$mySESSION[$itemKey]) {
                        unset($mySESSION[$itemKey]);
                    }
                }
            } else {
                // si hay solo 1 elemento en el array de sesión
                $mySESSION=array();
            }
        }

        $mySESSION = $CI->session->set_userdata(array('antibotLlave'=>$mySESSION));
    }
}

if ( ! function_exists('antibotRedirectLogout'))
{
    function antibotRedirectLogout()
    {
        /*$CI =& get_instance();
        
        $CI->lib_autenticacion->unsetSession();
        
        $CI->session->set_userdata(array('message'=>config_item('antibot_logout_alert')));

        $baseurl = base_url();
        $autlogin = config_item('lib_autenticacion_login_uri');*/

        /*echo <<<EOT
<script language="javascript" type="text/javascript">
<!--
top.location = '{$baseurl}{$autlogin}';
// -->
</script>
EOT;
        die();*/
    }
}


if ( ! function_exists('antibotBorrarLlaves'))
{
    function antibotBorrarLlaves()
    {
        $CI =& get_instance();
        $CI->session->unset_userdata(array('antibotLlave'=>''));
    }
}

//EOF antibot_helper.php
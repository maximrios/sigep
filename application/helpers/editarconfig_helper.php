<?php
/**
 * putInput
 *
 * @access	public
 * @return	HTML
 */
if ( ! function_exists('getInputConfig'))
{
    function getInputConfig($vClave, $vValor) {
        $checked = ' checked="checked"';
        switch (gettype($vValor)) {
            case "boolean": {
                $chk1= $vValor?$checked:'';
                $chk2=!$vValor?$checked:'';
                echo <<<EOT
<div style="width: 276px; float:left;">
    <label for="{$vClave}_t" style="float:left;margin-right:14px;margin-top:4px;">
        <input type="radio" name="{$vClave}" id="{$vClave}_t" value="TRUE"{$chk1}/> Si</label>
    <label for="{$vClave}_f" style="float:left;margin-right:14px;margin-top:4px;">
        <input type="radio" name="{$vClave}" id="{$vClave}_f" value="FALSE"{$chk2}/> No</label>
</div>
EOT;
            }; break;
            case "integer": {
                echo '<input type="text" name="'.$vClave.'" id="'.$vClave.'" value="'.$vValor.'" style="width: 250px;"/>';
            }; break;
            default: {
                echo '<input type="text" name="'.$vClave.'" id="'.$vClave.'" value="'.$vValor.'" style="width: 250px;"/>';
            }; break;
        }
    }
}

if ( ! function_exists('putInputConfig'))
{
    function putInputConfig($vPOST, $vValor) {
        switch (gettype($vValor)) {
            case "boolean": {
                return ($vPOST=='TRUE'?"TRUE":"FALSE");
            }; break;
            case "integer": {
                return round($vPOST);
            }; break;
            default: {
                return "'".str_replace(array('"',"'"), array("&quot;","\'"), $vPOST)."'";
            }; break;
        }
    }
}
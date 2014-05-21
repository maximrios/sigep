<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DropDownCascade Class
 *
 * @package		base
 * @subpackage	Libraries
 * @category	DropDownCascade
 * @author		Diego G
 * @copyright	2012-02
 * @link		
 */
class DropDownCascade {
	
	protected $_isFirstExecute = true;
	
    function __construct($config = array())
    {
    	$this->_CI = & get_instance();
    }

    public function dropdowncascade($aDropDown=array())
    {
        $baseurl = base_url();
        $aSelect = array();
        $isFirst=true;
        $jQuery = '';
        $jFunction = '';
        if ($this->_isFirstExecute)
            $jFunction =
<<<EOT
if(typeof window.successJSONddc != 'function') {
    function successJSONddc(aData, dbId, valSelectBefore, dbName, txtSelected, txtSeleccione){
        var options;
        if (txtSeleccione)
            options = '<option value="">--' + txtSeleccione + '--</option>';
        else
            options = '<option value="">--Seleccionar/Elegir--</option>';
        for (var i = 0; i < aData.length; i++)
            options += '<option value="' + aData[i][dbId] + '">' + aData[i][dbName] + '</option>';
        $('#' + dbId).html(options);
        if (txtSelected)
            $('#' + dbId).val(txtSelected).change();
        if (valSelectBefore)
            $('#' + dbId + ', label[for=' + dbId + ']').show();
    };
};

EOT;

        for($i=0;$i<count($aDropDown);$i++){
            if ($isFirst){
                $jQuery.=
<<<EOT
    $.getJSON('{$baseurl}{$aDropDown[0]['modelo']}', function(aData){
        successJSONddc(aData, '{$aDropDown[0]['dbId']}', '', '{$aDropDown[0]['dbName']}', '{$aDropDown[0]['selected']}', '{$aDropDown[0]['txtSeleccione']}');
    })            

EOT;
            }
            $j=$i+1;
            if (@$aDropDown[$j]['dbId']) {
                $jQuery.=
<<<EOT
    $('#{$aDropDown[$i]['dbId']}').change(function(){

EOT;
                for($k=$i+1;$k<count($aDropDown);$k++){
                $jQuery.=
<<<EOT
            $('#{$aDropDown[$k]['dbId']}, label[for={$aDropDown[$k]['dbId']}]').val('').hide();

EOT;
                }
                $jQuery.=
<<<EOT
        $.getJSON('{$baseurl}{$aDropDown[$j]['modelo']}/' + $('#{$aDropDown[$i]['dbId']}').val(), function(aData){
            successJSONddc(aData, '{$aDropDown[$j]['dbId']}', $('#{$aDropDown[$i]['dbId']}').val(), '{$aDropDown[$j]['dbName']}', '{$aDropDown[$j]['selected']}', '{$aDropDown[$j]['txtSeleccione']}');
        })            
    });

EOT;
            }
            if (!$isFirst){
                $jQuery.=
<<<EOT
    $('#{$aDropDown[$i]['dbId']}, label[for={$aDropDown[$i]['dbId']}]').hide();

EOT;
            }
            $aSelect[$aDropDown[$i]['dbId']] = form_dropdown(
                                                $aDropDown[$i]['dbId'],
                                                array(''=>'Seleccione...'),
                                                $aDropDown[$i]['selected'],
                                                'id="'.$aDropDown[$i]['dbId'].'"'.$aDropDown[$i]['html']
                                             );
            $this->_isFirstExecute=false;
            $isFirst=false;
        }
        $aSelect[$aDropDown[count($aDropDown)-1]['dbId']].=
<<<EOT
<script language="javascript" type="text/javascript">
<!--
{$jFunction}
$(document).ready(function(){
{$jQuery}});
//-->
</script>

EOT;
        $_isFirstExecute = false;
        return $aSelect;
    }

}
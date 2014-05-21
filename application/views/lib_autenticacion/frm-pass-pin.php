<?php
/**
 * 
 *
 * @author Artigas Daniel
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Claves';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Modificar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
    	<fieldset>

    		<div class="fila despliegueLateral">
                <label for="chkPas">
                    <input name="chkPas" type="checkbox" id="chkPas" />
                    Cambiar Cotraseña
                </label>
                <div class="clearfloat"></div>
    		</div>
			<div id="frmPas" class="fila despliegueLateral">
        		<div class="fila">
                    <label for="hideButtonPas">
                        <input type="radio" class="radCambio" name="radPas" id="hideButtonPas" value="pass_auto" checked="checked"/>
                        Generar Contraseña automáticamente
                    </label>
                </div>
                <div class="clearfloat"></div>
        		<div class="fila">
            		<label for="showButtonPas">
                        <input type="radio" class="radCambio" name="radPas" id="showButtonPas" value="pass_manual" />
                        Definir Contraseña manualmente
                    </label>
                </div>
                <div class="clearfloat"></div>
    		</div>
    		<div id="avisoPas" class="fila despliegueLateral">
    		   	<div class="fila">
    		        <label for="vcUsuPassword">Contraseñia:</label>
    		       	<input name="vcUsuPassword" type="password" id="vcUsuPassword" <?=classRegValidation('vcUsuPassword')?>/>
    		    </div>
	            <div class="clearfloat"></div>
    		   	<div class="fila">
    		        <label for="vcUsuPassword2">Repetir Contraseña:</label>
    		       	<input name="vcUsuPassword2" type="password" id="vcUsuPassword2" <?=classRegValidation('vcUsuPassword2')?> />
    		    </div>
    	        <div class="clearfloat">&nbsp;</div>
    		</div>
            <div class="clearfloat"></div>
			
			<?php if (config_item('asunto_pin_enabled')): ?>
			<div class="fila despliegueLateral">
                <label for="chkPin">
                    <input name="chkPin" type="checkbox" id="chkPin" />
                    Cambiar Pin
                </label>
                <div class="clearfloat"></div>
    		</div>
			<div id="frmPin" class="fila despliegueLateral">
        		<div class="fila">
                    <label for="hideButtonPin">
                        <input type="radio" class="radCambio" name="radPin" id="hideButtonPin" value="pin_auto" checked="checked"/>
                        Generar Pin automáticamente
                    </label>
                </div>
                <div class="clearfloat"></div>
        		<div class="fila">
            		<label for="showButtonPin">
                        <input type="radio" class="radCambio" name="radPin" id="showButtonPin" value="pin_manual" />
                        Definir Pin manualmente
                    </label>
                </div>
                <div class="clearfloat"></div>
    		</div>
			<div id="avisoPin" class="fila despliegueLateral">
    		   	<div class="fila">
    		        <label for="vcUsuPIN">Pin:</label>
    		       	<input name="vcUsuPIN" type="password" maxlength="4" id="vcUsuPIN" <?=classRegValidation('vcUsuPIN')?>/>
    		    </div>
	            <div class="clearfloat"></div>
    		   	<div class="fila">
    		        <label for="vcUsuPIN2">Repetir Pin:</label>
    		       	<input name="vcUsuPIN2" type="password" maxlength="4" id="vcUsuPIN2" <?=classRegValidation('vcUsuPIN2')?>/>
    		    </div>
                <div class="clearfloat"></div>
    		</div>
            <div class="clearfloat"></div>
			<?php endif; ?>

    		<div id="divChkEmail" class="fila despliegueLateral">
                <label for="chkEmail">
                    <input type="checkbox" id="chkEmail" name="chkEmail" checked="checked" />
                    Enviar e-mail de notificación al Usuario
                </label>
                <div class="clearfloat"></div>
    		</div>
            <div class="clearfloat"></div>

		</fieldset>
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdUsuario'])?' btn-reset':''); ?>" value="Guardar"/>
	    	<a href="autenticacion/usuarios/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdUsuario" name="inIdUsuario" value="<?= $Reg['inIdUsuario']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>

	<script type="text/javascript">
	$('#avisoPas').hide();
	$('#avisoPin').hide();
	$('#frmPas').hide();
	$('#frmPin').hide();
	$('#divChkEmail').hide();
	$('#chkEmail').attr('disabled','disabled');
	
	function doDivChkEmail(){
		if ($('#chkPas').attr('checked') || $('#chkPin').attr('checked')){
			$('#divChkEmail').show('fast');
		} else {
			$('#divChkEmail').hide('fast');
		}
	}
	
	$(document).ready(function(){
        $('#<?= $vcFormName; ?> input:first').focus();

		$('#chkPas').click(function(){
			if ($(this).attr('checked')){
				$('#frmPas').show('fast');
                $('#chkEmail').attr('disabled','disabled');
			} else {
				$('#frmPas').hide('fast');
				$('#hideButtonPas').click();
			}
			doDivChkEmail();
	  	});
		$('#chkPin').click(function(){
			if ($(this).attr('checked')){
				$('#frmPin').show('fast');
                $('#chkEmail').attr('disabled','disabled');
			} else {
				$('#frmPin').hide('fast');
				$('#hideButtonPin').click();
			}
			doDivChkEmail();
	  	});
		$('#hideButtonPas').click(function(){
			$('#avisoPas').hide('fast');
			$('#avisoPas input[type=password]').val('');
			$('#<?= $vcFormName; ?>').validationEngine('hide');
	  	});
		$('#showButtonPas').click(function(){
			$('#avisoPas').show('fast');
	  	});
		$('#hideButtonPin').click(function(){
			$('#avisoPin').hide('fast');
			$('#avisoPin input[type=password]').val('');
			$('#<?= $vcFormName; ?>').validationEngine('hide');
	  	});
		$('#showButtonPin').click(function(){
			$('#avisoPin').show('fast');
	  	});	
	
		$('.radCambio').click(function(){
			if( (!$('#chkPas').attr('checked') || $('#showButtonPas').attr('checked'))
				&&
				(!$('#chkPin').attr('checked') || $('#showButtonPin').attr('checked'))) {
				$('#chkEmail').attr('disabled',false);
			} else {
				$('#chkEmail').attr('disabled','disabled');
				$('#chkEmail').attr('checked','checked');
			}
		});
	  	
	  		
	});
	</script>
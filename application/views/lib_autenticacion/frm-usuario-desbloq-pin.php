<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base30
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Desbloqueo de PIN (N&uacute;mero de Identificaci&oacute;n Personal)';
$vcAccion = (!empty($vcAccion))? $vcAccion: '';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<section class="box-normal-100">
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-edit">
		<fieldset>
		    <div class="fila">
		        <label for="vcPIN">Ingrese su PIN:</label>
		       	<input type="password" name="vcPIN" id="vcPIN" <?=classRegValidation('vcPIN','','',$vcFrmAction)?> style="width: 250px;"/>
		    </div>
		    <div class="clearfloat">&nbsp;</div>
		    <div class="fila">
		        <label for="vcPass">Ingrese su contraseña:</label>
		       	<input type="password" name="vcPass" id="vcPass" <?=classRegValidation('vcPass','','',$vcFrmAction)?> style="width: 250px;"/>
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		</fieldset>
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Guardar"/>
	    	<a href="#" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdUsuario" name="inIdUsuario" value="<?= $Reg['inIdUsuario']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
</section>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();
			onClickCancelar();
            $('#<?= $vcFormName; ?>').viaAjax({
            	'prepVars': function() {
            		$('input[type=password]').each(function(){
            			$(this).val($.md5($(this).val()));
            		});
            	}
            	, 'success': function() { }
            });
		});
	</script>
<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Novedad por Roles';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo mensajes-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<fieldset>
			<div class="fila">
		        <label for="inIdRol">Nombre del Rol</label>
		       	<?=form_dropdown('inIdRol', $rsRoles, $Reg['inIdRol'], 'id="inIdRol"'.classRegValidation('inIdRol'));?>
		    </div>
		    <div class="clearfloat">&nbsp;</div>
			<div class="fila">
		        <label for="tsFechaInicio">Fecha de Publicaci&oacute;n:</label>
		       	<input type="text" name="tsFechaInicio" id="tsFechaInicio" value="<?= $Reg['tsFechaInicio']; ?>"<?=classRegValidation('tsFechaInicio')?> placeholder="dd/mm/aaaa"/>
		    </div>
		    <div class="fila">
		        <label for="tsFechaCaducidad">Fecha de Caducidad:</label>
		       	<input type="text" name="tsFechaCaducidad" id="tsFechaCaducidad" value="<?= $Reg['tsFechaCaducidad']; ?>"<?=classRegValidation('tsFechaCaducidad')?> placeholder="dd/mm/aaaa"/>
		    </div>
		    <div class="clearfloat">&nbsp;</div>
		    <div class="fila">
		        <label for="vcNovTitulo">T&iacute;tulo:</label>
		       	<textarea name="vcNovTitulo" id="vcNovTitulo" <?=classRegValidation('vcNovTitulo')?> style="width: 450px; height: 18px; resize: none;"><?= $Reg['vcNovTitulo']; ?></textarea>
		    </div>
		    <div class="clearfloat">&nbsp;</div>  	
		   	<div class="fila">
		        <label for="vcNovResumen">Resúmen:</label>
		        <textarea name="vcNovResumen" id="vcNovResumen"<?=classRegValidation('vcNovResumen')?> style="width: 450px; height: 150px; resize: none;"><?= $Reg['vcNovResumen']; ?></textarea>
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		   	<div class="fila">
		        <label for="vcNovDescripcion">Contenido:</label>
		        <textarea name="vcNovDescripcion" id="vcNovDescripcion"<?=classRegValidation('vcNovDescripcion')?> style="width: 450px; height: 150px; resize: none;"><?= $Reg['vcNovDescripcion']; ?></textarea>
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		</fieldset>
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdNovedadesRol'])?' btn-reset':''); ?>" value="Guardar"/>
	    	<a href="autenticacion/novedadesrol/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdNovedadesRol" name="inIdNovedadesRol" value="<?= $Reg['inIdNovedadesRol']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();
		});
	</script>
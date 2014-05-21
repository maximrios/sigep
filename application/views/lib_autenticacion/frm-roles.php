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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Rol';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<fieldset>
		    <div class="fila">
		        <label for="vcRolNombre">Nombre del Rol</label>
		       	<input type="text" name="vcRolNombre" id="vcRolNombre" value="<?= $Reg['vcRolNombre']; ?>"<?=classRegValidation('vcRolNombre')?> style="width: 250px;"/>
		    </div>
		    <div class="fila">
		        <label for="vcRolCod">C&oacute;digo:</label>
		       	<input type="text" name="vcRolCod" id="vcRolCod" value="<?= $Reg['vcRolCod']; ?>"<?=classRegValidation('vcRolCod')?>/>
		    </div>    	
		   	<div class="fila">
		        <label for="inRolRango">Rango / Orden</label>
		       	<input type="text" name="inRolRango" id="inRolRango" value="<?= $Reg['inRolRango']; ?>"<?=classRegValidation('inRolRango')?>/>
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		</fieldset>
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdRol'])?' btn-reset':''); ?>" value="Guardar"/>
	    	<a href="autenticacion/roles/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdRol" name="inIdRol" value="<?= $Reg['inIdRol']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();

		});
	</script>
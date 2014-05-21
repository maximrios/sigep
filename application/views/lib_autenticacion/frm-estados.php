<?php
/**
 * @author Artigas Daniel
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Estados';
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
		        <label for="vcSegEstDesc">Nombre del estado</label>
		       	<input type="text" name="vcSegEstDesc" id="vcSegEstDesc" value="<?= $Reg['vcSegEstDesc']; ?>"<?=classRegValidation('vcSegEstDesc')?> style="width: 250px;"/>
		    </div>
		    <div class="fila">
		        <label for="vcSegEstCod">C&oacute;digo:</label>
		       	<input type="text" name="vcSegEstCod" id="vcSegEstCod" value="<?= $Reg['vcSegEstCod']; ?>"<?=classRegValidation('vcSegEstCod')?>/>
		    </div>    	
		   	<div class="fila">
		        <label for="boSegEstHabilitado">Habilitado</label>
                <div class="radioFloat">
                    <input type="radio" id="boSegEstHabilitadoSi" name="boSegEstHabilitado" value="1" style="margin: 10px;" <?=($Reg['boSegEstHabilitado'] != 0 ? 'checked="checked"' : '' )?>/>
                    <label for="boSegEstHabilitadoSi">SI</label>
    
                    <input type="radio" id="boSegEstHabilitadoNo" name="boSegEstHabilitado" value="0" style="margin: 10px;" <?=($Reg['boSegEstHabilitado'] == 0 ? 'checked="checked"' : '' )?>/>
                    <label for="boSegEstHabilitadoNo">No</label>
                    <div class="clearfloat"></div>
                </div>                           		       	
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		</fieldset> 
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdSegEstado'])?' btn-reset':''); ?>" value="Guardar"/>
	    	<a href="autenticacion/estados/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdSegEstado" name="inIdSegEstado" value="<?= $Reg['inIdSegEstado']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();
		});
	</script>
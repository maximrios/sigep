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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Estado';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms readonly">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<fieldset>
		    <div class="fila">
		        <label for="vcSegEstDesc">Nombre del Estado</label>
                <input type="text" name="vcSegEstDesc" id="vcSegEstDesc" value="<?= $Reg['vcSegEstDesc']; ?>" style="width: 350px;"/>
		    </div>
		    <div class="fila">
		        <label for="vcSegEstCod">C&oacute;digo:</label>
                <input type="text" name="vcSegEstCod" id="vcSegEstCod" value="<?= $Reg['vcSegEstCod']; ?>"/>
		    </div>    	
		   	<div class="fila">
		        <label for="boSegEstHabilitado">Habilitado</label>
                <input type="text" name="boSegEstHabilitado" id="boSegEstHabilitado" value="<?=((bool)$Reg['boSegEstHabilitado']==true?"Si":"No")?>"/>
		    </div>           
	        <div class="clearfloat">&nbsp;</div>
		</fieldset> 
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Eliminar" name="Eliminar"/>
	    	<a href="autenticacion/estados/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdSegEstado" name="inIdSegEstado" value="<?= $Reg['inIdSegEstado']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>

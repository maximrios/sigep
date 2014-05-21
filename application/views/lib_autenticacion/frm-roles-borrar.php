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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Rol';
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
		        <label for="vcRolNombre">Nombre del Rol</label>
		       	<input type="text" name="vcRolNombre" id="vcRolNombre" value="<?= $Reg['vcRolNombre']; ?>" style="width: 250px;"/>
		    </div>
		    <div class="fila">
		        <label for="vcRolCod">C&oacute;digo:</label>
		       	<input type="text" name="vcRolCod" id="vcRolCod" value="<?= $Reg['vcRolCod']; ?>"/>
		    </div>    	
		   	<div class="fila">
		        <label for="inRolRango">Rango / Orden</label>
		       	<input type="text" name="inRolRango" id="inRolRango" value="<?= $Reg['inRolRango']; ?>"/>
		    </div>           
	        <div class="clearfloat">&nbsp;</div>
		</fieldset> 
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Eliminar" name="Eliminar"/>
	    	<a href="autenticacion/roles/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdRol" name="inIdRol" value="<?= $Reg['inIdRol']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>

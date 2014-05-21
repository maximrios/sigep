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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Usuario';
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

				<div class="fila"><label>N&uacute;mero de Documento</label>
					<input type="text" name="vcUsuLogin" style="width: 250px;" value="<?=$Ndocumento; ?>" id="vcUsuLogin"/>
				</div> 
		    	<div class="fila"><label>Persona</label>
		    	<input type="text" name="vcPerNombre" id="vcPerNombre" value="<?=$Reg['vcPerNombre']?>" style=" width: 200px;"/>
				</div>
                
                <div class="clearfloat"></div>
				
		    	<div class="fila"><label>Estado</label>
	 		   		<input type="text" name="vcSegEstDesc" id="vcSegEstDesc" value=<?=$Reg['vcSegEstDesc']?> />					 
				</div>

		      <div class="fila"><label>Rol</label>
	 		   		<input type="text" name="vcRolNombre" id="vcRolNombre" value="<?=$Reg['vcRolNombre'];?>" style="width:320px;" />
				</div>

		        <div class="fila"><label for="vcUsuEmail">Email</label>
		           <input type="text" name="vcUsuEmail"  value="<?=$Reg['vcUsuEmail'];?>" id="vcUsuEmail" style="width: 250px;" />
				</div>
	    <div class="clearfloat">&nbsp;</div>
		</fieldset> 
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Eliminar" name="Eliminar"/>
	    	<a href="autenticacion/usuarios/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdUsuario" name="inIdUsuario" value="<?= $Reg['inIdUsuario']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
	
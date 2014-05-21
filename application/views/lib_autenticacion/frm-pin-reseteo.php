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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Pin';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Reseteo';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?=$vcFrmAction?>" method="post">
		<fieldset>
			<input type="hidden" name="inIdUsuario" id="inIdUsuario" value="<?if(isset($usuario['inIdUsuario'])){echo $usuario['inIdUsuario'];}?>"/>
			<div class="fila">
                <label for="vcPerNombre">Persona</label>
				<?php foreach($personas as $fila){ ?>
				<div class="readonly">	
					<input id="vcPerNombre" type="text" value="<?=$fila['vcPerNombre']?>" style="width: 300px;" />
				<?}?>
				</div>
			</div>
			<!-- 
			<div class="fila">
                <label for="inIdDNI">N&uacute;mero de Documento</label>
				<input id="inIdDNI" type="text" style="width: 250px;" value="<?=$Ndocumento; ?>" readonly="readonly" disabled="disabled"/>
			</div>
			-->
			<div class="fila">
                <label for="vcUsuEmail">Email</label>
                <div class="readonly">
		       		<input type="text" name="vcUsuEmail"  value="<?=$Reg['vcUsuEmail'];?>" id="vcUsuEmail" style="width: 250px;" readonly="readonly" disabled="disabled" />
		       	</div>
			</div>
			
            <div class="clearfloat"></div>
	</fieldset>
    <br />
	<div class="buttons">
		<input type="submit" class="button guardar btn-accion" value="Resetear Pin"/>
		<a href="autenticacion/usuarios/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
    </div>
	</form> 
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();
		});
	</script>
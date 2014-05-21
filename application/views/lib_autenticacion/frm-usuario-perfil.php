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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Perfil';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Editar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<section class="box-normal-100">
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post">
		<fieldset>
		    <div class="fila">
		        <label for="vcPerNombre">Apellido y Nombres del Usuario:</label>
		       	<input type="text" name="vcPerNombre" id="vcPerNombre" value="<?= $Reg['vcPerNombre']; ?>"<?=classRegValidation('vcPerNombre','','',$vcFrmAction)?> style="width: 250px;"/>
		    </div>
		    <div class="fila">
		        <label for="vcUsuEmail">E-Mail:</label>
		       	<input type="text" name="vcUsuEmail" id="vcUsuEmail" value="<?= $Reg['vcUsuEmail']; ?>"<?=classRegValidation('vcUsuEmail','','',$vcFrmAction)?>/>
		    </div>    	
		   	<div class="fila">
		        <label for="dtPerFechaNac">Fecha de Nacimiento:</label>
		       	<input type="text" name="dtPerFechaNac" id="dtPerFechaNac" value="<?= $Reg['dtPerFechaNac']; ?>"<?=classRegValidation('dtPerFechaNac','custom[date]','',$vcFrmAction)?>/>
		    </div>
	        <div class="clearfloat">&nbsp;</div>
		</fieldset>
		<br/>
		<div class="buttons">
			<input id="btnGuardar" name="btnGuardar" type="submit" class="button guardar" value="Guardar"/>
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
			
            $("#<?= $vcFormName; ?>").validationEngine();
            $('#<?= $vcFormName; ?> input[type=text]').each(function(){
              if ($(this).attr('class')) {
                if ($(this).attr('class').indexOf('required') != -1) {
                  $(this).addClass("validate_required");
                }
              }
            });
		});
	</script>
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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Contrase&ntilde;a';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Modificar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<section class="box-normal-100">
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="form_cambiar_password" name="form_cambiar_password" action="<?= $vcFrmAction; ?>" method="post" target="contenido-edit">
		    <li>
		        <label for="vcPass">Ingrese su contraseña anterior:</label>
		       	<input type="password" name="passwordUsuario" id="passwordUsuario"/>
		    </li>
		    <li>
		        <label for="vcPassNuevo">Su nueva contraseña:</label>
		       	<input type="password" name="passwordNuevo" id="passwordNuevo"/>
		    </li>
		   	<li>
		        <label for="vcPassNuevo2">Repita su nueva contraseña:</label>
		       	<input type="password" name="repasswordNuevo"/>
		    </li>
		<br/>
		<button id="cambiarPassword" class="btn btn-primary"><i class="icon-refresh icon-white"></i>&nbsp;&nbsp;Modificar contraseña</button>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $Reg['idUsuario']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
</section>
<script>
	$('#cambiarPassword').on('click', cambiarPassword);
	function cambiarPassword(){
		$form = $('#form_cambiar_password');
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $form.serialize(),
			success: function() {
				alert('Se actualizaron los datos correctamente');
			}
		})

		setTimeout(function() { 
			$.fancybox.close();
		}, 2000);
		return false;
	}
</script>
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
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Usuarios';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Buscar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion); ?></h2>
	<?php if (isset($error)){ echo $error;}?>
	<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="autenticacion/usuarios/buscarPersona" method="post" target="contenido-abm">
		<fieldset>
		    <div class="fila">
		        <label >Numero de documento</label>
		       	<input type="text" name="validar_documento" <?=classRegValidation('validar_documento','','inputPegadosIzq')?> id="validar_documento" style="width: 140px;"/>
                <input  type="submit" class="button buscar btn-accion inputPegadosDer" value="Buscar"/>
    		</div>
		</fieldset>
		<br/>
        <div class="buttons">
            <a href="autenticacion/usuarios/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
        </div>
	</form> 
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();
		});
	</script>
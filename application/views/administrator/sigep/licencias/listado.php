<?php
/**
 * @author Rios Maximiliano Ezequiel
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Tipo de Licencias';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
	<?= $vcMsjSrv; ?>
	<div class="accionesd">
		<style>
		.accionesd form {
			margin: 0;
		}
		.accionesd a, .accionesd input, .accionesd form {
			display: inline-block!important;
			vertical-align: top!important;
		}
		</style>
		<a href="administrator/licencias/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
		<form id="frmBuscador" name="frmBuscador" action="administrator/licencias/listado" method="post" target="contenido-abm">
			<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?=$txtvcBuscar?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]')?> />
			
				<?php if($txtvcBuscar): ?>
            		<a href="administrator/licencias/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda">&nbsp;</a>
            	<?php endif; ?>				
            <input type="submit" id="btnEnviar" name="btnEnviar" class="btn-accion btn btn-primary" value="buscar"/>
		</form>
	</div>
	<?= $vcGridView; ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#frmBuscador input:first').focus();
		});
	</script>
<!-- EOF lst-personas.php -->
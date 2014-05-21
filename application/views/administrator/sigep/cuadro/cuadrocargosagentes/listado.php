<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package sigepv1
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Cargos';
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
		<a href="cuadro/cuadrocargosagentes/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
		<form id="frmBuscador" name="frmBuscador" action="cuadro/cuadrocargosagentes/listado" method="post" target="contenido-abm">
			<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?=$txtvcBuscar?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]')?> />
			
				<?php if($txtvcBuscar): ?>
            		<a href="cuadro/cuadrocargosagentes/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda">&nbsp;</a>
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
<?php
/**
 * @author Rios Maximiliano Ezequiel
 * @version 1.0.0
 * @copyright 2013
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
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
		<a href="administrator/agentes/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
		<a href="administrator/agentes/reporte/<?php echo $estructura?>/<?php echo $txtvcBuscar?>" id="btn-imprimir" target="_blank" class="btn"><i class="icon-print"></i>&nbsp;&nbsp;Imprimir Listado</a>
		<form id="frmBuscador" name="frmBuscador" action="administrator/agentes/listado" method="post" target="contenido-abm">
			<?php echo form_dropdown('idEstructura', $estructuras);?>
			<?php echo form_dropdown('idCargo', $cargos);?>
			<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?=$txtvcBuscar?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]')?> autofocus/>
				<?php if($txtvcBuscar || $estructura): ?>
            		<a href="administrator/agentes/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda">&nbsp;</a>
            	<?php endif; ?>				
            <input type="submit" id="btnEnviar" name="btnEnviar" class="btn-accion btn btn-primary" value="buscar"/>
		</form>
	</div>
	<?= $vcGridView; ?>
	<script type="text/javascript">
		$('.mensaje-nuevo').on('click', mensajeNuevo);
		$('.usuario').on('click', mensajeNuevo);
	</script>
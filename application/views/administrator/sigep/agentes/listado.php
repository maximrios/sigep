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
<a href="administrator/agentes/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
<a href="administrator/agentes/planilla" id="btn-nuevo" class="btn btn-primary" target="_blank"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Imprimir Planillas</a>
	<?= $vcMsjSrv; ?>
	<?= $vcGridView; ?>

	
	<!--<div class="accionesd">
		<a href="administrator/agentes/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
		<?php /*<a href="administrator/agentes/reporte/<?php echo $estructura?>/<?php echo $txtvcBuscar?>" id="btn-imprimir" target="_blank" class="btn"><i class="icon-print"></i>&nbsp;&nbsp;Imprimir Listado</a>*/?>
		<form id="frmBuscador" name="frmBuscador" action="administrator/agentes/listado" method="post" target="contenido-abm">
			<?php echo form_dropdown('idEstructura', $estructuras, $estructura, 'id="idEstructura"');?>
			<?php echo form_dropdown('idCargo', $cargos, $cargo, 'id="idCargo"');?>
			<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?=$txtvcBuscar?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]')?> autofocus/>
				<?php if($txtvcBuscar || $estructura || $cargo): ?>
            		<a href="administrator/agentes/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda" id="btn-limpiar">&nbsp;</a>
            	<?php endif; ?>				
            <input type="submit" id="btnEnviar" name="btnEnviar" class="btn-accion btn btn-primary" value="buscar"/>
            <input type="hidden" name="buscador" value="1">
		</form>
		<a href="administrator/agentes/exportar" target="_blank">Exportar</a>
	</div>-->
	

	<script type="text/javascript">
		/*$('.mensaje-nuevo').on('click', mensajeNuevo);
		$('.usuario').on('click', mensajeNuevo);*/
		$('#txtvcBuscar').on('change', function() {
			$('#gridview-'+$(this).attr('name')).val($(this).val());
		});
		$('#idEstructura').on('change', function() {
			$('#gridview-'+$(this).attr('name')).remove();
			$("input:hidden[name="+$(this).attr('name')+"]").remove();
			$("input:hidden").remove();
		});
		$('#idCargo').on('change', function() {
			$('#gridview-'+$(this).attr('name')).remove();
			$("input:hidden[name="+$(this).attr('name')+"]").remove();
			$("input:hidden").remove();
			//$('#gridview-'+$(this).attr('name')).val($(this).val());
		});
		$('#btn-limpiar').on('click', function() {
			$('#idEstructura').val('');
			$('#idCargo').val('');
			$('#txtvcBuscar').val('');
			$('#gridview-idEstructura').val('');
			$('#gridview-idCargo').val('');
			$('#gridview-vcBuscar').val('');
		});
	</script>
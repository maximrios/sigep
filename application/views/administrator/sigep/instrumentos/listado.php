<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Instrumentos Legales';
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
		<a href="administrator/instrumentos/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
		<form id="frmBuscador" name="frmBuscador" action="administrator/instrumentos/listado" method="post" target="contenido-abm">
			<?php echo form_dropdown('anio', $anios, $anio, 'id="anio"');?>
			<?php echo form_dropdown('idTipoInstrumentoLegal', $tipos, $tipo, 'id="idTipoInstrumentoLegal"');?>
			<?php echo form_dropdown('idTema', $temas, $tema, 'id="idTema"');?>
			<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?php echo $vcBuscar;?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]')?> />
			
				<?php if($vcBuscar || $anio || $tipo || $tema): ?>
            		<a href="administrator/instrumentos/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda">&nbsp;</a>
            	<?php endif; ?>				
            <input type="submit" id="btnEnviar" name="btnEnviar" class="btn-accion btn btn-primary" value="buscar"/>
		</form>
	</div>
	<?= $vcGridView; ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#frmBuscador input:first').focus();
		});
		$('#anio').on('change', function() {
			$('#gridview-'+$(this).attr('name')).val($(this).val());
		});
		$('#idTema').on('change', function() {
			$('#gridview-'+$(this).attr('name')).val($(this).val());
		});
		$('#idTipoInstrumentoLegal').on('change', function() {
			$('#gridview-'+$(this).attr('name')).val($(this).val());
		});
	</script>
<!-- EOF lst-personas.php -->
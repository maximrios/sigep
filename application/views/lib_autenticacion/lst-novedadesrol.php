<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Novedades por Roles';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<div class="box-layout-50-rt">
	<div class="toolbar-rgt-sb">
  	<div class="toolbar-rgt-sb-der">
  		<div class="forms">
  			<form id="frmBuscador" name="frmBuscador" action="autenticacion/novedadesrol/listado" method="post" target="contenido-abm">
  				<div class="fila">
  					<label for="txtvcBuscar">Buscar por texto &raquo;</label>
  					<input type="text" id="txtvcBuscar" name="vcBuscar" value="<?=$txtvcBuscar?>" placeholder="Ingrese un Criterio de Búsqueda" <?=classRegValidation('vcBuscar', 'custom[onlySearch]', 'inputPegadosIzq')?> />
                    <?php if($txtvcBuscar): ?>
                    <a href="autenticacion/novedadesrol/listado" target="contenido-abm" class="btn-accion limpiar btn-reset limpiarBusqueda" title="Limpiar Búsqueda">&nbsp;</a>
                    <?php endif; ?>
  					<input type="submit" id="btnEnviar" name="btnEnviar" class="button-sp1 btn-accion btn-reset inputPegadosDer" value="buscar"/>
  				</div>
    			<div class="clearfloat">&nbsp;</div>
  			</form>
  		</div>
    </div>
  	<div class="toolbar-rgt-sb-izq">
  		<a href="autenticacion/novedadesrol/formulario" id="btn-nuevo" class="button agregar btn-accion">Agregar Nuevo</a>
  	</div>
		<div class="clearfloat">&nbsp;</div>
	</div>
</div>
<div class="box-layout-50-lt">
  <span class="ico-subtitulo mensajes-30">&nbsp;</span>
  <h2 class="fontface-arimo-subtitulo box-layout-titulo">Listado de <?= $vcNombreList; ?></h2>
</div>
<div class="clearfloat">&nbsp;</div>
<?= $vcMsjSrv; ?>
<?= $vcGridView; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#frmBuscador input:first').focus();
	});
</script>
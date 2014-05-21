<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package sigep
 */
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
	<div class="full-content">
		<div class="box-normal-100">
	  		<h2 class="fontface-arimo-titulo">Solicitud de Licencia</h2>
	  		<p>En esta secci&oacute;n podr&aacute; completar el formulario para solicitud de licencia especial.</p>
		</div> 
		<section class="box-normal-100">
	  		<?= $vcMsjSrv; ?>
	  		<div id="contenido-abm" class="container-gridview"></div>
		</section>
	</div>
	<div class="clearfloat">&nbsp;</div>
	<form action="administrator/reportes/especial" method="post" target="_blank">
		<li>
			<label>Cantidad de dias solicitados</label>
			<input type="text" id="dias" name="dias">
		</li>
		<li>
			<label>Desde</label>
			<input class="fecha" type="text" id="desdeLicencia" name="desdeLicencia" tabindex="3" placeholder="dd-mm-yyyy">
		</li>
		<li>
			<label>Hasta</label>
			<input class="fecha" type="text" id="hastaLicencia" name="hastaLicencia" tabindex="4" placeholder="dd-mm-yyyy">
		</li>
		<button class="btn btn-primary"><i class="icon-print icon-white"></i>&nbsp;&nbsp;Imprimir formulario</button>
	</form>
<script>
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy'
	});
</script>
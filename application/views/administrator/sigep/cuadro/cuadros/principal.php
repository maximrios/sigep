<?php
/**
 * @author Maxim
 * @version 1.0.0
 * @copyright 2013
 * @package Sigepv1
 */
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
	<div class="full-content">
		<div class="box-normal-100">
	  		<h2 class="fontface-arimo-titulo">Administraci&oacute;n de Cuadros</h2>
	  		<p>En esta secci&oacute;n podr&aacute; administrar los cuadros registrados en el sistema.</p>
		</div> 
		<section class="box-normal-100">
	  		<?= $vcMsjSrv; ?>
	  		<div id="contenido-abm" class="container-gridview"></div>
		</section>
	</div>
	<div class="clearfloat">&nbsp;</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#contenido-abm').gridviewHandler({'url': 'cuadro/cuadro/listado'});
		});
	</script>
<!-- principal-personas.php -->
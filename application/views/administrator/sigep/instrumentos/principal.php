<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package base
 */
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
	<div class="full-content">
		<div class="box-normal-100">
			<!--<img src="assets/themes/sigep/images/icon-manager.png">
			<i class="icon-ok"></i>-->
	  		<h2 class="fontface-arimo-titulo">Administraci&oacute;n de Instrumentos Legales</h2>
	  		<p>En esta secci&oacute;n podr&aacute; administrar los instrumentos legales registrados en el sistema.</p>
		</div> 
		<section class="box-normal-100">
	  		<?= $vcMsjSrv; ?>
	  		<div id="contenido-abm" class="container-gridview"></div>
		</section>
	</div>
	<div class="clearfloat">&nbsp;</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#contenido-abm').gridviewHandler({'url': 'administrator/instrumentos/listado'});
		});
	</script>
<!-- principal-personas.php -->
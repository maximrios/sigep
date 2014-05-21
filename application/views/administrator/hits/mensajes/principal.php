<?php
/**
 * @author Maxim
 * @version 1.0.0
 * @copyright 2013
 * @package sigep
 */
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
	<div class="full-content">
		<div class="box-normal-100">
	  		<h2 class="fontface-arimo-titulo">Administraci&oacute;n de Mensajes</h2>
	  		<p>En esta secci&oacute;n podr&aacute; administrar los mensajes registrados en el sistema.</p>
		</div> 
		<section class="box-normal-100">
	  		<?= $vcMsjSrv; ?>
	  		<div id="contenido-abm" class="container-gridview"></div>
		</section>
	</div>
	<div class="clearfloat">&nbsp;</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#contenido-abm').gridviewHandler({'url': 'administrator/noticias/listado'});
		});
	</script>
<!-- principal-personas.php -->
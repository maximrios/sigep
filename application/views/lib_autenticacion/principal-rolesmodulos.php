<?php
/**
 * @author Duran Francisco Javier
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
	<div class="full-content"> 
		<div class="box-normal-100">
	  		<span class="ico-titulo ayuda-40">&nbsp;</span>
	  		<h2 class="fontface-arimo-titulo">Administraci&oacute;n de Roles-Modulos</h2>
	  		<p>En esta secci&oacute;n podr&aacute; editar los permisos de los Roles del Sistema</p>
	  		<div class=" clearfloat20"></div>
		</div>
		<section class="box-normal-100">
	  		<?= $vcMsjSrv; ?>
	  		<div id="contenido-abm" class="container-gridview"></div>
		</section>
	</div>
	<div class="clearfloat">&nbsp;</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#contenido-abm').gridviewHandler({'url': 'autenticacion/rolesmodulos/listadoEditar'});
		});
	</script>
<?php // EOF principal-rolesmodulos.php
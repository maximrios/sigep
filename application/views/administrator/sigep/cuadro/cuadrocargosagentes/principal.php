<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2014
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
<div class="panel panel-default">
	<div class="panel-heading">Administracion de Cargos<a data-toggle="collapse" href="#prueba"><span class="glyphicon glyphicon-minus pull-right"></span></a></div>
		<div class="panel-body panel-collapse">
			<?= $vcMsjSrv; ?>
 			<div id="contenido-abm" class="container-gridview"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#contenido-abm').gridviewHandler({'url': 'administrator/cuadrocargosagentes/listado'});
	});
</script>
<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<li id="articulo_1">
			<label>Nombre del Tema</label>
			<input id="textoTema" name="textoTema" value="<?php echo $Reg['textoTema']?>">
		</li>
		<button id="guardarTema" class="btn btn-primary"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Guardar</button>
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
		<input type="hidden" id="idTema" name="idTema" value="<?php echo $Reg['idTema']?>">
	</form>
</div>
<script>
	$('#guardarTema').on('click', enviarFancybox);
</script>
<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<style>
.ui-autocomplete {
	z-index: 99999;
}
#asuntoMensaje, #textoMensaje {
	width: 30em;
}
#textoMensaje {
	resize: none;
}
</style>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm" class="enviado">
	<div id="data" name="data" class="medio"></div>
	<li>
		<label>Asunto</label>
		<span></span>
		<input type="text" id="asuntoMensaje" name="asuntoMensaje">
	</li>
	<li>
		<label>Mensaje</label>
		<span>Escriba el mensaje para enviar</span>
		<textarea id="textoMensaje" name="textoMensaje" rows="4" cols="150"></textarea>
	</li>
	
	<button id="enviarMensaje" class="btn btn-primary"><i class="icon-check icon-white"></i> Enviar mensaje</button>
	<div id="destinatarios">
	</div>
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	<input type="hidden" id="idTipoMensaje" name="idTipoMensaje" value="2">
	<input type="hidden" id="deMensaje" name="deMensaje" value="<?php echo $this->lib_autenticacion->idPersona()?>">
	<input type="hidden" id="destinatarioMensaje" name="destinatarioMensaje" value="<?php echo $destinatarioMensaje?>" />
</form>
</div>
<script>
	$('#enviarMensaje').on('click', guardarMensaje);
</script>
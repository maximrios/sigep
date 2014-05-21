<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<style>
.ui-autocomplete {
	z-index: 99999;
}
span.borrar {
	display: block;
}
#textoMensaje {
	resize: none;
}
</style>
<div class="forms" style="width: 250px;">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm" class="enviado" style="margin: 0 auto;">
	<li class="medio">
		<label>Para </label>
		<span>Ingrese el o los destinatarios del mensaje</span>
		<input type="text" id="destinatario" name="destinatario" tabindex="1" placeholder="Destinatario" value="">
	</li>
	<div id="data" name="data" class="medio"></div>
	<li>
		<label>Asunto</label>
		<span></span>
		<input type="text" id="asuntoMensaje" tabindex="2" name="asuntoMensaje">
	</li>
	<li>
		<label>Mensaje</label>
		<span>Escriba el mensaje para enviar</span>
		<textarea id="textoMensaje" tabindex="3" name="textoMensaje"></textarea>
	</li>
	<!--<div class="buttons">-->
		<input type="submit" id="enviarMensaje" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idMensaje'])?' btn-reset':''); ?>" value="Guardar"/>
	<!--</div>-->
	<div id="destinatarios">
	</div>
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	<input type="hidden" id="idTipoMensaje" name="idTipoMensaje" value="2">
	<input type="hidden" id="deMensaje" name="deMensaje" value="<?php echo $this->lib_autenticacion->idPersona()?>">
	<input type="hidden" id="paraMensaje" name="paraMensaje" value="0" />
	<?php
		if($destinatarioMensaje)
			echo '<input type="hidden" id="destinatario'.$destinatarioMensaje.'" name="destinatarioMensaje[]" value="'.$destinatarioMensaje.'">';
	?>
</form>
</div>
<script>
	$("#destinatario").autocomplete({
		source: "cuadro/cuadrocargosagentes/obtenerAutocompleteAgentes",
		select: function(event, ui){
			$('#data').append('<span id="borrar'+ui.item.id+'" class="borrar">'+ui.item.label+'<i id="cerrar'+ui.item.id+'" class="icon-remove cerrar"></i></span>');
			$('#destinatarios').append('<input type="hidden" id="destinatario'+ui.item.id+'" name="destinatarioMensaje[]" value="'+ui.item.id+'">');
			$('#destinatario').focus();
		},
		close: function(event, ui){ 
			$('#destinatario').val('');
		},
	});
	$('#enviarMensaje').on('click', function(){
		$form = $('form.enviado');
		//var datos = $form.serialize();
		//var accion = $form.attr('action');
		$.ajax({
			url: $form.attr('action'),
			type: 'post',
			data: $form.serialize(),
			success: function(){
				$.fancybox.close();
			}
		});
		return false;
	})
	$('#data').on('click', 'i.cerrar', function(){
		var id = $(this).attr('id').replace('cerrar','');
		$('#borrar'+id).remove();
		$('#destinatario'+id).remove();
	})
</script>

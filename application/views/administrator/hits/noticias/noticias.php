<?php
	$vcFormName = antibotHacerLlave();
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Titulo de la Noticia</label>
		<span>Ingrese un titulo para identificar la noticia</span>
		<input type="text" id="tituloNoticia" name="tituloNoticia" tabindex="1" placeholder="Titulo de Noticia">
	</li>
	<li>
		<label>Cuerpo de la Noticia</label>
		<span>Ingrese el cuerpo completo de la noticia.</span>
		<textarea id="descripcionNoticia" name="descripcionNoticia" tabindex="2"></textarea>
	</li>
	<li class="medio">
		<label>Fecha de Inicio</label>
		<span>Fecha de inicio de publicación de la noticia.</span>
		<input class="fecha" type="text" id="inicioNoticia" name="inicioNoticia" tabindex="3" placeholder="dd-mm-yyyy">
	</li>
	<li class="medio">
		<label>Fecha de Fin</label>
		<span>Fecha de fin de publicación de la noticia.</span>
		<input class="fecha" type="text" id="vencimientoNoticia" name="vencimientoNoticia" tabindex="4" placeholder="dd-mm-yyyy">
	</li>
	<li>
		<label>Tipo de Noticia</label>
		<span>Identifique la noticia en alguno de los siguientes grupos.</span>
		<select id="idTipoNoticia" name="idTipoNoticia">
			<option value="0">Seleccione un item ...</option>
			<option value="1">Institucionales</option>
			<option value="2">Gremiales</option>
		</select>
	</li>
	<li class="checkbox">
		<input type="checkbox" id="publicadoNoticia" name="publicadoNoticia" checked>&nbsp; Publicar noticia automaticamente dependiendo de las fechas de inicio y fin.
	</li>
	<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idNoticia'])?' btn-reset':''); ?>" value="Guardar"/>
	<input type="hidden" id="idNoticia" name="idNoticia">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
<script>
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy',
		setDate: now(),
	});
</script>
<?php echo display_ckeditor($ckeditor_texto1); ?>
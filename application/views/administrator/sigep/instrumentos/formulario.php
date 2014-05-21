<?php
	$formNombre = antibotHacerLlave();
	$formAccion = (!empty($formAccion))? $formAccion: '';
?>
<form id="maxi" name="maxi" action="<?php echo $formAccion;?>" method="post" target="contenido-abm">
	<li>
		<label>Fecha</label>
		<span>Ingrese la fecha del instrumento legal</span>
		<input type="text" id="fechaInstrumentoLegal" name="fechaInstrumentoLegal">
	</li>
	<li>
		<label for="vistoResolucion">VISTO</label>
		<textarea id="vistoInstrumentoLegal" name="vistoInstrumentoLegal"></textarea>
	</li>
	<li>
		<label>CONSIDERANDO</label>
		<textarea id="considerandoInstrumentoLegal" name="considerandoInstrumentoLegal" class="resolucion"></textarea>
	</li>
	CUERPO
	<hr>
	<li id="articulo_1">
		<label>Articulo N° 1</label>
		<textarea id="cuerpoInstrumentoLegal" name="cuerpoInstrumentoLegal" class="resolucion"></textarea>
		<a href="#" class="agregar_articulo"><i class="icon-ok"></i></a>
	</li>
	<button></button>
	<button class="btn btn-primary">Guardar</button>
	<input type="hidden" id="vcForm" name="vcForm">
</form>
<?php 
	echo display_ckeditor($ck_visto); 
	echo display_ckeditor($ck_considerando);
	echo display_ckeditor($ck_cuerpo); 
?>
<!--<script>
	//var contenido = CKEDITOR.instances['miTextArea'].getData();
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy'
	});
	$('#probar').on('click', function() {
		var contenido = CKEDITOR.instances['descNoticia'].getData();
		$('#descripcionNoticia').val(contenido);
		alert(contenido);
	})
	//var contenido = CKEDITOR.instances['miTextArea'].getData();
</script>

<script>
	$('.agregar_articulo').on('click', agregarArticulo);
</script>-->
<?php //echo display_ckeditor($ckeditor_texto1); ?>
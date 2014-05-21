<form action="formulario_submit" method="get" accept-charset="utf-8">
	<li>
		<label>Fecha del Instrumento Legal</label>
		<span>Ingrese la fecha del instrumento Legal</span>
		<input type="date" id="fechaCuadro" name="fechaCuadro">
	</li>
	<li>
		<label>Numero de Instrumento Legal</label>
		<span>Ingrese solo el numero del instrumento</span>
		<input type="text" id="instrumentoCuadro" name="instrumentoCuadro">
	</li>
	<li>
		<label>Año de Instrumento Legal</label>
		<span>Ingrese solo el año del instrumento</span>
		<input type="text" id="anioCuadro" name="anioCuadro">
	</li>
	<li>
		<label>Archivo del Instrumento Legal</label>
		<span></span>
		<input type="file">
	</li>
</form>
<script>
	$('#fechaCuadro').datepicker({
		format: 'dd/mm/yyyy',
	});
</script>
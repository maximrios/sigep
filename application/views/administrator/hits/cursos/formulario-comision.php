<style>
form {
	text-align: center;
}
form input {
	text-align: center;
}
</style>
<form action="capacitacion/cursos/guardarComision" id="form-crearComision" name="form-crearComision" method="post">
	<li>
		<label>Comision N°</label>
		<span>Ingrese el numero de la comision</span>
		<input type="text" class="input-mini" id="numeroComision" name="numeroComision">
	</li>
	<li>
		<label>Dia</label>
		<span>Seleccione el dia de la semana</span>
		<select>
			<option value="0">Seleccione un item ...</option>
			<option>Lunes</option>
		</select>
	</li>
	<li>
		<label>Hora de Inicio</label>
		<span>Ingrese la hora de inicio. Formato: HH:mm</span>
		<input type="text" class="input-mini" id="inicioCursoHorario" name="inicioCursoHorario" placeholder="HH:mm">
	</li>
	<li>
		<label>Hora de Fin</label>
		<span>Ingrese la hora de fin. Formato: HH:mm</span>
		<input type="text" class="input-mini" id="finCursoHorario" name="finCursoHorario" placeholder="HH:mm">
	</li>
	<button id="btn-crearComision" name="btn-crearComision" class="btn btn-primary">Crear comisión</button>
</form>
<script>
	$('#btn-crearComision').on('click', crearComision);
	function crearComision() {
		$form = $("#form-crearComision");
		var datos = $form.serialize();
		$.ajax({
			type: $form.attr('method'),
			data: datos,
			success: function() {
				
			}
		});
		return false;
	}
</script>
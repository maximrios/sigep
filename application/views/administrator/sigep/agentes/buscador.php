<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Ingrese el nombre de la persona</label>
		<span>Ingrese parte del nombre o apellido de la persona</span>
		<input type="text" id="nombrePersona" name="nombrePersona">
		<a id="nuevaPersona" name="nuevaPersona" href="administrator/personas/">Si no encuentra la persona, haga clic aqui</a>
	</li>
	<li>
		<label>Fecha de ingreso a la Administracion Pública Provincial</label>
		<span>Seleccione la fecha de ingreso a la APP</span>
		<input id="ingresoAgenteAPP" name="ingresoAgenteAPP" value="">
	</li>
	<li>
		<label>Fecha de ingreso a la SIGEP</label>
		<span>Seleccione la fecha de ingreso a la SIGEP</span>
		<input id="ingresoAgenteSIGEP" name="ingresoAgenteSIGEP" value="">
	</li>
	<li>
		<label>Numero de interno</label>
		<span>Ingrese el numero de interno en el que se lo encontrará al agente.</span>
		<input type="text" class="input-mini" id="internoAgente" name="internoAgente" value="">
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?>" value="Guardar"/>
	</div>
	<input type="hidden" id="idPersona" name="idPersona" value=""/>
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
<script>
	$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
			/*var seleccion = ui.item.id;
			$.ajax({
				type: 'post',
				url: "administrator/agentes/formulario",
				data: 'idPersona=2'
			})*/
		}
	});
	$('#ingresoAgenteAPP').datepicker({
		format: 'dd/mm/yyyy'
	});
	$('#ingresoAgenteSIGEP').datepicker({
		format: 'dd/mm/yyyy'
	});
</script>
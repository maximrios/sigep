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
		<input type="text" id="nombrePersona" name="nombrePersona" value="<?php echo $Reg['nombrePersona']?>" autofocus/>
		<!--<a id="nuevaPersona" name="nuevaPersona" href="administrator/personas/">Si no encuentra la persona, haga clic aqui</a>-->
	</li>
	<li>
		<label>Fecha de ingreso a la Administracion Pública Provincial</label>
		<span>Seleccione la fecha de ingreso a la APP</span>
		<input id="ingresoAgenteAPP" name="ingresoAgenteAPP" value="<?php echo $Reg['ingresoAgenteAPP']?>">
	</li>
	<li>
		<label>Fecha de ingreso a la SIGEP</label>
		<span>Seleccione la fecha de ingreso a la SIGEP</span>
		<input id="ingresoAgenteSIGEP" name="ingresoAgenteSIGEP" value="<?php echo $Reg['ingresoAgenteSIGEP']?>">
	</li>
	<li>
		<label>Numero de interno</label>
		<span>Ingrese el numero de interno en el que se lo encontrará al agente.</span>
		<input type="text" class="input-mini" id="internoAgente" name="internoAgente" value="<?php echo $Reg['internoAgente']?>">
	</li>
	<input type="submit" class="btn-primary btn-accion<?= (empty($Reg['idAgente'])?' btn-reset':''); ?>" value="Guardar"/>
	<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $Reg['idPersona']?>" />
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	$('#ingresoAgenteAPP').datepicker({
		format: 'dd/mm/yyyy',
	});
	$('#ingresoAgenteSIGEP').datepicker({
		format: 'dd/mm/yyyy'
	});
	$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
		}
	});
	/*$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		minLength: 3,
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
			var seleccion = ui.item.id;
			$.ajax({
				type: 'post',
				url: "administrator/agentes/formulario",
				data: 'idPersona='+seleccion
			})
		}
	});*/
</script>
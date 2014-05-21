<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Cuadro</label>
		<span>Instrumento Legal</span>
		<input type="text" id="instrumentoCuadro" name="instrumentoCuadro" tabindex="1" placeholder="Instrumento Legal" value="<?php echo $Reg['instrumentoCuadro']?>" readonly>
	</li>
	<li>
		<label>Orden</label>
		<span>Numero de Orden</span>
		<input type="text" id="ordenCuadroCargo" name="ordenCuadroCargo" tabindex="1" placeholder="Número de orden" value="<?php echo $Reg['ordenCuadroCargo']?>" readonly>
	</li>
	<li>
		<label>Area</label>
		<span>Ingrese el nombre de la Gerencia o Area operativa</span>
		<input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="1" placeholder="Nombre de Area" value="<?php echo $Reg['nombreEstructura']?>" readonly>
	</li>
	<li>
		<label>Cargo</label>
		<span>Ingrese el nombre del cargo</span>
		<input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="1" placeholder="Denominación del Cargo" value="<?php echo $Reg['denominacionCargo']?>" readonly>
	</li>
	<li>
		<label>Datos del cargo</label>
		<span>Datos de la estructura de cargo</span>
		<?php echo form_dropdown('idEscalafon', $escalafones, $Reg['idEscalafon']);?>
		<?php echo form_dropdown('idAgrupamiento', $agrupamientos, $Reg['idAgrupamiento']);?>
		<?php echo form_dropdown('idFuncion', $funciones, $Reg['idFuncion']);?>
	</li>
	<li>
		<label>Agentes</label>
		<span>Ingrese parte del nombre del Agente</span>
		<input type="text" id="nombrePersona" name="nombrePersona" tabindex="1" placeholder="Nombre del Agente" value="<?php echo $Reg['nombrePersona']?>" autofocus>
	</li>
	<li>
		<label>Datos del agente</label>
		<span>Datos del cargo del agente</span>
		<?php echo form_dropdown('idSubgrupo', $subgrupos, $Reg['idSubgrupo']);?>
		<?php echo form_dropdown('idAgrupamientoCCA', $agrupamientos, $Reg['idAgrupamientoCCA']);?>
		<?php echo form_dropdown('idEquivalente', $equivalentes, $Reg['idEquivalente']);?>
		<!--<select class="mini" id="idAgrupamientoCCA" name="idAgrupamientoCCA" size="1">
			<option value="0">Seleccione un item ...</option>
			<option value="1">P</option>
			<option value="2">A</option>
			<option value="3">M</option>
		</select>
		<select class="mini" id="idEquivalente" name="idEquivalente" size="1">
			<option value="0">Seleccione un item ...</option>
			<option value="1">Director</option>
			<option value="2">Secretario</option>
			<option value="3">Subsecretario</option>
			<option value="4">Director General</option>
			<option value="5">Jefe de Programa</option>
		</select>-->
	</li>

	<li>
		<label>Observaciones</label>
		<span>Observaciones de la ocupacion del cargo</span>
		<input type="text" id="observacionesCuadroCargoAgente" name="observacionesCuadroCargoAgente" placeholder="Observaciones" value="<?php echo $Reg['observacionesCuadroCargoAgente']?>">
	</li>
	<li>
		<label>Designado por Instrumento Legal</label>
		<span>Numero de Instrumento Legal de la designación</span>
		<input type="text" id="instrumento" name="instrumento" value="<?php echo $Reg['instrumentoCuadro']?>">
	</li>
	<li>
		<label>Situacion de Revista</label>
		<span>Seleccione la situacion de revista</span>
		<?php echo form_dropdown('idSituacionRevista', $situaciones, $Reg['idSituacionRevista']);?>
	</li>
	<li>
		<label>Pertenece al Cuadro de Cargos ?</label>
		<span></span>
		<input type="checkbox" id="perteneceCuadroCargoAgente" name="perteneceCuadroCargoAgente" value="1" checked>
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?>" value="Guardar"/>
	</div>
	<input type="hidden" id="idCuadroCargo" name="idCuadroCargo" value="<?php echo $Reg['idCuadroCargo']?>">
	<input type="hidden" id="idCuadroCargoAgente" name="idCuadroCargoAgente" value="<?php echo $Reg['idCuadroCargoAgente']?>">
	<input type="hidden" id="idAgente" name="idAgente" value="<?php echo $Reg['idAgente']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	$("#nombrePersona").autocomplete({
		source: "cuadro/cuadrocargosagentes/obtenerAutocompleteAgentes",
		select: function(event, ui){
			$('#idAgente').val(ui.item.id);
		}
	});
</script>

<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Instrumento</label>
		<span>Instrumento Legal de Designacion</span>
		<input type="text" id="instrumentoLegal" name="instrumentoLegal" tabindex="1" placeholder="Instrumento Legal" value="<?php echo $Reg['instrumentoLegal']?>">
	</li>
	<li>
		<label>Area</label>
		<span>Ingrese el nombre de la Gerencia o Area operativa</span>
		<input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="1" placeholder="Nombre de Area" value="<?php echo $Reg['nombreEstructura']?>">
	</li>
	<li>
		<label>Agentes</label>
		<span>Ingrese parte del nombre del Agente</span>
		<input type="text" id="completoPersona" name="completoPersona" tabindex="1" placeholder="Nombre del Agente" value="<?php echo $Reg['completoPersona']?>">
	</li>
	<li>
		<label>Cargo</label>
		<span>Ingrese el nombre del cargo</span>
		<input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="1" placeholder="Denominación del Cargo" value="<?php echo $Reg['denominacionCargo']?>">
	</li>
	<li>
		<label>Fecha de Inicio</label>
		<span>Ingrese la fecha de inicio de la designacion</span>
		<input type="text" class="fecha" id="fechaInicioDesignacion" name="fechaInicioDesignacion" placeholder="dd/mm/YYYY" value="<?php echo $Reg['fechaInicioDesignacion']?>">
	</li>
	<li>
		<label>Fecha de Fin</label>
		<span>Ingrese la fecha de fin de la designacion</span>
		<input type="text" class="fecha" id="fechaFinDesignacion" name="fechaFinDesignacion" placeholder="dd/mm/YYYY" value="<?php echo $Reg['fechaFinDesignacion']?>">
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?>" value="Guardar"/>
	</div>
	<input type="hidden" id="idDesignacion" name="idDesignacion" value="<?php echo $Reg['idDesignacion']?>">
	<input type="hidden" id="idAgente" name="idAgente" value="<?php echo $Reg['idAgente']?>">
	<input type="hidden" id="idCargo" name="idCargo" value="<?php echo $Reg['idCargo']?>">
	<input type="hidden" id="idEstructura" name="idEstructura" value="<?php echo $Reg['idEstructura']?>">
	<input type="hidden" id="idInstrumentoLegal" name="idInstrumentoLegal" value="<?php echo $Reg['idInstrumentoLegal']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	$("#instrumentoLegal").autocomplete({
		source: "administrator/instrumentos/obtenerInstrumentosAutocomplete",
		select: function(event, ui){
			$('#idInstrumentoLegal').val(ui.item.id);
		}
	});
	$("#completoPersona").autocomplete({
		source: "cuadro/cuadrocargosagentes/obtenerAutocompleteAgentes",
		select: function(event, ui){
			$('#idAgente').val(ui.item.id);
		}
	});
	$("#nombreEstructura").autocomplete({
		source: "administrator/estructura/obtenerEstructuraAutocomplete",
		select: function(event, ui){
			$('#idEstructura').val(ui.item.id);
		}
	});
	$("#denominacionCargo").autocomplete({
		source: "cuadro/cuadrocargos/obtenerAutocompleteCargos",
		select: function(event, ui){
			$('#idCargo').val(ui.item.id);
		}
	});
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy'
	});
</script>

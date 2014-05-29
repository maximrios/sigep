<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<div class="form-group col-lg-6">
    	<label for="idInstrumentoLegal">Instrumento Legal</label>
		<?php echo form_dropdown('idInstrumentoLegal', $instrumentos, $Reg['idInstrumentoLegal'], 'class="form-control"');?>
    </div>
	<div class="form-group col-lg-6">
    	<label for="ordenCuadroCargo">Orden</label>
		<input type="text" id="ordenCuadroCargo" name="ordenCuadroCargo" tabindex="2" placeholder="Número de orden" value="<?php echo $Reg['ordenCuadroCargo']?>" class="form-control">
	</div>
	<div class="form-group col-lg-12">
    	<label for="nombreEstructura">Area</label>
    	<input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="3" placeholder="Nombre de Area" value="<?php echo $Reg['nombreEstructura']?>" class="form-control">
    </div>
	<div class="form-group col-lg-12">
    	<label for="denominacionCargo">Cargo</label>
		<input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="4" placeholder="Denominación del Cargo" value="<?php echo $Reg['denominacionCargo']?>" class="form-control">
	</div>
	<div class="form-group col-lg-4">
    	<label for="idEscalafon">Escalafon</label>
		<?php echo form_dropdown('idEscalafon', $escalafones, $Reg['idEscalafon'], 'class="form-control"');?>
	</div>
	<div class="form-group col-lg-4">
    	<label for="idAgrupamiento">Agrupamiento</label>
		<?php echo form_dropdown('idAgrupamiento', $agrupamientos, $Reg['idAgrupamiento'], 'class="form-control"');?>
	</div>
	<div class="form-group col-lg-4">
    	<label for="idFuncion">Función Jerarq.</label>
		<?php echo form_dropdown('idFuncion', $funciones, $Reg['idFuncion'], 'class="form-control"');?>
	</div>
	<div class="form-group col-lg-12">
        <label for="my-checkbox">Pertenece al Cuadro de Cargos</label><br>
        <input type="checkbox" class="form-control" id="perteneceCuadroCargo" name="perteneceCuadroCargo" value="1" <?=($Reg['perteneceCuadroCargo'] == 1)?'checked':''?>>
    </div>
	<div class="buttons">
		<input type="submit" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?> pull-right" value="Guardar"/>
	</div>
	<input type="hidden" id="idCuadroCargo" name="idCuadroCargo" value="<?php echo $Reg['idCuadroCargo']?>">
	<input type="hidden" id="idEstructura" name="idEstructura" value="<?php echo $Reg['idEstructura']?>">
	<input type="hidden" id="idCargo" name="idCargo" value="<?php echo $Reg['idCargo']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
<script>
	$('input[name="perteneceCuadroCargo"]').bootstrapSwitch({
        onText: 'SI',
        offText: 'NO',
    });
	/*$("#nombreEstructura").autocomplete({
		source: "cuadro/cuadrocargos/obtenerAutocomplete",
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
	$("#instrumentoCuadroCargo").autocomplete({
		source: "administrator/instrumentos/obtenerInstrumentosAutocomplete",
		select: function(event, ui){
			$('#idInstrumentoLegal').val(ui.item.id);
		}
	});*/
</script>

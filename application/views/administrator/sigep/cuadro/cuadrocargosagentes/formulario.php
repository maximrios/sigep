<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<div class="panel panel-default">
  		<div class="panel-heading">Denominacion del cargo</div>
  		<div class="panel-body">
    		<div class="form-group col-lg-6">
    			<label for="instrumentoCuadro">Instrumento Legal</label>
				<!--<input type="text" id="instrumentoCuadro" name="instrumentoCuadro" tabindex="1" placeholder="Instrumento Legal" value="<?php echo $Reg['instrumentoCuadro']?>" readonly class="form-control">-->
                <?php echo form_dropdown('idInstrumentoLegal', $instrumentos, $Reg['idInstrumentoLegal'], 'class="form-control" readonly');?>
    		</div>
			<div class="form-group col-lg-6">
    			<label for="ordenCuadroCargo">Numero de Orden</label>
				<input type="text" id="ordenCuadroCargo" name="ordenCuadroCargo" tabindex="1" placeholder="Número de orden" value="<?php echo $Reg['ordenCuadroCargo']?>" readonly class="form-control">
    		</div>
			<div class="form-group col-lg-6">
    			<label for="nombreEstructura">Area</label>
				<input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="1" placeholder="Nombre de Area" value="<?php echo $Reg['nombreEstructura']?>" readonly class="form-control">
    		</div>
			<div class="form-group col-lg-6">
    			<label for="denominacionCargo">Cargo</label>
				<input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="1" placeholder="Denominación del Cargo" value="<?php echo $Reg['denominacionCargo']?>" readonly class="form-control">
    		</div>
    		<div class="form-group col-lg-4">
    			<label for="idEscalafon">Escalafon</label>
    			<?php echo form_dropdown('idEscalafon', $escalafones, $Reg['idEscalafon'], 'class="form-control" readonly');?>
    		</div>
    		<div class="form-group col-lg-4">
    			<label for="idAgrupamiento">Agrupamiento</label>
    			<?php echo form_dropdown('idAgrupamiento', $agrupamientos, $Reg['idAgrupamiento'], 'class="form-control" readonly');?>
    		</div>
    		<div class="form-group col-lg-4">
    			<label for="idFuncion">Escalafon</label>
    			<?php echo form_dropdown('idFuncion', $funciones, $Reg['idFuncion'], 'class="form-control" readonly');?>
    		</div>
  		</div>
	</div>
	<div class="form-group col-lg-12">
    	<label for="idAgente">Agente</label>
        <?php echo form_dropdown('idAgente', $agentes, $Reg['idAgente'], 'class="form-control"');?>
    	<!--<input type="text" id="nombrePersona" name="nombrePersona" tabindex="1" placeholder="Nombre del Agente" value="<?php echo $Reg['nombrePersona']?>" autofocus class="form-control">-->
    </div>
    <div class="form-group col-lg-4">
    	<label for="idSubgrupo">Subgrupo</label>
    	<?php echo form_dropdown('idSubgrupo', $subgrupos, $Reg['idSubgrupo'], 'class="form-control"');?>
    </div>
    <div class="form-group col-lg-4">
    	<label for="idAgrupamientoCCA">Agrupamiento</label>
    	<?php echo form_dropdown('idAgrupamientoCCA', $agrupamientos, $Reg['idAgrupamientoCCA'], 'class="form-control"');?>
    </div>
    <div class="form-group col-lg-4">
    	<label for="idEquivalente">Equivalente Remun.</label>
    	<?php echo form_dropdown('idEquivalente', $equivalentes, $Reg['idEquivalente'], 'class="form-control"');?>
    </div>
    <div class="form-group col-lg-12">
    	<label for="observacionesCuadroCargoAgente">Observaciones</label>
    	<input type="text" id="observacionesCuadroCargoAgente" name="observacionesCuadroCargoAgente" placeholder="Observaciones" value="<?php echo $Reg['observacionesCuadroCargoAgente']?>" class="form-control">
    </div>
    <div class="form-group col-lg-6">
    	<label for="instrumento">Designado por Instrumento Legal</label>
        <?php echo form_dropdown('idInstrumentoLegalCuadroCargoAgente', $instrumentos, $Reg['idInstrumentoLegalCuadroCargoAgente'], 'class="form-control"');?>
    </div>
    <div class="form-group col-lg-6">
    	<label for="instrumento">Situacion de Revista</label>
    	<?php echo form_dropdown('idSituacionRevista', $situaciones, $Reg['idSituacionRevista'], 'class="form-control"');?>
	</div>
	<div class="form-group col-lg-6">
        <label for="my-checkbox">Pertenene al Cuadro de Cargos</label><br>
        <input type="checkbox" class="form-control my-checkbox" id="perteneceCuadroCargoAgente" name="perteneceCuadroCargoAgente" value="1" <?=($Reg['perteneceCuadroCargoAgente'] == 1)?'checked':''?>>
    </div>
    <div class="form-group col-lg-6">
        <label for="my-checkbox">Cargo en Vigencia</label><br>
        <input type="checkbox" class="form-control my-checkbox" id="vigenteCuadroCargoAgente" name="vigenteCuadroCargoAgente" value="1" <?=($Reg['vigenteCuadroCargoAgente'] == 1)?'checked':''?>>
    </div>
	<div class="form-group col-lg-12">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?> pull-right" value="Guardar"/>
	</div>
	<input type="hidden" id="idCuadroCargo" name="idCuadroCargo" value="<?php echo $Reg['idCuadroCargo']?>">
	<input type="hidden" id="idCuadroCargoAgente" name="idCuadroCargoAgente" value="<?php echo $Reg['idCuadroCargoAgente']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
<script>
	$('.my-checkbox').bootstrapSwitch({
        onText: 'SI',
        offText: 'NO',
    });
	/*$("#nombrePersona").autocomplete({
		source: "cuadro/cuadrocargosagentes/obtenerAutocompleteAgentes",
		select: function(event, ui){
			$('#idAgente').val(ui.item.id);
		}
	});*/
</script>

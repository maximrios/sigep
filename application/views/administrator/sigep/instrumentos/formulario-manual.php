<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<li>
			<label>Numero de Instrumento Legal</label>
			<span>Ingrese el numero de instrumento legal.</span>
			<input type="text" id="numeroInstrumentoLegal" name="numeroInstrumentoLegal" tabindex="1" placeholder="" value="<?php echo $Reg['numeroInstrumentoLegal']?>">
		</li>
		<li>
			<label>Fecha del Instrumento Legal</label>
			<span>Seleccione la fecha de aprobacion del instrumento legal.</span>
			<input type="text" id="fechaInstrumentoLegal" name="fechaInstrumentoLegal" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $Reg['fechaInstrumentoLegal']?>">
		</li>
		<li>
			<label>Tipo de Instrumento</label>
			<span>Seleccione el tipo de instrumento legal.</span>
			<?php echo form_dropdown('idTipoInstrumentoLegal', $tipos, $Reg['idTipoInstrumentoLegal'], 'tabindex="3"');?>
		</li>
		<li class="medio">
			<label>Tema</label>
			<span>Seleccione el tema del instrumento legal.</span>
			<?php echo form_dropdown('idTema', $temas, $Reg['idTema'], 'tabindex="4"');?>
		</li>
		<li>
			<label>Asunto</label>
			<span>Ingrese el asunto del Instrumento Legal.</span>
			<textarea id="asuntoInstrumentoLegal" name="asuntoInstrumentoLegal" tabindex="5"><?php echo $Reg['asuntoInstrumentoLegal']?></textarea>
		</li>
		<input type="submit" id="probar" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idInstrumentoLegal'])?' btn-reset':''); ?>" value="Guardar"/>
			<a href="administrator/instrumentos" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
		<input type="hidden" id="idInstrumentoLegal" name="idInstrumentoLegal" value="<?php echo $Reg['idInstrumentoLegal']?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
</div>
<script>
	$('#fechaInstrumentoLegal').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
		language: 'es',
	}).on('changeDate', function (ev) {
    	$(this).datepicker('hide');
	});
</script>
<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	
		<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
    	<div class="form-group col-lg-2">
    		<label for="dniPersona">Documento</label>
			<input type="text" id="dniPersona" name="dniPersona" tabindex="1" class="form-control" placeholder="Numero de documento. Sin puntos" value="<?php echo $Reg['dniPersona']?>">
    	</div>
    	<div class="form-group col-lg-5">
    		<label for="nombrePersona">Nombre</label>
			<input type="text" id="nombrePersona" name="nombrePersona" tabindex="2" class="form-control" placeholder="Nombre/s completo/s" value="<?php echo $Reg['nombrePersona']?>">
    	</div>
    	<div class="form-group col-lg-5">
    		<label for="apellidoPersona">Apellido</label>
			<input class="form-control" type="text" id="apellidoPersona" name="apellidoPersona" tabindex="3" placeholder="Apellido/s completo/s" value="<?php echo $Reg['apellidoPersona']?>">
    	</div>
		<div class="form-group col-lg-3">
			<label for="cuilPersona">C.U.I.L. N°</label>
			<input type="text" id="cuilPersona" name="cuilPersona" tabindex="4" placeholder="Numero de CUIL/CUIT. Sin puntos ni guiones." value="<?php echo $Reg['cuilPersona']?>" class="form-control">
		</div>
		<div class="form-group col-lg-3">
			<label for="nacimientoPersona">Fecha de Nacimiento</label>
			<input type="text" id="nacimientoPersona" name="nacimientoPersona" tabindex="5" placeholder="Fecha de Nacimiento" value="<?php echo $Reg['nacimientoPersona']?>" class="form-control">
		</div>
		<div class="form-group col-lg-3">
			<label for="idEcivil">Estado Civil</label>
			<?php echo form_dropdown('idEcivil', $estados, $Reg['idEcivil'], 'class="form-control" tabindex="6"');?>
		</div>
		<div class="form-group col-lg-3">
			<label for="idSexo">Sexo</label>
			<?php echo form_dropdown('idSexo', $sexos, $Reg['idSexo'], 'class="form-control" tabindex="7"');?>
		</div>
		<div class="form-group col-lg-12">
			<label for="nacionalidadPersona">Nacionalidad</label>
			<input type="text" id="nacionalidadPersona" name="nacionalidadPersona" tabindex="8" placeholder="Nacionalidad" value=" <?php echo $Reg['nacionalidadPersona'];?>" class="form-control">
		</div>
		<div class="form-group col-lg-12">
			<label>Domicilio</label>
			<input class="form-control" type="text" id="domicilioPersona" name="domicilioPersona" tabindex="9" placeholder="Domicilio completo" value="<?php echo $Reg['domicilioPersona']?>">
		</div>
		<div class="form-group col-lg-6">
			<label>Telefono Fijo</label>
			<input type="text" id="telefonoPersona" name="telefonoPersona" tabindex="10" placeholder="Telefono Fijo" value="<?php echo $Reg['telefonoPersona'];?>" class="form-control">
		</div>
		<div class="form-group col-lg-6">
			<label>Telefono Celular</label>
			<input type="text" id="celularPersona" name="celularPersona" tabindex="11" placeholder="Celular" value="<?php echo $Reg['celularPersona'];?>" class="form-control">
		</div>
		<div class="form-group col-lg-12">
			<label>Correo Electrónico</label>
			<input type="text" id="emailPersona" name="emailPersona" tabindex="12" placeholder="Correo electrónico" value="<?php echo $Reg['emailPersona'];?>" class="form-control">
		</div>
		<div class="buttons">
			<input type="submit" class="btn-primary btn-accion<?= (empty($Reg['idPersona'])?' btn-reset':''); ?>" value="Guardar"/>
		</div>
		<!--<button type="submit" class="btn btn-primary" tabindex="13"><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;Guardar</button>-->
		<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $Reg['idPersona'];?>">
		<input type="hidden" id="idTipoDni" name="idTipoDni" value="1">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
	<script>
	$('#nacimientoPersona').datepicker({
		format: 'dd/mm/yyyy',
		 startView: 2,
		language: "es",
		autoclose: true
	});
</script>
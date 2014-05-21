<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
	($Reg['idPersona'])? $readonly='readonly':$readonly='';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Documento</label>
		<span>Numero de documento del Agente</span>
		<input type="text" id="dniPersona" name="dniPersona" tabindex="1" placeholder="Numero de documento. Sin puntos" value="<?php echo $Reg['dniPersona']?>" <?php echo $readonly;?>>
	</li>
	<li class="cuarto">
		<label>Nombre</label>
		<span>Nombre/s completo/s del Agente</span>
		<input class="completo" type="text" id="nombrePersona" name="nombrePersona" tabindex="1" placeholder="Nombre/s del Agente" value="<?php echo $Reg['nombrePersona']?>" <?php echo $readonly;?>>
	</li>
	<li class="cuarto">
		<label>Apellido</label>
		<span>Apellido/s completo/s del Agente</span>
		<input class="completo" type="text" id="apellidoPersona" name="apellidoPersona" tabindex="1" placeholder="Apellido/s del Agente" value="<?php echo $Reg['apellidoPersona']?>" <?php echo $readonly;?>>
	</li>
	<br>
	<li class="cuarto">
		<label>C.U.I.L. N°</label>
		<span>Ingrese el numero de cuil del Agente</span>
		<input type="text" id="cuilPersona" name="cuilPersona" tabindex="1" placeholder="Numero de cuil del agente. Sin puntos ni guiones." value="<?php echo $Reg['cuilPersona']?>" <?php echo $readonly;?>>
	</li>
	<li class="cuarto">
		<label>Fecha de Nacimiento</label>
		<span>Ingrese la fecha de nacimiento</span>
		<input type="text" id="nacimientoPersona" name="nacimientoPersona" tabindex="1" placeholder="Fecha de Nacimiento del Agente" value="<?php echo $Reg['nacimientoPersona']?>" <?php echo $readonly;?>>
	</li>
	<br>
	<li class="cuarto">
		<label>Estado Civil</label>
		<span>Seleccione el estado civil del Agente</span>
		<?php echo form_dropdown('idEcivil', $estados, $Reg['idEcivil']);?>
	</li>
	<li class="cuarto">
		<label>Sexo</label>
		<span>Seleccione el sexo del Agente</span>
		<?php echo form_dropdown('idSexo', $sexos, $Reg['idSexo']);?>
	</li>
	<li>
		<label>Nacionalidad</label>
		<span>Ingrese la nacionalidad del Agente</span>
		<input type="text" id="nacionalidadPersona" name="nacionalidadPersona" tabindex="1" placeholder="Nacionalidad del Agente" value=" <?php echo $Reg['nacionalidadPersona'];?>"  <?php echo $readonly;?>>
	</li>
	<li class="medio">
		<label>Domicilio</label>
		<span>Domicilio completo del Agente</span>
		<input class="completo" type="text" id="domicilioPersona" name="domicilioPersona" tabindex="1" placeholder="Domicilio del Agente" value="<?php echo $Reg['domicilioPersona']?>">
	</li>
	<br>
	<li class="cuarto">
		<label>Telefono Fijo</label>
		<span>Numero de telefono del Agente</span>
		<input type="text" id="telefonoPersona" name="telefonoPersona" tabindex="1" placeholder="Telefono del Agente" value="<?php echo $Reg['telefonoPersona'];?>">
	</li>
	<li class="cuarto">
		<label>Telefono Celular</label>
		<span>Numero de celular del Agente</span>
		<input type="text" id="celularPersona" name="celularPersona" tabindex="1" placeholder="Celular del Agente" value="<?php echo $Reg['celularPersona'];?>">
	</li>
	<br>
	<li>
		<label>Correo Electrónico</label>
		<span>Correo electrónico oficial SIGEP</span>
		<input type="text" id="emailPersona" name="emailPersona" tabindex="1" placeholder="Correo electrónico oficial" value="<?php echo $Reg['emailPersona'];?>">
	</li>
	<li class="cuarto">
		<label>Telefono Laboral</label>
		<span>Numero de telefono laboral del Agente</span>
		<input type="text" id="laboralPersona" name="laboralPersona" tabindex="1" placeholder="Telefono laboral del Agente" value="<?php echo $Reg['laboralPersona'];?>">
	</li>
	<li class="cuarto">
		<label>Interno</label>
		<span>Numero de interno del Agente</span>
		<input type="text" id="internoAgente" name="internoAgente" tabindex="1" placeholder="Interno" value="<?php echo $Reg['internoAgente'];?>" class="input-mini">
	</li>
	<br>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idAgente'])?' btn-reset':''); ?>" value="Guardar"/>
		<a href="administrator/agentes" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	</div>
	<input type="hidden" id="idAgente" name="idAgente" value="<?php echo $Reg['idAgente']?>">
	<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $Reg['idPersona']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>

</div>
<script>
	$('#nacimientoPersona').datepicker({
		format: 'dd/mm/yyyy'
	});
	$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		minLength: 3,
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
		}
	});
</script>


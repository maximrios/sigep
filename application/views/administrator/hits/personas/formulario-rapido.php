<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<style type="text/css">
		.datepicker {
			z-index: 9999!important;
		}
	</style>
	<div class="forms">
		<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm" style="width:50em;">
    	<li>
			<label>Documento</label>
			<span>Numero de documento del Agente</span>
			<input type="text" id="dniPersona" name="dniPersona" tabindex="1" placeholder="Numero de documento. Sin puntos" value="">
		</li>
		<li class="medio">
			<label>Nombre</label>
			<span>Nombre/s completo/s del Agente</span>
			<input class="completo" type="text" id="nombrePersona" name="nombrePersona" tabindex="1" placeholder="Nombre/s del Agente" value="">
		</li>
		<li class="medio">
			<label>Apellido</label>
			<span>Apellido/s completo/s del Agente</span>
			<input class="completo" type="text" id="apellidoPersona" name="apellidoPersona" tabindex="1" placeholder="Apellido/s del Agente" value="">
		</li>
		<br>
		<li class="medio">
			<label>C.U.I.L. N°</label>
			<span>Ingrese el numero de cuil del Agente</span>
			<input type="text" id="cuilPersona" name="cuilPersona" tabindex="1" placeholder="Numero de cuil del agente. Sin puntos ni guiones." value="">
		</li>
		<li class="medio">
			<label>Fecha de Nacimiento</label>
			<span>Ingrese la fecha de nacimiento</span>
			<input type="text" id="nacimientoPersona" name="nacimientoPersona" tabindex="1" placeholder="Fecha de Nacimiento del Agente" value="">
		</li>
		<br>
		<li class="medio">
			<label>Estado Civil</label>
			<span>Seleccione el estado civil del Agente</span>
			<?php echo form_dropdown('idEcivil', $estados);?>
		</li>
		<li class="medio">
			<label>Sexo</label>
			<span>Seleccione el sexo del Agente</span>
			<?php echo form_dropdown('idSexo', $sexos);?>		
		</li>
		<li>
			<label>Nacionalidad</label>
			<span>Ingrese la nacionalidad del Agente</span>
			<input type="text" id="nacionalidadPersona" name="nacionalidadPersona" tabindex="1" placeholder="Nacionalidad del Agente" value="">
		</li>
		<li class="medio">
			<label>Domicilio</label>
			<span>Domicilio completo del Agente</span>
			<input class="completo" type="text" id="domicilioPersona" name="domicilioPersona" tabindex="1" placeholder="Domicilio del Agente" value="">
		</li>
		<br>
		<li class="medio">
			<label>Telefono Fijo</label>
			<span>Numero de telefono del Agente</span>
			<input type="text" id="telefonoPersona" name="telefonoPersona" tabindex="1" placeholder="Telefono del Agente" value="">
		</li>
		<li class="medio">
			<label>Telefono Celular</label>
			<span>Numero de celular del Agente</span>
			<input type="text" id="celularPersona" name="celularPersona" tabindex="1" placeholder="Celular del Agente" value="">
		</li>
		<br>
		<li>
			<label>Correo Electrónico</label>
			<span>Correo electrónico oficial SIGEP</span>
			<input type="text" id="emailPersona" name="emailPersona" tabindex="1" placeholder="Correo electrónico oficial" value="">
		</li>
		<li class="cuarto">
			<label>Telefono Laboral</label>
			<span>Numero de telefono laboral del Agente</span>
			<input type="text" id="laboralPersona" name="laboralPersona" tabindex="1" placeholder="Telefono laboral del Agente" value="">
		</li>
		<li class="completo">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idPersona'])?' btn-reset':''); ?>" value="Guardar"/>
			<button id="btn-guardar" class="btn btn-primary"><i class="icon-check icon-white"></i>&nbsp;&nbsp;Guardar datos</button>
		</li>
		<input type="hidden" id="idPersona" name="idPersona" value="0">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
</div>
<script>
	$('#nacimientoPersona').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#btn-guardar').on('click', enviarFancybox);
</script>
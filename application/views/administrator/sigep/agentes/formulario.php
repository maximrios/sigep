<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<style type="text/css">
.imagen {
	min-height: 205px;
	margin-bottom: 0;
	text-align: center;
}
.buttons button {
	margin: 0.5em;
}
.fileUpload {
	position: relative;
	overflow: hidden;
	margin: 10px;
}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
</style>
<div class="forms">
	<?= $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<div class="form-group col-md-6 col-lg-8">
			<label for="dniPersona">Documento</label>
			<input type="text" id="dniPersona" name="dniPersona" tabindex="1" placeholder="Numero de documento. Sin puntos." value="<?php echo $Reg['dniPersona']?>" required class="form-control">
		</div>
		<div class="form-group col-md-6 col-lg-4 pull-right">
			<div class="panel panel-default imagen">
                <div class="panel-heading">Imagen de perfil</div>
                <div class="panel-body">
                	<?php if ($Reg['pathPersona']) { ?>
                		<img src="<?=$Reg['pathPersona']?>">
                	<?php } 
                	else { ?>
                		<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
						<div class="fileUpload btn btn-primary">
    						<span>Cargar Imagen</span>
    						<input id="uploadBtn" type="file" class="upload" />
						</div>
            			<!--<input type="file" class="btn btn-primary" name="userfile[]" id="imagenes" multiple value="Cargar imagen"/>-->
                	<?php } ?>
        			
                </div>
        	</div>
    	</div>
		<div class="form-group col-md-6 col-lg-4 ">
			<label for="nombrePersona">Nombre</label>
			<input type="text" id="nombrePersona" name="nombrePersona" tabindex="2" placeholder="Nombre/s del Agente" value="<?php echo $Reg['nombrePersona']?>" required class="form-control">
		</div>
		<div class="form-group col-md-6 col-lg-4">
			<label for="apellidoPersona">Apellido</label>
			<input type="text" id="apellidoPersona" name="apellidoPersona" tabindex="3" placeholder="Apellido/s del Agente" value="<?php echo $Reg['apellidoPersona']?>" required class="form-control">
		</div>
		<div class="form-group col-md-12 col-lg-4">
			<label for="cuilPersona">C.U.I.L. N°</label>
			<input type="text" id="cuilPersona" name="cuilPersona" tabindex="4" placeholder="Numero de cuil del agente. Sin puntos ni guiones." value="<?php echo $Reg['cuilPersona']?>" required class="form-control">
		</div>
		<div class="form-group col-md-12 col-lg-4">
			<label for="nacimientoPersona">Fecha de Nacimiento</label>
			<input type="text" id="nacimientoPersona" name="nacimientoPersona" tabindex="5" placeholder="dd/mm/yyyy" value="<?php echo $Reg['nacimientoPersona']?>" required class="fecha form-control">
		</div>
		<div class="form-group col-lg-6">
			<label for="idEcivil">Estado Civil</label>
			<?php echo form_dropdown('idEcivil', $estados, $Reg['idEcivil'], 'id="idEcivil" tabindex="6" required class="form-control"');?>
		</div>
		<div class="form-group col-lg-6">
			<label for="idSexo">Sexo</label>
			<?php echo form_dropdown('idSexo', $sexos, $Reg['idSexo'], 'id="idSexo" tabindex="7" required class="form-control"');?>
		</div>
		<!--<div class="form-group col-lg-6">
			<label for="idPais">Pais de Nacimiento</label>
			<?php echo form_dropdown('idPais', $paises, '', 'id="idPais" tabindex="7" required class="form-control"');?>
		</div>
		<li>
			<label>Nacionalidad</label>
			<span>Ingrese la nacionalidad del Agente</span>
			<input type="text" id="nacionalidadPersona" name="nacionalidadPersona" tabindex="8" placeholder="Nacionalidad del Agente" value=" <?php echo $Reg['nacionalidadPersona'];?>">
		</li>-->
		<div class="form-group col-lg-12">
			<label for="domicilioPersona">Domicilio</label>
			<input type="text" id="domicilioPersona" name="domicilioPersona" tabindex="9" placeholder="Domicilio del Agente" value="<?php echo $Reg['domicilioPersona']?>" required class="form-control">
		</div>
		<div class="form-group col-lg-6">
			<label for="telefonoPersona">Telefono Fijo</label>
			<input type="text" id="telefonoPersona" name="telefonoPersona" tabindex="10" placeholder="Telefono del Agente" value="<?php echo $Reg['telefonoPersona'];?>" required class="form-control">
		</div>
		<div class="form-group col-lg-6">
			<label for="celularPersona">Telefono Celular</label>
			<input type="text" id="celularPersona" name="celularPersona" tabindex="11" placeholder="Celular del Agente" value="<?php echo $Reg['celularPersona'];?>" class="form-control">
		</div>
		<div class="form-group col-lg-12">
			<label for="emailPersona">Correo Electrónico</label>
			<input type="text" id="emailPersona" name="emailPersona" tabindex="12" placeholder="Correo electrónico oficial" value="<?php echo $Reg['emailPersona'];?>" required class="form-control">
		</div>
		<div class="form-group col-lg-8">
			<label for="laboralPersona">Telefono Laboral</label>
			<input type="text" id="laboralPersona" name="laboralPersona" tabindex="13" placeholder="Telefono laboral del Agente" value="<?php echo $Reg['laboralPersona'];?>" required class="form-control">
		</div>
		<div class="form-group col-lg-4">
			<label for="internoAgente">Numero de interno</label>
			<input type="text" class="form-control" id="internoAgente" name="internoAgente" value="<?php echo $Reg['internoAgente']?>" tabindex="14">
		</div>
		<div class="form-group col-lg-6">
			<label for="ingresoAgenteAPP">Fecha de ingreso a la APP</label>
			<input id="ingresoAgenteAPP" name="ingresoAgenteAPP" value="<?php echo $Reg['ingresoAgenteAPP']?>" tabindex="15" required class="fecha form-control">
		</div>
		<div class="form-group col-lg-6">
			<label for="ingresoAgenteSIGEP">Fecha de ingreso a la SIGEP</label>
			<input id="ingresoAgenteSIGEP" name="ingresoAgenteSIGEP" value="<?php echo $Reg['ingresoAgenteSIGEP']?>" tabindex="16" required class="fecha form-control">
		</div>
		<div class="col-lg-12 buttons">
			<!--<button type="" class="btn btn-danger btn-reset pull-right" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>-->
			<input type="submit" class="btn btn-primary btn-accion<?= (empty($Reg['idAgente'])?' btn-reset':''); ?> pull-right" value="Guardar">
            <!--<button type="submit" class="btn btn-primary btn-accion<?= (empty($Reg['idAgente'])?' btn-reset':''); ?> pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Grabar</button>-->
        </div>
		
		<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $Reg['idPersona']?>" />
		<input type="hidden" id="idAgente" name="idAgente" value="<?php echo $Reg['idAgente']?>" />
		<input type="hidden" id="idTipoDni" name="idTipoDni" value="1">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy',
	}).on('changeDate', function (ev) {
    	$(this).datepicker('hide');
	});
	$("#uploadBtn").on('onchange', function () {
    	document.getElementById("uploadFile").value = this.value;
	});
	//$('#idPais').on('change', selects);
	/*$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
		}
	});*/
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